<?php
class HomeController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        // Lấy tất cả sản phẩm
        $allProducts = $productModel->getAllProducts();
        
        // Lấy riêng 5 sản phẩm đầu tiên để đẩy sang view
        $data['featuredProducts'] = array_slice($allProducts, 0, 5);

        $data['title'] = "Trang chủ - BK88";
        $data['pageCss'] = ['assets/css/public/home.css', 'assets/slick/slick.css', 'assets/slick/slick-theme.css'];
        $data['pageJs'] = ['assets/jquery/jquery-1.11.0.min.js', 'assets/jquery/jquery-migrate-1.2.1.min.js', 'assets/slick/slick.min.js', 'assets/js/public/home.js'];
        $data['currentPage'] = 'home'; // Để Header active cho đúng

        // Đẩy toàn bộ sang View home/index
        $this->view('public/home/index', $data);
    }
}
?>