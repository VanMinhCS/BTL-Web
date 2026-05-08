<?php 
    /**
     * @var array $user
     */

    // Ghép Họ Tên
    $fullName = trim(($user['lastname'] ?? '') . ' ' . ($user['firstname'] ?? ''));
    
    // Kiểm tra xem đã có địa chỉ chưa (street khác rỗng)
    $hasAddress = !empty($user['street']);
    $fullAddress = $hasAddress ? $user['street'] . ', ' . $user['ward'] . ', ' . $user['city'] : 'Chưa có địa chỉ';
?>

<div class="container py-5" style="max-width: 800px; min-height: 60vh;">
    
    <div class="d-flex justify-content-center mb-5 align-items-center position-relative">
        <h2 class="fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Tài khoản của tôi</h2>
    </div>

    <!-- KHỐI 1: HỒ SƠ -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Hồ sơ</h5>
        <button class="btn btn-link text-dark fw-bold text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-pen me-1"></i> Chỉnh sửa
        </button>
    </div>
    
    <div class="card border mb-5 shadow-sm" style="border-radius: 12px; border-color: #eaeaea !important;">
        <div class="card-body p-4">
            <div class="mb-3">
                <span class="text-muted small fw-bold d-block mb-1">Họ và Tên</span>
                <span class="fs-6"><?php echo $fullName ?: 'Chưa cập nhật'; ?></span>
            </div>
            <div class="mb-3">
                <span class="text-muted small fw-bold d-block mb-1">Email</span>
                <span class="fs-6"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div>
                <span class="text-muted small fw-bold d-block mb-1">Số điện thoại</span>
                <span class="fs-6"><?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Chưa cập nhật'; ?></span>
            </div>
        </div>
    </div>

    <!-- KHỐI 2: ĐỊA CHỈ -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Địa chỉ</h5>
        <button class="btn btn-link text-dark fw-bold text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#editAddressModal">
            <?php if ($hasAddress): ?>
                <i class="fas fa-pen me-1"></i> Chỉnh sửa
            <?php else: ?>
                <i class="fas fa-plus me-1"></i> Thêm
            <?php endif; ?>
        </button>
    </div>
    
    <div class="card border mb-5 shadow-sm" style="border-radius: 12px; border-color: #eaeaea !important; <?php echo !$hasAddress ? 'background-color: #f9f9f9;' : ''; ?>">
        <div class="card-body p-4 text-center">
            <?php if (!$hasAddress): ?>
                <span class="text-muted"><i class="fas fa-info-circle me-2"></i>Chưa có địa chỉ</span>
            <?php else: ?>
                <span class="fs-6 fw-medium text-start d-block"><?php echo htmlspecialchars($fullAddress); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- KHỐI 3: BẢO MẬT -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Bảo mật</h5>
        <button class="btn btn-link text-dark fw-bold text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="fas fa-lock me-1"></i> Đổi mật khẩu
        </button>
    </div>

    <div class="card border shadow-sm" style="border-radius: 12px; border-color: #eaeaea !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="text-muted small fw-bold d-block mb-1">Mật khẩu đăng nhập</span>
                <span class="fs-6">********</span>
            </div>
            <!-- ĐÃ SỬA ĐƯỜNG DẪN Ở ĐÂY: Trỏ thẳng vào hàm forgot() -->
            <a href="<?php echo BASE_URL; ?>auth/forgot" class="text-primary fw-bold text-decoration-none small">
                Bạn quên mật khẩu ư?
            </a>
        </div>
    </div>

</div>

<!-- ============================================== -->
<!-- CÁC MODAL (POPUP) -->
<!-- ============================================== -->

<!-- 1. Modal Sửa Hồ Sơ -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 mt-3 px-4">
                <h5 class="modal-title fw-bold fs-4">Chỉnh sửa hồ sơ</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditProfile">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Họ và Tên</label>
                        <input type="text" name="fullname" class="form-control py-2" required value="<?php echo htmlspecialchars($fullName); ?>" placeholder="Nhập đầy đủ họ và tên">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Email (Không thể thay đổi)</label>
                        <input type="email" class="form-control py-2 bg-light" disabled value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control py-2" required value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark fw-bold px-4">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Sửa Địa Chỉ -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 mt-3 px-4">
                <h5 class="modal-title fw-bold fs-4"><?php echo $hasAddress ? 'Chỉnh sửa địa chỉ' : 'Thêm địa chỉ'; ?></h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formEditAddress">
                    <input type="hidden" name="address_id" value="<?php echo htmlspecialchars($user['address_id'] ?? ''); ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Số nhà & Tên đường</label>
                        <input type="text" name="street" class="form-control py-2" required value="<?php echo htmlspecialchars($user['street'] ?? ''); ?>" placeholder="VD: 268 Lý Thường Kiệt">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Phường/Xã</label>
                        <input type="text" name="ward" class="form-control py-2" required value="<?php echo htmlspecialchars($user['ward'] ?? ''); ?>" placeholder="VD: Phường 14">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Tỉnh/Thành phố</label>
                        <input type="text" name="city" class="form-control py-2" required value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" placeholder="VD: TP. HCM">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark fw-bold px-4">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 3. Modal Đổi Mật Khẩu -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 mt-3 px-4">
                <h5 class="modal-title fw-bold fs-4">Đổi mật khẩu</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formChangePassword">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" id="current_password" class="form-control py-2" required placeholder="Nhập mật khẩu hiện tại">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mật khẩu mới</label>
                        <input type="password" name="new_password" id="new_password" class="form-control py-2" required placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control py-2" required placeholder="Nhập lại mật khẩu mới">
                        <div id="passwordError" class="text-danger small mt-2 d-none">Mật khẩu xác nhận không khớp!</div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-dark fw-bold px-4">Xác nhận đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Cập nhật Profile
    document.getElementById('formEditProfile').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        fetch('<?php echo BASE_URL; ?>profile/updateInfo', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.reload(); 
            }
        });
    });

    // 2. Cập nhật Address
    document.getElementById('formEditAddress').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        fetch('<?php echo BASE_URL; ?>profile/updateAddress', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.reload();
            }
        });
    });

    // 3. Đổi mật khẩu
    let formPassword = document.getElementById('formChangePassword');
    if (formPassword) {
        formPassword.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Lấy giá trị để kiểm tra trước khi gửi lên server
            let newPass = document.getElementById('new_password').value;
            let confirmPass = document.getElementById('confirm_password').value;
            let errorMsg = document.getElementById('passwordError');

            // Kiểm tra mật khẩu xác nhận có khớp không
            if (newPass !== confirmPass) {
                errorMsg.classList.remove('d-none');
                return; // Dừng lại, không gửi AJAX
            } else {
                errorMsg.classList.add('d-none');
            }

            let formData = new FormData(this);
            
            fetch('<?php echo BASE_URL; ?>profile/changePassword', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Đổi mật khẩu thành công!');
                    window.location.reload();
                } else {
                    // Nếu server trả về lỗi (VD: Sai mật khẩu cũ)
                    alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Lỗi kết nối đến máy chủ!');
            });
        });
    }

});
</script>