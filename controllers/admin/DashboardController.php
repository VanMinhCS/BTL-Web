<?php
class DashboardController extends Controller {
    public function index() {
        // Chuyển hướng thẳng sang admin/news
        header("Location: " . BASE_URL . "admin/news");
        exit;
    }
    
}

