<style>
    /* Màu xanh dương đậm hơn khi hover */
    .btn-confirm-checkout {
        background-color: #0d6efd;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-confirm-checkout:hover {
        background-color: #0b5ed7 !important; /* Xanh đậm hơn */
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        transform: translateY(-1px);
    }
</style>

<div class="container py-5 mt-4 mb-5">
    <h2 class="fw-bold mb-4 text-uppercase">Thanh toán đơn hàng</h2>

    <form action="<?php echo BASE_URL; ?>onestepcheckout/processOrder" method="POST">

        <?php 
            require_once __DIR__ . '/../../../models/UserModel.php';
            $userModel = new UserModel();
            $currentUser = $userModel->getUserById($_SESSION['user_id']);
            $userPhone = $currentUser['phone'] ?? '';
        ?>

        <div class="row g-5">
            
            <div class="col-lg-7">
                
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold text-primary mb-0"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Họ và tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" name="receiver_name" class="form-control" required value="<?php echo $_SESSION['user_name'] ?? ''; ?>" placeholder="Nhập họ tên">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="receiver_phone" class="form-control" required value="<?php echo htmlspecialchars($userPhone); ?>" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required placeholder="VD: TP.HCM">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Quận/Huyện <span class="text-danger">*</span></label>
                                <input type="text" name="district" class="form-control" required placeholder="VD: Quận 10">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Phường/Xã <span class="text-danger">*</span></label>
                                <input type="text" name="ward" class="form-control" required placeholder="VD: Phường 14">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Số nhà <span class="text-danger">*</span></label>
                                <input type="text" name="house_number" class="form-control" required placeholder="VD: 268">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold small">Tên đường <span class="text-danger">*</span></label>
                                <input type="text" name="street" class="form-control" required placeholder="VD: Lý Thường Kiệt">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Ghi chú đơn hàng</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Ghi chú thêm cho người giao hàng (không bắt buộc)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Hình thức nhận hàng</h5>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" id="deliveryHome" value="home" checked>
                                <label class="form-check-label fw-medium" for="deliveryHome">
                                    Giao hàng tận nơi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" id="deliveryStore" value="store">
                                <label class="form-check-label fw-medium" for="deliveryStore">
                                    Nhận tại cửa hàng
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;" id="shippingMethodCard">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Phương thức vận chuyển</h5>
                        <div class="form-check border rounded p-3 bg-light d-flex align-items-center">
                            <input class="form-check-input m-0 me-3" type="radio" name="shipping_fee" id="shippingStandard" value="22000" checked>
                            <label class="form-check-label w-100 m-0" for="shippingStandard">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-medium">Giao hàng tiêu chuẩn</span>
                                    <span class="fw-bold text-primary">22.000 ₫</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>
                        <div class="form-check border rounded p-3 bg-light d-flex align-items-center">
                            <input class="form-check-input m-0 me-3" type="radio" name="payment_method" id="paymentCOD" value="cod" checked>
                            <label class="form-check-label w-100 m-0" for="paymentCOD">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo BASE_URL; ?>assets/img/cod.png" alt="COD" style="width: 32px; height: 32px; margin-right: 12px; object-fit: contain;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2800/2800185.png'">
                                    <span class="fw-medium">Thanh toán bằng tiền mặt khi nhận hàng</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 100px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">Đơn hàng của bạn</h5>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-4" style="max-height: 250px; overflow-y: auto;">
                            <?php 
                            require_once __DIR__ . '/../../../models/ProductModel.php';
                            $productModel = new ProductModel();
                            $allProducts = $productModel->getAllProducts();
                            
                            $productReference = [];
                            foreach ($allProducts as $p) {
                                $productReference[$p['id']] = [
                                    'name' => $p['name'], 
                                    'price' => $p['price']
                                ];
                            }

                            $subTotal = 0;
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): 
                                foreach ($_SESSION['cart'] as $item):
                                    
                                    $pId = $item['product_id'] ?? $item['id'] ?? 0;
                                    $qty = $item['quantity'] ?? 1;

                                    if (isset($productReference[$pId])) {
                                        $pName = $productReference[$pId]['name'];
                                        $pPrice = $productReference[$pId]['price'];
                                        
                                        $itemTotal = $pPrice * $qty;
                                        $subTotal += $itemTotal;
                            ?>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <div class="text-truncate pe-2" style="max-width: 70%;" title="<?php echo $pName; ?>">
                                        <span class="fw-bold text-primary"><?php echo $qty; ?>x</span> <?php echo $pName; ?>
                                    </div>
                                    <div class="fw-medium text-end" style="min-width: 80px;">
                                        <?php echo number_format($itemTotal, 0, ',', '.'); ?> ₫
                                    </div>
                                </div>
                            <?php 
                                    } 
                                endforeach; 
                            else:
                                echo '<p class="text-muted small text-center my-3">Giỏ hàng của bạn đang trống.</p>';
                            endif;
                            ?>
                        </div>

                        <hr class="text-muted">

                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Thành tiền</span>
                            <span><?php echo number_format($subTotal, 0, ',', '.'); ?> ₫</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 text-muted" id="shippingFeeRow">
                            <span>Phí vận chuyển (Giao hàng tiêu chuẩn)</span>
                            <span>22.000 ₫</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4 pt-3 border-top">
                            <span class="fw-bold text-dark fs-5">Tổng Số Tiền (gồm VAT)</span>
                            <span class="fw-bold fs-4" style="color: #0d6efd;" id="totalPriceDisplay"> 
                                <?php echo number_format($subTotal + 22000, 0, ',', '.'); ?> ₫
                            </span>
                            <input type="hidden" name="total_amount" id="totalAmountInput" value="<?php echo $subTotal + 22000; ?>">
                        </div>

                        <button type="submit" class="btn btn-confirm-checkout w-100 py-3 fw-bold text-white fs-5 text-uppercase">
                            Xác nhận thanh toán
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryHome = document.getElementById('deliveryHome');
    const deliveryStore = document.getElementById('deliveryStore');
    const shippingMethodCard = document.getElementById('shippingMethodCard');
    const shippingFeeRow = document.getElementById('shippingFeeRow');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const totalAmountInput = document.getElementById('totalAmountInput');
    const shippingStandardInput = document.getElementById('shippingStandard');

    const subTotal = <?php echo isset($subTotal) ? $subTotal : 0; ?>;
    const shippingFee = 22000;

    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number) + ' ₫';
    }

    function updateCheckoutState() {
        if (deliveryStore.checked) {
            // Nhận tại cửa hàng
            shippingMethodCard.style.display = 'none'; 
            shippingFeeRow.style.display = 'none'; 
            shippingStandardInput.disabled = true; 
            
            totalPriceDisplay.innerText = formatCurrency(subTotal);
            totalAmountInput.value = subTotal;
        } else {
            // Giao hàng tận nơi
            shippingMethodCard.style.display = 'block'; 
            shippingFeeRow.style.display = 'flex'; 
            shippingStandardInput.disabled = false; 
            
            totalPriceDisplay.innerText = formatCurrency(subTotal + shippingFee);
            totalAmountInput.value = subTotal + shippingFee;
        }
    }

    deliveryHome.addEventListener('change', updateCheckoutState);
    deliveryStore.addEventListener('change', updateCheckoutState);

    updateCheckoutState();
});
</script>