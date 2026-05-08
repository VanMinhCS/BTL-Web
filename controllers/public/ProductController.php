<?php
// FILE: controllers/public/ProductController.php
class ProductController extends Controller {
    
    // 1. Trang danh sách sản phẩm
    public function index() {
        require_once __DIR__ . '/../../models/ProductModel.php';
        $productModel = new ProductModel();
        
        $data['products'] = $productModel->getAllProducts();
        $data['title'] = "Sản phẩm - BK88";
        $data['currentPage'] = 'product'; 
        
        $this->view('public/product/index', $data);
    }

    // 2. Trang chi tiết sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$id) {
            header("Location: " . BASE_URL . "product");
            exit();
        }

        require_once __DIR__ . '/../../models/ProductModel.php';

        /** @var ProductReview $reviewModel */
        $productModel = new ProductModel();
        
        $currentProduct = $productModel->getProductById($id);

        if (!$currentProduct) {
            header("Location: " . BASE_URL . "product");
            exit();
        }

        $allProducts = $productModel->getAllProducts();
        $relatedProducts = [];
        foreach ($allProducts as $p) {
            if ($p['item_id'] != $id) {
                $relatedProducts[] = $p;
            }
        }

        // --- BỔ SUNG: LẤY DỮ LIỆU ĐÁNH GIÁ (RATING & REVIEWS) ---
        require_once __DIR__ . "/../../models/ProductReview.php";
        $reviewModel = new ProductReview();
        
        // Lấy thống kê (VD: 4.5 sao, 10 lượt đánh giá)
        $data['ratingSummary'] = $reviewModel->getRatingSummary($id);
        
        // Lấy danh sách bình luận chi tiết kèm tên người dùng
        $data['reviewList'] = $reviewModel->getReviewsByProduct($id);
        // --------------------------------------------------------

        $data['currentProduct'] = $currentProduct;
        $data['relatedProducts'] = $relatedProducts;
        $data['title'] = "Chi tiết giáo trình - BK88";
        $data['currentPage'] = 'product'; 

        $this->view('public/product/detail', $data);
    }

    // 3. API xử lý gửi đánh giá từ người dùng qua AJAX
    public function submitReview() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Kiểm tra đăng nhập
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            echo json_encode(["success" => false, "message" => "Vui lòng đăng nhập để đánh giá."]);
            return;
        }

        // Lấy dữ liệu từ request
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        // Kiểm tra tính hợp lệ của dữ liệu
        if ($productId === 0 || $rating < 1 || $rating > 5) {
            echo json_encode(["success" => false, "message" => "Dữ liệu đánh giá không hợp lệ."]);
            return;
        }

        require_once __DIR__ . "/../../models/ProductReview.php";

        /** @var ProductReview $reviewModel */
        $reviewModel = new ProductReview();

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa (Tránh spam)
        if ($reviewModel->hasUserReviewed($productId, $userId)) {
            echo json_encode(["success" => false, "message" => "Bạn đã đánh giá sản phẩm này rồi."]);
            return;
        }

        // Lưu vào cơ sở dữ liệu
        $reviewModel->setProductId($productId);
        $reviewModel->setUserId($userId);
        $reviewModel->setRating($rating);
        // Dùng htmlspecialchars để chống lỗi bảo mật XSS khi lưu comment
        $reviewModel->setComment(htmlspecialchars($comment, ENT_QUOTES, 'UTF-8')); 

        if ($reviewModel->create()) {
            echo json_encode(["success" => true, "message" => "Cảm ơn bạn đã đánh giá sản phẩm!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Đã có lỗi xảy ra, vui lòng thử lại sau."]);
        }
    }
}
?>