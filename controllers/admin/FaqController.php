<?php

class FaqController extends Controller {
    
    public function index() {
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();
        $data['title'] = "Quản lý Hỏi Đáp - BK88 Admin";
        $data['all_faqs'] = $faqModel->getAllFaqsForAdmin(); 
        $this->view('admin/faq/index', $data);
    }

    public function reply() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $answer = $_POST['answer'] ?? '';
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