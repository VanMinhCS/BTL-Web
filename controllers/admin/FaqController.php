<?php

class FaqController extends Controller {
    
    // Router của bạn đang đi tìm hàm này đây!
    public function index() {
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();
        
        $data['title'] = "Quản lý Hỏi Đáp - BK88 Admin";
        // Lấy dữ liệu từ Model bạn đã viết
        $data['all_faqs'] = $faqModel->getAllFaqsForAdmin(); 
        
        // Load view
        $this->view('admin/faq/index', $data);
    }

    public function reply() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $answer = $_POST['answer'] ?? '';
        // Nếu admin tích vào ô "Công khai" thì status = 1, ngược lại = 0
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;

        header('Content-Type: application/json');
        if ($id > 0) {
            require_once '../models/FaqModel.php';
            $faqModel = new FaqModel();
            if ($faqModel->updateAnswer($id, $answer, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
        exit;
    }
}
}