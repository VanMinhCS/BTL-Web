<?php
// FILE: models/UserModel.php

require_once __DIR__ . '/../core/Database.php';

class UserModel extends Database {
    
    // 1. Kiểm tra Email
    public function checkEmailExists($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->rowCount() > 0;
    }

    // 2. Lấy toàn bộ thông tin Profile (JOIN 3 bảng)
    public function getUserProfile($user_id) {
        $sql = "SELECT u.email, u.phone, i.firstname, i.lastname, i.address_id, a.street, a.ward, a.city 
                FROM users u 
                LEFT JOIN information i ON u.user_id = i.user_id 
                LEFT JOIN addresses a ON i.address_id = a.address_id 
                WHERE u.user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Cập nhật thông tin cá nhân (Họ tên & SĐT)
    public function updateProfileInfo($user_id, $firstname, $lastname, $phone) {
        try {
            $this->conn->beginTransaction();

            // Cập nhật SĐT ở bảng users
            $stmtU = $this->conn->prepare("UPDATE users SET phone = ? WHERE user_id = ?");
            $stmtU->execute([$phone, $user_id]);

            // Cập nhật Họ tên ở bảng information
            $stmtI = $this->conn->prepare("UPDATE information SET firstname = ?, lastname = ? WHERE user_id = ?");
            $stmtI->execute([$firstname, $lastname, $user_id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 4. Cập nhật địa chỉ
    public function updateAddressInfo($address_id, $street, $ward, $city) {
        $stmt = $this->conn->prepare("UPDATE addresses SET street = ?, ward = ?, city = ? WHERE address_id = ?");
        return $stmt->execute([$street, $ward, $city, $address_id]);
    }

    // 5. Thêm người dùng mới (ĐĂNG KÝ) - Đã xử lý liên kết 3 bảng bằng PDO
    public function registerUser($fullname, $email, $password, $phone) {
        try {
            // Tách Chuỗi Fullname thành Tên (Firstname) và Họ (Lastname)
            $nameParts = explode(' ', trim($fullname));
            $firstname = array_pop($nameParts);
            $lastname = implode(' ', $nameParts);

            // Bắt đầu transaction (Chuẩn PDO)
            $this->conn->beginTransaction(); 

            // BƯỚC 1: Tạo một địa chỉ trống
            $sqlAddr = "INSERT INTO addresses (street, ward, city) VALUES ('', '', '')";
            $this->conn->exec($sqlAddr);
            $address_id = $this->conn->lastInsertId(); // Lấy ID vừa tạo (Chuẩn PDO)

            // BƯỚC 2: Lưu vào bảng Users
            $sqlUser = "INSERT INTO users (email, password, role, phone) VALUES (:email, :password, 0, :phone)";
            $stmtUser = $this->conn->prepare($sqlUser);
            $stmtUser->execute([
                'email' => $email,
                'password' => $password,
                'phone' => $phone
            ]);
            $user_id = $this->conn->lastInsertId();

            // BƯỚC 3: Lưu vào bảng Information
            $sqlInfo = "INSERT INTO information (user_id, address_id, firstname, lastname, payment_method) VALUES (:user_id, :address_id, :firstname, :lastname, 0)";
            $stmtInfo = $this->conn->prepare($sqlInfo);
            $stmtInfo->execute([
                'user_id' => $user_id,
                'address_id' => $address_id,
                'firstname' => $firstname,
                'lastname' => $lastname
            ]);

            $this->conn->commit(); // Xác nhận lưu
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack(); // Hoàn tác nếu có lỗi
            return false;
        }
    }

    // 6. Đăng nhập - Nối (JOIN) thêm bảng information để lấy Họ Tên
    public function getUserByEmailOrPhone($login_id) {
        $sql = "SELECT u.*, i.firstname, i.lastname 
                FROM users u 
                LEFT JOIN information i ON u.user_id = i.user_id 
                WHERE u.email = :email OR u.phone = :phone LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'email' => $login_id,
            'phone' => $login_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 7. Lấy thông tin user bằng ID (Dùng cho Checkout)
    public function getUserById($id) {
        $sql = "SELECT u.*, i.firstname, i.lastname 
                FROM users u 
                LEFT JOIN information i ON u.user_id = i.user_id 
                WHERE u.user_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>