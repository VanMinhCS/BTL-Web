<?php
class NewsController extends Controller { 
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Bắt buộc đăng nhập mới được vào trang này
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    public function index() {
        if ($_SESSION['user_role'] !== 1) {
            header("Location: " . BASE_URL . "home");
            exit;
        }
        $data['title'] = "Trang tin tức của BK88";
        $this->view('admin/news/index', $data);
    }

    public function view($view, $data = []) {
        $basePath = __DIR__ . '/../../views/';
        $fullPath = $basePath . $view . '.php';
        
        if (file_exists($fullPath)) {
            extract($data);
            // Chỉ load nội dung chính, không header/footer
            require_once $fullPath;
        } else {
            die("View không tồn tại: " . $fullPath);
        }
    }

    public function getArticles() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $rows = $articleModel->getAllArticles();

        header('Content-Type: application/json; charset=utf-8');
        if ($rows) {
            $articles = [];
            foreach ($rows as $row) {
                $articles[] = [
                    "id"          => $row['id_article'],
                    "title"       => $row['title'],
                    "description" => $row['description'],
                    "time_modified" => $row['time_modified'],
                    "status"      => (int)$row['status']
                ];
            }
            echo json_encode($articles);
        } else {
            echo json_encode([]);
        }
    }

    public function getNews() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        $page    = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";

        $itemsPerPage = 5;

        if ($keyword !== "") {
            $rows = $articleModel->searchArticles($keyword);
        } else {
            $rows = $articleModel->getAllArticles();
        }

        $totalItems = count($rows);

        // cắt mảng theo trang ngay tại controller
        $offset = ($page - 1) * $itemsPerPage;
        $pagedRows = array_slice($rows, $offset, $itemsPerPage);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "totalItems" => $totalItems,
            "items" => array_map(function($row){
                return [
                    "id"          => $row['id_article'],
                    "title"       => $row['title'],
                    "description" => $row['description'],
                    "upload_date" => date("d/m/Y", strtotime($row['time_modified'])),
                    "status"      => $row['status']
                ];
            }, $pagedRows)
        ]);
    }

    public function toggleStatus() {
        require_once __DIR__ . "/../../models/Article.php";
        $articleModel = new Article();

        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $articleModel->setIdArticle($id);

            $newStatus = $articleModel->getStatus() == 1 ? 0 : 1;
            $articleModel->setStatus($newStatus);

            header('Content-Type: application/json; charset=utf-8');
            if ($articleModel->update()) {
                echo json_encode(["success" => true, "status" => $newStatus]);
            } else {
                echo json_encode(["success" => false]);
            }
        }
    }

    public function bulkAction() {
        require_once __DIR__ . "/../../models/Article.php";
        $data = json_decode(file_get_contents("php://input"), true);
        $ids = $data['ids'];
        $action = $data['action'];

        $articleModel = new Article();

        if ($action === 'delete') {
            $articleModel->deleteArticles($ids);
        } elseif ($action === 'hide') {
            $articleModel->hideArticles($ids);
        } elseif ($action === 'show') {
            $articleModel->showArticles($ids);
        }

        echo json_encode(["success" => true]);
    }

    public function create() {
        require_once __DIR__ . "/../../models/Article.php";

        $title       = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $content     = $_POST['content'] ?? '';
        $background  = $_POST['background'] ?? '';
        $status      = 0; 

        $news = new Article();
        $news->setTitle($title);
        $news->setDescription($description);
        $news->setContent($content);
        $news->setBackground($background);
        $news->setStatus($status);

        if($news->create()){
            echo json_encode([
                "success" => true,
                "message" => "Thêm bài viết thành công",
                "id"      => $news->getIdArticle()
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Thêm bài viết thất bại"
            ]);
        }
    }
}