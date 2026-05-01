<?php
// FILE: controllers/public/AccountController.php

class AccountController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Bắt buộc đăng nhập mới được vào trang này
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        $data['title'] = "Quản lý tài khoản - BK88";
        $this->view('public/account/index', $data);
    }
}
?>