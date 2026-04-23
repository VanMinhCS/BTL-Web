<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo isset($title) ? $title : 'BK88 Admin'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/metismenujs.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/swiper-bundle.min.css">
    
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/typography.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/default-css.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/css/responsive.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="<?php echo BASE_URL; ?>admin/dashboard">
                        <img src="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/images/icon/logo.png" alt="logo">
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                                <ul class="collapse">
                                    <li class="active"><a href="<?php echo BASE_URL; ?>admin/dashboard">Ecommerce</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>admin/product"><i class="ti-layout-grid2"></i><span>Quản lý sản phẩm</span></a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>admin/order"><i class="ti-receipt"></i><span>Quản lý đơn hàng</span></a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>admin/user"><i class="ti-user"></i><span>Quản lý người dùng</span></a>
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
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Search..." required>
                                <i class="ti-search"></i>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-fullscreen"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?php echo BASE_URL; ?>admin/dashboard">Home</a></li>
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="<?php echo BASE_URL; ?>public/assets/strdash-admin-dashboard/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-bs-toggle="dropdown">Admin BK88 <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>home">Trang chủ web</a>
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/logout">Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content-inner">
                