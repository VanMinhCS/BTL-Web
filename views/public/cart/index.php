<?php
/**
 * @var array $cartItems
 * @var int $totalPrice
 */
?>

<style>
    .qty-btn { width: 32px; height: 32px; border: 1px solid #ced4da; background: #fff; font-weight: bold; transition: 0.2s; padding: 0; }
    .qty-btn:disabled { background-color: #e9ecef; color: #adb5bd; cursor: not-allowed; }
    .qty-input { width: 45px; height: 32px; text-align: center; border: 1px solid #ced4da; border-left: none; border-right: none; font-weight: bold; }
    .qty-input::-webkit-inner-spin-button, .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .qty-input { -moz-appearance: textfield; }
</style>

<div class="container py-5 mt-4" style="min-height: 60vh;">
    <h2 class="fw-bold text-uppercase mb-4">Giỏ hàng của bạn</h2>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted mb-4">Giỏ hàng của bạn đang trống!</h4>
            <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-dark px-4 py-2 fw-bold">&larr; Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row gx-5">
            <div class="col-lg-8 mb-4">
                <div class="table-responsive">
                    <table class="table align-middle border-bottom">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center" style="width: 40px;">
                                    <input class="form-check-input border-dark shadow-none" type="checkbox" id="selectAll" checked>
                                </th>
                                <th scope="col" class="text-uppercase small fw-bold">Sản phẩm</th>
                                <th scope="col" class="text-uppercase small fw-bold text-center">Đơn giá</th>
                                <th scope="col" class="text-uppercase small fw-bold text-center">Số lượng</th>
                                <th scope="col" class="text-uppercase small fw-bold text-end">Thành tiền</th>
                                <th scope="col" class="text-uppercase small fw-bold text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                            <?php $rawPrice = round($item['raw_item_total'] / max(1, $item['quantity'])); ?>
                            <tr>
                                <td class="text-center">
                                    <input class="form-check-input border-dark shadow-none item-checkbox" 
                                           type="checkbox" 
                                           value="<?php echo $item['id']; ?>" 
                                           data-total="<?php echo $item['raw_item_total']; ?>" 
                                           checked>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-2 rounded me-3" style="width: 80px; height: 100px; display: flex; align-items: center;">
                                            <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid object-fit-contain" onerror="this.src='https://placehold.co/80x100/1a1a1a/FFF?text=BK'">
                                        </div>
                                        <div><h6 class="fw-bold mb-1"><?php echo $item['name']; ?></h6></div>
                                    </div>
                                </td>
                                <td class="text-center fw-medium"><?php echo $item['price']; ?></td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="button" class="qty-btn rounded-start btn-decrease" data-id="<?php echo $item['id']; ?>" <?php echo ($item['quantity'] <= 1) ? 'disabled' : ''; ?>>-</button>
                                        
                                        <input type="number" class="qty-input item-qty" data-id="<?php echo $item['id']; ?>" data-price="<?php echo $rawPrice; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                                        
                                        <button type="button" class="qty-btn rounded-end btn-increase" data-id="<?php echo $item['id']; ?>">+</button>
                                    </div>
                                </td>

                                <td class="text-end fw-bold text-primary item-total-display" data-id="<?php echo $item['id']; ?>"><?php echo $item['item_total']; ?></td>
                                <td class="text-center ps-4">
                                    <form action="<?php echo BASE_URL; ?>cart/remove" method="POST" class="m-0 form-remove-item">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                            <img src="<?php echo BASE_URL; ?>assets/img/bin.png" alt="Xóa" style="width: 22px; height: 22px; opacity: 0.7; transition: 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <a href="<?php echo BASE_URL; ?>product" class="text-dark text-decoration-none fw-bold">&larr; Tiếp tục mua sắm</a>
                    <button type="button" id="btnDeleteSelected" class="btn btn-outline-danger fw-bold px-3 py-2">
                        <i class="ti-trash me-1"></i> Xóa sản phẩm đã chọn
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-uppercase mb-4">Tóm tắt đơn hàng</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold" id="summary-subtotal"><?php echo number_format($totalPrice, 0, ',', '.'); ?> ₫</span>
                        </div>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Tổng cộng</span>
                            <span class="fw-bold fs-4 text-danger" id="summary-total"><?php echo number_format($totalPrice, 0, ',', '.'); ?> ₫</span>
                        </div>
                        <button type="button" onclick="processCheckout()" class="btn py-3 w-100 fw-bold text-uppercase text-white mb-2" style="background-color: #0d6efd; letter-spacing: 1px;">
                            Thanh toán ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllBtn = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const summarySubtotal = document.getElementById('summary-subtotal');
    const summaryTotal = document.getElementById('summary-total');
    const btnDeleteSelected = document.getElementById('btnDeleteSelected');

    // HÀM 1: Tính lại Tổng tiền & Kiểm soát nút Xóa nhiều
    function calculateTotal() {
        let currentTotal = 0;
        let allChecked = true;
        let anyChecked = false;

        itemCheckboxes.forEach(cb => {
            if (cb.checked) {
                currentTotal += parseInt(cb.getAttribute('data-total'));
                anyChecked = true;
            } else {
                allChecked = false;
            }
        });

        if (selectAllBtn) selectAllBtn.checked = allChecked && anyChecked;

        let formattedTotal = new Intl.NumberFormat('vi-VN').format(currentTotal) + ' ₫';
        if (summarySubtotal) summarySubtotal.innerText = formattedTotal;
        if (summaryTotal) summaryTotal.innerText = formattedTotal;

        // Bật/tắt hiển thị của nút "Xóa sản phẩm đã chọn"
        if (btnDeleteSelected) {
            btnDeleteSelected.style.display = anyChecked ? 'block' : 'none';
        }
    }

    // Gọi hàm một lần khi tải trang để định hình giao diện
    calculateTotal();

    if (selectAllBtn) {
        selectAllBtn.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => cb.checked = this.checked);
            calculateTotal();
        });
    }

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', calculateTotal);
    });

    // HÀM 2: Thay đổi số liệu TRỰC TIẾP TRÊN GIAO DIỆN
    function updateItemUI(id, newQty) {
        let input = document.querySelector(`.item-qty[data-id="${id}"]`);
        let rawPrice = parseInt(input.getAttribute('data-price'));
        let newItemTotal = rawPrice * newQty;

        let displayTotal = document.querySelector(`.item-total-display[data-id="${id}"]`);
        if (displayTotal) {
            displayTotal.innerText = new Intl.NumberFormat('vi-VN').format(newItemTotal) + ' ₫';
        }

        let checkbox = document.querySelector(`.item-checkbox[value="${id}"]`);
        if (checkbox) {
            checkbox.setAttribute('data-total', newItemTotal);
        }

        calculateTotal();
    }

    // ==========================================
    // SỰ KIỆN: BẤM NÚT +/- VÀ GÕ TAY
    // ==========================================
    document.querySelectorAll('.btn-increase, .btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let input = document.querySelector(`.item-qty[data-id="${id}"]`);
            let currentVal = parseInt(input.value) || 1;
            
            let action = '';
            if (this.classList.contains('btn-increase')) {
                input.value = currentVal + 1;
                action = 'increase';
            } else if (this.classList.contains('btn-decrease') && currentVal > 1) {
                input.value = currentVal - 1;
                action = 'decrease';
            }
            
            document.querySelector(`.btn-decrease[data-id="${id}"]`).disabled = (parseInt(input.value) <= 1);
            
            updateItemUI(id, parseInt(input.value));
            updateCartItemAjax(id, action, input.value);
        });
    });

    document.querySelectorAll('.item-qty').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.blur(); 
            }
        });

        input.addEventListener('input', function() {
            let id = this.getAttribute('data-id');
            let btnDecrease = document.querySelector(`.btn-decrease[data-id="${id}"]`);
            btnDecrease.disabled = (isNaN(parseInt(this.value)) || parseInt(this.value) <= 1);
        });

        input.addEventListener('change', function() {
            let id = this.getAttribute('data-id');
            let currentVal = parseInt(this.value);
            
            if (isNaN(currentVal) || currentVal < 1) {
                this.value = 1;
                currentVal = 1;
                document.querySelector(`.btn-decrease[data-id="${id}"]`).disabled = true;
            }
            
            updateItemUI(id, currentVal);
            updateCartItemAjax(id, 'set', currentVal);
        });
    });

    function updateCartItemAjax(productId, action, quantity) {
        let formData = new FormData();
        formData.append('product_id', productId);
        formData.append('action', action);
        formData.append('quantity', quantity); 
        formData.append('ajax', 1);

        fetch('<?php echo BASE_URL; ?>cart/update', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            let badge = document.getElementById('cart-badge');
            if(badge && data.status === 'success') {
                badge.innerText = data.cartCount;
            }
        });
    }

    // ==========================================
    // LOGIC XÓA CÁC SẢN PHẨM ĐÃ CHỌN (TICK XANH)
    // ==========================================
    if (btnDeleteSelected) {
        btnDeleteSelected.addEventListener('click', function() {
            let selectedIds = [];
            let rowsToRemove = []; // Array to store the HTML rows that need to be removed
            
            // Iterate through each checkbox, collect IDs of checked ones and their corresponding row elements
            itemCheckboxes.forEach(cb => {
                if (cb.checked === true) {
                    selectedIds.push(cb.value);
                    rowsToRemove.push(cb.closest('tr'));
                }
            });

            if (selectedIds.length === 0) {
                return; 
            }

            if (confirm('Bạn có chắc chắn muốn xóa ' + selectedIds.length + ' sản phẩm đang được tick xanh khỏi giỏ hàng?')) {
                let formData = new FormData();
                selectedIds.forEach(id => formData.append('product_id[]', id));
                formData.append('ajax', 1);

                fetch('<?php echo BASE_URL; ?>cart/remove', { 
                    method: 'POST', 
                    body: formData 
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        // 1. Apply animation to all selected rows
                        rowsToRemove.forEach(row => {
                            row.style.transition = "all 0.3s ease";
                            row.style.opacity = "0";
                            row.style.transform = "translateX(-20px)";
                        });

                        // 2. Wait for animation to finish, then remove rows and update UI
                        setTimeout(() => {
                            rowsToRemove.forEach(row => row.remove()); 
                            
                            if(data.cartCount === 0) {
                                location.reload(); // Reload if the cart is now empty
                            } else {
                                // Re-query remaining checkboxes and recalculate totals
                                itemCheckboxes = document.querySelectorAll('.item-checkbox');
                                calculateTotal(); 
                            }
                        }, 300);

                        // 3. Update the cart badge
                        let badge = document.getElementById('cart-badge');
                        if (badge) {
                            badge.innerText = data.cartCount;
                            if(data.cartCount === 0) badge.classList.add('d-none');
                        }

                        // 4. Show the success notification
                        showRemoveToast();
                    }
                });
            }
        });
    }

    // Xóa từng sản phẩm lẻ (Thùng rác nhỏ)
    document.querySelectorAll('.form-remove-item').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            let formData = new FormData(this);
            formData.append('ajax', 1);

            fetch(this.action, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    let row = this.closest('tr');
                    row.style.transition = "all 0.3s ease";
                    row.style.opacity = "0";
                    row.style.transform = "translateX(-20px)";
                    
                    setTimeout(() => {
                        row.remove(); 
                        if(data.cartCount === 0) {
                            location.reload(); 
                        } else {
                            // Tính lại tổng tiền sau khi dòng bị xóa hoàn toàn khỏi HTML
                            itemCheckboxes = document.querySelectorAll('.item-checkbox');
                            calculateTotal(); 
                        }
                    }, 300);

                    let badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.innerText = data.cartCount;
                        if(data.cartCount === 0) badge.classList.add('d-none');
                    }

                    showRemoveToast();
                }
            });
        });
    });

    function showRemoveToast() {
        let toast = document.getElementById('remove-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'remove-toast';
            toast.style.cssText = `
                position: fixed; top: 100px; right: 20px;
                background-color: #dc3545; color: #fff; 
                padding: 12px 24px; border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999; font-weight: bold;
                transition: opacity 0.3s ease, transform 0.3s ease;
                transform: translateY(-20px); opacity: 0;
            `;
            toast.innerHTML = 'Đã xóa sản phẩm khỏi giỏ!';
            document.body.appendChild(toast);
        }
        setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateY(0)'; }, 10);
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateY(-20px)'; }, 1500);
    }
});

function processCheckout() {
    let selectedIds = [];
    document.querySelectorAll('.item-checkbox:checked').forEach(cb => selectedIds.push(cb.value));
    
    if (selectedIds.length === 0) {
        alert('Vui lòng chọn ít nhất 1 sản phẩm để thanh toán!');
        return;
    }

    let form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo BASE_URL; ?>onestepcheckout';
    
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'selected_items'; 
    input.value = JSON.stringify(selectedIds);
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
</script>