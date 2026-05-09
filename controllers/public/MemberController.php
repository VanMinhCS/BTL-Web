<?php
class MemberController extends Controller {
    
    // 1. HIỂN THỊ TRANG DASHBOARD CỦA MEMBER
    public function index() {
        // Bắt buộc phải đăng nhập mới được vào trang này
        // (Nếu chưa có session_start() ở index.php thì bỏ comment dòng dưới)
        // session_start(); 
        
        if (!isset($_SESSION['user_id'])) {
            // Chưa đăng nhập -> Đá về trang login
            header("Location: /BTL-Web/auth/login"); 
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Gọi Model để lấy lịch sử câu hỏi của user này
        require_once '../models/FaqModel.php';
        $faqModel = new FaqModel();
        
        $data = [
            'my_faqs' => $faqModel->getFaqsByUserId($userId)
        ];

        $this->view('member/index', $data);
    }

    // 2. XỬ LÝ KHI MEMBER GỬI CÂU HỎI MỚI
    public function submit_faq() {
        // (Nếu ở file index.php gốc chưa có session_start() thì bạn nhớ mở cmt dòng này nhé)
        // session_start();
        
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
            $this->index();
            exit;
        }
    }
}
?>