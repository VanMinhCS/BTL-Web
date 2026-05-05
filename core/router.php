<?php
class Router {
    public function route($url) {
        $url = $url ?? 'home';
        $segments = explode('/', $url);

        // Nếu URL bắt đầu bằng 'admin' → vào controllers/admin/
        if ($segments[0] === 'admin') {

            // ============== Khóa user, tạm thời chưa cần ==============
            // if (session_status() === PHP_SESSION_NONE) {
            //     session_start();
            // }
            // // Nếu chưa đăng nhập -> đuổi về trang Login
            // if (!isset($_SESSION['user_id'])) {
            //     header("Location: " . BASE_URL . "auth/login");
            //     exit;
            // }
            // // Nếu đăng nhập rồi nhưng role không phải Admin -> đuổi về Home
            // if ($_SESSION['user_role'] !== 1) {
            //     header("Location: " . BASE_URL . "home");
            //     exit;
            // }
            // ====================================================
            $controllerName = ucfirst($segments[1] ?? 'dashboard') . 'Controller';
            $method = $segments[2] ?? 'index';
            $folder = 'admin';
        } else {
            // Còn lại → vào controllers/public/
            $controllerName = ucfirst($segments[0]) . 'Controller';
            $method = $segments[1] ?? 'index';
            $folder = 'public';
        }

        $controllerFile = __DIR__ . '/../controllers/' . $folder . '/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            $controller->$method();
        } else {
            http_response_code(404);  // set HTTP status code đúng chuẩn
            require_once __DIR__ . '/../views/public/error/404.php';
            exit;
        }
    }
}