<?php

class OnestepcheckoutController extends Controller {
    
    // Middleware kiểm tra đăng nhập được gọi đầu tiên
    public function __construct() {
        // Đảm bảo session đã chạy (phòng hờ)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // KIỂM TRA ĐĂNG NHẬP
        // Giả sử khi user đăng nhập thành công, bạn lưu ID của họ vào $_SESSION['user_id']
        // Nếu chưa có session này -> Chưa đăng nhập -> Đuổi về trang login
        if (!isset($_SESSION['user_id'])) {
            
            // Mẹo UX: Lưu lại trang người dùng đang muốn vào (checkout) 
            // để lát nữa đăng nhập xong tự động redirect trả về đây
            $_SESSION['redirect_after_login'] = BASE_URL . 'onestepcheckout';
            
            // Đẩy về trang đăng nhập
            header('Location: ' . BASE_URL . 'auth/login');
            exit(); // Bắt buộc phải có exit() để ngắt luồng thực thi
        }
    }

    public function index() {
        // Nếu đoạn code chạy được xuống đây, có nghĩa là đã qua ải kiểm tra đăng nhập!
        
        echo "<h1 style='text-align:center; margin-top:100px; font-family:sans-serif;'>TRANG ĐIỀN THÔNG TIN THANH TOÁN</h1>";
        echo "<h3 style='text-align:center; color: green;'>Chào mừng User #" . $_SESSION['user_id'] . " đã đăng nhập thành công!</h3>";
        echo "<p style='text-align:center;'>Giao diện form Checkout sẽ được xây dựng ở đây.</p>";
        echo "<div style='text-align:center;'><a href='" . BASE_URL . "cart'>Quay lại giỏ hàng</a></div>";
        
        // Sau này bạn sẽ gọi View thực sự ra như thế này:
        // $data['title'] = "Thanh toán - BK88";
        // $this->view('public/checkout/index', $data);
    }
}