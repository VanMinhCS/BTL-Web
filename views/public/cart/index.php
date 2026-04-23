<div class="container py-5 mt-4" style="min-height: 60vh;">
    <h2 class="fw-bold text-uppercase mb-4">Giỏ hàng của bạn</h2>

    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5">
            <h4 class="text-muted mb-4">Giỏ hàng của bạn đang trống!</h4>
            <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-dark px-4 py-2 fw-bold">
                &larr; Tiếp tục mua sắm
            </a>
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
                                            <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid object-fit-contain" onerror="this.src='https://placehold.co/80x100/1a1a1a/FFF?text=BK'">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1"><?php echo $item['name']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-medium"><?php echo $item['price']; ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <form action="<?php echo BASE_URL; ?>cart/update" method="POST" class="m-0">
                                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 30px; height: 30px; padding: 0;" <?php echo ($item['quantity'] <= 1) ? 'disabled' : ''; ?>>-</button>
                                        </form>
                                        <span class="mx-3 fw-bold fs-6"><?php echo $item['quantity']; ?></span>
                                        <form action="<?php echo BASE_URL; ?>cart/update" method="POST" class="m-0">
                                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 30px; height: 30px; padding: 0;">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-primary"><?php echo $item['item_total']; ?></td>
                                <td class="text-center ps-4">
                                    <form action="<?php echo BASE_URL; ?>cart/remove" method="POST" class="m-0">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn btn-link p-0 border-0 text-decoration-none">
                                            <img src="<?php echo BASE_URL; ?>assets/img/bin.png" alt="Xóa" style="width: 22px; height: 22px; opacity: 0.7; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <a href="<?php echo BASE_URL; ?>product" class="text-dark text-decoration-none fw-bold">
                        &larr; Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-uppercase mb-4">Tóm tắt đơn hàng</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính</span>
                            <span class="fw-bold" id="summary-subtotal"><?php echo number_format($totalPrice, 0, ',', '.'); ?>₫</span>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Tổng cộng</span>
                            <span class="fw-bold fs-4 text-danger" id="summary-total"><?php echo number_format($totalPrice, 0, ',', '.'); ?>₫</span>
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

        selectAllBtn.checked = allChecked && anyChecked;

        let formattedTotal = new Intl.NumberFormat('vi-VN').format(currentTotal) + '₫';
        summarySubtotal.innerText = formattedTotal;
        summaryTotal.innerText = formattedTotal;
    }

    selectAllBtn.addEventListener('change', function() {
        itemCheckboxes.forEach(cb => cb.checked = this.checked);
        calculateTotal();
    });

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', calculateTotal);
    });
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[action*="cart/remove"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            let formData = new FormData(this);
            formData.append('ajax', 1);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
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
                            recalculateAfterDelete();
                        }
                    }, 300);

                    let badge = document.querySelector('.badge.bg-danger');
                    if (badge) {
                        badge.innerText = data.cartCount;
                        if(data.cartCount === 0) badge.remove();
                    }

                    showRemoveToast();
                }
            });
        });
    });

    function recalculateAfterDelete() {
        let currentTotal = 0;
        let allChecked = true;
        let anyChecked = false;
        
        let remainingCheckboxes = document.querySelectorAll('.item-checkbox');
        remainingCheckboxes.forEach(cb => {
            if (cb.checked) {
                currentTotal += parseInt(cb.getAttribute('data-total'));
                anyChecked = true;
            } else {
                allChecked = false;
            }
        });

        document.getElementById('selectAll').checked = allChecked && anyChecked;
        let formattedTotal = new Intl.NumberFormat('vi-VN').format(currentTotal) + '₫';
        document.getElementById('summary-subtotal').innerText = formattedTotal;
        document.getElementById('summary-total').innerText = formattedTotal;
    }

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
</script>