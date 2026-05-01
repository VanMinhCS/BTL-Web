<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Header'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/footer.css">
    <?php if (!empty($data['pageCss']) && is_array($data['pageCss'])): ?>
        <?php foreach ($data['pageCss'] as $cssPath): ?>
            <link rel="stylesheet" href="<?= BASE_URL . $cssPath ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ===== NAVBAR CHÍNH ===== -->
<nav class="navbar navbar-expand-lg shadow-sm main-navbar">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>home">
            <img src="<?php echo BASE_URL; ?>assets/img/logo88.png"
                 alt="Logo"
                 height="40"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <span class="brand-text fw-bold">BK88</span>
            <!-- Fallback text nếu không có file logo -->
            <span class="brand-text fw-bold fst-italic" style="display:none">BK88-logo</span>
        </a>

        <!-- NÚT TOGGLE MOBILE -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- CÁC NÚT ĐIỀU HƯỚNG -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'home' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>home">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'product' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>product">SẢN PHẨM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'about' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>about">GIỚI THIỆU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'news' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>news">TIN TỨC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'faq' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>faq">HỎI/ĐÁP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>"
                       href="<?php echo BASE_URL; ?>contact">LIÊN HỆ</a>
                </li>
            </ul>

            <!-- PHẦN PHẢI: tìm kiếm + đăng nhập -->
            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Tìm kiếm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm px-3"
                       href="<?php echo BASE_URL; ?>auth/login">Đăng nhập</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1">