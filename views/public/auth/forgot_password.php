<div class="container py-5 mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                <h4 class="fw-bold text-center mb-4 text-uppercase">Khôi phục mật khẩu</h4>
                
                <div id="pageForgotMsg" class="text-center mb-3" style="font-size: 14px;"></div>

                <form id="pageForgotForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Email đăng ký</label>
                        <div class="input-group">
                            <input type="email" name="email" id="page_forgot_email" class="form-control py-2" required placeholder="Nhập email...">
                            <button class="btn btn-outline-primary fw-bold" type="button" id="pageBtnSendOtp">Gửi mã OTP</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Mã xác nhận OTP</label>
                        <input type="text" name="otp_code" id="page_forgot_otp" class="form-control py-2 bg-light" required placeholder="6 ký tự" maxlength="6">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted">Mật khẩu mới</label>
                        <input type="password" name="new_password" id="page_forgot_new_pass" class="form-control py-2 bg-light" required placeholder="Nhập mật khẩu mới">
                    </div>

                    <button type="submit" id="pageBtnConfirm" class="btn w-100 py-2 fw-bold mb-3 text-dark" style="background-color: #e2e2e2; border-radius: 8px; transition: all 0.3s;">Xác nhận</button>

                    <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-outline-danger w-100 py-2 fw-bold" style="border-radius: 8px;">Trở về</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // PHẦN 1: LẤY CÁC PHẦN TỬ DOM
    // ==========================================
    const form = document.getElementById('pageForgotForm');
    const btnSend = document.getElementById('pageBtnSendOtp');
    const msgBox = document.getElementById('pageForgotMsg');
    
    const emailInput = document.getElementById('page_forgot_email');
    const otpInput = document.getElementById('page_forgot_otp');
    const passInput = document.getElementById('page_forgot_new_pass');
    const btnConfirm = document.getElementById('pageBtnConfirm');

    // ==========================================
    // PHẦN 2: HIỆU ỨNG ĐỔI MÀU NÚT XÁC NHẬN
    // ==========================================
    function checkInputsForConfirm() {
        let emailVal = emailInput.value.trim();
        let otpVal = otpInput.value.trim();
        let passVal = passInput.value.trim();

        // Nếu cả 3 ô đều có chữ (Riêng OTP phải đủ 6 số)
        if (emailVal !== '' && otpVal.length === 6 && passVal !== '') {
            // Đổi sang giao diện Xanh dương (btn-outline-primary)
            btnConfirm.className = 'btn btn-outline-primary w-100 py-2 fw-bold mb-3';
            btnConfirm.style.backgroundColor = ''; // Xóa màu xám nội tuyến
            btnConfirm.style.color = ''; 
        } else {
            // Nếu xóa đi chưa đủ, trở về màu Xám như cũ
            btnConfirm.className = 'btn w-100 py-2 fw-bold mb-3 text-dark';
            btnConfirm.style.backgroundColor = '#e2e2e2';
        }
    }

    // Lắng nghe sự kiện gõ phím
    if (emailInput && otpInput && passInput) {
        emailInput.addEventListener('input', checkInputsForConfirm);
        otpInput.addEventListener('input', checkInputsForConfirm);
        passInput.addEventListener('input', checkInputsForConfirm);
    }

    // ==========================================
    // PHẦN 3: XỬ LÝ GỬI MÃ OTP (Giữ nguyên của bạn)
    // ==========================================
    if (btnSend) {
        btnSend.addEventListener('click', function() {
            let email = emailInput.value;
            if(!email) { alert('Vui lòng nhập email!'); return; }
            
            btnSend.innerText = 'Đang gửi...';
            btnSend.disabled = true;

            let fd = new FormData(); fd.append('email', email);

            fetch('<?php echo BASE_URL; ?>auth/processSendResetOTP', { method: 'POST', body: fd })
            .then(res => res.json())
            .then(data => {
                btnSend.innerText = 'Gửi lại mã';
                btnSend.disabled = false;
                msgBox.innerHTML = `<div class="text-${data.status === 'success' ? 'success' : 'danger'} fw-bold">${data.message}</div>`;
            });
        });
    }

    // ==========================================
    // PHẦN 4: XỬ LÝ ĐỔI MẬT KHẨU (Giữ nguyên của bạn)
    // ==========================================
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let fd = new FormData(this);
            fetch('<?php echo BASE_URL; ?>auth/processResetPassword', { method: 'POST', body: fd })
            .then(res => res.json())
            .then(data => {
                msgBox.innerHTML = `<div class="text-${data.status === 'success' ? 'success' : 'danger'} fw-bold">${data.message}</div>`;
                if(data.status === 'success') {
                    setTimeout(() => window.location.href = '<?php echo BASE_URL; ?>auth/login', 1500);
                }
            });
        });
    }
});
</script>