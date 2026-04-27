<?php
class HomeController extends Controller {
    public function index() {
        // 1. Giữ lại phần khởi tạo Session của nhánh Task_3
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Giữ lại phần gọi View của nhánh news-admin
        $data['title'] = "Trang chủ BK88";
        $this->view('public/home/index', $data);
    }
}
?>