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

    public function updateAbout($title, $description, $features) {
        // Kiểm tra xem trong bảng đã có dữ liệu chưa
        $check = $this->db->query("SELECT id FROM about_content LIMIT 1")->fetch();
        
        if ($check) {
            // Nếu đã có dữ liệu -> Chạy lệnh UPDATE
            $sql = "UPDATE about_content SET title = ?, description = ?, features = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$title, $description, $features, $check['id']]);
        } else {
            // Nếu chưa có (lần đầu tiên) -> Chạy lệnh INSERT
            $sql = "INSERT INTO about_content (title, description, features) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$title, $description, $features]);
        }
    }
}