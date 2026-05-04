<?php
// FILE: models/ProductModel.php
require_once __DIR__ . '/../core/database.php';

class ProductModel extends Database {
    
    // Lấy toàn bộ sản phẩm (Đã cập nhật JOIN với bảng product_reviews)
    public function getAllProducts() {
        $sql = "SELECT i.*, 
                       COUNT(pr.id) as total_reviews, 
                       IFNULL(AVG(pr.rating), 0) as average_rating 
                FROM items i
                LEFT JOIN product_reviews pr ON i.item_id = pr.product_id
                GROUP BY i.item_id
                ORDER BY i.item_id DESC";
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
            $sql = "UPDATE items SET item_name = :name, item_stock = :stock, description = :description, price = :price, cost_price = :cost_price, item_image = :image WHERE item_id = :id";
        } else {
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
        $stmt->bindParam(':cost_price', $cost_price); 
        $stmt->bindParam(':image', $image);
        
        return $stmt->execute();
    }

    // Xóa sản phẩm và xóa luôn ảnh trong thư mục
    public function deleteProduct($id) {
        $sqlSelect = "SELECT item_image FROM items WHERE item_id = :id";
        $stmtSelect = $this->conn->prepare($sqlSelect);
        $stmtSelect->execute([':id' => $id]);
        $product = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $sql = "DELETE FROM items WHERE item_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $isDeleted = $stmt->execute();

        if ($isDeleted && $product && !empty($product['item_image'])) {
            $filePath = __DIR__ . '/../../public/assets/img/products/' . $product['item_image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return $isDeleted;
    }

    // =================================================================
    // CÁC HÀM THỐNG KÊ ĐÃ ĐƯỢC CẬP NHẬT LOGIC (CHỈ TÍNH ĐƠN ĐÃ THANH TOÁN)
    // =================================================================

    public function getDashboardStats() {
        $stats = [];

        // 1. Sản phẩm đã bán (is_paid = 1)
        $sql1 = "SELECT SUM(od.quantity) as total_sold FROM order_details od JOIN orders o ON od.order_id = o.order_id WHERE o.status != 4 AND o.is_paid = 1";
        $result1 = $this->conn->query($sql1)->fetch(PDO::FETCH_ASSOC);
        $stats['total_sold'] = $result1['total_sold'] ?? 0;

        // 2. Tổng doanh thu (is_paid = 1)
        $sql2 = "SELECT SUM(od.price * od.quantity) as total_revenue FROM order_details od JOIN orders o ON od.order_id = o.order_id WHERE o.status != 4 AND o.is_paid = 1";
        $result2 = $this->conn->query($sql2)->fetch(PDO::FETCH_ASSOC);
        $stats['total_revenue'] = $result2['total_revenue'] ?? 0;

        // 3. Lợi nhuận gộp (is_paid = 1)
        $sql3 = "SELECT SUM((od.price - i.cost_price) * od.quantity) as gross_profit 
                 FROM order_details od 
                 JOIN items i ON od.item_id = i.item_id
                 JOIN orders o ON od.order_id = o.order_id
                 WHERE o.status != 4 AND o.is_paid = 1";
        $result3 = $this->conn->query($sql3)->fetch(PDO::FETCH_ASSOC);
        $stats['gross_profit'] = $result3['gross_profit'] ?? 0;

        // 4. Tổng số đơn hàng (is_paid = 1)
        $sql4 = "SELECT COUNT(*) as total_orders FROM orders WHERE status != 4 AND is_paid = 1";
        $result4 = $this->conn->query($sql4)->fetch(PDO::FETCH_ASSOC);
        $stats['total_orders'] = $result4['total_orders'] ?? 0;

        return $stats;
    }

    // Hàm lấy danh sách sản phẩm bán chạy nhất (Chỉ tính đơn đã thanh toán)
    public function getTopSelling() {
        $sql = "SELECT i.item_name, SUM(od.quantity) as sold_qty, SUM(od.price * od.quantity) as revenue
                FROM order_details od
                JOIN items i ON od.item_id = i.item_id
                JOIN orders o ON od.order_id = o.order_id
                WHERE o.status != 4 AND o.is_paid = 1
                GROUP BY od.item_id
                ORDER BY sold_qty DESC
                LIMIT 5";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 5 đơn hàng mới nhất (Giữ nguyên vì đây là danh sách hiển thị chung)
    public function getRecentOrders() {
        $sql = "SELECT order_id, order_date, status, is_paid 
                FROM orders 
                ORDER BY order_date DESC 
                LIMIT 5";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy dữ liệu cho biểu đồ (Chỉ tính đơn đã thanh toán)
    public function getDynamicChartData($type, $range) {
        $labels = [];
        $values = [];
        
        $aggregate = "";
        $joinItems = "";
        
        if ($type == 'revenue') {
            $aggregate = "SUM(od.price * od.quantity)";
        } elseif ($type == 'profit') {
            $aggregate = "SUM((od.price - i.cost_price) * od.quantity)";
            $joinItems = "JOIN items i ON od.item_id = i.item_id";
        } elseif ($type == 'sold') {
            $aggregate = "SUM(od.quantity)";
        } elseif ($type == 'orders') {
            $aggregate = "COUNT(DISTINCT o.order_id)";
        } else {
            $aggregate = "SUM(od.price * od.quantity)";
        }

        // Bổ sung AND o.is_paid = 1 vào tất cả các mốc thời gian
        if ($range == '24h') {
            $sql = "SELECT CONCAT(FLOOR(HOUR(order_date) / 3) * 3, ':00') as label, IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 1 DAY AND o.status != 4 AND o.is_paid = 1
                    GROUP BY FLOOR(HOUR(order_date) / 3) ORDER BY o.order_date ASC";
        } elseif ($range == '3d') {
            $sql = "SELECT CONCAT(DATE_FORMAT(order_date, '%d/%m'), ' ', 
                           CASE WHEN HOUR(order_date) < 6 THEN 'Sáng sớm' WHEN HOUR(order_date) < 12 THEN 'Sáng' WHEN HOUR(order_date) < 18 THEN 'Chiều' ELSE 'Tối' END) as label,
                           IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 3 DAY AND o.status != 4 AND o.is_paid = 1
                    GROUP BY DATE(order_date), FLOOR(HOUR(order_date) / 6) ORDER BY o.order_date ASC";
        } else {
            $sql = "SELECT DATE_FORMAT(order_date, '%d/%m') as label, IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 7 DAY AND o.status != 4 AND o.is_paid = 1
                    GROUP BY DATE(order_date) ORDER BY o.order_date ASC";
        }

        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $labels[] = $row['label'];
            $values[] = (float)$row['total'];
        }

        return ['labels' => $labels, 'values' => $values];
    }

    // =================================================================
    // CÁC HÀM QUẢN LÝ ĐƠN HÀNG DƯỚI ĐÂY GIỮ NGUYÊN
    // =================================================================

    public function getAllOrders() {
        $sql = "SELECT o.order_id, o.order_date, o.status, o.is_paid, o.shipping_fee, 
                       u.email, u.phone, 
                       i.firstname, i.lastname 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                LEFT JOIN information i ON u.user_id = i.user_id
                ORDER BY o.order_date DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function advanceOrderStatus($order_id, $status) {
        if ($status == 3) {
            $sql = "UPDATE orders SET status = :status, is_paid = 1 WHERE order_id = :order_id";
        } else {
            $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($status == 4) {
            $sqlItems = "SELECT item_id, quantity FROM order_details WHERE order_id = :order_id";
            $stmtItems = $this->conn->prepare($sqlItems);
            $stmtItems->execute([':order_id' => $order_id]);
            $itemsToRestore = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            foreach ($itemsToRestore as $item) {
                $sqlRestore = "UPDATE items SET item_stock = item_stock + :qty WHERE item_id = :item_id";
                $stmtRestore = $this->conn->prepare($sqlRestore);
                $stmtRestore->execute([
                    ':qty' => $item['quantity'], 
                    ':item_id' => $item['item_id']
                ]);
            }
        }

        return true;
    }

    public function getOrderById($order_id) {
        $sql = "SELECT o.*, u.email, u.phone as user_phone, i.firstname, i.lastname, 
                       a.street, a.ward, a.city 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                LEFT JOIN information i ON u.user_id = i.user_id
                LEFT JOIN addresses a ON i.address_id = a.address_id
                WHERE o.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($order_id) {
        $sql = "SELECT od.*, i.item_name, i.item_image 
                FROM order_details od
                JOIN items i ON od.item_id = i.item_id
                WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>