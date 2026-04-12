<?php
class ArticleController extends Controller {
    public function index() {
        $data['title'] = "Bài viết của BK88";
        $this->view('public/article/index', $data);
    }
}