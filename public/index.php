<?php
require_once '../config/config.php';
require_once '../core/controller.php';
require_once '../controllers/public/HomeController.php';
require_once '../core/router.php';

$url = $_GET['url'] ?? 'home';

$router = new Router();
$router->route($url);