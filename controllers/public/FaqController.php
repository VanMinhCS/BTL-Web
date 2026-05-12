<?php


class FaqController extends Controller {
    public function index() {
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();
        $publicFaqs = $faqModel->getPublicFaqs();
        $data = [
            'public_faqs' => $publicFaqs,
            'currentPage' => "faq"
        ];
        $this->view('public/faq/index', $data);
    }
    public function ask() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /BTL-Web/auth/login"); 
            exit;
        }
        $userId = $_SESSION['user_id'];
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();
        
        $data = [
            'my_faqs' => $faqModel->getFaqsByUserId($userId)
        ];
        $this->view('public/faq/ask', $data);
    }
    public function submit_faq() {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>window.location.href='" . BASE_URL . "login';</script>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $category = $_POST['category'];
            $question = $_POST['question'];
            require_once '../models/FaqModel.php';
            $faqModel = new FaqModel();
            $faqModel->insertFaq($userId, $category, $question);
            header("Location: " . BASE_URL . "faq/ask");
            exit;
        }
    }
}
?>