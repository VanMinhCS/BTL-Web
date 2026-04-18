<?php
class NewsController extends Controller {
    public function index() {
        $data['title'] = "Trang tin tức của BK88";
        $this->view('admin/news/index', $data);
    }
}