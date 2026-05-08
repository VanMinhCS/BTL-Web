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
        // 1. Lấy thông tin User
        require_once __DIR__ . '/../../models/UserModel.php';
        $userModel = new UserModel();
        $data['currentUser'] = $userModel->getUserProfile($_SESSION['user_id']);

        // 2. Lấy dữ liệu Giỏ hàng và tính tiền (Giống như bên CartController)
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        $dbProducts = $productModel->getAllProducts();
        
        $productsLookup = [];
        foreach ($dbProducts as $p) {
            $productsLookup[$p['item_id']] = $p;
        }

        $checkoutItems = [];
        $subTotal = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $pId = $item['product_id'] ?? $item['id'] ?? 0;
                $qty = $item['quantity'] ?? 1;

                if (isset($productsLookup[$pId])) {
                    $p = $productsLookup[$pId];
                    $itemTotal = $p['price'] * $qty;
                    $subTotal += $itemTotal;

                    $checkoutItems[] = [
                        'name' => $p['item_name'],
                        'quantity' => $qty,
                        'item_total' => $itemTotal
                    ];
                }
            }
        }

        $data['checkoutItems'] = $checkoutItems;
        $data['subTotal'] = $subTotal;
        $data['title'] = "Thanh toán đơn hàng - BK88";

        // 3. Ném toàn bộ dữ liệu sạch sẽ sang View
        $this->view('public/onestepcheckout/index', $data);
    }

    // ========================================================
    // HÀM XỬ LÝ LƯU ĐƠN HÀNG VÀO DATABASE
    // ========================================================
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            require_once __DIR__ . '/../../models/Information.php'; 
            require_once __DIR__ . '/../../models/Order.php';       

            $user_id = $_SESSION['user_id'];
            $city = trim($_POST['city'] ?? '');
            $ward = trim($_POST['ward'] ?? '');
            $street = trim($_POST['street'] ?? ''); 
            $payment_method_raw = $_POST['payment_method'] ?? 'cod';
            $note = isset($_POST['note']) ? trim($_POST['note']) : '';

            try {
                // --- BƯỚC 1: XỬ LÝ ĐỊA CHỈ (CẬP NHẬT ĐỊA CHỈ CÓ SẴN CỦA USER) ---
                require_once __DIR__ . '/../../models/UserModel.php';
                $userModel = new UserModel();
                
                // Lấy thông tin user hiện tại (đã bao gồm address_id được tạo lúc đăng ký)
                $currentUser = $userModel->getUserProfile($user_id);
                $address_id = $currentUser['address_id'];

                if (!empty($address_id)) {
                    // Cập nhật thông tin đường, phường, thành phố vào dòng địa chỉ của riêng user này
                    $userModel->updateAddressInfo($address_id, $street, $ward, $city);
                } else {
                    // Dự phòng cho các account cũ (tạo trước khi có logic đăng ký mới)
                    $addressObj = new Address();
                    $addressObj->setStreet($street); 
                    $addressObj->setWard($ward);
                    $addressObj->setCity($city);
                    $address_id = $addressObj->create(); 
                    
                    // Lệnh này cần viết thêm ở Bước 2 bên dưới
                    $userModel->updateUserAddressId($user_id, $address_id);
                }

                // Bắt phương thức giao hàng từ form
                $delivery_method = $_POST['delivery_method'] ?? 'home';
                $shipping_fee = ($delivery_method === 'home') ? 22000 : 0;

                // --- BƯỚC 2: TẠO ĐƠN HÀNG (ORDER) ---
                date_default_timezone_set('Asia/Ho_Chi_Minh'); 
                $orderObj = new Order();
                $orderObj->setUserId($user_id);
                $orderObj->setOrderDate(date("Y-m-d H:i:s"));
                $orderObj->setStatus(0); 
                $orderObj->setIsPaid(0); 
                $orderObj->setShippingFee($shipping_fee);
                $orderObj->setNote($note);
                
                $order_id = $orderObj->create();

                // --- BƯỚC 3: LƯU CHI TIẾT ĐƠN HÀNG (ORDER DETAILS) ---
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $detailObj = new OrderDetail();
                        $detailObj->setOrderId($order_id);
                        
                        $itemId = $item['product_id'] ?? $item['item_id'] ?? $item['id'] ?? 0;
                        $detailObj->setItemId($itemId); 
                        $detailObj->setQuantity($item['quantity'] ?? 1);
                        
                        $itemDb = new Item();
                        $itemDb->setItemId($itemId); 
                        $currentPrice = $itemDb->getPrice(); 
                        
                        $detailObj->setPrice($currentPrice); 
                        $detailObj->create();
                    }
                }

                // =========================================================
                // BƯỚC 3.5: GỬI THÔNG BÁO CHO ADMIN (ĐÃ CHÈN)
                // =========================================================
                require_once __DIR__ . '/../../models/Notification.php';

                // 1. Tạo chi tiết đơn hàng cho bảng notification_order
                $notifyOrder = new NotificationOrder();
                $notifyOrder->setOrderId($order_id); // Dùng biến $order_id có sẵn của hàm
                $notifyOrder->setOrderStatus('chờ xác nhận');
                $notifyOrder->create();

                // Lấy ID vừa được sinh ra
                $notifyOrderId = $notifyOrder->getId();

                // 2. Tạo thông báo tổng quát cho bảng notifications
                $notification = new Notification();
                $notification->setType('order');
                $notification->setUserId($user_id); // Dùng biến $user_id có sẵn của hàm
                $notification->setNotificationOrderId($notifyOrderId);
                $notification->setIsRead(0);
                $notification->create();
                // =========================================================

                // --- BƯỚC 4: HOÀN TẤT VÀ CHUYỂN HƯỚNG TRANG ---
                unset($_SESSION['cart']);

                // Lưu tạm mã đơn hàng vào Session để in ra ở trang Success
                $_SESSION['last_order_id'] = $order_id;
                
                // Đá người dùng sang trang thông báo thành công thay vì trang chủ
                header("Location: " . BASE_URL . "onestepcheckout/success"); 
                exit;

            } catch (Exception $e) {
                die("Lỗi hệ thống: " . $e->getMessage());
            }
        }
    }

    // ========================================================
    // HÀM HIỂN THỊ TRANG THÀNH CÔNG
    // ========================================================
    public function success() {
        // Nếu người dùng cố tình gõ URL vào trang này mà không có đơn hàng vừa đặt, đá về trang chủ
        if (!isset($_SESSION['last_order_id'])) {
            header("Location: " . BASE_URL . "home");
            exit;
        }

        $data['title'] = "Đặt hàng thành công - BK88";
        $data['order_id'] = $_SESSION['last_order_id'];
        
        // Hủy session để tránh việc người dùng F5 lại trang này nhiều lần
        unset($_SESSION['last_order_id']);

        $this->view('public/onestepcheckout/success', $data);
    }
}
?>