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
        $data['title'] = "Tổng quan sản phẩm - Admin";
        $data['currentPage'] = 'product_overview'; // Báo cho header biết đang ở trang Tổng quan
        
        // Gọi View giao diện Tổng quan
        $this->view('admin/product/overview', $data);
    }

    public function order() {
        $data['title'] = "Quản lý đơn hàng sản phẩm - Admin";
        
        // Cắm cờ để làm sáng menu Quản lý đơn hàng bên trong Sản phẩm
        $data['currentPage'] = 'product_order'; 
        
        // Sau này khi bạn có Dashboard, bạn sẽ tạo file views/admin/product/order.php
        // Hiện tại mình cứ gọi View này, bạn tạo file trống trước để không bị lỗi 404 nhé
        $this->view('admin/product/order', $data);
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
            $result = $productModel->insertProduct($name, $stock, $desc, $price, $image_name);

            if ($result) {
                // Thành công thì quay về danh sách
                header("Location: " . BASE_URL . "admin/product?status=success");
            } else {
                die("Lỗi khi thêm giáo trình!");
            }
        }
    }
}