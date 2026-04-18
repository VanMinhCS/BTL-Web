<?php
require_once __DIR__ . "/../core/model.php";

class ProductReview extends Model {
    private $id;
    private $item_id;
    private $average_rating;
    private $total_reviews;
    private $created_at;
    private $updated_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getItemId() { return $this->item_id; }
    public function setItemId($itemId) { $this->item_id = $itemId; }

    public function getAverageRating() { return $this->average_rating; }
    public function setAverageRating($rating) { $this->average_rating = $rating; }

    public function getTotalReviews() { return $this->total_reviews; }
    public function setTotalReviews($total) { $this->total_reviews = $total; }

    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM product_reviews WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id             = $result['id'];
            $this->item_id        = $result['item_id'];
            $this->average_rating = $result['average_rating'];
            $this->total_reviews  = $result['total_reviews'];
            $this->created_at     = $result['created_at'];
            $this->updated_at     = $result['updated_at'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO product_reviews (item_id, average_rating, total_reviews) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("idi", $this->item_id, $this->average_rating, $this->total_reviews);
        $success = $stmt->execute();
        if ($success) $this->id = $stmt->insert_id;
        $stmt->close();
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE product_reviews SET item_id=?, average_rating=?, total_reviews=? WHERE id=?"
        );
        $stmt->bind_param("idii", $this->item_id, $this->average_rating, $this->total_reviews, $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM product_reviews WHERE id=?");
        $stmt->bind_param("i", $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}

class ReviewDetail extends Model {
    private $id;
    private $review_id;
    private $user_id;
    private $content;
    private $rating;
    private $created_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getReviewId() { return $this->review_id; }
    public function setReviewId($reviewId) { $this->review_id = $reviewId; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($userId) { $this->user_id = $userId; }

    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; }

    public function getRating() { return $this->rating; }
    public function setRating($rating) { $this->rating = $rating; }

    public function getCreatedAt() { return $this->created_at; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM review_details WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id        = $result['id'];
            $this->review_id = $result['review_id'];
            $this->user_id   = $result['user_id'];
            $this->content   = $result['content'];
            $this->rating    = $result['rating'];
            $this->created_at= $result['created_at'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO review_details (review_id, user_id, content, rating) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iisi", $this->review_id, $this->user_id, $this->content, $this->rating);
        $success = $stmt->execute();
        if ($success) $this->id = $stmt->insert_id;
        $stmt->close();
        return $success;
    }

    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE review_details SET review_id=?, user_id=?, content=?, rating=? WHERE id=?"
        );
        $stmt->bind_param("iisii", $this->review_id, $this->user_id, $this->content, $this->rating, $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM review_details WHERE id=?");
        $stmt->bind_param("i", $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
