<?php
class AboutController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        require_once '../models/AboutModel.php';
        $aboutModel = new AboutModel();
        require_once '../models/ProductModel.php'; // Đường dẫn tới Model xử lý bảng item của bạn
        $productModel = new ProductModel();

    // Lấy danh sách sản phẩm ném sang View
    $data['all_items'] = $productModel->getAllItems();
        $data['title'] = "Chỉnh sửa Giới thiệu - BK88 Admin";
        $data['about'] = $aboutModel->getAboutData();
        
        // Gọi đến view admin/about/index.php
        $this->view('admin/about/index', $data);
    }

    // Hàm xử lý lưu dữ liệu
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $features = $_POST['features'];
            
            // Lấy danh sách ID sản phẩm được tick, gom lại thành chuỗi phân cách bằng dấu phẩy
            $featured_items_arr = isset($_POST['featured_items']) ? $_POST['featured_items'] : [];
            $featured_items = implode(',', $featured_items_arr);

            require_once '../models/AboutModel.php';
            $aboutModel = new AboutModel();
            
            // Truyền thêm biến $featured_items vào hàm update của Model
            $aboutModel->updateAbout($title, $description, $features, $featured_items);

            header("Location: " . BASE_URL . "admin/about");
            exit;
        }
    }
}