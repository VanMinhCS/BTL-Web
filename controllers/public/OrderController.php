<?php
// FILE: controllers/public/OrderController.php

class OrderController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Bắt buộc phải đăng nhập mới được xem đơn hàng
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        require_once __DIR__ . '/../../models/Order.php';
        
        $orderModel = new Order();
        $user_id = $_SESSION['user_id'];
        
        // Chỉ cần gọi 1 dòng duy nhất, không cần đụng chạm gì đến getConnection() nữa!
        $orderData = $orderModel->getFullOrderHistory($user_id);
        
        $data['title'] = "Đơn mua của tôi - BK88";
        $data['orders'] = $orderData;
        
        // Gọi giao diện View
        $this->view('public/order/index', $data);
    }
}
?>