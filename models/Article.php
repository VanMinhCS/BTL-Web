<?php
require_once __DIR__ . "/../core/Model.php";

class Article extends Model {
    private $id_article;
    private $title;
    private $description;   // thêm thuộc tính mới
    private $time_modified;
    private $status;
    private $content;
    private $background;

    // Getter/Setter
    public function getIdArticle() { return $this->id_article; }
    public function setIdArticle($id) { $this->id_article = $id; $this->loadById($id); }

    public function getTitle() { return $this->title; }
    public function setTitle($title) { $this->title = $title; }

    public function getDescription() { return $this->description; }
    public function setDescription($desc) { $this->description = $desc; }

    public function getStatus() { return $this->status; }
    public function setStatus($status) { $this->status = $status; }

    public function getContent() { return $this->content; }
    public function setContent($content) { $this->content = $content; }

    public function getBackground() { return $this->background; }
    public function setBackground($bg) { $this->background = $bg; }

    // Load dữ liệu từ DB
    private function loadById($id) {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id_article=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        if ($result) {
            $this->id_article   = $result['id_article'];
            $this->title        = $result['title'];
            $this->description  = $result['description']; // lấy thêm description
            $this->time_modified= $result['time_modified'];
            $this->status       = $result['status'];
            $this->content      = $result['content'];
            $this->background   = $result['background'];
        }
    }

    // CREATE
    public function create() {
        $stmt = $this->db->prepare("INSERT INTO articles (title, description, status, content, background) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $this->title, $this->description, $this->status, $this->content, $this->background);
        return $stmt->execute();
    }

    // UPDATE
    public function update() {
        $stmt = $this->db->prepare("UPDATE articles SET title=?, description=?, status=?, content=?, background=? WHERE id_article=?");
        $stmt->bind_param("ssissi", $this->title, $this->description, $this->status, $this->content, $this->background, $this->id_article);
        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id_article=?");
        $stmt->bind_param("i", $this->id_article);
        return $stmt->execute();
    }
}
