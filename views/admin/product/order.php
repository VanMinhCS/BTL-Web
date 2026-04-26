<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Quản lý Đơn đặt hàng</h4>
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái hiện tại</th>
                                <th style="width: 180px;">Thao tác xử lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                <?php 
                                    $isShipping = ($order['shipping_fee'] > 0);
                                    $status = $order['status'];
                                ?>
                                <tr>
                                    <td class="fw-bold">#<?php echo $order['order_id']; ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark">
                                            <?php echo trim(($order['lastname'] ?? '') . ' ' . ($order['firstname'] ?? '')) ?: $order['email']; ?>
                                        </div>
                                        <div class="text-muted small"><?php echo $order['phone'] ?: 'Chưa có SĐT'; ?></div>
                                    </td>
                                    
                                    <td><?php echo date('H:i - d/m/Y', strtotime($order['order_date'])); ?></td>
                                    
                                    <td>
                                        <?php if ($order['is_paid'] == 1): ?>
                                            <span class="badge bg-success px-3 py-2">Đã thanh toán</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-2">Chưa thanh toán</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        if ($isShipping) {
                                            // Luồng 1: Giao tận nơi
                                            switch($status) {
                                                case 0: echo '<span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>'; break;
                                                case 1: echo '<span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị hàng</span>'; break;
                                                case 2: echo '<span class="badge bg-primary text-white px-3 py-2">Đang giao hàng</span>'; break;
                                                case 3: echo '<span class="badge bg-success px-3 py-2">Giao thành công</span>'; break;
                                                case 4: echo '<span class="badge bg-danger px-3 py-2">Thất bại / Đã hủy</span>'; break;
                                                default: echo '<span class="badge bg-danger px-3 py-2">Không xác định</span>'; break;
                                            }
                                        } else {
                                            // Luồng 2: Nhận tại cửa hàng
                                            switch($status) {
                                                case 0: echo '<span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>'; break;
                                                case 1: echo '<span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị hàng</span>'; break;
                                                case 2: echo '<span class="badge bg-primary text-white px-3 py-2">Sẵn sàng nhận</span>'; break;
                                                case 3: echo '<span class="badge bg-success px-3 py-2">Đã nhận hàng</span>'; break;
                                                case 4: echo '<span class="badge bg-danger px-3 py-2">Thất bại / Đã hủy</span>'; break;
                                                default: echo '<span class="badge bg-danger px-3 py-2">Không xác định</span>'; break;
                                            }
                                        }
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($status < 3): // Ẩn form nếu đơn đã hoàn thành hoặc đã hủy ?>
                                            <form action="<?php echo BASE_URL; ?>admin/product/processOrderFlow" method="POST" class="mb-2">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                
                                                <?php if ($status == 0): ?>
                                                    <button type="submit" name="next_status" value="1" class="btn btn-xs btn-info text-white w-100 mb-1">Chuẩn bị hàng</button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</button>
                                                
                                                <?php elseif ($status == 1): ?>
                                                    <?php $btnText = $isShipping ? 'Bắt đầu giao hàng' : 'Báo khách đến lấy'; ?>
                                                    <button type="submit" name="next_status" value="2" class="btn btn-xs btn-primary w-100 mb-1"><?php echo $btnText; ?></button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</button>
                                                
                                                <?php elseif ($status == 2): ?>
                                                    <?php $btnText = $isShipping ? 'Giao xong & Thu tiền' : 'Đã nhận & Thu tiền'; ?>
                                                    <button type="submit" name="next_status" value="3" class="btn btn-xs btn-success w-100 mb-1" onclick="return confirm('Xác nhận hoàn thành và đánh dấu đã thanh toán (COD)?')"><?php echo $btnText; ?></button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Xác nhận khách boom hàng/hủy đơn?')">Giao thất bại</button>
                                                
                                                <?php endif; ?>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo BASE_URL; ?>admin/product/orderDetail?id=<?php echo $order['order_id']; ?>" class="btn btn-xs btn-secondary w-100">
                                            <i class="ti-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Hệ thống chưa có đơn đặt hàng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>