<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        
        // Kiểm tra xem View đang gọi có nằm trong thư mục admin không
        if (strpos($view, 'admin/') === 0) {
            // Lắp ráp giao diện ADMIN
            require_once '../views/admin/layouts/header.php';
            require_once '../views/' . $view . '.php'; // Đây chính là phần ruột
            require_once '../views/admin/layouts/footer.php';
        } else {
            // Lắp ráp giao diện KHÁCH HÀNG (Public)
            require_once '../views/public/layouts/header.php';
            require_once '../views/' . $view . '.php';
            require_once '../views/public/layouts/footer.php';
        }
    }
}