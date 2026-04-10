<?php
class ProductController extends Controller {
    public function index() {
        $data['title'] = "Sản phẩm - BK88";
        // Truyền biến này sang view để Navbar tự động gạch dưới chữ SẢN PHẨM
        $data['currentPage'] = 'product'; 
        
        $this->view('public/product/index', $data);
    }
}