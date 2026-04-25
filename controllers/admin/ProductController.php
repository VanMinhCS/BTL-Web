<?php
// FILE: controllers/admin/ProductController.php
class ProductController extends Controller {
    
    public function __construct() {
        // 1. Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }

        // 3. Kiểm tra quyền Admin (role = 1 trong DB bk88.sql)
        if ($_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "home");
            exit;
        }
    }

    public function index() {
        // Gọi Model để lấy dữ liệu giáo trình
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Lấy dữ liệu từ bảng `items`
        $data['products'] = $productModel->getAllProducts();
        
        $data['title'] = "Quản lý giáo trình - Admin";
        $data['currentPage'] = 'product'; 
        
        // Gọi View và tự động kẹp layout admin
        $this->view('admin/product/index', $data);
    }
}