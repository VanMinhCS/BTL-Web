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
        
        // ==========================================
        // THIẾT LẬP PHÂN TRANG (5 Đơn/Trang)
        // ==========================================
        $limit = 5; 
        
        // Lấy số trang từ URL (VD: index.php?url=order&page=2)
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        
        // Tính vị trí bắt đầu lấy dữ liệu trong Database
        $offset = ($currentPage - 1) * $limit;
        
        // Đếm tổng số đơn hàng của người dùng này
        $totalOrders = $orderModel->countUserOrders($user_id);
        
        // Tính tổng số trang (Làm tròn lên)
        $totalPages = ceil($totalOrders / $limit);
        
        // Lấy danh sách đơn hàng tương ứng với trang hiện tại
        $orderData = $orderModel->getPaginatedOrderHistory($user_id, $limit, $offset);
        
        // ==========================================
        // GÓI DỮ LIỆU ĐẨY SANG VIEW
        // ==========================================
        $data['title'] = "Đơn mua của tôi - BK88";
        $data['orders'] = $orderData;
        $data['currentPage'] = $currentPage;
        $data['totalPages'] = $totalPages;
        
        // Gọi giao diện View
        $this->view('public/order/index', $data);
    }
}
?>