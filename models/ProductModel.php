<?php
// FILE: models/ProductModel.php
require_once __DIR__ . '/../core/Database.php';

class ProductModel extends Database {
    
    // Lấy toàn bộ sản phẩm
    public function getAllProducts() {
        $sql = "SELECT * FROM products ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 sản phẩm theo ID (Dùng cho trang chi tiết hoặc thanh toán)
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}