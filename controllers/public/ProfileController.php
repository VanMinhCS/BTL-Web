<?php
// FILE: controllers/public/ProfileController.php

class ProfileController extends Controller {
    private $userModel;

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
}