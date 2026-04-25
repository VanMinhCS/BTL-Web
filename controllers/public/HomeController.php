<?php
class HomeController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // BẮT ĐẦU ĐOẠN CODE THÊM VÀO: Kiểm tra nếu là Admin
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 1) {
            // Nếu có tham số ?view=public trên URL thì cho phép Admin xem trang User
            if (!isset($_GET['view']) || $_GET['view'] !== 'public') {
                // Nếu không, tự động đá Admin về trang Dashboard (hoặc admin/news)
                header("Location: " . BASE_URL . "admin/dashboard");
                exit;
            }
        }
        // KẾT THÚC ĐOẠN CODE THÊM VÀO

        // ... Các code lấy dữ liệu trang chủ cũ của bạn giữ nguyên ở dưới đây ...
        $data['title'] = "Trang chủ BK88";
        $this->view('public/home/index', $data);
    }
}
?>