<?php
// FILE: controllers/public/CartController.php
class CartController extends Controller {
    
    public function add() {
        $id = $_POST['product_id'] ?? null;
        $qty = (int)($_POST['quantity'] ?? 1);

        if ($id) {
            if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] += $qty;
            } else {
                $_SESSION['cart'][$id] = ['id' => $id, 'quantity' => $qty];
            }
        }

        // [TÍNH NĂNG MỚI]: Nếu gọi bằng AJAX (gửi ngầm) -> Trả về số lượng mới để update icon
        if (isset($_POST['ajax']) && $_POST['ajax'] == 1) {
            $cartCount = 0;
            foreach($_SESSION['cart'] as $item) { $cartCount += $item['quantity']; }
            echo $cartCount; // Trả về con số thuần túy (VD: 3)
            exit();
        }

        // Nếu không có AJAX (fallback cho trình duyệt cũ), vẫn load lại trang như cũ
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function index() {
        $data['title'] = "Giỏ hàng - BK88";
        $this->view('public/cart/index', $data);
    }

    // Xử lý Tăng/Giảm số lượng
    public function update() {
        $id = $_POST['product_id'] ?? null;
        $action = $_POST['action'] ?? null;

        if ($id && isset($_SESSION['cart'][$id])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$id]['quantity']++; // Tăng 1
            } elseif ($action === 'decrease') {
                // CHỈ GIẢM KHI SỐ LƯỢNG LỚN HƠN 1
                if ($_SESSION['cart'][$id]['quantity'] > 1) {
                    $_SESSION['cart'][$id]['quantity']--; 
                }
                // (Đã xóa đoạn xóa sản phẩm ở đây)
            }
        }
        
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }

    public function remove() {
        $id = $_POST['product_id'] ?? null;
        
        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]); // Xóa khỏi Session
        }
        
        // --- BỔ SUNG: Trả lời lại cho Javascript (AJAX) ---
        if (isset($_POST['ajax']) && $_POST['ajax'] == 1) {
            $cartCount = 0;
            if(isset($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $item) { $cartCount += $item['quantity']; }
            }
            // Trả về định dạng JSON báo thành công và số lượng mới
            echo json_encode(['status' => 'success', 'cartCount' => $cartCount]);
            exit();
        }
        
        // Fallback: Xóa xong thì tự động load lại trang giỏ hàng
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }
}