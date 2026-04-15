<?php
class ArticleController extends Controller {
    public function index() {
        $data['title'] = "Bài viết của BK88";
        $this->view('public/article/index', $data);
    }

    public function getRole() {
        require_once __DIR__ . "/../../models/Authentication.php";
        $user = new User();
        $user->setUserId(1); // tạm gán cứng
        header('Content-Type: application/json');
        echo json_encode([
            "role" => $user->getRole()
        ]);
        $user->closeDb();
    }
    
    public function getArticle() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $stmt = $articleModel->getDb()->prepare(
            "SELECT id_article, title, description, time_modified, content, background 
            FROM articles 
            WHERE id_article = ? AND status = 1"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            echo json_encode([
                "id"          => $row['id_article'],
                "title"       => $row['title'],
                "description" => $row['description'],
                "upload_date" => date("d/m/Y", strtotime($row['time_modified'])), // chỉ ngày/tháng/năm
                "content"     => $row['content'], // nội dung HTML
                "background"  => $row['background']
            ]);
        } else {
            echo json_encode(["error" => "Không tìm thấy bài viết"]);
        }
        $stmt->close();
        $articleModel->closeDb();
    }

    public function getComments() {
        require_once __DIR__ . "/../../models/Authentication.php";
        require_once __DIR__ . "/../../models/Comment.php";

        $commentModel = new Comment();
        $id_article = isset($_GET['id']) ? intval($_GET['id']) : 0; 
        $userId     = 1; // sau này lấy từ session
        $stmt = $commentModel->getDb()->prepare("
            SELECT c.id_comment, c.id_article, c.id_user, u.email, u.role, 
                c.text, c.date_modified, c.is_edited, c.replied,
                SUM(cv.vote='like') AS likes,
                SUM(cv.vote='dislike') AS dislikes,
                uv.vote AS userVote
            FROM comments c
            JOIN users u ON c.id_user = u.user_id
            LEFT JOIN comment_votes cv ON c.id_comment = cv.comment_id
            LEFT JOIN comment_votes uv 
                ON c.id_comment = uv.comment_id 
                AND uv.user_id = ?
            WHERE c.id_article = ?
            GROUP BY c.id_comment
            ORDER BY c.date_modified DESC
        ");
        $stmt->bind_param("ii", $userId, $id_article);
        $stmt->execute();
        $result = $stmt->get_result();

        function maskEmail($email) {
            $parts = explode("@", $email);
            $name = $parts[0];
            $domain = $parts[1];
            if(strlen($name) > 1) {
                $masked = substr($name, 0, 1) . str_repeat("*", strlen($name)-1);
            } else {
                $masked = $name;
            }
            return $masked . "@" . $domain;
        }

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = [
                "id"        => $row['id_comment'],
                "user"      => maskEmail($row['email']),
                "text"      => $row['text'],
                "likes"     => (int)$row['likes'],
                "dislikes"  => (int)$row['dislikes'],
                "date"      => $row['date_modified'],
                "isEdited"  => ((int)$row['is_edited'] === 1),
                "isOwner"   => ($row['id_user'] == $userId),
                "isAdmin"   => ((int)$row['role'] === 1),
                "repliedId" => $row['replied'],
                "repliedUser" => $row['replied'] 
                    ? $commentModel->getRepliedUserMaskedEmail($row['replied']) 
                    : null,
                "userVote"  => $row['userVote'] ?? null
            ];
        }
        echo json_encode([
            "totalItems" => count($comments),
            "items"      => $comments
        ]);
        $stmt->close();
        $commentModel->closeDb();
    }
    
    public function voteComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php"; // chứa cả Comment và VoteComment

        $commentId = intval($_POST['comment_id'] ?? 0);
        $voteType  = $_POST['vote'] ?? null;
        $userId    = 1; // sau này lấy từ session

        if ($commentId && ($voteType === 'like' || $voteType === 'dislike')) {
            $voteModel = new VoteComment();
            $voteModel->setCommentId($commentId);
            $voteModel->setUserId($userId);

            $result = $voteModel->findByUserAndComment($commentId, $userId);

            if ($result) {
                if ($result['vote'] === $voteType) {
                    // đã vote cùng loại → hủy
                    $voteModel->setId($result['id']);
                    $success = $voteModel->delete();
                    $userVote = null;
                } else {
                    // đã vote khác loại → đổi loại
                    $voteModel->setId($result['id']);
                    $voteModel->setVote($voteType); // quan trọng: set lại loại mới
                    $success = $voteModel->update(); // update chỉ cột vote
                    $userVote = $voteType;
                }
            } else {
                // chưa từng vote → thêm mới
                $voteModel->setVote($voteType);
                $success = $voteModel->create();
                $userVote = $voteType;
            }

            if ($success) {
                $votes = $voteModel->getVotesByComment($commentId);
                echo json_encode([
                    "success"   => true,
                    "likes"     => $votes['likes'],
                    "dislikes"  => $votes['dislikes'],
                    "userVote"  => $userVote
                ]);
            } else {
                echo json_encode(["success" => false, "error" => "Không thể cập nhật vote"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Tham số không hợp lệ"]);
        }
        $voteModel->closeDb();
    }

    public function addComment() {      
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";
        require_once __DIR__ . "/../../models/Authentication.php";

        $id_article = intval($_POST['article_id'] ?? 0);
        $text       = trim($_POST['text'] ?? "");
        $userId     = 1; // tạm thời fix cứng user id = 1

        $comment = new Comment();
        $comment->setIdArticle($id_article);
        $comment->setIdUser($userId);
        $comment->setText($text);
        $comment->setIsEdited(0);
        $comment->setReplied(null);

        function maskEmail($email) {
            $parts = explode("@", $email);
            $name = $parts[0];
            $domain = $parts[1];
            $masked = strlen($name) > 1 
                ? substr($name, 0, 1) . str_repeat("*", strlen($name)-1) 
                : $name;
            return $masked . "@" . $domain;
        }

        if ($comment->create()) {
            $stmt = $comment->getDb()->prepare("
                SELECT c.date_modified, u.email, u.role
                FROM comments c
                JOIN users u ON c.id_user = u.user_id
                WHERE c.id_comment = ?
            ");
            $idComment = $comment->getIdComment();
            $stmt->bind_param("i", $idComment);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            $maskedEmail = maskEmail($row['email']);
            $role = (int)$row['role'];

            echo json_encode([
                "success" => true,
                "comment" => [
                    "id"          => $idComment,
                    "user"        => $maskedEmail,
                    "text"        => $text,
                    "likes"       => 0,
                    "dislikes"    => 0,
                    "date"        => date("c", strtotime($row['date_modified'])),
                    "isEdited"    => false,
                    "isOwner"     => true,
                    "isAdmin"     => ($role === 1),
                    "repliedId"   => null,
                    "repliedUser" => null,
                    "userVote"    => null
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Không thể thêm bình luận"]);
        }
        $stmt->close();
        $comment->closeDb();
    }

    public function replyComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";
        require_once __DIR__ . "/../../models/Authentication.php";

        $id_article = intval($_POST['article_id'] ?? 0);
        $parentId   = intval($_POST['parent_id'] ?? 0); // id comment gốc
        $text       = trim($_POST['text'] ?? "");
        $userId     = 1; // tạm thời fix cứng user id = 1

        $comment = new Comment();
        $comment->setIdArticle($id_article);
        $comment->setIdUser($userId);
        $comment->setText($text);
        $comment->setIsEdited(0);
        $comment->setReplied($parentId);

        function maskEmail($email) {
            $parts = explode("@", $email);
            $name = $parts[0];
            $domain = $parts[1];
            $masked = strlen($name) > 1 
                ? substr($name, 0, 1) . str_repeat("*", strlen($name)-1) 
                : $name;
            return $masked . "@" . $domain;
        }

        if ($comment->create()) {
            $stmt = $comment->getDb()->prepare("
                SELECT c.date_modified, c.replied, u.email, u.role
                FROM comments c
                JOIN users u ON c.id_user = u.user_id
                WHERE c.id_comment = ?
            ");
            $idComment = $comment->getIdComment();
            $stmt->bind_param("i", $idComment);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            $maskedEmail = maskEmail($row['email']);
            $role = (int)$row['role'];

            echo json_encode([
                "success" => true,
                "comment" => [
                    "id"          => $idComment,
                    "user"        => $maskedEmail,
                    "text"        => $text,
                    "likes"       => 0,
                    "dislikes"    => 0,
                    "date"        => date("c", strtotime($row['date_modified'])),
                    "isEdited"    => false,
                    "isOwner"     => true,
                    "isAdmin"     => ($role === 1),
                    "repliedId"   => $row['replied'],
                    "repliedUser" => $row['replied'] 
                        ? $comment->getRepliedUserMaskedEmail($row['replied']) 
                        : null,
                    "userVote"    => null
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Không thể thêm phản hồi"]);
        }
        $stmt->close();
        $comment->closeDb();
    }












        

}