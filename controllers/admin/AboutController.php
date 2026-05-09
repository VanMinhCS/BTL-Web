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
        
        $data['title'] = "Chỉnh sửa Giới thiệu - BK88 Admin";
        $data['about'] = $aboutModel->getAboutData();
        
        // Gọi đến view admin/about/index.php
        $this->view('admin/about/index', $data);
    }

    // Hàm xử lý lưu dữ liệu
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $features = $_POST['features'] ?? '';

            require_once '../models/AboutModel.php';
            $aboutModel = new AboutModel();
            
            if ($aboutModel->updateAbout($title, $description, $features)) {
                header("Location: " . BASE_URL . "admin/about?status=success");
            } else {
                header("Location: " . BASE_URL . "admin/about?status=error");
            }
            exit;
        }
    }
}