<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php
    $fullName = trim(($order['lastname'] ?? '') . ' ' . ($order['firstname'] ?? ''));
    $customerName = $fullName ?: $order['email'];
    $phone = $order['user_phone'] ?: 'Chưa cập nhật';
    $address = !empty($order['street']) ? $order['street'] . ', ' . $order['ward'] . ', ' . $order['city'] : 'Chưa có thông tin địa chỉ';
    $isShipping = ($order['shipping_fee'] > 0);
?>

<div class="row mt-4">
    <div class="col-12 mb-3">
        <a href="<?php echo BASE_URL; ?>admin/product/order" class="btn btn-outline-dark btn-sm fw-bold">
            <i class="ti-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h4 class="header-title mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                        Chi tiết đơn hàng <span class="text-primary">#<?php echo $order['order_id']; ?></span>
                    </h4>
                    <div class="text-end">
                        <p class="mb-1 text-muted small">Ngày đặt hàng: <span class="text-dark fw-bold"><?php echo date('H:i - d/m/Y', strtotime($order['order_date'])); ?></span></p>
                        <p class="mb-0 text-muted small">Phương thức: <span class="text-dark fw-bold"><?php echo $isShipping ? 'Giao hàng tận nơi' : 'Nhận tại cửa hàng'; ?></span></p>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="bg-light p-3 rounded h-100">
                            <h6 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Thông tin Khách hàng</h6>
                            <p class="mb-2"><i class="ti-user me-2 text-muted"></i> <strong><?php echo $customerName; ?></strong></p>
                            <p class="mb-2"><i class="ti-email me-2 text-muted"></i> <?php echo $order['email']; ?></p>
                            <p class="mb-2"><i class="ti-mobile me-2 text-muted"></i> <?php echo $phone; ?></p>
                            <?php if ($isShipping): ?>
                                <p class="mb-0"><i class="ti-location-pin me-2 text-muted"></i> <?php echo $address; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded h-100">
                            <h6 class="fw-bold mb-3 text-uppercase border-bottom pb-2">Trạng thái thanh toán</h6>
                            <p class="mb-2">Tình trạng: 
                                <?php if ($order['is_paid'] == 1): ?>
                                    <span class="badge bg-success ms-1">Đã thanh toán</span>
                                <?php else: ?>
                                    <span class="badge bg-danger ms-1">Chưa thanh toán (COD)</span>
                                <?php endif; ?>
                            </p>
                            <p class="mb-0">Trạng thái xử lý: 
                                <?php
                                    switch($order['status']) {
                                        case 0: echo '<span class="fw-bold text-warning ms-1">Chờ xác nhận</span>'; break;
                                        case 1: echo '<span class="fw-bold text-info ms-1">Đang chuẩn bị hàng</span>'; break;
                                        case 2: echo '<span class="fw-bold text-primary ms-1">' . ($isShipping ? 'Đang giao hàng' : 'Sẵn sàng nhận') . '</span>'; break;
                                        case 3: echo '<span class="fw-bold text-success ms-1">Hoàn thành</span>'; break;
                                        case 4: echo '<span class="fw-bold text-danger ms-1">Đã hủy</span>'; break;
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 text-uppercase">Danh sách Giáo trình</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 80px;">Hình ảnh</th>
                                <th class="text-start">Tên giáo trình</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $subTotal = 0; ?>
                            <?php foreach ($orderItems as $item): ?>
                            <?php 
                                $itemTotal = $item['price'] * $item['quantity']; 
                                $subTotal += $itemTotal;
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['item_image']; ?>" 
                                         alt="Hình ảnh" style="width: 50px; height: 60px; object-fit: cover;" class="rounded shadow-sm">
                                </td>
                                <td class="text-start fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫</td>
                                <td>x<?php echo $item['quantity']; ?></td>
                                <td class="text-end fw-bold"><?php echo number_format($itemTotal, 0, ',', '.'); ?> ₫</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-5 col-lg-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tổng tiền hàng:</span>
                            <span class="fw-bold"><?php echo number_format($subTotal, 0, ',', '.'); ?> ₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Phí vận chuyển:</span>
                            <span class="fw-bold"><?php echo number_format($order['shipping_fee'], 0, ',', '.'); ?> ₫</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-uppercase fs-6">Thanh toán:</span>
                            <span class="fw-bold fs-5" style="color: #0d6efd;">
                                <?php echo number_format($subTotal + $order['shipping_fee'], 0, ',', '.'); ?> ₫
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>