<?php
// FILE: models/ProductModel.php
require_once __DIR__ . '/../core/database.php';

class ProductModel extends Database {
    
    // Lấy toàn bộ sản phẩm (Đã đổi bảng products -> items, cột id -> item_id)
    public function getAllProducts() {
        $sql = "SELECT * FROM items ORDER BY item_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 sản phẩm theo ID (Đã đổi bảng products -> items, cột id -> item_id)
    public function getProductById($id) {
        $sql = "SELECT * FROM items WHERE item_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>