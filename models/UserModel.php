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
    // 3. Lấy thông tin người dùng bằng Email hoặc SĐT
    // ====================================================
    public function getUserByEmailOrPhone($login_id) {
        // Tách riêng thành 2 biến :email và :phone cho rành mạch
        $sql = "SELECT * FROM users WHERE email = :email OR phone = :phone LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        
        // Truyền đủ 2 giá trị vào mảng (dù cả 2 đều lấy từ $login_id)
        $stmt->execute([
            'email' => $login_id,
            'phone' => $login_id
        ]);
        
        return $stmt->fetch(); 
    }

    // Lấy thông tin user bằng ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}