<?php
// FILE: core/Database.php

class Database {
    protected $conn;

    public function __construct() {
        try {
            // 1. Chuẩn bị chuỗi kết nối (DSN) sử dụng các hằng số từ file config.php (Chuẩn PDO của Task_3)
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Báo lỗi chi tiết nếu có
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Trả về dữ liệu dạng mảng dễ đọc
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Tăng cường bảo mật chống SQL Injection
            ];
            
            // 2. Khởi tạo kết nối PDO
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Nếu sai tên database hoặc sai mật khẩu, web sẽ dừng và báo lỗi tại đây
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    // =================================================================
    // GIỮ LẠI 2 HÀM CỦA NHÁNH MAIN ĐỂ KHÔNG LÀM HỎNG CODE CỦA TEAM
    // =================================================================
    
    // Hàm lấy kết nối (Dùng cho các model cũ chưa kế thừa Database)
    public function getConnection() {
        return $this->conn;
    }

    // Hàm đóng kết nối (Với PDO, chỉ cần gán bằng null là kết nối tự đóng)
    public function closeConnection() {
        if ($this->conn) {
            $this->conn = null;
        }
    }
}
?>