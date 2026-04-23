<?php
require_once __DIR__ . "/../core/Model.php";
require_once __DIR__ . "/../models/Notification.php";

class Comment extends Model {
    private $id_comment;
    private $id_article;
    private $id_user;
    private $text;
    private $date_modified;
    private $is_edited;
    private $replied;

    private function maskEmail($email) {
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

    public function getIdComment() { return $this->id_comment; }
    public function setIdComment($id) { $this->id_comment = $id; $this->loadById($id); }

    public function getIdArticle() { return $this->id_article; }
    public function setIdArticle($id) { $this->id_article = $id; }

    public function getIdUser() { return $this->id_user; }
    public function setIdUser($id) { $this->id_user = $id; }

    public function getText() { return $this->text; }
    public function setText($text) { $this->text = $text; }

    public function getDateModified() { return $this->date_modified; }
    public function setDateModified($date) { $this->date_modified = $date; }

    public function getIsEdited() { return $this->is_edited; }
    public function setIsEdited($edited) { $this->is_edited = $edited; }

    public function getReplied() { return $this->replied; }
    public function setReplied($reply) { $this->replied = $reply; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comments WHERE id_comment=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id_comment   = $result['id_comment'];
            $this->id_article   = $result['id_article'];
            $this->id_user      = $result['id_user'];
            $this->text         = $result['text'];
            $this->date_modified= $result['date_modified'];
            $this->is_edited    = $result['is_edited'];
            $this->replied      = $result['replied'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO comments (id_article, id_user, text, is_edited, replied) 
            VALUES (?, ?, ?, ?, ?)"
        );
        $success = $stmt->execute([
            $this->id_article,
            $this->id_user,
            $this->text,
            $this->is_edited,
            $this->replied
        ]);
        if ($success) {
            $this->id_comment = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare("
            UPDATE comments 
            SET id_article=?, id_user=?, text=?, date_modified=?, is_edited=?, replied=? 
            WHERE id_comment=?"
        );
        return $stmt->execute([
            $this->id_article,
            $this->id_user,
            $this->text,
            $this->date_modified,
            $this->is_edited,
            $this->replied,
            $this->id_comment
        ]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM comments WHERE id_comment=?");
        return $stmt->execute([$this->id_comment]);
    }

    public function getRepliedUserMaskedEmail($repliedId) {
        if(!$repliedId) return null;

        // nạp comment gốc
        $this->setIdComment($repliedId);
        $userId = $this->getIdUser();

        if(!$userId) return null;

        // dùng model User để lấy email
        require_once __DIR__ . "/Authentication.php";
        $user = new User();
        $user->setUserId($userId); // hàm này sẽ tự load dữ liệu user

        return $this->maskEmail($user->getEmail());
    }

    public function getRepliedUserFullName($repliedId) {
        $stmt = $this->getDb()->prepare("
            SELECT i.firstname, i.lastname
            FROM comments c
            JOIN users u ON c.id_user = u.user_id
            JOIN information i ON u.user_id = i.user_id
            WHERE c.id_comment = ?
        ");
        $stmt->execute([$repliedId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? trim($row['lastname'] . ' ' . $row['firstname']) : null;
    }

    public function updateText($userId) {
        $stmt = $this->getDb()->prepare("
            UPDATE comments 
            SET text=?, is_edited=1 
            WHERE id_comment=? AND id_user=?"
        );
        return $stmt->execute([$this->text, $this->id_comment, $userId]);
    }

    public function deleteByUser($userId) {
        $stmt = $this->getDb()->prepare("DELETE FROM comments WHERE id_comment=? AND id_user=?");
        return $stmt->execute([$this->id_comment, $userId]);
    }

    public function deleteCascade($userId) {
        // Xóa các bình luận trả lời
        $stmt = $this->getDb()->prepare("DELETE FROM comments WHERE replied=?");
        $stmt->execute([$this->id_comment]);

        // Xóa bình luận gốc
        $stmt2 = $this->getDb()->prepare("DELETE FROM comments WHERE id_comment=? AND id_user=?");
        return $stmt2->execute([$this->id_comment, $userId]);
    }

    public function getCommentsByArticle($articleId, $userId) {
        $stmt = $this->getDb()->prepare("
            SELECT c.id_comment, c.id_article, c.id_user, 
                    i.firstname, i.lastname, u.role, 
                    c.text, c.date_modified, c.is_edited, c.replied,
                    SUM(cv.vote='like') AS likes,
                    SUM(cv.vote='dislike') AS dislikes,
                    uv.vote AS userVote
            FROM comments c
            JOIN users u ON c.id_user = u.user_id
            JOIN information i ON u.user_id = i.user_id
            LEFT JOIN comment_votes cv ON c.id_comment = cv.comment_id
            LEFT JOIN comment_votes uv 
                    ON c.id_comment = uv.comment_id 
                    AND uv.user_id = ?
            WHERE c.id_article = ?
            GROUP BY c.id_comment
            ORDER BY c.date_modified DESC
        ");
        $stmt->execute([$userId, $articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentWithUserInfo($idComment) {
        $stmt = $this->getDb()->prepare("
            SELECT c.date_modified, u.role, i.firstname, i.lastname
            FROM comments c
            JOIN users u ON c.id_user = u.user_id
            JOIN information i ON u.user_id = i.user_id
            WHERE c.id_comment = ?
        ");
        $stmt->execute([$idComment]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCommentNotification($id_article, $idComment, $text, $userId) {
        $notifComment = new NotificationComment();
        $notifComment->setArticleId($id_article);
        $notifComment->setCommentId($idComment);
        $notifComment->setContent($text);
        $notifComment->setReplied(null);
        $notifComment->create();

        $notif = new Notification();
        $notif->setType("comment");
        $notif->setUserId($userId);
        $notif->setNotificationCommentId($notifComment->getId());
        $notif->setIsRead(0);
        $notif->create();
    }

    public function getReplyWithUserInfo($idComment) {
        $stmt = $this->getDb()->prepare("
            SELECT c.date_modified, c.replied, u.role, i.firstname, i.lastname
            FROM comments c
            JOIN users u ON c.id_user = u.user_id
            JOIN information i ON u.user_id = i.user_id
            WHERE c.id_comment = ?
        ");
        $stmt->execute([$idComment]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createReplyNotification($id_article, $idComment, $text, $parentId, $userId) {
        $notifComment = new NotificationComment();
        $notifComment->setArticleId($id_article);
        $notifComment->setCommentId($idComment);
        $notifComment->setContent($text);
        $notifComment->setReplied($parentId);
        $notifComment->create();

        $notif = new Notification();
        $notif->setType("reply_comment");
        $notif->setUserId($userId);
        $notif->setNotificationCommentId($notifComment->getId());
        $notif->setIsRead(0);
        $notif->create();
    }

    public function createEditNotification($comment, $commentId, $text, $userId) {
        $notifComment = new NotificationComment();
        $notifComment->setArticleId($comment->getIdArticle());
        $notifComment->setCommentId($commentId);
        $notifComment->setContent($text);
        $notifComment->setReplied($comment->getReplied());
        $notifComment->create();

        $notif = new Notification();
        $notif->setType("edit_comment");
        $notif->setUserId($userId);
        $notif->setNotificationCommentId($notifComment->getId());
        $notif->setIsRead(0);
        $notif->create();
    }
}

class VoteComment extends Model {
    private $id;          // cột id trong bảng
    private $comment_id;  // cột comment_id
    private $user_id;     // cột user_id
    private $vote;        // cột vote: 'like' hoặc 'dislike'

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getCommentId() { return $this->comment_id; }
    public function setCommentId($id) { $this->comment_id = $id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { $this->user_id = $id; }

    public function getVote() { return $this->vote; }
    public function setVote($vote) { $this->vote = $vote; }

    // Load dữ liệu từ DB
    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comment_votes WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id         = $result['id'];
            $this->comment_id = $result['comment_id'];
            $this->user_id    = $result['user_id'];
            $this->vote       = $result['vote'];
        }
    }

    // CREATE
    public function create() {
        $stmt = $this->getDb()->prepare("INSERT INTO comment_votes (comment_id, user_id, vote) VALUES (?, ?, ?)");
        $success = $stmt->execute([$this->comment_id, $this->user_id, $this->vote]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    // UPDATE
    public function update() {
        $stmt = $this->getDb()->prepare("UPDATE comment_votes SET vote=? WHERE id=?");
        return $stmt->execute([$this->vote, $this->id]);
    }

    // DELETE
    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM comment_votes WHERE id=?");
        return $stmt->execute([$this->id]);
    }

    // Lấy tổng số like/dislike cho 1 comment
    public function getVotesByComment($commentId) {
        $stmt = $this->getDb()->prepare("
            SELECT 
                SUM(vote='like') as likes,
                SUM(vote='dislike') as dislikes
            FROM comment_votes 
            WHERE comment_id=?"
        );
        $stmt->execute([$commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUserAndComment($commentId, $userId) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comment_votes WHERE comment_id=? AND user_id=?");
        $stmt->execute([$commentId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function handleVoteNotification($commentId, $voteType, $userId) {
        $db = (new Comment())->getDb();
        $stmt = $db->prepare("SELECT id_article FROM comments WHERE id_comment = ?");
        $stmt->execute([$commentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $articleId = $row ? $row['id_article'] : null;

        if ($articleId) {
            $notifVote = new NotificationVoteComment();
            $notifVote->setCommentId($commentId);
            $notifVote->setArticleId($articleId);
            $notifVote->setVoteType($voteType);
            $notifVote->create();

            $notif = new Notification();
            $notif->setType("vote_comment");
            $notif->setUserId($userId);
            $notif->setNotificationVoteCommentId($notifVote->getId());
            $notif->setIsRead(0);
            $notif->create();
        }
    }
}

