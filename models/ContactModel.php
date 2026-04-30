<?php
class ContactModel extends Model {
    public function __construct() {
        // Khởi tạo db
        parent::__construct(); 
        
        // Tự động kiểm tra và tạo bảng ngay khi Model được gọi
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            contact_id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            status TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $this->db->exec($sql);
    }
    // Lưu tin nhắn mới (Public)
    public function saveContact($customer_name, $customer_email, $subject, $message) {
        $sql = "INSERT INTO contacts (customer_name, customer_email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$customer_name, $customer_email, $subject, $message]);
    }

    // Lấy toàn bộ danh sách (Admin)
    public function getAll() {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Đánh dấu đã đọc (Admin)
    public function markAsRead($id) {
        $sql = "UPDATE contacts SET status = 1 WHERE contact_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}