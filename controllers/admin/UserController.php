<?php
class UserController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    // Load giao diện danh sách
    public function index() {
        require_once '../models/UserModel.php';
        $userModel = new UserModel();
        
        $data['title'] = "Quản lý Thành viên - BK88 Admin";
        $data['users'] = $userModel->getAllUsers();
        
        $this->view('admin/user/index', $data);
    }
    public function toggleBan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
            $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

            header('Content-Type: application/json');

            if ($user_id > 0) {
                if ($user_id == $_SESSION['user_id']) {
                    echo json_encode(['success' => false, 'message' => 'Bạn không thể tự khóa tài khoản của mình!']);
                    exit;
                }
                require_once '../models/UserModel.php';
                $userModel = new UserModel();
                
                if ($userModel->toggleBanStatus($user_id, $status)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật Database.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID không hợp lệ.']);
            }
            exit;
        }
    }
}