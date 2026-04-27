<?php
class NotificationController extends Controller { 
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
        $this->view('admin/notification/index', $data);
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

    public function toggleNotification() {
        require_once __DIR__ . "/../../models/Notification.php";
        $adminId = $_SESSION['user_id'] ?? 0;
        $enabled = intval($_POST['is_enabled']); // 1 hoặc 0

        $setting = new NotificationSetting();
        // kiểm tra xem đã có bản ghi chưa
        if ($setting->loadByAdminId($adminId)) {
            // đã có -> update
            $setting->setIsEnabled($enabled);
            $success = $setting->update();
        } else {
            // chưa có -> create
            $setting->setAdminId($adminId);
            $setting->setIsEnabled($enabled);
            $success = $setting->create();
        }

        echo json_encode(["success" => $success, "is_enabled" => $enabled]);
    }

    public function updateNotificationSettings() {
        require_once __DIR__ . "/../../models/Notification.php";        
        $adminId = $_SESSION['user_id'] ?? 0;
        if (!$adminId) {
            echo json_encode(["success" => false]);
            return;
        }
        $model = new NotificationSetting();
        if (!$model->loadByAdminId($adminId)) {
            // chưa có thì tạo mới
            $model->setAdminId($adminId);
            $model->setIsEnabled($_POST['enable_notifications'] ?? 0);
            $model->setEnableComment($_POST['enable_comment'] ?? 0);
            $model->setEnableReply($_POST['enable_reply'] ?? 0);
            $model->setEnableEdit($_POST['enable_edit'] ?? 0);
            $model->setEnableVote($_POST['enable_vote'] ?? 0);
            $success = $model->create();
        } else {
            // có rồi thì update
            $model->setIsEnabled($_POST['enable_notifications'] ?? 0);
            $model->setEnableComment($_POST['enable_comment'] ?? 0);
            $model->setEnableReply($_POST['enable_reply'] ?? 0);
            $model->setEnableEdit($_POST['enable_edit'] ?? 0);
            $model->setEnableVote($_POST['enable_vote'] ?? 0);
            $success = $model->update();
        }

        echo json_encode(["success" => $success]);
    }

    public function getNotificationSettings() {
        require_once __DIR__ . "/../../models/Notification.php";
        $adminId = $_SESSION['user_id'] ?? 0;
        if (!$adminId) {
            echo json_encode(["success" => false]);
            return;
        }

        $model = new NotificationSetting();
        if ($model->loadByAdminId($adminId)) {
            echo json_encode([
                "success" => true,
                "is_enabled"      => $model->getIsEnabled(),
                "enable_comment"  => $model->getEnableComment(),
                "enable_reply"    => $model->getEnableReply(),
                "enable_edit"     => $model->getEnableEdit(),
                "enable_vote"     => $model->getEnableVote()
            ]);
        } else {
            echo json_encode(["success" => false]);
        }
    }

    public function getNotificationStatus() {
        require_once __DIR__ . "/../../models/Notification.php";
        $adminId = $_SESSION['user_id'] ?? 0;
        if (!$adminId) {
            echo json_encode(["success" => false, "error" => "No admin id"]);
            return;
        }

        $setting = new NotificationSetting();
        if ($setting->loadByAdminId($adminId)) {
            echo json_encode([
                "success" => true,
                "is_enabled" => $setting->getIsEnabled()
            ]);
        } else {
            // chưa có bản ghi thì mặc định tắt
            echo json_encode([
                "success" => true,
                "is_enabled" => 0
            ]);
        }
    }

    public function getNotifications() {
        require_once __DIR__ . "/../../models/Notification.php";

        $adminId = $_SESSION['user_id'] ?? 0;
        if (!$adminId) {
            echo json_encode(["success" => false, "error" => "No user"]);
            return;
        }

        // Load setting
        $setting = new NotificationSetting();
        $setting->loadByAdminId($adminId);

        $notificationModel = new Notification();

        // Lấy tổng số chưa đọc (không giới hạn)
        $totalUnread = $notificationModel->countAllUnread();

        // Lấy danh sách thông báo (giới hạn 10 cái để hiển thị dropdown)
        $notifications = $notificationModel->getUnread(3);

        // Lọc theo setting
        $filtered = array_filter($notifications, function($n) use ($setting) {
            if ($setting->getIsEnabled() == 0) return false;
            switch ($n['type']) {
                case 'comment':       return $setting->getEnableComment() == 1;
                case 'reply_comment': return $setting->getEnableReply() == 1;
                case 'edit_comment':  return $setting->getEnableEdit() == 1;
                case 'vote_comment':  return $setting->getEnableVote() == 1;
                default:              return true;
            }
        });

        // Trả về JSON cho frontend
        echo json_encode([
            "success" => true,
            "count" => $totalUnread, // tổng số chưa đọc để hiển thị trên chuông
            "notifications" => array_map(function($n){
                return [
                    "id"         => $n['id'],
                    "message"    => $n['message'] ?? null,
                    "created_at" => $n['created_at'],
                    "id_article" => $n['article_id'] ?? null,
                    "id_comment" => $n['comment_id'] ?? null,
                    "type"       => $n['type']
                ];
            }, array_values($filtered))
        ]);
    }

    public function getAllNotifications() {
        require_once __DIR__ . "/../../models/Notification.php";
        $notificationModel = new Notification();
        $adminId = $_SESSION['user_id'] ?? 0;
        if (!$adminId) {
            echo json_encode(["success" => false, "error" => "No user"]);
            return;
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = 5;
        $keyword = $_GET['keyword'] ?? "";
        $status = $_GET['status'] ?? ""; // read/unread
        $type   = $_GET['type'] ?? "";   // comment, reply_comment, edit_comment, vote_comment
        $sort   = $_GET['sort'] ?? "desc"; // asc/desc theo thời gian

        $notifications = $notificationModel->getAll($page, $itemsPerPage, $keyword, $status, $type, $sort);
        $totalItems = $notificationModel->countAll($keyword);

        echo json_encode([
            "success" => true,
            "totalItems" => $totalItems,
            "notifications" => array_map(function($n) use ($notificationModel){
                return [
                    "id"          => $n['id'],
                    "id_user"     => $n['id_user'],
                    "type"        => $n['type'],
                    "created_at"  => $n['created_at'],
                    "id_article"  => $n['article_id'] ?? $n['vote_article_id'] ?? null,
                    "id_comment"  => $n['comment_id'] ?? $n['vote_comment_id'] ?? null,
                    "is_read"     => $n['is_read'],
                    "message"     => $notificationModel->map($n)
                ];
            }, $notifications)
        ]);
    }

    public function markRead() {
        require_once __DIR__ . "/../../models/Notification.php";
        $model = new Notification();

        $adminId = $_SESSION['user_id'] ?? 0;
        $id = $_POST['id'] ?? 0;   

        if ($adminId && $id && $model->markAsRead($id)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }

    public function markAllRead() {
        require_once __DIR__ . "/../../models/Notification.php";
        $model = new Notification();
        $adminId = $_SESSION['user_id'] ?? 0;   
        if ($adminId && $model->markAllAsRead()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }

    public function bulkAction() {
        require_once __DIR__ . "/../../models/Notification.php";
        $data = json_decode(file_get_contents("php://input"), true);
        $ids = $data['ids'] ?? [];
        $action = $data['action'] ?? "";

        $notificationModel = new Notification();

        if ($action === 'delete') {
            $notificationModel->deleteNotifications($ids);
        } elseif ($action === 'read') {
            $notificationModel->markAsReadMultiple($ids);
        }

        echo json_encode(["success" => true]);
    }

}