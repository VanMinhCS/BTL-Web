<?php
class AboutModel {
    private $db;

    public function __construct() {
        // Kết nối CSDL BK88 - Đảm bảo thông số này đúng với máy bạn
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=bk88;charset=utf8", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối database thất bại: " . $e->getMessage());
        }
    }

    public function getAboutData() {
        $sql = "SELECT * FROM about_content LIMIT 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAbout($title, $description, $features, $featured_items) {
        $check = $this->db->query("SELECT id FROM about_content LIMIT 1")->fetch();
        
        if ($check) {
            $sql = "UPDATE about_content SET title = ?, description = ?, features = ?, featured_items = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);   
            return $stmt->execute([$title, $description, $features, $featured_items, $check['id']]);
        } else {
            $sql = "INSERT INTO about_content (title, description, features, featured_items) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            
            // Thêm biến $featured_items vào mảng execute
            return $stmt->execute([$title, $description, $features, $featured_items]);
        }
    }
}