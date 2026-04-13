<?php
// FILE: controllers/public/OnestepcheckoutController.php

class OnestepcheckoutController extends Controller {

    public function __construct() {
        // Kiểm tra đăng nhập
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASE_URL . "onestepcheckout";
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    // Hàm mặc định khi truy cập http://localhost/onestepcheckout
    public function index() {
        $data['title'] = "Thanh toán đơn hàng - BK88";
        $this->view('public/onestepcheckout/index', $data);
    }

    // ========================================================
    // HÀM XỬ LÝ KHI NGƯỜI DÙNG BẤM NÚT "XÁC NHẬN THANH TOÁN"
    // ========================================================
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Nhận thông tin cơ bản
            $receiver_name = trim($_POST['receiver_name'] ?? '');
            $receiver_phone = trim($_POST['receiver_phone'] ?? '');
            $note = trim($_POST['note'] ?? '');

            // 2. NHẬN 5 Ô ĐỊA CHỈ TỪ FORM
            $city = trim($_POST['city'] ?? '');
            $district = trim($_POST['district'] ?? '');
            $ward = trim($_POST['ward'] ?? '');
            $house_number = trim($_POST['house_number'] ?? '');
            $street = trim($_POST['street'] ?? '');

            // 3. THỰC HIỆN NỐI CHUỖI ĐỊA CHỈ
            // Kết quả sẽ ra dạng: "268 Lý Thường Kiệt, Phường 14, Quận 10, TP.HCM"
            $full_address = $house_number . ' ' . $street . ', ' . $ward . ', ' . $district . ', ' . $city;

            // 4. Nhận thông tin thanh toán & vận chuyển
            $delivery_method = $_POST['delivery_method'] ?? 'home'; // home hoặc store
            $payment_method = $_POST['payment_method'] ?? 'cod';
            $total_amount = $_POST['total_amount'] ?? 0;

            // ====================================================
            // IN THỬ RA MÀN HÌNH ĐỂ KIỂM TRA DỮ LIỆU ĐÃ CHUẨN CHƯA
            // ====================================================
            echo "<div style='font-family: sans-serif; padding: 20px;'>";
            echo "<h2 style='color: #0d6efd;'>Đã nhận thông tin đặt hàng!</h2>";
            echo "<p><b>Họ tên:</b> $receiver_name</p>";
            echo "<p><b>Số điện thoại:</b> $receiver_phone</p>";
            echo "<p><b>Địa chỉ hoàn chỉnh:</b> <span style='color: red;'>$full_address</span></p>";
            echo "<p><b>Ghi chú:</b> $note</p>";
            echo "<p><b>Hình thức nhận hàng:</b> $delivery_method</p>";
            echo "<p><b>Tổng thanh toán:</b> " . number_format($total_amount, 0, ',', '.') . " đ</p>";
            echo "<hr>";
            echo "<p><i>Bước tiếp theo: Chúng ta sẽ tạo bảng `orders` và `order_details` trong Database để Insert đống dữ liệu này vào!</i></p>";
            echo "</div>";
            
            exit; // Dừng tạm ở đây để bạn kiểm tra chữ in ra
        }
    }
}