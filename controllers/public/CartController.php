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

        if (isset($_POST['ajax']) && $_POST['ajax'] == 1) {
            $cartCount = 0;
            foreach($_SESSION['cart'] as $item) { $cartCount += $item['quantity']; }
            echo $cartCount; 
            exit();
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function index() {
        // 1. GỌI MODEL LẤY DỮ LIỆU TẠI ĐÂY (Chuẩn MVC)
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        $dbProducts = $productModel->getAllProducts();

        // Chuyển mảng Database thành dạng Key-Value để tra cứu cực nhanh (O(1))
        $productsMap = [];
        foreach ($dbProducts as $p) {
            $productsMap[$p['item_id']] = $p;
        }

        $cartItems = [];
        $totalPrice = 0;

        // 2. XỬ LÝ LOGIC GIỎ HÀNG VÀ TÍNH TIỀN
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $sessionItem) {
                $id = $sessionItem['id'];
                
                // Nếu sản phẩm trong giỏ vẫn còn tồn tại trong Database
                if (isset($productsMap[$id])) {
                    $p = $productsMap[$id];
                    $quantity = $sessionItem['quantity'];
                    
                    // Tính toán tiền
                    $rawPrice = (int)$p['price']; // Lấy giá trị số gốc từ DB
                    $itemTotal = $rawPrice * $quantity;
                    $totalPrice += $itemTotal;
                    
                    // Gom dữ liệu đã được Format đẹp đẽ vào mảng mới
                    $cartItems[] = [
                        'id'             => $p['item_id'],
                        'img'            => $p['item_image'],
                        'name'           => $p['item_name'],
                        'quantity'       => $quantity,
                        'price'          => number_format($rawPrice, 0, ',', '.') . '₫',
                        'item_total'     => number_format($itemTotal, 0, ',', '.') . '₫',
                        'raw_item_total' => $itemTotal // Dữ liệu thô để truyền cho JS tính động
                    ];
                }
            }
        }

        // 3. ĐÓNG GÓI VÀ ĐẨY SANG VIEW
        $data['title'] = "Giỏ hàng - BK88";
        $data['cartItems'] = $cartItems;
        $data['totalPrice'] = $totalPrice;

        $this->view('public/cart/index', $data);
    }

    public function update() {
        $id = $_POST['product_id'] ?? null;
        $action = $_POST['action'] ?? null;

        if ($id && isset($_SESSION['cart'][$id])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$id]['quantity']++; 
            } elseif ($action === 'decrease') {
                if ($_SESSION['cart'][$id]['quantity'] > 1) {
                    $_SESSION['cart'][$id]['quantity']--; 
                }
            }
        }
        
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }

    public function remove() {
        $id = $_POST['product_id'] ?? null;
        
        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        
        if (isset($_POST['ajax']) && $_POST['ajax'] == 1) {
            $cartCount = 0;
            if(isset($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $item) { $cartCount += $item['quantity']; }
            }
            echo json_encode(['status' => 'success', 'cartCount' => $cartCount]);
            exit();
        }
        
        header('Location: ' . BASE_URL . 'cart');
        exit();
    }
}
?>