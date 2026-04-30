<?php
class HomeController extends Controller {
    public function index() {
        $data['title'] = "Trang chủ của BK88";
        $data['pageCss'] = ['assets/css/public/home.css', 'assets/slick/slick.css', 'assets/slick/slick-theme.css'];
        $data['pageJs'] = ['assets/jquery/jquery-1.11.0.min.js', 'assets/jquery/jquery-migrate-1.2.1.min.js', 'assets/slick/slick.min.js', 'assets/js/public/home.js'];
        $this->view('public/home/index', $data);
    }
}