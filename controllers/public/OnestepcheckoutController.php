<?php
// FILE: controllers/public/OnestepcheckoutController.php

class OnestepcheckoutController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASE_URL . "onestepcheckout";
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        $data['title'] = "Thanh toán đơn hàng - BK88";
        $this->view('public/onestepcheckout/index', $data);
    }

    // ========================================================
    // HÀM XỬ LÝ LƯU ĐƠN HÀNG VÀO DATABASE
    // ========================================================
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Nhúng các class bằng đường dẫn TƯƠNG ĐỐI TỪ THƯ MỤC GỐC để tránh lỗi
            require_once __DIR__ . '/../../models/Information.php'; // Chứa Address, Information
            require_once __DIR__ . '/../../models/Order.php';       // Chứa Order, OrderDetail, Item

            // 2. Lấy dữ liệu từ Form (Đã bỏ district và house_number)
            $user_id = $_SESSION['user_id'];
            $city = trim($_POST['city'] ?? '');
            $ward = trim($_POST['ward'] ?? '');
            $street = trim($_POST['street'] ?? ''); // Ô này giờ đã chứa sẵn "Số nhà & Tên đường"
            
            $payment_method_raw = $_POST['payment_method'] ?? 'cod';
            $total_amount = $_POST['total_amount'] ?? 0;

            try {
                // --- BƯỚC 1: LƯU ĐỊA CHỈ MỚI ---
                $addressObj = new Address();
                $addressObj->setStreet($street); 
                $addressObj->setWard($ward);
                $addressObj->setCity($city);
                
                // Hứng ID ngay khi chạy lệnh create()
                $address_id = $addressObj->create(); 

                // --- BƯỚC 2: TẠO ĐƠN HÀNG (ORDER) ---
                
                date_default_timezone_set('Asia/Ho_Chi_Minh'); 
                
                $orderObj = new Order();
                $orderObj->setUserId($user_id);
                $orderObj->setOrderDate(date("Y-m-d H:i:s")); // Bây giờ hàm date() sẽ chạy đúng giờ VN
                $orderObj->setStatus(0); 
                $orderObj->setIsPaid(0); 
                $orderObj->setPaymentMethod($payment_method_raw == 'cod' ? 0 : 1);
                
                // Hứng ID ngay khi chạy lệnh create()
                $order_id = $orderObj->create();

                // --- BƯỚC 3: LƯU CHI TIẾT ĐƠN HÀNG (ORDER DETAILS) ---
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $detailObj = new OrderDetail();
                        $detailObj->setOrderId($order_id);
                        
                        // 1. Lấy ID sản phẩm từ giỏ hàng
                        $itemId = $item['product_id'] ?? $item['item_id'] ?? $item['id'] ?? 0;
                        $detailObj->setItemId($itemId); 
                        $detailObj->setQuantity($item['quantity'] ?? 1);
                        
                        // 2. LẤY GIÁ GỐC TỪ DATABASE (Bảo mật tuyệt đối, chống gian lận giá)
                        $itemDb = new Item();
                        $itemDb->setItemId($itemId); // Khi set ID, class Item sẽ tự động lấy dữ liệu từ DB
                        $currentPrice = $itemDb->getPrice(); // Rút giá tiền chuẩn ra
                        
                        $detailObj->setPrice($currentPrice); 
                        
                        // 3. Lưu vào chi tiết đơn hàng
                        $detailObj->create();
                    }
                }

                // --- BƯỚC 4: HOÀN TẤT ---
                // Xóa giỏ hàng sau khi đặt thành công
                unset($_SESSION['cart']);

                // Chuyển hướng sang trang thông báo thành công
                $_SESSION['success_order'] = "Chúc mừng! Đơn hàng #$order_id của bạn đã được đặt thành công.";
                header("Location: " . BASE_URL . "home"); 
                exit;

            } catch (Exception $e) {
                die("Lỗi hệ thống: " . $e->getMessage());
            }
        }
    }
}