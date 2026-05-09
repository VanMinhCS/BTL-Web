<?php
class Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // --- BẢO VỆ ĐI TUẦN TRA ---
        // Chỉ kiểm tra những người ĐANG ĐĂNG NHẬP
        if (isset($_SESSION['user_id'])) {
            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel();
            
            if ($userModel->checkIsBanned($_SESSION['user_id'])) {

                session_unset();
                session_destroy();
                

                session_start();
                $_SESSION['error'] = "Tài khoản của bạn vừa bị Quản trị viên khóa do vi phạm chính sách!";
                
                header("Location: " . BASE_URL . "auth/login");
                exit;
            }
        }
    }

    public function view($view, $data = []) {
        extract($data);
        
        // Kiểm tra xem View đang gọi có nằm trong thư mục admin không
        if (strpos($view, 'admin/') === 0) {
            // Lắp ráp giao diện ADMIN
            require_once '../views/admin/layouts/header.php';
            require_once '../views/' . $view . '.php'; // Đây chính là phần ruột
            require_once '../views/admin/layouts/footer.php';
        } else {
            // Lắp ráp giao diện KHÁCH HÀNG (Public)
            require_once '../views/public/layouts/header.php';
            require_once '../views/' . $view . '.php';
            require_once '../views/public/layouts/footer.php';
        }
    }
}