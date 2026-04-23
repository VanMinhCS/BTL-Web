<?php
// FILE: controllers/public/ProductController.php
class ProductController extends Controller {
    
    // 1. Trang danh sách sản phẩm
    public function index() {
        // GỌI MODEL Ở ĐÂY
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        $data['products'] = $productModel->getAllProducts(); // Lấy dữ liệu đẩy vào mảng $data
        $data['title'] = "Sản phẩm - BK88";
        $data['currentPage'] = 'product'; 
        
        $this->view('public/product/index', $data);
    }

    // 2. Trang chi tiết sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // ĐIỀU HƯỚNG Ở ĐÂY (Nhiệm vụ của Controller)
        if (!$id) {
            header("Location: " . BASE_URL . "product");
            exit();
        }

        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        $currentProduct = $productModel->getProductById($id);

        if (!$currentProduct) {
            header("Location: " . BASE_URL . "product");
            exit();
        }

        // TÍNH TOÁN LOGIC SẢN PHẨM LIÊN QUAN Ở ĐÂY
        $allProducts = $productModel->getAllProducts();
        $relatedProducts = [];
        foreach ($allProducts as $p) {
            if ($p['item_id'] != $id) {
                $relatedProducts[] = $p;
            }
        }

        // Đẩy toàn bộ dữ liệu sạch sẽ sang View
        $data['currentProduct'] = $currentProduct;
        $data['relatedProducts'] = $relatedProducts;
        $data['title'] = "Chi tiết giáo trình - BK88";
        $data['currentPage'] = 'product'; 

        $this->view('public/product/detail', $data);
    }
}
?>