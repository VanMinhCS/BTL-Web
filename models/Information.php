<?php
// FILE: models/Information.php
require_once __DIR__ . '/../core/Database.php';

class Address extends Database {
    private $address_id;
    private $street;
    private $ward;
    private $city;

    public function getAddressId() { return $this->address_id; }
    public function setAddressId($id) { 
        $this->address_id = $id; 
        $this->loadById($id); 
    }

    public function getStreet() { return $this->street; }
    public function setStreet($street) { $this->street = $street; }

    public function getWard() { return $this->ward; }
    public function setWard($ward) { $this->ward = $ward; }

    public function getCity() { return $this->city; }
    public function setCity($city) { $this->city = $city; }

    private function loadById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM addresses WHERE address_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $this->address_id = $result['address_id'];
            $this->street     = $result['street'];
            $this->ward       = $result['ward'];
            $this->city       = $result['city'];
        }
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO addresses (street, ward, city) VALUES (?, ?, ?)");
        $stmt->execute([$this->street, $this->ward, $this->city]);
        return $this->conn->lastInsertId(); // Trả về ID vừa tạo
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE addresses SET street=?, ward=?, city=? WHERE address_id=?");
        return $stmt->execute([$this->street, $this->ward, $this->city, $this->address_id]);
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM addresses WHERE address_id=?");
        return $stmt->execute([$this->address_id]);
    }
}

class Information extends Database {
    private $info_id;
    private $user_id;
    private $address_id;
    private $firstname;
    private $lastname;
    // Đã xóa hoàn toàn payment_method cho khớp với Database mới

    public function getInfoId() { return $this->info_id; }
    public function setInfoId($id) { 
        $this->info_id = $id; 
        $this->loadById($id); 
    }

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { $this->user_id = $id; }

    public function getAddressId() { return $this->address_id; }
    public function setAddressId($id) { $this->address_id = $id; }

    public function getFirstname() { return $this->firstname; }
    public function setFirstname($name) { $this->firstname = $name; }

    public function getLastname() { return $this->lastname; }
    public function setLastname($name) { $this->lastname = $name; }

    private function loadById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM information WHERE info_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $this->info_id        = $result['info_id'];
            $this->user_id        = $result['user_id'];
            $this->address_id     = $result['address_id'];
            $this->firstname      = $result['firstname'];
            $this->lastname       = $result['lastname'];
        }
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO information (user_id, address_id, firstname, lastname) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->user_id, $this->address_id, $this->firstname, $this->lastname]);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE information SET user_id=?, address_id=?, firstname=?, lastname=? WHERE info_id=?");
        return $stmt->execute([$this->user_id, $this->address_id, $this->firstname, $this->lastname, $this->info_id]);
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM information WHERE info_id=?");
        return $stmt->execute([$this->info_id]);
    }
}
?>