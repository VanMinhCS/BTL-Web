<?php
require_once __DIR__ . '/../../models/UserModel.php';

class ArticleController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function getFullName($firstName, $lastName) {
        // Ghép theo định dạng: Lastname Firstname
        return trim($lastName . ' ' . $firstName);
    }

    public function index() {
        $data['title'] = "Bài viết của BK88";
        $this->view('public/article/index', $data);
    }

    public function getRole() {
        // session đã được khởi tạo trong __construct()
        $role = $_SESSION['user_role'] ?? null;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "role" => $role
        ]);
    }
    
    public function getArticle() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $row = $articleModel->findArticleById($id);

        header('Content-Type: application/json; charset=utf-8');
        if ($row) {
            echo json_encode([
                "id"          => $row['id_article'],
                "title"       => $row['title'],
                "description" => $row['description'],
                "upload_date" => date("d/m/Y", strtotime($row['time_modified'])), 
                "content"     => $row['content'], 
                "background"  => $row['background']
            ]);
        } else {
            echo json_encode(["error" => "Không tìm thấy bài viết"]);
        }
    }

    public function getComments() {
        require_once __DIR__ . "/../../models/Authentication.php";
        require_once __DIR__ . "/../../models/Comment.php";
        require_once __DIR__ . "/../../models/Information.php";

        $commentModel = new Comment();
        $id_article = isset($_GET['id']) ? intval($_GET['id']) : 0; 
        $userId     = $_SESSION['user_id'] ?? 0;

        $rows = $commentModel->getCommentsByArticle($id_article, $userId);

        $comments = [];
        foreach ($rows as $row) {
            $comments[] = [
                "id"          => $row['id_comment'],
                "user"        => $this->getFullName($row['firstname'], $row['lastname']),
                "text"        => $row['text'],
                "likes"       => (int)$row['likes'],
                "dislikes"    => (int)$row['dislikes'],
                "date"        => $row['date_modified'],
                "isEdited"    => ((int)$row['is_edited'] === 1),
                "isOwner"     => ($row['id_user'] == $userId),
                "isAdmin"     => ((int)$row['role'] === 1),
                "repliedId"   => $row['replied'],
                "repliedUser" => $row['replied'] 
                    ? $commentModel->getRepliedUserFullName($row['replied']) 
                    : null,
                "userVote"    => $row['userVote'] ?? null
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "totalItems" => count($comments),
            "items"      => $comments
        ]);
    }

    public function voteComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php"; 

        $commentId = intval($_POST['comment_id'] ?? 0);
        $voteType  = $_POST['vote'] ?? null;
        $userId    = $_SESSION['user_id'] ?? 0; // lấy từ session

        if ($userId && $commentId && ($voteType === 'like' || $voteType === 'dislike')) {
            $voteModel = new VoteComment();
            $voteModel->setCommentId($commentId);
            $voteModel->setUserId($userId);

            $result = $voteModel->findByUserAndComment($commentId, $userId);

            if ($result) {
                if ($result['vote'] === $voteType) {
                    $voteModel->setId($result['id']);
                    $success = $voteModel->delete();
                    $userVote = null;
                } else {
                    $voteModel->setId($result['id']);
                    $voteModel->setVote($voteType);
                    $success = $voteModel->update();
                    $userVote = $voteType;
                }
            } else {
                $voteModel->setVote($voteType);
                $success = $voteModel->create();
                $userVote = $voteType;
            }

            if ($success) {
                if ($userVote !== null) {
                    $voteModel->handleVoteNotification($commentId, $voteType, $userId);
                }

                $votes = $voteModel->getVotesByComment($commentId);
                echo json_encode([
                    "success"   => true,
                    "likes"     => (int)($votes['likes'] ?? 0),
                    "dislikes"  => (int)($votes['dislikes'] ?? 0),
                    "userVote"  => $userVote
                ]);
            } else {
                echo json_encode(["success" => false, "error" => "Không thể cập nhật vote"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Tham số không hợp lệ hoặc chưa đăng nhập"]);
        }
    }

    public function addComment() {      
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";


        $id_article = intval($_POST['article_id'] ?? 0);
        $text       = trim($_POST['text'] ?? "");
        $userId     = $_SESSION['user_id'] ?? 0; // lấy từ session

        $comment = new Comment();
        $comment->setIdArticle($id_article);
        $comment->setIdUser($userId);
        $comment->setText($text);
        $comment->setIsEdited(0);
        $comment->setReplied(null);

        if ($comment->create()) {
            $idComment = $comment->getIdComment();

            // gọi service để tạo thông báo
            $comment->createCommentNotification($id_article, $idComment, $text, $userId);

            // lấy thông tin user từ model
            $row = $comment->getCommentWithUserInfo($idComment);

            $fullName = trim($row['lastname'] . ' ' . $row['firstname']);
            $role = (int)$row['role'];

            echo json_encode([
                "success" => true,
                "comment" => [
                    "id"          => $idComment,
                    "user"        => $fullName,
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
    }

    public function replyComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";

        $id_article = intval($_POST['article_id'] ?? 0);
        $parentId   = intval($_POST['parent_id'] ?? 0);
        $text       = trim($_POST['text'] ?? "");
        $userId     = $_SESSION['user_id'] ?? 0;

        $comment = new Comment();
        $comment->setIdArticle($id_article);
        $comment->setIdUser($userId);
        $comment->setText($text);
        $comment->setIsEdited(0);
        $comment->setReplied($parentId);

        if ($comment->create()) {
            $idComment = $comment->getIdComment();

            // gọi service để tạo thông báo reply
            $comment->createReplyNotification($id_article, $idComment, $text, $parentId, $userId);

            // lấy thông tin user từ model
            $row = $comment->getReplyWithUserInfo($idComment);

            $fullName = trim($row['lastname'] . ' ' . $row['firstname']);
            $role = (int)$row['role'];

            echo json_encode([
                "success" => true,
                "comment" => [
                    "id"          => $idComment,
                    "user"        => $fullName,
                    "text"        => $text,
                    "likes"       => 0,
                    "dislikes"    => 0,
                    "date"        => date("c", strtotime($row['date_modified'])),
                    "isEdited"    => false,
                    "isOwner"     => true,
                    "isAdmin"     => ($role === 1),
                    "repliedId"   => $row['replied'],
                    "repliedUser" => $row['replied'] 
                        ? $comment->getRepliedUserFullName($row['replied']) 
                        : null,
                    "userVote"    => null
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Không thể thêm phản hồi"]);
        }
    }

    public function editComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";

        $commentId = intval($_POST['comment_id'] ?? 0);
        $text      = trim($_POST['text'] ?? "");
        $userId    = $_SESSION['user_id'] ?? 0;

        if ($commentId && $text !== "" && $userId) {
            $comment = new Comment();
            $comment->setIdComment($commentId);
            $comment->setText($text);
            $comment->setIsEdited(1);

            if ($comment->updateText($userId)) {
                // gọi service để tạo thông báo edit comment
                $comment->createEditNotification($comment, $commentId, $text, $userId);

                echo json_encode([
                    "success" => true,
                    "comment" => [
                        "id"       => $commentId,
                        "text"     => $text,
                        "isEdited" => true
                    ]
                ]);
            } else {
                echo json_encode(["success" => false, "error" => "Không thể chỉnh sửa"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Tham số không hợp lệ hoặc chưa đăng nhập"]);
        }
    }

    public function deleteComment() {
        header('Content-Type: application/json; charset=utf-8');
        require_once __DIR__ . "/../../models/Comment.php";
    
        $commentId = intval($_POST['comment_id'] ?? $_GET['comment_id'] ?? 0);
        $userId    = $_SESSION['user_id'] ?? 0; 
        
        if ($commentId) {
            $comment = new Comment();
            $comment->setIdComment($commentId);

            if ($comment->deleteCascade($userId)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Không thể xóa bình luận"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Tham số không hợp lệ"]);
        }
    }

    public function getOldestNewest() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $oldest = $articleModel->getOldestArticleId();
        $newest = $articleModel->getNewestArticleId();

        echo json_encode([
            "oldest" => $oldest ? BASE_URL . "article?id=" . $oldest['id_article'] : null,
            "newest" => $newest ? BASE_URL . "article?id=" . $newest['id_article'] : null
        ]);
    }
    

}