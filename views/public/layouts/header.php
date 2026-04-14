<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'Header'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/footer.css">

    <style>
    @media (min-width: 992px) {
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            animation: fadeInDropdown 0.2s ease forwards;
        }

        .nav-item.dropdown .dropdown-menu {
            top: 100%;               
            margin-top: 16px !important;
            left: 50% !important;
            right: auto !important;
            transform: translateX(-50%) !important;
        }

        .nav-item.dropdown .dropdown-menu::before {
            content: "";
            position: absolute;
            top: -30px;
            left: 0;
            width: 100%;
            height: 30px;
            background-color: transparent; 
        }

        .navbar {
            position: relative;
            z-index: 1040 !important; 
        }

        .nav-item.dropdown .dropdown-menu {
            z-index: 9999 !important; 
        }
    }

    @keyframes fadeInDropdown {
        from { opacity: 0; transform: translateY(5px) translateX(-50%); }
        to { opacity: 1; transform: translateY(0) translateX(-50%); }
    }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<!-- ===== NAVBAR CHÍNH ===== -->
<nav class="navbar navbar-expand-lg shadow-sm main-navbar">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>home">
            <img src="<?php echo BASE_URL; ?>assets/img/logoBK.png"
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
            <ul class="navbar-nav align-items-center gap-3">
                
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Tìm kiếm">
                        <img src="<?php echo BASE_URL; ?>assets/img/search.png" alt="Search" style="width: 20px; height: 20px; filter: invert(1);">
                    </a>
                </li>

                <li class="nav-item dropdown position-relative">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>auth/login" id="userDropdown" aria-expanded="false">
                        <img src="<?php echo BASE_URL; ?>assets/img/user.png" alt="User" style="width: 22px; height: 22px; filter: invert(1);">
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <span class="ms-1 text-white-50 small d-none d-md-inline"><?php echo $_SESSION['user_name']; ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <ul class="dropdown-menu shadow border-0 p-0" aria-labelledby="userDropdown" style="border-radius: 12px; min-width: 240px;">
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <div class="p-3">
                                <li><h6 class="dropdown-header text-primary fw-bold p-0 mb-3 fs-6">Xin chào, <?php echo $_SESSION['user_name']; ?></h6></li>
                                <li><a class="dropdown-item py-2 rounded" href="<?php echo BASE_URL; ?>profile">Tài khoản của tôi</a></li>
                                <li><a class="dropdown-item py-2 rounded" href="<?php echo BASE_URL; ?>order">Đơn mua</a></li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li><a class="dropdown-item py-2 text-danger fw-bold rounded" href="<?php echo BASE_URL; ?>auth/logout">Đăng xuất</a></li>
                            </div>
                        <?php else: ?>
                            <div class="p-3">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#ajaxLoginModal" class="btn w-100 mb-2 fw-bold text-white" style="background-color: #0d6efd; border-radius: 8px; padding: 10px 0;">
                                    Đăng nhập
                                </button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#ajaxRegisterModal" class="btn w-100 fw-bold" style="color: #0d6efd; border: 2px solid #0d6efd; background-color: white; border-radius: 8px; padding: 8px 0;">
                                    Đăng ký
                                </button>
                            </div>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item me-2">
                    <a class="nav-link position-relative" href="<?php echo BASE_URL; ?>cart" title="Giỏ hàng">
                        <img src="<?php echo BASE_URL; ?>assets/img/shopping-cart.png" alt="Cart" style="width: 24px; height: 24px; filter: invert(1);">
                        
                        <?php 
                            $cartCount = 0;
                            if(isset($_SESSION['cart'])) {
                                foreach($_SESSION['cart'] as $item) { $cartCount += $item['quantity']; }
                            }
                        ?>
                        
                        <span id="cart-badge" 
                              class="position-absolute badge rounded-pill bg-danger <?php echo ($cartCount == 0) ? 'd-none' : ''; ?>" 
                              style="font-size: 0.65rem; top: 0px; right: -5px; padding: 0.25em 0.5em; border: 1px solid #0d6efd;">
                            <?php echo $cartCount; ?>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="ajaxLoginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-4">Đăng nhập</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="loginErrorMsg" class="alert alert-danger d-none" style="border-radius: 8px;"></div>
                <form id="ajaxLoginForm">
                    <input type="hidden" name="ajax" value="1">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số điện thoại/Email</label>
                        <input type="text" name="login_id" class="form-control py-2" required placeholder="Nhập SĐT hoặc Email">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control py-2" required placeholder="Nhập mật khẩu">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 8px;">Đăng nhập ngay</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxRegisterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-4">Đăng ký</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="registerErrorMsg" class="alert alert-danger d-none" style="border-radius: 8px;"></div>
                <div id="registerSuccessMsg" class="alert alert-success d-none" style="border-radius: 8px;"></div>
                <form id="ajaxRegisterForm">
                    <input type="hidden" name="ajax" value="1">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ tên</label>
                        <input type="text" name="fullname" class="form-control" required placeholder="Nhập họ và tên">
                    </div>
                    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required placeholder="Nhập email">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-4">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required placeholder="Mật khẩu">
                        </div>
                        <div class="col-6 mb-4">
                            <label class="form-label fw-bold">Nhập lại</label>
                            <input type="password" name="repassword" class="form-control" required placeholder="Nhập lại">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary border-2 w-100 py-3 fw-bold" style="border-radius: 8px;">Đăng ký tài khoản</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. XỬ LÝ AJAX ĐĂNG NHẬP
    const loginForm = document.getElementById('ajaxLoginForm');
    if(loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Chặn tải lại trang
            let formData = new FormData(this);
            let errorBox = document.getElementById('loginErrorMsg');

            fetch('<?php echo BASE_URL; ?>auth/processLogin', {
                method: 'POST', body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'error') {
                    errorBox.innerText = data.message;
                    errorBox.classList.remove('d-none');
                } else {
                    // Thành công thì tải lại trang (hoặc redirect về trang thanh toán nếu có)
                    window.location.href = data.redirect;
                }
            });
        });
    }

    // 2. XỬ LÝ AJAX ĐĂNG KÝ
    const registerForm = document.getElementById('ajaxRegisterForm');
    if(registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let errorBox = document.getElementById('registerErrorMsg');
            let successBox = document.getElementById('registerSuccessMsg');

            fetch('<?php echo BASE_URL; ?>auth/processRegister', {
                method: 'POST', body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'error') {
                    successBox.classList.add('d-none');
                    errorBox.innerText = data.message;
                    errorBox.classList.remove('d-none');
                } else {
                    errorBox.classList.add('d-none');
                    successBox.innerText = data.message;
                    successBox.classList.remove('d-none');
                    // Thành công -> Đợi 1.5s -> Đóng popup ĐK, Mở popup Đăng nhập
                    setTimeout(() => {
                        let regModal = bootstrap.Modal.getInstance(document.getElementById('ajaxRegisterModal'));
                        regModal.hide();
                        let loginModal = new bootstrap.Modal(document.getElementById('ajaxLoginModal'));
                        loginModal.show();
                    }, 1500);
                }
            });
        });
    }

    // =========================================================
    // 3. ẨN FORM NỀN KHI MỞ POPUP (CHỈ ÁP DỤNG Ở TRANG LOGIN/REGISTER)
    // =========================================================
    const mainAuthWrapper = document.getElementById('mainAuthWrapper');
    
    // Nếu trang hiện tại có chứa khối mainAuthWrapper (tức là đang ở trang login/register)
    if (mainAuthWrapper) {
        
        // --- XỬ LÝ KHI MỞ/ĐÓNG POPUP ĐĂNG NHẬP ---
        const loginModalEl = document.getElementById('ajaxLoginModal');
        loginModalEl.addEventListener('show.bs.modal', function () {
            mainAuthWrapper.style.opacity = '0'; // Làm trong suốt form nền
            mainAuthWrapper.style.pointerEvents = 'none'; // Khóa click chuột vào form nền
        });
        loginModalEl.addEventListener('hidden.bs.modal', function () {
            mainAuthWrapper.style.opacity = '1'; // Hiện lại form nền
            mainAuthWrapper.style.pointerEvents = 'auto'; // Mở lại click chuột
        });

        // --- XỬ LÝ KHI MỞ/ĐÓNG POPUP ĐĂNG KÝ ---
        const registerModalEl = document.getElementById('ajaxRegisterModal');
        registerModalEl.addEventListener('show.bs.modal', function () {
            mainAuthWrapper.style.opacity = '0';
            mainAuthWrapper.style.pointerEvents = 'none';
        });
        registerModalEl.addEventListener('hidden.bs.modal', function () {
            mainAuthWrapper.style.opacity = '1';
            mainAuthWrapper.style.pointerEvents = 'auto';
        });
    }
});
</script>

<main class="flex-grow-1">