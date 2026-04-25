<?php
class NewsController extends Controller { 
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Bắt buộc đăng nhập mới được vào trang này
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        if ($_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "home");
            exit;
        }
        $data['title'] = "Trang tin tức của BK88";
        
        $data['currentPage'] = 'dashboard';
        
        // Gọi hàm view() từ class Cha (core/Controller.php)
        $this->view('admin/news/index', $data);
    }
}
?>