<?php
require_once __DIR__ . "/../core/Model.php";

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
        $stmt = $this->getDb()->prepare("SELECT * FROM users WHERE user_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->user_id  = $result['user_id'];
            $this->email    = $result['email'];
            $this->password = $result['password'];
            $this->role     = $result['role'];
            $this->phone    = $result['phone'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare("INSERT INTO users (email, password, role, phone) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$this->email, $this->password, $this->role, $this->phone]);
        if ($success) {
            $this->user_id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare("UPDATE users SET email=?, password=?, role=?, phone=? WHERE user_id=?");
        return $stmt->execute([$this->email, $this->password, $this->role, $this->phone, $this->user_id]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM users WHERE user_id=?");
        return $stmt->execute([$this->user_id]);
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
        $stmt = $this->getDb()->prepare("SELECT * FROM otp WHERE otp_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->otp_id     = $result['otp_id'];
            $this->user_id    = $result['user_id'];
            $this->code       = $result['code'];
            $this->time_expire= $result['time_expire'];
            $this->is_active  = $result['is_active'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare("INSERT INTO otp (user_id, code, time_expire, is_active) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$this->user_id, $this->code, $this->time_expire, $this->is_active]);
        if ($success) {
            $this->otp_id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare("UPDATE otp SET user_id=?, code=?, time_expire=?, is_active=? WHERE otp_id=?");
        return $stmt->execute([$this->user_id, $this->code, $this->time_expire, $this->is_active, $this->otp_id]);
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM otp WHERE otp_id=?");
        return $stmt->execute([$this->otp_id]);
    }
}
