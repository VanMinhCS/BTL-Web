<?php
class NewsController extends Controller {
    public function index() {
        $data['title'] = "Trang tin tức của BK88";
        $this->view('public/news/index', $data);
    }

    public function getNews() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $stmt = $articleModel->getDb()->prepare(
            "SELECT id_article, title, description, time_modified, content, background 
            FROM articles 
            WHERE status = 1 
            ORDER BY time_modified DESC"
        );
        $stmt->execute();
        $result = $stmt->get_result();

        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = [
                "id"          => $row['id_article'],
                "title"       => $row['title'],
                "description" => $row['description'],   // lấy trực tiếp từ DB
                "upload_date" => $row['time_modified'],
                "image"       => $row['background'],
                "link"        => "article?id=" . $row['id_article']
            ];
        }

        echo json_encode([
            "totalItems" => count($articles),
            "items"      => $articles
        ]);
        $stmt->close();
        $articleModel->closeDb();
    }
}