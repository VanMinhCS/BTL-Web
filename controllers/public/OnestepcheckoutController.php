<?php
// FILE: controllers/public/OnestepcheckoutController.php

class OnestepcheckoutController extends Controller {

    public function __construct() {
        // Kiểm tra đăng nhập: Nếu chưa đăng nhập thì không cho vào trang thanh toán
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            // Lưu lại trang hiện tại để sau khi đăng nhập xong nó quay lại đây
            $_SESSION['redirect_after_login'] = BASE_URL . "onestepcheckout";
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    // Hàm mặc định khi truy cập http://localhost/onestepcheckout
    public function index() {
        $data['title'] = "Thanh toán đơn hàng - BK88";
        
        // Đây chính là lệnh gọi đến cái file bạn vừa tạo ở thư mục views!
        $this->view('public/onestepcheckout/index', $data);
    }

    // Hàm xử lý khi người dùng bấm nút "Xác nhận thanh toán"
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Logic lưu đơn hàng vào Database sẽ viết ở đây
            echo "Đang xử lý đơn hàng... Chúc mừng bạn đã thắng lớn!";
        }
    }
}