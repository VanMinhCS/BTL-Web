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

    public function getUnread($limit = 3) {
        $sql = "
            SELECT n.id, n.type, n.created_at,
                n.notification_comment_id,
                n.notification_vote_comment_id,
                nc.article_id, nc.comment_id, nc.content AS message,
                vc.article_id AS vote_article_id, vc.comment_id AS vote_comment_id, vc.vote_type,
                i.user_id AS id_user, i.firstname, i.lastname
            FROM notifications n
            LEFT JOIN notification_comment nc 
                ON n.notification_comment_id = nc.id
            LEFT JOIN notification_vote_comment vc 
                ON n.notification_vote_comment_id = vc.id
            LEFT JOIN information i 
                ON n.user_id = i.user_id
            WHERE n.is_read = 0
            ORDER BY n.created_at DESC
            LIMIT ?
        ";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllUnread() {
        $sql = "SELECT COUNT(*) FROM notifications WHERE is_read = 0";
        $stmt = $this->getDb()->query($sql);
        return (int)$stmt->fetchColumn();
    }

    public function getAll($page = 1, $itemsPerPage = 5, $keyword = "", $status = "", $type = "", $sort = "desc") {
        $offset = ($page - 1) * $itemsPerPage;
        $sql = "
            SELECT n.id, n.type, n.created_at, n.is_read,
                nc.article_id, nc.comment_id,
                vc.article_id AS vote_article_id, vc.comment_id AS vote_comment_id,
                i.user_id AS id_user, i.firstname, i.lastname
            FROM notifications n
            LEFT JOIN notification_comment nc ON n.notification_comment_id = nc.id
            LEFT JOIN notification_vote_comment vc ON n.notification_vote_comment_id = vc.id
            LEFT JOIN information i ON n.user_id = i.user_id
            WHERE 1=1
        ";

        $params = [];

        if ($status === "read") {
            $sql .= " AND n.is_read = 1";
        } elseif ($status === "unread") {
            $sql .= " AND n.is_read = 0";
        }

        if ($type !== "") {
            $sql .= " AND n.type = ?";
            $params[] = $type;
        }

        // Thêm điều kiện keyword
        if ($keyword !== "") {
            $sql .= " AND (
                i.firstname LIKE ? 
                OR i.lastname LIKE ? 
                OR n.type LIKE ? 
                OR nc.article_id LIKE ? 
                OR nc.comment_id LIKE ?
            )";
            $kw = "%$keyword%";
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
        }

        $sql .= " ORDER BY n.created_at " . ($sort === "asc" ? "ASC" : "DESC");
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $itemsPerPage;
        $params[] = $offset;

        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($keyword = "") {
        $sql = "SELECT COUNT(*) FROM notifications";
        $stmt = $this->getDb()->query($sql);
        $count = (int)$stmt->fetchColumn();

        if ($keyword !== "") {
            $all = $this->getAll(1, $count, $keyword);
            return count($all);
        }
        return $count;
    }

    public function markAsRead($id) {
        $stmt = $this->getDb()->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function markAllAsRead() {
        $stmt = $this->getDb()->prepare("UPDATE notifications SET is_read = 1");
        return $stmt->execute();
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
        $userName = $this->getUserFullName($notification['id_user']);
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

    public function deleteNotifications($ids) {
        if (empty($ids)) return false;
        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "DELETE FROM notifications WHERE id IN ($in)";
        $stmt = $this->getDb()->prepare($sql);
        return $stmt->execute($ids);
    }

    public function markAsReadMultiple($ids) {
        if (empty($ids)) return false;
        $in  = str_repeat('?,', count($ids) - 1) . '?';
        $sql = "UPDATE notifications SET is_read = 1 WHERE id IN ($in)";
        $stmt = $this->getDb()->prepare($sql);
        return $stmt->execute($ids);
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


