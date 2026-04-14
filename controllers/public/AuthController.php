<?php
// FILE: controllers/public/AuthController.php

require_once __DIR__ . '/../../models/UserModel.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ==========================================
    // 1. CÁC HÀM HIỂN THỊ GIAO DIỆN (VIEW)
    // ==========================================
    public function login() {
        $data['title'] = "Đăng nhập - BK88";
        $this->view('public/auth/login', $data);
    }

    public function register() {
        $data['title'] = "Đăng ký - BK88";
        $this->view('public/auth/register', $data);
    }

    // ==========================================
    // 2. XỬ LÝ LOGIC ĐĂNG KÝ
    // ==========================================
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $repassword = $_POST['repassword'] ?? '';
            $isAjax = isset($_POST['ajax']) && $_POST['ajax'] == 1;

            if (empty($fullname) || empty($email) || empty($password)) {
                if($isAjax) { echo json_encode(['status'=>'error', 'message'=>'Điền đủ thông tin!']); exit; }
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
                header("Location: " . BASE_URL . "auth/register"); exit;
            }

            if ($password !== $repassword) {
                if($isAjax) { echo json_encode(['status'=>'error', 'message'=>'Mật khẩu không khớp!']); exit; }
                $_SESSION['error'] = "Mật khẩu không khớp.";
                header("Location: " . BASE_URL . "auth/register"); exit;
            }

            if ($this->userModel->checkEmailExists($email)) {
                if($isAjax) { echo json_encode(['status'=>'error', 'message'=>'Email đã tồn tại!']); exit; }
                $_SESSION['error'] = "Email này đã được sử dụng.";
                header("Location: " . BASE_URL . "auth/register"); exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($this->userModel->registerUser($fullname, $email, $hashedPassword, $phone)) {
                if($isAjax) { echo json_encode(['status'=>'success', 'message'=>'Đăng ký thành công! Đang chuyển sang đăng nhập...']); exit; }
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: " . BASE_URL . "auth/login");
            } else {
                if($isAjax) { echo json_encode(['status'=>'error', 'message'=>'Lỗi hệ thống!']); exit; }
                $_SESSION['error'] = "Lỗi hệ thống, vui lòng thử lại sau.";
                header("Location: " . BASE_URL . "auth/register");
            }
            exit;
        }
    }

    // ==========================================
    // 3. XỬ LÝ LOGIC ĐĂNG NHẬP
    // ==========================================
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login_id = trim($_POST['login_id'] ?? '');
            $password = $_POST['password'] ?? '';
            $isAjax = isset($_POST['ajax']) && $_POST['ajax'] == 1;

            $user = $this->userModel->getUserByEmailOrPhone($login_id);

            // MẸO: Chấp nhận cả mật khẩu đã hash VÀ mật khẩu thô ('1') từ file SQL của nhóm
            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                
                // ĐÃ SỬA: Dùng đúng tên cột mới của DB (user_id, lastname, firstname)
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = trim(($user['lastname'] ?? '') . ' ' . ($user['firstname'] ?? ''));
                $_SESSION['user_role'] = $user['role'];

                $redirectUrl = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : BASE_URL . "home";
                unset($_SESSION['redirect_after_login']);

                if ($isAjax) {
                    echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                    exit;
                }
                header("Location: " . $redirectUrl);
            } else {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không chính xác.']);
                    exit;
                }
                
                $_SESSION['error'] = "Email hoặc mật khẩu không chính xác.";
                $_SESSION['old_login_id'] = $login_id; 
                header("Location: " . BASE_URL . "auth/login");
            }
            exit;
        }
    }

    // ==========================================
    // 4. ĐĂNG XUẤT
    // ==========================================
    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "home");
        exit;
    }
}