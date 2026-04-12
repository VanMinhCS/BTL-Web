<div class="container py-5 mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4">
                <h3 class="fw-bold text-center mb-4 text-uppercase">Đăng nhập</h3>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>auth/processLogin" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control py-2" required placeholder="Nhập email của bạn">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mật khẩu</label>
                        <input type="password" name="password" class="form-control py-2" required placeholder="Nhập mật khẩu">
                    </div>

                    <button type="submit" class="btn w-100 py-3 fw-bold text-white text-uppercase" style="background-color: #5a31f4; letter-spacing: 1px;">
                        Đăng nhập ngay
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>auth/register" class="text-primary fw-bold text-decoration-none">Đăng ký tại đây</a></p>
                </div>
            </div>
        </div>
    </div>
</div>