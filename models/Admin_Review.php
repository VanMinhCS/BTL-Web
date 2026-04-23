<?php
require_once __DIR__ . "/../core/Model.php";

class ReviewAdminReply extends Model {
    private $id;
    private $detail_id;
    private $admin_id;
    private $reply_content;
    private $created_at;

    // Getter & Setter
    public function getId() { return $this->id; }
    public function setId($id) { 
        $this->id = $id; 
        $this->loadById($id); 
    }

    public function getDetailId() { return $this->detail_id; }
    public function setDetailId($detailId) { $this->detail_id = $detailId; }

    public function getAdminId() { return $this->admin_id; }
    public function setAdminId($adminId) { $this->admin_id = $adminId; }

    public function getReplyContent() { return $this->reply_content; }
    public function setReplyContent($content) { $this->reply_content = $content; }

    public function getCreatedAt() { return $this->created_at; }

    // Load dữ liệu theo id
    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM review_admin_replies WHERE id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id            = $result['id'];
            $this->detail_id     = $result['detail_id'];
            $this->admin_id      = $result['admin_id'];
            $this->reply_content = $result['reply_content'];
            $this->created_at    = $result['created_at'];
        }
    }

    // CREATE
    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO review_admin_replies (detail_id, admin_id, reply_content) VALUES (?, ?, ?)"
        );
        $success = $stmt->execute([$this->detail_id, $this->admin_id, $this->reply_content]);
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    // UPDATE
    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE review_admin_replies SET detail_id=?, admin_id=?, reply_content=? WHERE id=?"
        );
        return $stmt->execute([$this->detail_id, $this->admin_id, $this->reply_content, $this->id]);
    }

    // DELETE
    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM review_admin_replies WHERE id=?");
        return $stmt->execute([$this->id]);
    }
}
