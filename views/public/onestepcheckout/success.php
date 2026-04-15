<div class="container py-5 text-center d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow p-5" style="border-radius: 16px;">
                
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                </div>
                
                <h2 class="fw-bold mb-3">Đặt hàng thành công!</h2>
                <p class="text-muted fs-5 mb-4">
                    Cảm ơn bạn đã tin tưởng và mua sắm tại BK88. Đơn hàng mã số <strong class="text-primary">#<?php echo $order_id ?? ''; ?></strong> của bạn đã được hệ thống ghi nhận và đang chờ xử lý.
                </p>
                
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-dark fw-bold px-4 py-2" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                    <a href="<?php echo BASE_URL; ?>order" class="btn btn-primary fw-bold px-4 py-2" style="border-radius: 8px;">
                        Xem đơn mua<i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>