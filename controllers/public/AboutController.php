<?php
class AboutController extends Controller {
    public function index() {
        // Gọi Model để lấy dữ liệu từ bảng about_content
        require_once '../models/AboutModel.php';
        $aboutModel = new AboutModel();
        $content = $aboutModel->getAboutData();

        // Chuẩn bị dữ liệu gửi sang View
        $data = [
            'title'       => $content['title'] ?? 'Giới Thiệu BK88',
            'description' => $content['description'] ?? 'Nền tảng giải trí hàng đầu...',
            'features'    => !empty($content['features']) ? explode(',', $content['features']) : []
        ];

        $this->view('public/about/index', $data);
    }
}