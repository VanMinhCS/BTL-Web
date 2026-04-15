<?php
require_once __DIR__ . "/../core/Model.php";

class Address extends Model {
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
        $stmt = $this->db->prepare("SELECT * FROM addresses WHERE address_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->address_id = $result['address_id'];
            $this->street     = $result['street'];
            $this->ward       = $result['ward'];
            $this->city       = $result['city'];
        }
    }

    public function create() {
        $stmt = $this->db->prepare("INSERT INTO addresses (street, ward, city) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->street, $this->ward, $this->city);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE addresses SET street=?, ward=?, city=? WHERE address_id=?");
        $stmt->bind_param("sssi", $this->street, $this->ward, $this->city, $this->address_id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM addresses WHERE address_id=?");
        $stmt->bind_param("i", $this->address_id);
        return $stmt->execute();
    }
}

class Information extends Model {
    private $info_id;
    private $user_id;
    private $address_id;
    private $firstname;
    private $lastname;
    private $payment_method;

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

    public function getPaymentMethod() { return $this->payment_method; }
    public function setPaymentMethod($method) { $this->payment_method = $method; }

    private function loadById($id) {
        $stmt = $this->db->prepare("SELECT * FROM information WHERE info_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->info_id        = $result['info_id'];
            $this->user_id        = $result['user_id'];
            $this->address_id     = $result['address_id'];
            $this->firstname      = $result['firstname'];
            $this->lastname       = $result['lastname'];
            $this->payment_method = $result['payment_method'];
        }
    }

    public function create() {
        $stmt = $this->db->prepare("INSERT INTO information (user_id, address_id, firstname, lastname, payment_method) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $this->user_id, $this->address_id, $this->firstname, $this->lastname, $this->payment_method);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->db->prepare("UPDATE information SET user_id=?, address_id=?, firstname=?, lastname=?, payment_method=? WHERE info_id=?");
        $stmt->bind_param("iisssi", $this->user_id, $this->address_id, $this->firstname, $this->lastname, $this->payment_method, $this->info_id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM information WHERE info_id=?");
        $stmt->bind_param("i", $this->info_id);
        return $stmt->execute();
    }
}
