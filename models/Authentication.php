<?php
require_once __DIR__ . "/../core/model.php";

class User extends Model {
    private $user_id;
    private $email;
    private $password;
    private $role;
    private $phone;

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { 
        $this->user_id = $id; 
        $this->loadById($id);
    }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }

    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; }

    private function loadById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->user_id  = $result['user_id'];
            $this->email    = $result['email'];
            $this->password = $result['password'];
            $this->role     = $result['role'];
            $this->phone    = $result['phone'];
        }
    }

    public function create() {
        $stmt = $this->db->prepare("INSERT INTO users (email, password, role, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $this->email, $this->password, $this->role, $this->phone);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE users SET email=?, password=?, role=?, phone=? WHERE user_id=?");
        $stmt->bind_param("ssisi", $this->email, $this->password, $this->role, $this->phone, $this->user_id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id=?");
        $stmt->bind_param("i", $this->user_id);
        return $stmt->execute();
    }
}

class Otp extends Model {
    private $otp_id;
    private $user_id;
    private $code;
    private $time_expire;
    private $is_active;

    public function getOtpId() { return $this->otp_id; }
    public function setOtpId($id) { $this->otp_id = $id; $this->loadById($id); }

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { $this->user_id = $id; }

    public function getCode() { return $this->code; }
    public function setCode($code) { $this->code = $code; }

    public function getTimeExpire() { return $this->time_expire; }
    public function setTimeExpire($time) { $this->time_expire = $time; }

    public function getIsActive() { return $this->is_active; }
    public function setIsActive($active) { $this->is_active = $active; }

    private function loadById($id) {
        $stmt = $this->db->prepare("SELECT * FROM otp WHERE otp_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->otp_id     = $result['otp_id'];
            $this->user_id    = $result['user_id'];
            $this->code       = $result['code'];
            $this->time_expire= $result['time_expire'];
            $this->is_active  = $result['is_active'];
        }
    }

    public function create() {
        $stmt = $this->db->prepare("INSERT INTO otp (user_id, code, time_expire, is_active) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $this->user_id, $this->code, $this->time_expire, $this->is_active);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE otp SET user_id=?, code=?, time_expire=?, is_active=? WHERE otp_id=?");
        $stmt->bind_param("issii", $this->user_id, $this->code, $this->time_expire, $this->is_active, $this->otp_id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM otp WHERE otp_id=?");
        $stmt->bind_param("i", $this->otp_id);
        return $stmt->execute();
    }
}
?>