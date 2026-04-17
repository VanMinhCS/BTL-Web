<?php
require_once __DIR__ . "/../core/model.php";

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
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id            = $result['id'];
            $this->detail_id     = $result['detail_id'];
            $this->admin_id      = $result['admin_id'];
            $this->reply_content = $result['reply_content'];
            $this->created_at    = $result['created_at'];
        }
        $stmt->close();
    }

    // CRUD
    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO review_admin_replies (detail_id, admin_id, reply_content) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $this->detail_id, $this->admin_id, $this->reply_content);
        $success = $stmt->execute();
        if ($success) $this->id = $stmt->insert_id;
        $stmt->close();
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE review_admin_replies SET detail_id=?, admin_id=?, reply_content=? WHERE id=?"
        );
        $stmt->bind_param("iisi", $this->detail_id, $this->admin_id, $this->reply_content, $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM review_admin_replies WHERE id=?");
        $stmt->bind_param("i", $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
