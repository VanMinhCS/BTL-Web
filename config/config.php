<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$host = $_SERVER['HTTP_HOST'];

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$projectPath = str_replace('index.php', '', $scriptName);

define('BASE_URL', $protocol . $host . $projectPath);
// define('BASE_URL', 'http://localhost/');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');      
define('DB_PASS', '');          
define('DB_NAME', 'bk88');   
?>