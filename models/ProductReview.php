<?php
require_once __DIR__ . "/../core/Model.php";

class ProductReview extends Model {
    private $id;
    private $product_id;
    private $user_id;
    private $rating;
    private $comment;
    private $created_at;

    // --- GETTERS & SETTERS ---
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getProductId() { return $this->product_id; }
    public function setProductId($product_id) { $this->product_id = $product_id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getRating() { return $this->rating; }
    public function setRating($rating) { $this->rating = $rating; }

    public function getComment() { return $this->comment; }
    public function setComment($comment) { $this->comment = $comment; }

    public function getCreatedAt() { return $this->created_at; }

    // --- CÁC HÀM TƯƠNG TÁC VỚI DATABASE ---

    /**
     * Thêm một đánh giá mới vào cơ sở dữ liệu
     */
    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO product_reviews (product_id, user_id, rating, comment) 
             VALUES (?, ?, ?, ?)"
        );
        $success = $stmt->execute([
            $this->product_id,
            $this->user_id,
            $this->rating,
            $this->comment
        ]);
        
        if ($success) {
            $this->id = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    /**
     * Lấy thống kê: Điểm trung bình và Tổng số lượt đánh giá của một sản phẩm
     */
    public function getRatingSummary($productId) {
        $stmt = $this->getDb()->prepare(
            "SELECT 
                COUNT(id) as total_reviews, 
                IFNULL(AVG(rating), 0) as average_rating 
             FROM product_reviews 
             WHERE product_id = ?"
        );
        $stmt->execute([$productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Làm tròn điểm trung bình đến 1 chữ số thập phân (VD: 4.5)
        return [
            'total_reviews'  => (int)$result['total_reviews'],
            'average_rating' => round((float)$result['average_rating'], 1)
        ];
    }

    /**
     * Lấy toàn bộ danh sách đánh giá của một sản phẩm (kèm tên người dùng)
     */
    public function getReviewsByProduct($productId) {
        $sql = "
            SELECT pr.*, i.firstname, i.lastname 
            FROM product_reviews pr
            LEFT JOIN information i ON pr.user_id = i.user_id
            WHERE pr.product_id = ?
            ORDER BY pr.created_at DESC
        ";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra xem một người dùng đã đánh giá sản phẩm này chưa
     * (Hữu ích để ngăn người dùng đánh giá 1 sản phẩm nhiều lần)
     */
    public function hasUserReviewed($productId, $userId) {
        $stmt = $this->getDb()->prepare(
            "SELECT COUNT(*) FROM product_reviews WHERE product_id = ? AND user_id = ?"
        );
        $stmt->execute([$productId, $userId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Xóa một đánh giá dựa vào ID
     */
    public function delete() {
        if (!$this->id) return false;
        
        $stmt = $this->getDb()->prepare("DELETE FROM product_reviews WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
?>