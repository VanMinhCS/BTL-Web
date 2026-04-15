<style>
    .account-option-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #eaeaea;
        background-color: #fff;
    }
    .account-option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        border-color: #0d6efd;
    }
</style>

<div class="container py-5 mt-5" style="min-height: 60vh; max-width: 800px; display: flex; align-items: center;">
    
    <div class="row w-100 g-4 justify-content-center m-0">
        
        <div class="col-md-5">
            <a href="<?php echo BASE_URL; ?>profile" class="text-decoration-none text-dark">
                <div class="card account-option-card h-100 p-5 text-center shadow-sm d-flex flex-column justify-content-center">
                    <h4 class="fw-bold mb-3">Tài khoản của tôi</h4>
                    <p class="text-muted small mb-0">Xem và chỉnh sửa thông tin cá nhân, địa chỉ giao hàng của bạn.</p>
                </div>
            </a>
        </div>

        <div class="col-md-5">
            <a href="<?php echo BASE_URL; ?>order" class="text-decoration-none text-dark">
                <div class="card account-option-card h-100 p-5 text-center shadow-sm d-flex flex-column justify-content-center">
                    <h4 class="fw-bold mb-3">Đơn mua</h4>
                    <p class="text-muted small mb-0">Kiểm tra lịch sử mua sắm và theo dõi trạng thái đơn hàng của bạn.</p>
                </div>
            </a>
        </div>

    </div>

</div>