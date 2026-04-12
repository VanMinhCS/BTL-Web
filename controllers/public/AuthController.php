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
    // 2. XỬ LÝ LOGIC ĐĂNG KÝ (Nhận dữ liệu từ form)
    // ==========================================
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $repassword = $_POST['repassword'] ?? '';

            // Validate cơ bản
            if (empty($fullname) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc.";
                header("Location: " . BASE_URL . "auth/register");
                exit;
            }

            if ($password !== $repassword) {
                $_SESSION['error'] = "Mật khẩu nhập lại không khớp.";
                header("Location: " . BASE_URL . "auth/register");
                exit;
            }

            // Kiểm tra email trùng
            if ($this->userModel->checkEmailExists($email)) {
                $_SESSION['error'] = "Email này đã được sử dụng.";
                header("Location: " . BASE_URL . "auth/register");
                exit;
            }

            // MÃ HÓA MẬT KHẨU (Bắt buộc để bảo mật)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Lưu vào DB
            if ($this->userModel->registerUser($fullname, $email, $hashedPassword, $phone)) {
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: " . BASE_URL . "auth/login");
            } else {
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
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            // Kiểm tra: Có tìm thấy user không? VÀ Mật khẩu giải mã ra có khớp không?
            if ($user && password_verify($password, $user['password'])) {
                
                // Lưu thông tin vào Session để các trang khác nhận diện
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_role'] = $user['role'];

                // [QUAN TRỌNG] - Logic Redirect về trang Thanh toán mà chúng ta đã bàn trước đó
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirectUrl = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']); // Xóa Session này đi cho sạch
                    header("Location: " . $redirectUrl);
                } else {
                    header("Location: " . BASE_URL . "home"); // Bình thường thì về trang chủ
                }
            } else {
                $_SESSION['error'] = "Email hoặc mật khẩu không chính xác.";
                header("Location: " . BASE_URL . "auth/login");
            }
            exit;
        }
    }

    // ==========================================
    // 4. ĐĂNG XUẤT
    // ==========================================
    public function logout() {
        // Xóa toàn bộ Session
        session_destroy();
        header("Location: " . BASE_URL . "home");
        exit;
    }
}