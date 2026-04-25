<?php
class HomeController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ... Các code lấy dữ liệu trang chủ cũ của bạn giữ nguyên ở dưới đây ...
        $data['title'] = "Trang chủ BK88";
        $this->view('public/home/index', $data);
    }
}
?>