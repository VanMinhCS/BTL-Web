<?php
class Controller {
    public function view($view, $data = []) {
        $basePath = __DIR__ . '/../views/';
        $fullPath = $basePath . $view . '.php';
        
        if (file_exists($fullPath)) {
            require_once $basePath . 'public/layouts/header.php';
            require_once $fullPath;
            require_once $basePath . 'public/layouts/footer.php';
        } else {
            die("View không tồn tại: " . $fullPath);
        }
    }
}