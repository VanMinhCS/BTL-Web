<?php
require_once __DIR__ . "/../core/Model.php";

class Notification extends Model {
    private $id;
    private $type;
    private $user_id;
    private $notification_comment_id;
    private $notification_vote_comment_id;
    private $is_read;
    private $created_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getType() { return $this->type; }
    public function setType($type) { $this->type = $type; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($userId) { $this->user_id = $userId; }

    public function getNotificationCommentId() { return $this->notification_comment_id; }
    public function setNotificationCommentId($id) { $this->notification_comment_id = $id; }

    public function getNotificationVoteCommentId() { return $this->notification_vote_comment_id; }
    public function setNotificationVoteCommentId($id) { $this->notification_vote_comment_id = $id; }

    public function getIsRead() { return $this->is_read; }
    public function setIsRead($isRead) { $this->is_read = $isRead; }

    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($date) { $this->created_at = $date; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM notifications WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id                          = $result['id'];
            $this->type                        = $result['type'];
            $this->user_id                     = $result['user_id'];
            $this->notification_comment_id     = $result['notification_comment_id'];
            $this->notification_vote_comment_id= $result['notification_vote_comment_id'];
            $this->is_read                     = $result['is_read'];
            $this->created_at                  = $result['created_at'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO notifications (type, user_id, notification_comment_id, notification_vote_comment_id, is_read) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $success = $stmt->execute([
            $this->type,
            $this->user_id,
            $this->notification_comment_id,
            $this->notification_vote_comment_id,
            $this->is_read
        ]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE notifications 
             SET type=?, user_id=?, notification_comment_id=?, notification_vote_comment_id=?, is_read=? 
             WHERE id=?"
        );
        return $stmt->execute([
            $this->type,
            $this->user_id,
            $this->notification_comment_id,
            $this->notification_vote_comment_id,
            $this->is_read,
            $this->id
        ]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM notifications WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}

class NotificationComment extends Model {
    private $id;
    private $article_id;
    private $comment_id;
    private $content;
    private $replied;
    private $created_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getArticleId() { return $this->article_id; }
    public function setArticleId($id) { $this->article_id = $id; }

    public function getCommentId() { return $this->comment_id; }
    public function setCommentId($id) { $this->comment_id = $id; }

    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; }

    public function getReplied() { return $this->replied; }
    public function setReplied($reply) { $this->replied = $reply; }

    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($date) { $this->created_at = $date; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM notification_comment WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id         = $result['id'];
            $this->article_id = $result['article_id'];
            $this->comment_id = $result['comment_id'];
            $this->content    = $result['content'];
            $this->replied    = $result['replied'];
            $this->created_at = $result['created_at'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO notification_comment (article_id, comment_id, content, replied) VALUES (?, ?, ?, ?)"
        );
        $success = $stmt->execute([$this->article_id, $this->comment_id, $this->content, $this->replied]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE notification_comment SET article_id=?, comment_id=?, content=?, replied=? WHERE id=?"
        );
        return $stmt->execute([$this->article_id, $this->comment_id, $this->content, $this->replied, $this->id]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM notification_comment WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}

class NotificationVoteComment extends Model {
    private $id;
    private $comment_id;
    private $article_id;
    private $vote_type;
    private $created_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getCommentId() { return $this->comment_id; }
    public function setCommentId($id) { $this->comment_id = $id; }

    public function getArticleId() { return $this->article_id; }
    public function setArticleId($id) { $this->article_id = $id; }

    public function getVoteType() { return $this->vote_type; }
    public function setVoteType($type) { $this->vote_type = $type; }

    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($date) { $this->created_at = $date; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM notification_vote_comment WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id         = $result['id'];
            $this->comment_id = $result['comment_id'];
            $this->article_id = $result['article_id'];
            $this->vote_type  = $result['vote_type'];
            $this->created_at = $result['created_at'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO notification_vote_comment (comment_id, article_id, vote_type) VALUES (?, ?, ?)"
        );
        $success = $stmt->execute([$this->comment_id, $this->article_id, $this->vote_type]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE notification_vote_comment SET comment_id=?, article_id=?, vote_type=? WHERE id=?"
        );
        return $stmt->execute([$this->comment_id, $this->article_id, $this->vote_type, $this->id]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM notification_vote_comment WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}
