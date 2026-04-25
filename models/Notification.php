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

    public function getUnreadByUser($userId, $limit = 3) {
        $stmt = $this->getDb()->prepare("
            SELECT * FROM notifications 
            WHERE user_id = ? AND is_read = 0 
            ORDER BY created_at DESC 
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnreadByUser($userId) {
        $stmt = $this->getDb()->prepare("
            SELECT COUNT(*) as total 
            FROM notifications 
            WHERE user_id = ? AND is_read = 0
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function markAsRead($id) {
        $stmt = $this->getDb()->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function markAllAsRead($userId) {
        $stmt = $this->getDb()->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    private function getUserFullName($userId) {
        $stmt = $this->getDb()->prepare("SELECT firstname, lastname FROM information WHERE user_id=?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return trim($row['lastname'] . ' ' . $row['firstname']);
        }
        return "Người dùng #$userId";
    }
    private function getArticleIdFromComment($commentId) {
        $stmt = $this->getDb()->prepare("SELECT article_id FROM notification_comment WHERE id=?");
        $stmt->execute([$commentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['article_id'] : null;
    }

    private function getArticleIdFromVote($voteId) {
        $stmt = $this->getDb()->prepare("SELECT article_id FROM notification_vote_comment WHERE id=?");
        $stmt->execute([$voteId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['article_id'] : null;
    }

    public function map($notification) {
        $userName = $this->getUserFullName($notification['user_id']);
        $articleId = null;

        if (!empty($notification['notification_comment_id'])) {
            $articleId = $this->getArticleIdFromComment($notification['notification_comment_id']);
        }
        if (!empty($notification['notification_vote_comment_id'])) {
            $articleId = $this->getArticleIdFromVote($notification['notification_vote_comment_id']);
        }

        switch ($notification['type']) {
            case 'comment':
                return "$userName đã bình luận bài viết $articleId";
            case 'reply_comment':
                return "$userName đã phản hồi bình luận trong bài viết $articleId";
            case 'edit_comment':
                return "$userName đã chỉnh sửa bình luận trong bài viết $articleId";
            case 'vote_comment':
                return "$userName đã bình chọn bình luận trong bài viết $articleId";
            default:
                return "$userName có hoạt động mới trong bài viết $articleId";
        }
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

class NotificationSetting extends Model {
    private $id;          
    private $admin_id;    
    private $is_enabled;  
    private $enable_comment;
    private $enable_reply;
    private $enable_edit;
    private $enable_vote;

    public function getId() { return $this->id; }
    public function setId($id) { 
        $this->id = $id; 
        $this->loadById($id); 
    }

    public function getAdminId() { return $this->admin_id; }
    public function setAdminId($adminId) { $this->admin_id = $adminId; }

    public function getIsEnabled() { return $this->is_enabled; }
    public function setIsEnabled($enabled) { $this->is_enabled = $enabled; }

    public function getEnableComment() { return $this->enable_comment; }
    public function setEnableComment($val) { $this->enable_comment = $val; }

    public function getEnableReply() { return $this->enable_reply; }
    public function setEnableReply($val) { $this->enable_reply = $val; }

    public function getEnableEdit() { return $this->enable_edit; }
    public function setEnableEdit($val) { $this->enable_edit = $val; }

    public function getEnableVote() { return $this->enable_vote; }
    public function setEnableVote($val) { $this->enable_vote = $val; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM notification_setting WHERE setting_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id             = $result['setting_id'];
            $this->admin_id       = $result['admin_id'];
            $this->is_enabled     = $result['is_enabled'];
            $this->enable_comment = $result['enable_comment'];
            $this->enable_reply   = $result['enable_reply'];
            $this->enable_edit    = $result['enable_edit'];
            $this->enable_vote    = $result['enable_vote'];
        }
    }

    public function loadByAdminId($adminId) {
        $stmt = $this->getDb()->prepare("SELECT * FROM notification_setting WHERE admin_id=?");
        $stmt->execute([$adminId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id             = $result['setting_id'];
            $this->admin_id       = $result['admin_id'];
            $this->is_enabled     = $result['is_enabled'];
            $this->enable_comment = $result['enable_comment'];
            $this->enable_reply   = $result['enable_reply'];
            $this->enable_edit    = $result['enable_edit'];
            $this->enable_vote    = $result['enable_vote'];
            return true;
        }
        return false;
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO notification_setting (admin_id, is_enabled, enable_comment, enable_reply, enable_edit, enable_vote) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $success = $stmt->execute([
            $this->admin_id,
            $this->is_enabled,
            $this->enable_comment,
            $this->enable_reply,
            $this->enable_edit,
            $this->enable_vote
        ]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE notification_setting 
             SET admin_id=?, is_enabled=?, enable_comment=?, enable_reply=?, enable_edit=?, enable_vote=? 
             WHERE setting_id=?"
        );
        return $stmt->execute([
            $this->admin_id,
            $this->is_enabled,
            $this->enable_comment,
            $this->enable_reply,
            $this->enable_edit,
            $this->enable_vote,
            $this->id
        ]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM notification_setting WHERE setting_id=?");
        return $stmt->execute([$this->id]);
    }
}


