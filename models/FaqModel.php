<?php
class FaqModel {
    private $db;
    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=bk88;charset=utf8", "root", "");
    }

    // Lấy câu hỏi Public (Đã trả lời)
    public function getPublicFaqs() {
        $stmt = $this->db->query("SELECT * FROM faq WHERE status = 1 ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy câu hỏi CỦA RIÊNG USER (Dựa vào user_id)
    public function getFaqsByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM faq WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function insertFaq($userId, $category, $question, $image) {
        $stmt = $this->db->prepare("INSERT INTO faq (user_id, category, question, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $category, $question, $image]);
    }

    public function getAllFaqsForAdmin() {
        $sql = "SELECT f.*, CONCAT(ui.lastname, ' ', ui.firstname) AS full_name 
                FROM faq f 
                LEFT JOIN information ui ON f.user_id = ui.user_id 
                ORDER BY f.status ASC, f.created_at DESC";
        
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Lỗi SQL: " . $e->getMessage());
        }
    }

    public function updateAnswer($id, $answer, $status) {
        $sql = "UPDATE faq SET answer = ?, status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$answer, $status, $id]);
    }

    public function toggleStatus($id, $newStatus) {
        $sql = "UPDATE faq SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$newStatus, $id]);
    }
}