<?php
class AboutController extends Controller {
    public function index() {

        require_once '../models/AboutModel.php';
        $aboutModel = new AboutModel();
        $content = $aboutModel->getAboutData();

 
        $featured_products = [];
        if (!empty($content['featured_items'])) {
            require_once '../models/ProductModel.php';
            $productModel = new ProductModel();

            $featured_products = $productModel->getFeaturedItemsByIds($content['featured_items']);
        }

        // 3. Chuẩn bị dữ liệu gửi sang View
        $data = [
            'title'             => $content['title'] ?? 'Giới Thiệu BK88',
            'description'       => $content['description'] ?? 'Nền tảng giải trí hàng đầu...',
            'features'          => !empty($content['features']) ? explode(',', $content['features']) : [],
            'featured_products' => $featured_products 
        ];

        $this->view('public/about/index', $data);
    }
}