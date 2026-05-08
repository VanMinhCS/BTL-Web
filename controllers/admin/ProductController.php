<?php
// FILE: controllers/admin/ProductController.php
class ProductController extends Controller {
    
    public function __construct() {
        // 1. Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }

        // 3. Kiểm tra quyền Admin (role = 1 trong DB bk88.sql)
        if ($_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "home");
            exit;
        }
    }

    public function overview() {
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Lấy dữ liệu thật từ DB
        $data['stats'] = $productModel->getDashboardStats();
        $data['topSelling'] = $productModel->getTopSelling();
        $data['recentOrders'] = $productModel->getRecentOrders();
        
        $data['title'] = "Tổng quan sản phẩm - Admin";
        $data['currentPage'] = 'product_overview';
        $this->view('admin/product/overview', $data);
    }

    // GỌI TRANG DANH SÁCH ĐƠN HÀNG (Đã được cập nhật lấy dữ liệu thật)
    public function order() {
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Gọi Model để lấy toàn bộ dữ liệu đơn hàng
        $data['orders'] = $productModel->getAllOrders(); 
        
        $data['title'] = "Quản lý đơn hàng - Admin";
        $data['currentPage'] = 'product_order'; // Giữ sáng menu Quản lý đơn hàng
        
        $this->view('admin/product/order', $data);
    }

    // XEM CHI TIẾT ĐƠN HÀNG
    public function orderDetail() {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "admin/product/order");
            exit;
        }

        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        $order_id = $_GET['id'];
        $data['order'] = $productModel->getOrderById($order_id);
        $data['orderItems'] = $productModel->getOrderItems($order_id);
        
        // Nếu ai đó nhập bậy ID không tồn tại trên URL thì đẩy về lại danh sách
        if (!$data['order']) {
            header("Location: " . BASE_URL . "admin/product/order");
            exit;
        }

        $data['title'] = "Chi tiết đơn hàng #" . $order_id . " - Admin";
        $data['currentPage'] = 'product_order'; // Giữ sáng menu Quản lý Đơn hàng
        
        $this->view('admin/product/orderDetail', $data);
    }

    // XỬ LÝ LUỒNG TRẠNG THÁI (WORKFLOW)
    public function processOrderFlow() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['next_status'])) {
            require_once __DIR__ . '/../../models/ProductModel.php';
            $productModel = new ProductModel();
            
            // Đẩy đơn hàng sang bước tiếp theo
            $productModel->advanceOrderStatus($_POST['order_id'], $_POST['next_status']);
            
            // Quay lại trang quản lý
            header("Location: " . BASE_URL . "admin/product/order?status=updated");
            exit;
        }
    }

    public function index() {
        // Gọi Model để lấy dữ liệu giáo trình
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Lấy dữ liệu từ bảng `items`
        $data['products'] = $productModel->getAllProducts();
        
        $data['title'] = "Quản lý giáo trình - Admin";
        $data['currentPage'] = 'product_list'; 
        
        // Gọi View và tự động kẹp layout admin
        $this->view('admin/product/index', $data);
    }

    public function create() {
        $data['title'] = "Thêm giáo trình mới - Admin";
        
        // Cắm cờ để Header biết và bật sáng menu "Thêm giáo trình mới"
        $data['currentPage'] = 'product_create'; 
        
        // Gọi View giao diện Form
        $this->view('admin/product/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 1. Lấy dữ liệu từ Form
            $name = $_POST['item_name'];
            $price = $_POST['price'];
            $cost_price = $_POST['cost_price'];
            $stock = $_POST['item_stock'];
            $desc = $_POST['description'];
            
            // 2. Xử lý Upload ảnh
            $image_name = 'default.png'; 
            if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
                $image_name = time() . '_' . $_FILES['item_image']['name'];
                
                // Khai báo đường dẫn thư mục
                $target_dir = __DIR__ . '/../../public/assets/img/products/';
                
                // Nếu thư mục products chưa tồn tại thì tự động tạo mới
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true); 
                }
                
                $target_file = $target_dir . $image_name;
                move_uploaded_file($_FILES['item_image']['tmp_name'], $target_file);
            }

            // 3. Gọi Model để lưu vào DB
            require_once __DIR__ . '/../../models/ProductModel.php';
            $productModel = new ProductModel();
            $result = $productModel->insertProduct($name, $stock, $desc, $price, $cost_price, $image_name);

            if ($result) {
                // Thành công thì quay về danh sách
                header("Location: " . BASE_URL . "admin/product?status=success");
            } else {
                die("Lỗi khi thêm giáo trình!");
            }
        }
    }

    public function getChartData() {
        header('Content-Type: application/json');
        
        // Nhận dải thời gian (mặc định 24h) và loại biểu đồ (mặc định revenue)
        $range = $_GET['range'] ?? '24h'; 
        $type = $_GET['type'] ?? 'revenue';
        
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Gọi hàm mới vừa tạo
        $result = $productModel->getDynamicChartData($type, $range);
        
        echo json_encode($result);
        exit();
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "admin/product");
            exit;
        }
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Lấy data sản phẩm cũ
        $data['product'] = $productModel->getProductById($_GET['id']);
        $data['title'] = "Sửa giáo trình - Admin";
        $data['currentPage'] = 'product_list'; // Giữ sáng menu "Danh sách"
        
        $this->view('admin/product/edit', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $name = $_POST['item_name'];
            $price = $_POST['price'];
            $cost_price = $_POST['cost_price'];
            $stock = $_POST['item_stock'];
            $desc = $_POST['description'];
            
            $image_name = null; // Mặc định là null (không đổi ảnh)
            
            // Nếu người dùng chọn file ảnh mới
            if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
                $image_name = time() . '_' . $_FILES['item_image']['name'];
                $target_dir = __DIR__ . '/../../public/assets/img/products/';
                if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
                move_uploaded_file($_FILES['item_image']['tmp_name'], $target_dir . $image_name);
            }

            require_once __DIR__ . '/../../models/ProductModel.php';
            $productModel = new ProductModel();
            $result = $productModel->updateProduct($id, $name, $stock, $desc, $price, $cost_price, $image_name);

            if ($result) {
                header("Location: " . BASE_URL . "admin/product?status=updated");
            } else {
                die("Lỗi khi cập nhật!");
            }
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            require_once __DIR__ . '/../../models/ProductModel.php';
            $productModel = new ProductModel();
            $productModel->deleteProduct($_GET['id']);
            
            header("Location: " . BASE_URL . "admin/product?status=deleted");
        }
    }

    // ==========================================
    // QUẢN LÝ ĐÁNH GIÁ (RATING & REVIEWS)
    // ==========================================

    // Hiển thị danh sách đánh giá của 1 sản phẩm
    public function reviews() {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "admin/product");
            exit;
        }

        $productId = (int)$_GET['id'];

        // Lấy thông tin sản phẩm (để hiển thị tiêu đề)
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        $data['product'] = $productModel->getProductById($productId);

        if (!$data['product']) {
            header("Location: " . BASE_URL . "admin/product");
            exit;
        }

        // Lấy danh sách đánh giá
        require_once __DIR__ . '/../../models/ProductReview.php';
        $reviewModel = new ProductReview();
        $data['reviews'] = $reviewModel->getReviewsByProduct($productId);

        $data['title'] = "Đánh giá sản phẩm: " . htmlspecialchars($data['product']['item_name']) . " - Admin";
        $data['currentPage'] = 'product_list'; // Giữ sáng menu danh sách sản phẩm

        $this->view('admin/product/reviews', $data);
    }

    // Xóa một bình luận (Dùng AJAX hoặc redirect)
    public function deleteReview() {
        if (isset($_GET['id']) && isset($_GET['product_id'])) {
            $reviewId = (int)$_GET['id'];
            $productId = (int)$_GET['product_id'];

            require_once __DIR__ . '/../../models/ProductReview.php';
            $reviewModel = new ProductReview();
            
            // Hàm delete() sẽ được thêm vào model ở bước tiếp theo
            $reviewModel->setId($reviewId);
            $reviewModel->delete();

            header("Location: " . BASE_URL . "admin/product/reviews?id=" . $productId . "&status=deleted");
            exit;
        }
        header("Location: " . BASE_URL . "admin/product");
    }
}