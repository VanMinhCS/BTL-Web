<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo isset($title) ? $title : 'BK88 Admin'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/metismenujs.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/typography.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/default-css.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/css/responsive.css">

    <style>
        /* 1. Ẩn hoàn toàn mũi tên ở những menu KHÔNG có mục con */
        .metismenu > li > a:not([aria-expanded])::after {
            display: none !important;
            content: none !important;
        }

        /* 2. Mặc định mũi tên hướng XUỐNG cho menu CÓ mục con */
        .metismenu > li > a[aria-expanded]::after {
            content: '\f107' !important; /* Mã mũi tên xuống */
            transform: translateY(-10%) rotate(0deg) !important;
            transition: transform 0.3s ease-in-out !important; /* Xoay mượt 0.3s */
        }

        /* 3. Khi menu xổ xuống (mở), xoay ngược mũi tên hướng LÊN */
        .metismenu > li > a[aria-expanded="true"]::after {
            transform: translateY(-10%) rotate(180deg) !important;
        }
    </style>
</head>

<body>
    <div id="preloader" style="display: none;">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="<?php echo BASE_URL; ?>admin/dashboard">
                        <img src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/images/icon/logo.png" alt="logo">
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <?php 
                        // SỬA Ở ĐÂY: Bắt biến bằng 2 cách để đảm bảo 100% không bị hụt dữ liệu
                        $current = '';
                        if (isset($currentPage)) {
                            $current = $currentPage;
                        } elseif (isset($data['currentPage'])) {
                            $current = $data['currentPage'];
                        }
                        ?>
                        <ul class="metismenu" id="menu">
                            
                            <li class="<?php echo ($current == 'dashboard') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL; ?>admin/dashboard">
                                    <i class="ti-dashboard"></i><span>Dashboard</span>
                                </a>
                            </li>
                            
                            <?php 
                            $isProduct = in_array($current, ['product_overview', 'product_order', 'product_list', 'product_create']); 
                            ?>
                            <li class="<?php echo $isProduct ? 'active mm-active' : ''; ?>">
                                <a href="javascript:void(0)" aria-expanded="<?php echo $isProduct ? 'true' : 'false'; ?>">
                                    <i class="ti-layout-grid2"></i><span>Cửa hàng</span>
                                </a>
                                
                                <ul class="collapse <?php echo $isProduct ? 'show mm-collapse mm-show' : ''; ?>">
                                    <li class="<?php echo ($current == 'product_overview') ? 'active' : ''; ?>">
                                        <a href="<?php echo BASE_URL; ?>admin/product/overview">Tổng quan</a>
                                    </li>

                                    <li class="<?php echo ($current == 'product_order') ? 'active' : ''; ?>">
                                        <a href="<?php echo BASE_URL; ?>admin/product/order">Quản lý đơn hàng</a>
                                    </li>

                                    <li class="<?php echo ($current == 'product_list') ? 'active' : ''; ?>">
                                        <a href="<?php echo BASE_URL; ?>admin/product">Quản lý sản phẩm</a>
                                    </li>
                                    <li class="<?php echo ($current == 'product_create') ? 'active' : ''; ?>">
                                        <a href="<?php echo BASE_URL; ?>admin/product/create">Thêm giáo trình mới</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="<?php echo ($current == 'user') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL; ?>admin/user">
                                    <i class="ti-user"></i><span>Quản lý người dùng</span>
                                </a>
                            </li>
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn float-start">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box float-start">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area float-end">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-bs-toggle="dropdown">
                                    <span>2</span>
                                </i>
                            </li>
                            <li class="dropdown">
                                <i class="fa-regular fa-envelope dropdown-toggle" data-bs-toggle="dropdown"><span>3</span></i>
                            </li>
                            <li class="settings-btn">
                                <i class="ti-settings"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h1 class="page-title float-start">Dashboard</h1>
                            <ul class="breadcrumbs float-start">
                                <li><a href="<?php echo BASE_URL; ?>admin/dashboard">Home</a></li>
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile float-end">
                            <img class="avatar user-thumb" src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/images/author/avatar.png" alt="avatar">
                            
                            <h4 class="user-name dropdown-toggle" data-bs-toggle="dropdown">Admin BK88 <i class="fa-solid fa-angle-down"></i></h4>
                            
                            <div class="dropdown-menu user-dropdown">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>home?view=public"><i class="fa-solid fa-globe"></i> Trang chủ Web</a>
                                
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>profile"><i class="fa-solid fa-user"></i> Hồ sơ của tôi</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item user-dropdown-logout" href="<?php echo BASE_URL; ?>auth/logout"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner">