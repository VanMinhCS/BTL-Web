<?php
require_once __DIR__ . "/../core/model.php";

class Article extends Model {
    private $id_article;
    private $title;
    private $description;
    private $time_modified;
    private $status;
    private $content;
    private $background;

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
        $stmt = $this->getDb()->prepare("SELECT * FROM articles WHERE id_article=?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id_article   = $result['id_article'];
            $this->title        = $result['title'];
            $this->description  = $result['description'];
            $this->time_modified= $result['time_modified'];
            $this->status       = $result['status'];
            $this->content      = $result['content'];
            $this->background   = $result['background'];
        }
    }

    // CREATE
    public function create() {
        $stmt = $this->getDb()->prepare(
            "INSERT INTO articles (title, description, status, content, background) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $success = $stmt->execute([
            $this->title,
            $this->description,
            $this->status,
            $this->content,
            $this->background
        ]);
        if ($success) {
            $this->id_article = $this->getDb()->lastInsertId();
        }
        return $success;
    }

    // UPDATE
    public function update() {
        $stmt = $this->getDb()->prepare(
            "UPDATE articles 
             SET title=?, description=?, status=?, content=?, background=? 
             WHERE id_article=?"
        );
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->status,
            $this->content,
            $this->background,
            $this->id_article
        ]);
    }

    // DELETE
    public function delete() {
        $stmt = $this->getDb()->prepare("DELETE FROM articles WHERE id_article=?");
        return $stmt->execute([$this->id_article]);
    }

    public function getOldestArticleId() {
        $stmt = $this->getDb()->query(
            "SELECT id_article FROM articles ORDER BY time_modified ASC LIMIT 1"
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNewestArticleId() {
        $stmt = $this->getDb()->query(
            "SELECT id_article FROM articles ORDER BY time_modified DESC LIMIT 1"
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findArticleById($id) {
        $stmt = $this->getDb()->prepare("
            SELECT id_article, title, description, time_modified, content, background 
            FROM articles 
            WHERE id_article = ? AND status = 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
