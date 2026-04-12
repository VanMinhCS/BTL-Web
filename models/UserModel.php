<?php
// FILE: models/UserModel.php

// Gọi file kết nối Database mà chúng ta đã tạo ở thư mục core
require_once __DIR__ . '/../core/Database.php';

class UserModel extends Database {
    
    // ====================================================
    // 1. Kiểm tra xem email đã tồn tại trong DB chưa
    // ====================================================
    public function checkEmailExists($email) {
        $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        // Nếu rowCount > 0 tức là đã có người dùng email này
        return $stmt->rowCount() > 0;
    }

    // ====================================================
    // 2. Thêm người dùng mới vào Database (ĐĂNG KÝ)
    // ====================================================
    public function registerUser($fullname, $email, $password, $phone) {
        $sql = "INSERT INTO users (fullname, email, password, phone) VALUES (:fullname, :email, :password, :phone)";
        $stmt = $this->conn->prepare($sql);
        
        // Trả về true nếu Insert thành công, false nếu thất bại
        return $stmt->execute([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => $password, // Password truyền vào đây ĐÃ PHẢI ĐƯỢC MÃ HÓA
            'phone'    => $phone
        ]);
    }

    // ====================================================
    // 3. Lấy thông tin người dùng bằng Email (ĐĂNG NHẬP)
    // ====================================================
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        // Trả về 1 mảng chứa thông tin user, hoặc false nếu không tìm thấy
        return $stmt->fetch(); 
    }
}