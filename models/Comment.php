<?php
require_once __DIR__ . "/../core/Model.php";

class Comment extends Model {
    private $id_comment;
    private $id_article;
    private $id_user;
    private $text;
    private $date_modified;
    private $is_edited;
    private $replied;

    private function maskEmail($email) {
        $parts = explode("@", $email);
        $name = $parts[0];
        $domain = $parts[1];
        if(strlen($name) > 1) {
            $masked = substr($name, 0, 1) . str_repeat("*", strlen($name)-1);
        } else {
            $masked = $name;
        }
        return $masked . "@" . $domain;
    }

    public function getIdComment() { return $this->id_comment; }
    public function setIdComment($id) { $this->id_comment = $id; $this->loadById($id); }

    public function getIdArticle() { return $this->id_article; }
    public function setIdArticle($id) { $this->id_article = $id; }

    public function getIdUser() { return $this->id_user; }
    public function setIdUser($id) { $this->id_user = $id; }

    public function getText() { return $this->text; }
    public function setText($text) { $this->text = $text; }

    public function getDateModified() { return $this->date_modified; }
    public function setDateModified($date) { $this->date_modified = $date; }

    public function getIsEdited() { return $this->is_edited; }
    public function setIsEdited($edited) { $this->is_edited = $edited; }

    public function getReplied() { return $this->replied; }
    public function setReplied($reply) { $this->replied = $reply; }

    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comments WHERE id_comment=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id_comment   = $result['id_comment'];
            $this->id_article   = $result['id_article'];
            $this->id_user      = $result['id_user'];
            $this->text         = $result['text'];
            $this->date_modified= $result['date_modified'];
            $this->is_edited    = $result['is_edited'];
            $this->replied      = $result['replied'];
        }
    }

    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO comments (id_article, id_user, text, is_edited, replied) 
            VALUES (?, ?, ?, ?, ?)"
        );
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->getDb()->error);
            return false;
        }
        $stmt->bind_param("iisii",
            $this->id_article,
            $this->id_user,
            $this->text,
            $this->is_edited,
            $this->replied
        );
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        $this->id_comment = $stmt->insert_id;
        return true;
    }

    public function update() {
        $stmt = $this->getDb()->prepare("UPDATE comments SET id_article=?, id_user=?, text=?, date_modified=?, is_edited=?, replied=? WHERE id_comment=?");
        $stmt->bind_param("iissiii", $this->id_article, $this->id_user, $this->text, $this->date_modified, $this->is_edited, $this->replied, $this->id_comment);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM comments WHERE id_comment=?");
        $stmt->bind_param("i", $this->id_comment);
        return $stmt->execute();
    }

    public function getRepliedUserMaskedEmail($repliedId) {
        if(!$repliedId) return null;

        // nạp comment gốc
        $this->setIdComment($repliedId);
        $userId = $this->getIdUser();

        if(!$userId) return null;

        // dùng model User để lấy email
        require_once __DIR__ . "/Authentication.php";
        $user = new User();
        $user->setUserId($userId); // hàm này sẽ tự load dữ liệu user

        return $this->maskEmail($user->getEmail());
    }



}

class VoteComment extends Model {
    private $id;          // cột id trong bảng
    private $comment_id;  // cột comment_id
    private $user_id;     // cột user_id
    private $vote;        // cột vote: 'like' hoặc 'dislike'

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; $this->loadById($id); }

    public function getCommentId() { return $this->comment_id; }
    public function setCommentId($id) { $this->comment_id = $id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($id) { $this->user_id = $id; }

    public function getVote() { return $this->vote; }
    public function setVote($vote) { $this->vote = $vote; }

    // Load dữ liệu từ DB
    private function loadById($id) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comment_votes WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id         = $result['id'];
            $this->comment_id = $result['comment_id'];
            $this->user_id    = $result['user_id'];
            $this->vote       = $result['vote'];
        }
    }

    // CREATE
    public function create() {
        $stmt = $this->getDb()->prepare("INSERT INTO comment_votes (comment_id, user_id, vote) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $this->comment_id, $this->user_id, $this->vote);
        return $stmt->execute();
    }

    // UPDATE
    public function update() {
        $stmt = $this->getDb()->prepare("UPDATE comment_votes SET vote=? WHERE id=?");
        $stmt->bind_param("si", $this->vote, $this->id);
        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM comment_votes WHERE id=?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    // Lấy tổng số like/dislike cho 1 comment
    public function getVotesByComment($commentId) {
        $stmt = $this->getDb()->prepare("SELECT 
            SUM(vote='like') as likes,
            SUM(vote='dislike') as dislikes
            FROM comment_votes WHERE comment_id=?");
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByUserAndComment($commentId, $userId) {
        $stmt = $this->getDb()->prepare("SELECT * FROM comment_votes WHERE comment_id=? AND user_id=?");
        $stmt->bind_param("ii", $commentId, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

}
