<?php
class HomeController extends Controller {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $homeInfoModel = $this->model('HomeInfoModel');
        $data['homeSections'] = $homeInfoModel->getSections();
        $data['homeQuotes'] = $homeInfoModel->getQuotes(true);
        $data['homeReasons'] = $homeInfoModel->getReasons(true);
        $data['homeFeaturedProducts'] = $homeInfoModel->getFeaturedProducts(true);

        $data['title'] = "Trang chủ - BK88";
        $data['pageCss'] = ['assets/css/public/home.css', 'assets/slick/slick.css', 'assets/slick/slick-theme.css'];
        $data['pageJs'] = ['assets/jquery/jquery-1.11.0.min.js', 'assets/jquery/jquery-migrate-1.2.1.min.js', 'assets/slick/slick.min.js', 'assets/js/public/home.js'];
        $data['currentPage'] = 'home'; 

        // Đẩy toàn bộ sang View home/index
        $this->view('public/home/index', $data);
    }
}
?>