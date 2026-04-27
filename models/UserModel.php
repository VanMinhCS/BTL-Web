<?php
// FILE: models/UserModel.php

require_once __DIR__ . '/../core/database.php';

class UserModel extends Database {
    
    // 1. Kiểm tra Email
    public function checkEmailExists($email) {
        $sql = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function checkUserExists($email, $phone) {
        // Chỉ kiểm tra phone nếu người dùng có nhập
        if (!empty($phone)) {
            $sql = "SELECT email, phone FROM users WHERE email = :email OR phone = :phone LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email, ':phone' => $phone]);
        } else {
            // Nếu không nhập SĐT thì chỉ check Email
            $sql = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
        }
        
        // Trả về dữ liệu nếu tìm thấy (tức là bị trùng), ngược lại trả về false
        return $stmt->fetch(PDO::FETCH_ASSOC); 
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
            return $user_id;
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
            $sqlInfo = "INSERT INTO information (user_id, address_id, firstname, lastname) VALUES (:user_id, :address_id, :firstname, :lastname)";
            $stmtInfo = $this->conn->prepare($sqlInfo);
            $stmtInfo->execute([
                'user_id' => $user_id,
                'address_id' => $address_id,
                'firstname' => $firstname,
                'lastname' => $lastname
            ]);

            $this->conn->commit(); // Xác nhận lưu
            return $user_id;
        } catch (Exception $e) {
            $this->conn->rollBack(); // Hoàn tác nếu có lỗi
            return false;
        }
    }

    // 6. Đăng nhập - Chỉ sử dụng Email (Đã thêm điều kiện is_verified = 1)
    public function getUserByEmailForLogin($email) {
        $sql = "SELECT u.*, i.firstname, i.lastname 
                FROM users u 
                LEFT JOIN information i ON u.user_id = i.user_id 
                WHERE u.email = :email AND u.is_verified = 1 LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
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

    // 8. Hàm gắn address_id vào hồ sơ người dùng (Dùng cho account cũ chưa có liên kết địa chỉ)
    public function updateUserAddressId($user_id, $address_id) {
        $stmt = $this->conn->prepare("UPDATE information SET address_id = ? WHERE user_id = ?");
        return $stmt->execute([$address_id, $user_id]);
    }

    // 9. Hàm tạo và lưu mã OTP vào Database
    public function createOTP($user_id, $code) {
        // Vô hiệu hóa các OTP cũ của user này (nếu có) để tránh lỗi trùng lặp
        $stmtOld = $this->conn->prepare("UPDATE otp SET is_active = 0 WHERE user_id = ?");
        $stmtOld->execute([$user_id]);

        // Tạo OTP mới hết hạn sau 5 phút (Dùng hàm DATE_ADD của MySQL)
        $stmtNew = $this->conn->prepare("INSERT INTO otp (user_id, code, time_expire, is_active) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 1)");
        return $stmtNew->execute([$user_id, $code]);
    }

    // 10. Kiểm tra mã OTP khách nhập có khớp và còn hạn không
    public function validateOTP($user_id, $code) {
        $stmt = $this->conn->prepare("SELECT * FROM otp WHERE user_id = ? AND code = ? AND is_active = 1 AND time_expire >= NOW() LIMIT 1");
        $stmt->execute([$user_id, $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 11. Kích hoạt tài khoản và vô hiệu hóa mã OTP đã dùng
    public function activateUser($user_id) {
        $this->conn->beginTransaction();
        try {
            // 1. Kích hoạt user
            $stmt1 = $this->conn->prepare("UPDATE users SET is_verified = 1 WHERE user_id = ?");
            $stmt1->execute([$user_id]);

            // 2. Vô hiệu hóa OTP
            $stmt2 = $this->conn->prepare("UPDATE otp SET is_active = 0 WHERE user_id = ?");
            $stmt2->execute([$user_id]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 12. Lấy thông tin user đã xác thực qua Email (Dùng cho Quên mật khẩu)
    public function getUserByEmailVerified($email) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ? AND is_verified = 1 LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 13. Cập nhật mật khẩu mới
    public function updatePassword($user_id, $hashed_password) {
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        return $stmt->execute([$hashed_password, $user_id]);
    }

    // 14. Vô hiệu hóa OTP (Dành cho Quên mật khẩu)
    public function deactivateOTP($user_id) {
        $stmt = $this->conn->prepare("UPDATE otp SET is_active = 0 WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }
}
?>