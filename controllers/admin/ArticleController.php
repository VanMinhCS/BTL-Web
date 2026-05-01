<?php
class ArticleController extends Controller {
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
        $data['title'] = "Bài viết của BK88";
        $this->view('admin/article/index', $data);
    }
    
    public function view($view, $data = []) {
        $basePath = __DIR__ . '/../../views/';
        $fullPath = $basePath . $view . '.php';
        
        if (file_exists($fullPath)) {
            extract($data);
            // Chỉ load nội dung chính, không header/footer
            require_once $fullPath;
        } else {
            die("View không tồn tại: " . $fullPath);
        }
    }
}