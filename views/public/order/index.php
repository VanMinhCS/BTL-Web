<div class="container py-5 mt-4 mb-5" style="min-height: 60vh;">
    <h2 class="fw-bold mb-4 text-uppercase">Đơn mua của tôi</h2>

    <?php if (empty($orders)): ?>
        <div class="text-center py-5 shadow-sm bg-light rounded-3" style="border: 2px dashed #dee2e6;">
            <img src="<?php echo BASE_URL; ?>assets/img/shopping-cart.png" width="80" class="mb-3" style="opacity: 0.3; filter: invert(1);">
            <h5 class="text-muted mb-3">Bạn chưa có đơn hàng nào.</h5>
            <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary px-4 py-2 fw-bold">Mua sắm ngay</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?php foreach ($orders as $order): ?>
                    <div class="card mb-4 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                        
                        <div class="card-header bg-light border-bottom-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <span class="fw-bold text-dark fs-5">Mã đơn: #<?php echo $order['order_id']; ?></span>
                                <span class="text-muted ms-3 small"><i class="far fa-clock me-1"></i><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
                            </div>
                            <div class="d-flex gap-2">
                                <?php 
                                    $isShipping = ($order['shipping_fee'] > 0);
                                    $status = $order['status']; 
                                    
                                    // LOGIC HIỂN THỊ TRẠNG THÁI THEO LUỒNG (Áp dụng bảng mã trạng thái bạn gửi)
                                    if ($isShipping) {
                                        // 1. LUỒNG GIAO HÀNG TẬN NƠI (SHIP COD)
                                        switch($status) {
                                            case 0: echo '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Chờ xác nhận</span>'; break;
                                            case 1: echo '<span class="badge bg-info text-white px-3 py-2 rounded-pill">Đang chuẩn bị hàng</span>'; break;
                                            case 2: echo '<span class="badge bg-primary text-white px-3 py-2 rounded-pill">Đang giao hàng</span>'; break;
                                            case 3: echo '<span class="badge bg-success px-3 py-2 rounded-pill">Giao thành công</span>'; break;
                                            case 4: echo '<span class="badge bg-danger px-3 py-2 rounded-pill">Chuyển hoàn</span>'; break;
                                            default: echo '<span class="badge bg-secondary px-3 py-2 rounded-pill">Không xác định</span>';
                                        }
                                    } else {
                                        // 2. LUỒNG NHẬN TẠI CỬA HÀNG (PICKUP)
                                        switch($status) {
                                            case 0: echo '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Chờ xác nhận</span>'; break;
                                            case 1: echo '<span class="badge bg-info text-white px-3 py-2 rounded-pill">Đang chuẩn bị hàng</span>'; break;
                                            case 2: echo '<span class="badge bg-primary text-white px-3 py-2 rounded-pill">Sẵn sàng nhận hàng</span>'; break;
                                            case 3: echo '<span class="badge bg-success px-3 py-2 rounded-pill">Đã lấy hàng</span>'; break;
                                            case 4: echo '<span class="badge bg-danger px-3 py-2 rounded-pill">Đã hủy</span>'; break;
                                            default: echo '<span class="badge bg-secondary px-3 py-2 rounded-pill">Không xác định</span>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <?php foreach ($order['details'] as $item): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light p-2 rounded" style="width: 80px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['item_image']; ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" class="img-fluid object-fit-contain" style="max-height: 100%;">
                                    </div>
                                    <div class="ms-4 flex-grow-1">
                                        <h6 class="fw-bold mb-1 fs-5"><?php echo $item['item_name']; ?></h6>
                                        <p class="text-muted mb-0">Số lượng: x<?php echo $item['quantity']; ?></p>
                                    </div>
                                    <div class="ms-auto fw-bold text-dark fs-5">
                                        <?php echo number_format($item['price'], 0, ',', '.'); ?> ₫
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-end align-items-center">
                            <span class="text-muted me-3">
                                <?php 
                                    $shipFee = $order['shipping_fee'] ?? 0;
                                    if ($shipFee > 0) {
                                        echo 'Thành tiền (Đã bao gồm ' . number_format($shipFee, 0, ',', '.') . 'đ phí vận chuyển):';
                                    } else {
                                        echo 'Thành tiền (Nhận tại cửa hàng):';
                                    }
                                ?>
                            </span>
                            <h4 class="fw-bold mb-0" style="color: #0d6efd;">
                                <?php echo number_format($order['total_amount'] + $shipFee, 0, ',', '.'); ?> ₫
                            </h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>