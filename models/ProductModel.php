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

    // Lấy thông tin 1 sản phẩm dựa vào ID để đổ vào form Sửa
    public function getProductById($id) {
        $sql = "SELECT * FROM items WHERE item_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($id, $name, $stock, $description, $price, $cost_price, $image) {
        if ($image) {
            // Nếu người dùng có chọn ảnh mới
            $sql = "UPDATE items SET item_name = :name, item_stock = :stock, description = :description, price = :price, cost_price = :cost_price, item_image = :image WHERE item_id = :id";
        } else {
            // Nếu người dùng không chọn ảnh (giữ nguyên ảnh cũ)
            $sql = "UPDATE items SET item_name = :name, item_stock = :stock, description = :description, price = :price, cost_price = :cost_price WHERE item_id = :id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':cost_price', $cost_price);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($image) {
            $stmt->bindParam(':image', $image);
        }
        
        return $stmt->execute();
    }

    public function insertProduct($name, $stock, $description, $price, $cost_price, $image) {
        
        $sql = "INSERT INTO items (item_name, item_stock, description, price, cost_price, item_image) 
                VALUES (:name, :stock, :description, :price, :cost_price, :image)";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':cost_price', $cost_price); // Nó sẽ lấy từ trên ngoặc tròn xuống đây
        $stmt->bindParam(':image', $image);
        
        return $stmt->execute();
    }

    // Xóa sản phẩm
    public function deleteProduct($id) {
        $sql = "DELETE FROM items WHERE item_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Hàm lấy các chỉ số thống kê tổng quát
    public function getDashboardStats() {
        $stats = [];

        // 1. Sản phẩm đã bán (Tổng quantity trong order_details)
        $sql1 = "SELECT SUM(quantity) as total_sold FROM order_details";
        $result1 = $this->conn->query($sql1)->fetch(PDO::FETCH_ASSOC);
        $stats['total_sold'] = $result1['total_sold'] ?? 0;

        // 2. Tổng doanh thu (Tổng price * quantity trong order_details)
        $sql2 = "SELECT SUM(price * quantity) as total_revenue FROM order_details";
        $result2 = $this->conn->query($sql2)->fetch(PDO::FETCH_ASSOC);
        $stats['total_revenue'] = $result2['total_revenue'] ?? 0;

        // 3. Lợi nhuận gộp (Doanh thu - Giá vốn)
        // Join với bảng items để lấy giá vốn tại thời điểm hiện tại
        $sql3 = "SELECT SUM((od.price - i.cost_price) * od.quantity) as gross_profit 
                 FROM order_details od 
                 JOIN items i ON od.item_id = i.item_id";
        $result3 = $this->conn->query($sql3)->fetch(PDO::FETCH_ASSOC);
        $stats['gross_profit'] = $result3['gross_profit'] ?? 0;

        // 4. Tổng số đơn hàng
        $sql4 = "SELECT COUNT(*) as total_orders FROM orders";
        $result4 = $this->conn->query($sql4)->fetch(PDO::FETCH_ASSOC);
        $stats['total_orders'] = $result4['total_orders'] ?? 0;

        return $stats;
    }

    // Hàm lấy danh sách sản phẩm bán chạy nhất
    public function getTopSelling() {
        $sql = "SELECT i.item_name, SUM(od.quantity) as sold_qty, SUM(od.price * od.quantity) as revenue
                FROM order_details od
                JOIN items i ON od.item_id = i.item_id
                GROUP BY od.item_id
                ORDER BY sold_qty DESC
                LIMIT 5";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 5 đơn hàng mới nhất
    public function getRecentOrders() {
        $sql = "SELECT order_id, order_date, status, is_paid 
                FROM orders 
                ORDER BY order_date DESC 
                LIMIT 5";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDynamicChartData($type, $range) {
        $labels = [];
        $values = [];
        
        // 1. Xác định công thức tính toán dựa trên loại biểu đồ
        $aggregate = "";
        $joinItems = "";
        
        if ($type == 'revenue') {
            $aggregate = "SUM(od.price * od.quantity)"; // Doanh thu
        } elseif ($type == 'profit') {
            $aggregate = "SUM((od.price - i.cost_price) * od.quantity)"; // Lợi nhuận
            $joinItems = "JOIN items i ON od.item_id = i.item_id";
        } elseif ($type == 'sold') {
            $aggregate = "SUM(od.quantity)"; // Số cuốn đã bán
        } elseif ($type == 'orders') {
            $aggregate = "COUNT(DISTINCT o.order_id)"; // Số đơn hàng
        } else {
            $aggregate = "SUM(od.price * od.quantity)";
        }

        // 2. Xác định câu lệnh nhóm theo thời gian
        if ($range == '24h') {
            $sql = "SELECT CONCAT(FLOOR(HOUR(order_date) / 3) * 3, ':00') as label,
                           IFNULL($aggregate, 0) as total 
                    FROM orders o
                    LEFT JOIN order_details od ON o.order_id = od.order_id
                    $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 1 DAY
                    GROUP BY FLOOR(HOUR(order_date) / 3)
                    ORDER BY o.order_date ASC";
        } elseif ($range == '3d') {
            $sql = "SELECT CONCAT(DATE_FORMAT(order_date, '%d/%m'), ' ', 
                           CASE 
                               WHEN HOUR(order_date) < 6 THEN 'Sáng sớm'
                               WHEN HOUR(order_date) < 12 THEN 'Sáng'
                               WHEN HOUR(order_date) < 18 THEN 'Chiều'
                               ELSE 'Tối'
                           END) as label,
                           IFNULL($aggregate, 0) as total 
                    FROM orders o
                    LEFT JOIN order_details od ON o.order_id = od.order_id
                    $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 3 DAY
                    GROUP BY DATE(order_date), FLOOR(HOUR(order_date) / 6)
                    ORDER BY o.order_date ASC";
        } else {
            $sql = "SELECT DATE_FORMAT(order_date, '%d/%m') as label,
                           IFNULL($aggregate, 0) as total 
                    FROM orders o
                    LEFT JOIN order_details od ON o.order_id = od.order_id
                    $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 7 DAY
                    GROUP BY DATE(order_date)
                    ORDER BY o.order_date ASC";
        }

        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $labels[] = $row['label'];
            $values[] = (float)$row['total'];
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
?>