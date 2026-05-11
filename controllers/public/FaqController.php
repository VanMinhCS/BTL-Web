<?php
// File: controllers/public/FaqController.php

class FaqController extends Controller {
    
    public function index() {
        // 1. Gọi Model
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();

        // 2. Lấy dữ liệu các câu hỏi Public
        $publicFaqs = $faqModel->getPublicFaqs();

        // 3. Đóng gói dữ liệu gửi sang View
        $data = [
            'public_faqs' => $publicFaqs
        ];

        // 4. Hiển thị giao diện
        $this->view('public/faq/index', $data);
    }
}
?>