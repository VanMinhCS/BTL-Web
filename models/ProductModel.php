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

    // Xóa sản phẩm và xóa luôn ảnh trong thư mục
    public function deleteProduct($id) {
        // 1. Lấy tên file ảnh của sản phẩm trước khi xóa data
        $sqlSelect = "SELECT item_image FROM items WHERE item_id = :id";
        $stmtSelect = $this->conn->prepare($sqlSelect);
        $stmtSelect->execute([':id' => $id]);
        $product = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // 2. Xóa dữ liệu trong Database
        $sql = "DELETE FROM items WHERE item_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $isDeleted = $stmt->execute();

        // 3. Nếu xóa DB thành công và sản phẩm có ảnh, thì xóa ảnh vật lý
        if ($isDeleted && $product && !empty($product['item_image'])) {
            $filePath = __DIR__ . '/../../public/assets/img/products/' . $product['item_image'];
            // Kiểm tra xem file có thực sự tồn tại trong thư mục không rồi mới xóa (hàm unlink)
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return $isDeleted;
    }

    // Hàm lấy các chỉ số thống kê tổng quát (ĐÃ LOẠI TRỪ ĐƠN HỦY)
    public function getDashboardStats() {
        $stats = [];

        // 1. Sản phẩm đã bán (Chỉ tính đơn không hủy)
        $sql1 = "SELECT SUM(od.quantity) as total_sold FROM order_details od JOIN orders o ON od.order_id = o.order_id WHERE o.status != 4";
        $result1 = $this->conn->query($sql1)->fetch(PDO::FETCH_ASSOC);
        $stats['total_sold'] = $result1['total_sold'] ?? 0;

        // 2. Tổng doanh thu (Chỉ tính đơn không hủy)
        $sql2 = "SELECT SUM(od.price * od.quantity) as total_revenue FROM order_details od JOIN orders o ON od.order_id = o.order_id WHERE o.status != 4";
        $result2 = $this->conn->query($sql2)->fetch(PDO::FETCH_ASSOC);
        $stats['total_revenue'] = $result2['total_revenue'] ?? 0;

        // 3. Lợi nhuận gộp (Chỉ tính đơn không hủy)
        $sql3 = "SELECT SUM((od.price - i.cost_price) * od.quantity) as gross_profit 
                 FROM order_details od 
                 JOIN items i ON od.item_id = i.item_id
                 JOIN orders o ON od.order_id = o.order_id
                 WHERE o.status != 4";
        $result3 = $this->conn->query($sql3)->fetch(PDO::FETCH_ASSOC);
        $stats['gross_profit'] = $result3['gross_profit'] ?? 0;

        // 4. Tổng số đơn hàng (Chỉ đếm đơn hợp lệ)
        $sql4 = "SELECT COUNT(*) as total_orders FROM orders WHERE status != 4";
        $result4 = $this->conn->query($sql4)->fetch(PDO::FETCH_ASSOC);
        $stats['total_orders'] = $result4['total_orders'] ?? 0;

        return $stats;
    }

    // Hàm lấy danh sách sản phẩm bán chạy nhất (ĐÃ LOẠI TRỪ ĐƠN HỦY)
    public function getTopSelling() {
        $sql = "SELECT i.item_name, SUM(od.quantity) as sold_qty, SUM(od.price * od.quantity) as revenue
                FROM order_details od
                JOIN items i ON od.item_id = i.item_id
                JOIN orders o ON od.order_id = o.order_id
                WHERE o.status != 4
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

    // Lấy dữ liệu cho biểu đồ (ĐÃ LOẠI TRỪ ĐƠN HỦY)
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

        // Thêm điều kiện AND o.status != 4 vào TẤT CẢ các truy vấn biểu đồ
        if ($range == '24h') {
            $sql = "SELECT CONCAT(FLOOR(HOUR(order_date) / 3) * 3, ':00') as label, IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 1 DAY AND o.status != 4
                    GROUP BY FLOOR(HOUR(order_date) / 3) ORDER BY o.order_date ASC";
        } elseif ($range == '3d') {
            $sql = "SELECT CONCAT(DATE_FORMAT(order_date, '%d/%m'), ' ', 
                           CASE WHEN HOUR(order_date) < 6 THEN 'Sáng sớm' WHEN HOUR(order_date) < 12 THEN 'Sáng' WHEN HOUR(order_date) < 18 THEN 'Chiều' ELSE 'Tối' END) as label,
                           IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 3 DAY AND o.status != 4
                    GROUP BY DATE(order_date), FLOOR(HOUR(order_date) / 6) ORDER BY o.order_date ASC";
        } else {
            $sql = "SELECT DATE_FORMAT(order_date, '%d/%m') as label, IFNULL($aggregate, 0) as total 
                    FROM orders o LEFT JOIN order_details od ON o.order_id = od.order_id $joinItems
                    WHERE o.order_date >= NOW() - INTERVAL 7 DAY AND o.status != 4
                    GROUP BY DATE(order_date) ORDER BY o.order_date ASC";
        }

        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $labels[] = $row['label'];
            $values[] = (float)$row['total'];
        }

        return ['labels' => $labels, 'values' => $values];
    }

    // Lấy toàn bộ danh sách đơn hàng kèm thông tin người mua (Đã lấy thêm shipping_fee)
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

    // Chuyển đổi trạng thái đơn hàng (Có tích hợp tự động Hoàn Kho)
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

        // NẾU LÀ HỦY ĐƠN (status = 4) -> HOÀN KHO
        if ($status == 4) {
            // Lấy danh sách sản phẩm trong đơn
            $sqlItems = "SELECT item_id, quantity FROM order_details WHERE order_id = :order_id";
            $stmtItems = $this->conn->prepare($sqlItems);
            $stmtItems->execute([':order_id' => $order_id]);
            $itemsToRestore = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            // Cộng lại kho cho từng sản phẩm
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

    // Lấy thông tin chung của 1 đơn hàng cụ thể
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

    // Lấy danh sách các giáo trình nằm trong đơn hàng đó
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