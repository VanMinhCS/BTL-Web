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
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];

            // 1. Kiểm tra mật khẩu khớp
            if ($password !== $repassword) {
                echo json_encode(['status' => 'error', 'message' => 'Mật khẩu nhập lại không khớp!']);
                return;
            }

            require_once __DIR__ . '/../../models/UserModel.php';
            $userModel = new UserModel();

            // 2. Kiểm tra Email tồn tại
            if ($userModel->checkEmailExists($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Email này đã được đăng ký!']);
                return;
            }

            // 3. Mã hóa mật khẩu và Lưu vào Database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $userModel->registerUser($fullname, $email, $hashed_password, $phone);

            if ($user_id) {
                // --- BẮT ĐẦU LUỒNG XỬ LÝ OTP ---
                
                // A. Tạo mã 6 số ngẫu nhiên
                $otpCode = rand(100000, 999999);
                
                // B. Lưu OTP vào Database
                $userModel->createOTP($user_id, $otpCode);
                
                // C. Gọi Bưu tá gửi Mail
                require_once __DIR__ . '/../../models/MailService.php';
                $isSent = MailService::sendOTP($email, $otpCode);

                if ($isSent) {
                    // Trả về status 'otp_required' để frontend biết đường mở popup OTP
                    echo json_encode([
                        'status' => 'otp_required', 
                        'user_id' => $user_id, // Gửi kèm ID để lát nữa xác thực
                        'email' => $email,
                        'message' => 'Đăng ký thành công! Vui lòng kiểm tra Email để lấy mã OTP.'
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi gửi mail xác thực. Vui lòng thử lại!']);
                }

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi đăng ký!']);
            }
        }
    }

    // ==========================================
    // 2.5 XỬ LÝ XÁC THỰC OTP
    // ==========================================
    public function processVerifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['user_id'] ?? '';
            $otp_code = trim($_POST['otp_code'] ?? '');

            if (empty($user_id) || empty($otp_code)) {
                echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ!']);
                return;
            }

            require_once __DIR__ . '/../../models/UserModel.php';
            $userModel = new UserModel();

            // 1. Kiểm tra OTP
            $otpData = $userModel->validateOTP($user_id, $otp_code);

            if ($otpData) {
                // 2. Nếu đúng thì kích hoạt tài khoản
                if ($userModel->activateUser($user_id)) {
                    echo json_encode(['status' => 'success', 'message' => 'Xác thực thành công! Hệ thống đang chuyển hướng...']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi kích hoạt tài khoản!']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Mã OTP không đúng hoặc đã hết hạn!']);
            }
        }
    }

    // ==========================================
    // 5. HIỂN THỊ TRANG QUÊN MẬT KHẨU ĐẦY ĐỦ
    // ==========================================
    public function forgot() {
        $data['title'] = "Quên mật khẩu - BK88";
        $this->view('public/auth/forgot_password', $data);
    }

    // ==========================================
    // 6. XỬ LÝ GỬI MÃ OTP QUÊN MẬT KHẨU
    // ==========================================
    public function processSendResetOTP() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            
            require_once __DIR__ . '/../../models/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserByEmailVerified($email);

            if ($user) {
                $otpCode = rand(100000, 999999);
                $userModel->createOTP($user['user_id'], $otpCode);
                
                require_once __DIR__ . '/../../models/MailService.php';
                if (MailService::sendOTP($email, $otpCode)) {
                    echo json_encode(['status' => 'success', 'message' => 'Mã OTP đã được gửi! Vui lòng kiểm tra email.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi gửi mail!']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Email không tồn tại hoặc chưa được kích hoạt!']);
            }
        }
    }

    // ==========================================
    // 7. XỬ LÝ ĐẶT LẠI MẬT KHẨU
    // ==========================================
    public function processResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $otp_code = trim($_POST['otp_code'] ?? '');
            $new_password = $_POST['new_password'] ?? '';

            if (empty($email) || empty($otp_code) || empty($new_password)) {
                echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin!']); return;
            }

            require_once __DIR__ . '/../../models/UserModel.php';
            $userModel = new UserModel();
            $user = $userModel->getUserByEmailVerified($email);

            if ($user) {
                // Kiểm tra OTP
                $otpData = $userModel->validateOTP($user['user_id'], $otp_code);
                if ($otpData) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $userModel->updatePassword($user['user_id'], $hashed_password);
                    
                    // Vô hiệu hóa OTP sau khi dùng (Gọi qua Model cho chuẩn OOP)
                    $userModel->deactivateOTP($user['user_id']);

                    echo json_encode(['status' => 'success', 'message' => 'Đổi mật khẩu thành công! Bạn có thể đăng nhập.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Mã OTP không đúng hoặc đã hết hạn!']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi xác thực người dùng!']);
            }
        }
    }

    // ==========================================
    // 3. XỬ LÝ LOGIC ĐĂNG NHẬP
    // ==========================================
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login_id = trim($_POST['login_id'] ?? '');
            $password = $_POST['password'] ?? '';
            $isAjax   = isset($_POST['ajax']) && $_POST['ajax'] == 1;

            $user = $this->userModel->getUserByEmailOrPhone($login_id);

            // Chấp nhận cả mật khẩu đã hash VÀ mật khẩu thô
            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                
                // Lưu thông tin vào session
                $_SESSION['user_id']   = $user['user_id'];
                $_SESSION['user_name'] = trim(($user['lastname'] ?? '') . ' ' . ($user['firstname'] ?? ''));
                $_SESSION['user_role'] = $user['role'];

                // Điều hướng theo role
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirectUrl = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                } else {
                    if ($_SESSION['user_role'] === 1) {
                        $redirectUrl = BASE_URL . "admin/news";
                    } else {
                        $redirectUrl = BASE_URL . "home";
                    }
                }

                if ($isAjax) {
                    echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
                    exit;
                }
                header("Location: " . $redirectUrl);
                exit;
            } else {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không chính xác.']);
                    exit;
                }
                
                $_SESSION['error'] = "Email hoặc mật khẩu không chính xác.";
                $_SESSION['old_login_id'] = $login_id; 
                header("Location: " . BASE_URL . "auth/login");
                exit;
            }
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