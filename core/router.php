<?php
class Router {
    public function route($url) {
        $url = $url ?? 'home';
        $segments = explode('/', $url);

        // Nếu URL bắt đầu bằng 'admin' → vào controllers/admin/
        if ($segments[0] === 'admin') {
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
            die("Trang không tồn tại: " . $controllerFile);
        }
    }
}