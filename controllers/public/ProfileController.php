<?php
// FILE: controllers/public/ProfileController.php

class ProfileController extends Controller {
    private UserModel $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
        require_once __DIR__ . '/../../models/UserModel.php';
        $this->userModel = new UserModel();
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        // Gọi hàm từ model
        $userInfo = $this->userModel->getUserProfile($user_id);

        $data['title'] = "Tài khoản của tôi - BK88";
        $data['user'] = $userInfo;
        
        $this->view('public/profile/index', $data);
    }

    public function updateInfo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);

            // Tách tên
            $nameParts = explode(' ', $fullname);
            $firstname = array_pop($nameParts);
            $lastname = implode(' ', $nameParts);

            // Gọi model xử lý
            $success = $this->userModel->updateProfileInfo($user_id, $firstname, $lastname, $phone);

            if ($success) {
                $_SESSION['user_name'] = $fullname;
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
            exit;
        }
    }

    public function updateAddress() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $address_id = $_POST['address_id'];
            $street = trim($_POST['street']);
            $ward = trim($_POST['ward']);
            $city = trim($_POST['city']);

            // Gọi model xử lý
            $success = $this->userModel->updateAddressInfo($address_id, $street, $ward, $city);

            echo json_encode(['status' => ($success ? 'success' : 'error')]);
            exit;
        }
    }


    // ==========================================
    // XỬ LÝ ĐỔI MẬT KHẨU
    // ==========================================
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ép kiểu dữ liệu trả về luôn là JSON để AJAX không bị lỗi
            header('Content-Type: application/json');

            $user_id = $_SESSION['user_id'] ?? null;
            if (!$user_id) {
                echo json_encode(['status' => 'error', 'message' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại!']);
                exit();
            }

            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Kiểm tra rỗng
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                echo json_encode(['status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin!']);
                exit();
            }

            // Kiểm tra khớp mật khẩu
            if ($new_password !== $confirm_password) {
                echo json_encode(['status' => 'error', 'message' => 'Mật khẩu xác nhận không khớp!']);
                exit();
            }

            require_once __DIR__ . '/../../models/UserModel.php';
            $userModel = new UserModel();
            
            // Giả định bạn có hàm getUserById trong UserModel để lấy thông tin user hiện tại
            $user = $userModel->getUserById($user_id); 

            if ($user) {
                // Kiểm tra mật khẩu cũ (hỗ trợ cả mật khẩu đã mã hóa và chưa mã hóa giống form Login)
                if (password_verify($current_password, $user['password']) || $current_password === $user['password']) {
                    
                    // Mã hóa mật khẩu mới
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    // Cập nhật vào DB (Tận dụng hàm updatePassword đã có sẵn ở logic Quên mật khẩu)
                    $updateStatus = $userModel->updatePassword($user_id, $hashed_password);

                    if ($updateStatus) {
                        echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu thành công!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật mật khẩu!']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Mật khẩu hiện tại không chính xác!']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy thông tin người dùng!']);
            }
            
            exit();
        }
    }
}