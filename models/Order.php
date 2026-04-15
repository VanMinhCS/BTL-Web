<?php
// FILE: models/Order.php
require_once __DIR__ . '/../core/Database.php';

class Item extends Database {
    private $item_id;
    private $item_name;
    private $item_stock;
    private $description;
    private $price;
    private $item_image;

    public function getItemId() { return $this->item_id; }
    public function setItemId($id) { $this->item_id = $id; $this->loadById($id); }

    public function getItemName() { return $this->item_name; }
    public function setItemName($name) { $this->item_name = $name; }

    public function getItemStock() { return $this->item_stock; }
    public function setItemStock($stock) { $this->item_stock = $stock; }

    public function getDescription() { return $this->description; }
    public function setDescription($desc) { $this->description = $desc; }

    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }

    public function getItemImage() { return $this->item_image; }
    public function setItemImage($img) { $this->item_image = $img; }

    private function loadById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE item_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->item_id    = $result['item_id'];
            $this->item_name  = $result['item_name'];
            $this->item_stock = $result['item_stock'];
            $this->description= $result['description'];
            $this->price      = $result['price'];
            $this->item_image = $result['item_image'];
        }
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO items (item_name, item_stock, description, price, item_image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->item_name, $this->item_stock, $this->description, $this->price, $this->item_image]);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE items SET item_name=?, item_stock=?, description=?, price=?, item_image=? WHERE item_id=?");
        return $stmt->execute([$this->item_name, $this->item_stock, $this->description, $this->price, $this->item_image, $this->item_id]);
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM items WHERE item_id=?");
        return $stmt->execute([$this->item_id]);
    }
}

class Order extends Database {
    private $order_id;
    private $user_id;
    private $order_date;
    private $status;
    private $is_paid;
    private $payment_method;
    private $shipping_fee; // Đã thêm cột phí ship

    public function getOrderId() { return $this->order_id; }
    public function setOrderId($id) { $this->order_id = $id; $this->loadById($id); }

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { $this->user_id = $id; }

    public function getOrderDate() { return $this->order_date; }
    public function setOrderDate($date) { $this->order_date = $date; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getIsPaid() { return $this->is_paid; }
    public function setIsPaid($paid) { $this->is_paid = $paid; }

    public function getPaymentMethod() { return $this->payment_method; }
    public function setPaymentMethod($method) { $this->payment_method = $method; }

    public function getShippingFee() { return $this->shipping_fee; }
    public function setShippingFee($fee) { $this->shipping_fee = $fee; }

    private function loadById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE order_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->order_id       = $result['order_id'];
            $this->user_id        = $result['user_id'];
            $this->order_date     = $result['order_date'];
            $this->status         = $result['status'];
            $this->is_paid        = $result['is_paid'];
            $this->payment_method = $result['payment_method'];
            $this->shipping_fee   = $result['shipping_fee'];
        }
    }

    public function create() {
        // Đã cập nhật câu SQL để Insert shipping_fee
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, order_date, status, is_paid, payment_method, shipping_fee) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->user_id, $this->order_date, $this->status, $this->is_paid, $this->payment_method, $this->shipping_fee]);
        return $this->conn->lastInsertId();
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE orders SET user_id=?, order_date=?, status=?, is_paid=?, payment_method=?, shipping_fee=? WHERE order_id=?");
        return $stmt->execute([$this->user_id, $this->order_date, $this->status, $this->is_paid, $this->payment_method, $this->shipping_fee, $this->order_id]);
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE order_id=?");
        return $stmt->execute([$this->order_id]);
    }

    public function getFullOrderHistory($user_id) {
        $sqlOrders = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
        $stmtOrders = $this->conn->prepare($sqlOrders);
        $stmtOrders->execute([$user_id]);
        $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
        
        $orderData = [];
        foreach ($orders as $o) {
            $order_id = $o['order_id'];
            
            $sqlDetails = "SELECT od.*, i.item_name, i.item_image 
                           FROM order_details od 
                           JOIN items i ON od.item_id = i.item_id 
                           WHERE od.order_id = ?";
            $stmtDetails = $this->conn->prepare($sqlDetails);
            $stmtDetails->execute([$order_id]);
            $details = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);
            
            $total = 0;
            foreach ($details as $d) {
                $total += $d['price'] * $d['quantity'];
            }
            
            $o['details'] = $details;
            $o['total_amount'] = $total;
            $orderData[] = $o;
        }
        
        return $orderData;
    }
}

class OrderDetail extends Database {
    private $detail_id;
    private $order_id;
    private $item_id;
    private $quantity;
    private $price;

    public function getDetailId() { return $this->detail_id; }
    public function setDetailId($id) { $this->detail_id = $id; $this->loadById($id); }

    public function getOrderId() { return $this->order_id; }
    public function setOrderId($id) { $this->order_id = $id; }

    public function getItemId() { return $this->item_id; }
    public function setItemId($id) { $this->item_id = $id; }

    public function getQuantity() { return $this->quantity; }
    public function setQuantity($qty) { $this->quantity = $qty; }

    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }

    private function loadById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM order_details WHERE detail_id=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->detail_id = $result['detail_id'];
            $this->order_id  = $result['order_id'];
            $this->item_id   = $result['item_id'];
            $this->quantity  = $result['quantity'];
            $this->price     = $result['price'];
        }
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO order_details (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->order_id, $this->item_id, $this->quantity, $this->price]);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE order_details SET order_id=?, item_id=?, quantity=?, price=? WHERE detail_id=?");
        return $stmt->execute([$this->order_id, $this->item_id, $this->quantity, $this->price, $this->detail_id]);
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM order_details WHERE detail_id=?");
        return $stmt->execute([$this->detail_id]);
    }
}
?>