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

    public function insertProduct($name, $stock, $description, $price, $image) {
        // 1. Viết câu lệnh SQL (Dùng dấu : để tạo tham số ẩn)
        $sql = "INSERT INTO items (item_name, item_stock, description, price, item_image) 
                VALUES (:name, :stock, :description, :price, :image)";
        
        // 2. Chuẩn bị câu lệnh (Lưu ý: thay $this->db bằng biến kết nối CSDL của bạn, ví dụ $this->conn)
        // Giả sử PDO connection được lưu ở thuộc tính db
        $stmt = $this->conn->prepare($sql);
        
        // 3. Gán giá trị thật vào các tham số ẩn
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        
        // 4. Thực thi lệnh và trả về kết quả (true nếu thành công, false nếu lỗi)
        return $stmt->execute();
    }
}
?>