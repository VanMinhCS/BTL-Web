<?php
require_once __DIR__ . "/Database.php";

class Model {
    protected $db;
    protected $database;

    public function __construct() {
        $this->database = new Database();
        $this->db = $this->database->getConnection();
    }

    public function closeDb() {
        $this->database->closeConnection();
    }

    public function getDb() {
    return $this->db;
    }

}
