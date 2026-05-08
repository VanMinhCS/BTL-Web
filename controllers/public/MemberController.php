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

        // Gọi View hiển thị. 
        // Lưu ý: Tùy vào cấu trúc thư mục View của bạn, 
        // nếu file ở 'views/member/dashboard.php' thì giữ nguyên dòng này.
        // Nếu file ở 'views/public/member/dashboard.php' thì sửa lại đường dẫn.
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
            $imageName = null;

            // Xử lý Upload Ảnh (Đường dẫn vật lý cực sạch)
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = dirname(__DIR__, 2) . "/public/assets/img/uploads/";
                
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $imageName = time() . '_' . basename($_FILES["image"]["name"]);
                $targetFile = $targetDir . $imageName;

                move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
            }

            // Gọi Model để lưu vào Database
            require_once '../models/FaqModel.php';
            $faqModel = new FaqModel();
            $faqModel->insertFaq($userId, $category, $question, $imageName);

            // ==========================================
            // CÁCH SỬA LỖI ĐẶC TRỊ ROUTER BKU:
            // Không dùng header() hay <script> chuyển hướng.
            // Gọi ngay hàm index() để tải lại lịch sử câu hỏi mới nhất!
            // ==========================================
            $this->index();
            exit;
        }
    }
}
?>