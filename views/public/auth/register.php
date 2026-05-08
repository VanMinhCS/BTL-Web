<div id="mainAuthWrapper" class="container py-5 mt-5 mb-5" style="transition: opacity 0.3s ease;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h3 class="fw-bold text-center mb-4 text-uppercase">Đăng ký tài khoản</h3>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form id="pageRegisterForm">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control py-2" required placeholder="VD: Nguyễn Văn A">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control py-2" placeholder="Nhập số điện thoại">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control py-2" required placeholder="Nhập địa chỉ email của bạn">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control py-2" required placeholder="Nhập mật khẩu">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold">Xác nhận mật khẩu</label>
                            <input type="password" name="repassword" class="form-control py-2" required placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-3 fw-bold text-white text-uppercase" style="background-color: #5a31f4; letter-spacing: 1px;">
                        Đăng ký
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Đã có tài khoản? <a href="<?php echo BASE_URL; ?>auth/login" class="text-primary fw-bold text-decoration-none">Đăng nhập tại đây</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageRegForm = document.getElementById('pageRegisterForm');
    if(pageRegForm) {
        pageRegForm.addEventListener('submit', function(e) {
            e.preventDefault(); 

            // 1. TÌM NÚT SUBMIT VÀ THÊM HIỆU ỨNG LOADING
            let submitBtn = this.querySelector('button[type="submit"]');
            let originalText = submitBtn.innerHTML; // Lưu lại chữ "Đăng ký" ban đầu
            
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';
            submitBtn.disabled = true; // Khóa nút chặn click đúp

            let formData = new FormData(this);
            fetch('<?php echo BASE_URL; ?>auth/processRegister', {
                method: 'POST', body: formData
            })
            .then(res => res.json())
            .then(data => {
                // 2. NHẬN KẾT QUẢ XONG THÌ TRẢ LẠI NÚT VỀ TRẠNG THÁI CŨ
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                if(data.status === 'error') {
                    alert(data.message);
                } else if (data.status === 'otp_required') {
                    document.getElementById('otp_user_id').value = data.user_id;
                    document.getElementById('otp_email_display').innerText = data.email;
                    let otpModal = new bootstrap.Modal(document.getElementById('ajaxOtpModal'));
                    otpModal.show();
                }
            })
            .catch(err => {
                // 3. TRẢ LẠI NÚT NẾU BỊ LỖI MẠNG
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                alert("Lỗi kết nối, vui lòng thử lại!");
            });
        });
    }
});
</script>