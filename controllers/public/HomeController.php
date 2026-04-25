<?php
class HomeController extends Controller {
    public function index() {
        $data['title'] = "Trang chủ BK88";
        $this->view('public/home/index', $data);
    }
}
?>