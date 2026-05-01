<?php
/**
 * @var array $currentProduct
 * @var array $relatedProducts
 */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link rel="stylesheet" href="assets/css/public/product-list.css"/>

<style>
    .slick-prev:before, .slick-next:before { color: #1a1a1a; font-size: 24px; }
    .slick-prev { left: -30px; }
    .slick-next { right: -30px; }
    .qty-btn { width: 40px; border: 1px solid #ced4da; background: #fff; font-weight: bold; }
    .qty-input { width: 60px; text-align: center; border: 1px solid #ced4da; border-left: none; border-right: none; }

</style>

<style>
    /* ... các style cũ giữ nguyên ... */
    
    /* Bao bọc ảnh để căn giữa chữ Hết Hàng */
    .product-img-wrapper { position: relative; display: block; overflow: hidden; }

    /* Hiệu ứng làm mờ ảnh khi hết hàng */
    .img-dimmed { 
        opacity: 0.4; 
        filter: grayscale(100%); 
        transition: 0.3s ease; 
    }

    /* Vòng tròn đen mờ chứa chữ Hết Hàng (trang Detail làm to hơn) */
    .out-of-stock-overlay {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.75);
        color: #fff !important;
        width: 120px; /* To hơn trang danh sách */
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px; /* Chữ to rõ hơn */
        font-weight: bold;
        pointer-events: none;
        z-index: 10;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }

    /* Cấm click và hiện icon cấm */
    .btn-disabled-strict {
        opacity: 0.5;
        cursor: not-allowed !important;
    }
</style>

<div class="container py-5 mt-4">
    
    <div class="row gx-5 mb-5 pb-5 border-bottom">
        
        <div class="col-md-6 mb-4 mb-md-0">
            <?php $isOutOfStock = ($currentProduct['item_stock'] <= 0); ?>
            
            <div class="bg-light d-flex justify-content-center align-items-center p-5 rounded product-img-wrapper" style="aspect-ratio: 1/1;">
                <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $currentProduct['item_image']; ?>" 
                    alt="<?php echo htmlspecialchars($currentProduct['item_name']); ?>" 
                    class="img-fluid object-fit-contain <?php echo $isOutOfStock ? 'img-dimmed' : ''; ?>" 
                    style="max-height: 100%;"
                    onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($currentProduct['item_name']); ?>'">
                
                <?php if ($isOutOfStock): ?>
                    <div class="out-of-stock-overlay">Hết Hàng</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h6 class="text-muted text-uppercase mb-2">SÁCH GIÁO TRÌNH BÁCH KHOA</h6>
            <h1 class="fw-bold text-uppercase mb-3" style="font-size: 2.5rem;"><?php echo $currentProduct['item_name']; ?></h1>
            

            <h3 class="fw-bold mb-4 text-primary"><?php echo number_format($currentProduct['price'], 0, ',', '.') . ' ₫'; ?></h3>

            <form action="<?php echo BASE_URL; ?>cart/add" method="POST">
                
                <input type="hidden" name="product_id" value="<?php echo $currentProduct['item_id']; ?>">

                <div class="mb-4">
                    <label class="fw-bold mb-2">Số lượng</label>
                    <div class="d-flex">
                        <button type="button" class="qty-btn rounded-start" onclick="decreaseQty()">-</button>
                        
                        <input type="text" id="quantity" name="quantity" value="1" class="qty-input" readonly>
                        
                        <button type="button" class="qty-btn rounded-end" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <button type="submit" 
                            class="btn btn-outline-dark py-3 fw-bold text-uppercase <?php echo $isOutOfStock ? 'btn-disabled-strict' : ''; ?>" 
                            style="border-width: 2px; letter-spacing: 1px;"
                            <?php echo $isOutOfStock ? 'disabled' : ''; ?>>
                        Thêm vào giỏ hàng
                    </button>
                    
                    <button type="button" 
                            id="buyNowBtn" class="btn py-3 fw-bold text-uppercase text-white <?php echo $isOutOfStock ? 'btn-disabled-strict' : ''; ?>" 
                            style="background-color: #0d6efd; letter-spacing: 1px;"
                            <?php echo $isOutOfStock ? 'disabled' : ''; ?>>
                        Mua ngay
                    </button>
                </div>
                
            </form>

            <div class="mt-5">
                <h6 class="fw-bold">Mô tả sản phẩm:</h6>
                <p class="text-muted" style="line-height: 1.8;">
                    <?php echo !empty($currentProduct['description']) ? nl2br(htmlspecialchars($currentProduct['description'])) : 'Nội dung mô tả đang được cập nhật...'; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-3">
        <div class="col-12">
            <h2 class="fw-bold mb-4">Có thể bạn cũng cần đến</h2>
            
            <div class="related-products-slider">
                <?php foreach ($relatedProducts as $item): ?>
                <div class="px-2">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="text-decoration-none">
                            <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; display: flex; align-items: center; justify-content: center;">
                                <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['item_image']; ?>" 
                                    alt="<?php echo htmlspecialchars($item['item_name']); ?>" 
                                    class="w-100 h-100 object-fit-contain p-3"
                                    onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($item['item_name']); ?>'">
                            </div>
                        </a>
                        <div class="card-body text-center pt-3 pb-4">
                            <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="text-decoration-none text-dark">
                                <h6 class="card-title fw-bold text-uppercase mb-1" style="height: 40px; overflow: hidden;">
                                    <?php echo $item['item_name']; ?>
                                </h6>
                            </a>
                            <p class="card-text mb-0">
                                <span class="fw-bold text-primary"><?php echo number_format($item['price'], 0, ',', '.') . ' ₫'; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    // Xử lý tăng giảm số lượng
    function increaseQty() {
        let input = document.getElementById('quantity');
        input.value = parseInt(input.value) + 1;
    }
    
    function decreaseQty() {
        let input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // Khởi tạo Slick Carousel khi trang đã load xong
    $(document).ready(function(){
        $('.related-products-slider').slick({
            slidesToShow: 4,      // Hiện 4 sản phẩm trên màn hình máy tính
            slidesToScroll: 1,    // Cuộn 1 sản phẩm mỗi lần bấm
            autoplay: true,       // Tự động trượt
            autoplaySpeed: 3000,  // Tốc độ 3 giây
            arrows: true,         // Hiện mũi tên trái/phải
            dots: false,
            responsive: [
                {
                    breakpoint: 992, // Tablet
                    settings: { slidesToShow: 3 }
                },
                {
                    breakpoint: 768, // Mobile ngang
                    settings: { slidesToShow: 2 }
                },
                {
                    breakpoint: 576, // Mobile dọc
                    settings: { slidesToShow: 1, arrows: false }
                }
            ]
        });
    });
</script>

<script>
    // Bắt sự kiện khi bấm nút Thêm vào giỏ hàng
    document.querySelector('form[action*="cart/add"]').addEventListener('submit', function(e) {
        e.preventDefault(); // Phanh gấp! Ngăn không cho trình duyệt load lại trang

        let form = this;
        let formData = new FormData(form);
        formData.append('ajax', 1); // Đính kèm cờ báo hiệu đây là gửi ngầm (AJAX)

        // Gửi dữ liệu đi một cách âm thầm
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(cartCount => {
            // 1. TÌM VÀ CẬP NHẬT ĐÚNG CỤC BADGE TRÊN HEADER BẰNG ID
            let badge = document.getElementById('cart-badge');
            if (badge) {
                badge.innerText = cartCount;         // Cập nhật số lượng mới
                badge.classList.remove('d-none');    // Gỡ bỏ trạng thái tàng hình (nếu trước đó giỏ hàng trống)
            }

            // 2. HIỆU ỨNG UX: HIỂN THỊ POPUP (TOAST NOTIFICATION)
            let toast = document.getElementById('cart-toast');
            
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'cart-toast';
                
                toast.style.cssText = `
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    background-color: #198754;
                    color: #fff;
                    padding: 12px 24px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 9999;
                    font-weight: bold;
                    transition: opacity 0.3s ease, transform 0.3s ease;
                    transform: translateY(-20px);
                    opacity: 0;
                `;
                toast.innerHTML = '✓ Đã thêm vào giỏ hàng!';
                document.body.appendChild(toast);
            }

            // Kích hoạt hiệu ứng hiện popup
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            // Tự động biến mất sau 1 giây
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
            }, 1000);
        })
        .catch(error => {
            console.error("Lỗi khi thêm vào giỏ hàng:", error);
            alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
        });
    });

    // --- XỬ LÝ SỰ KIỆN NÚT "MUA NGAY" ---
    let buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            // 1. Lấy dữ liệu từ form giống hệt như nút Thêm vào giỏ
            let form = document.querySelector('form[action*="cart/add"]');
            let formData = new FormData(form);
            formData.append('ajax', 1);

            // Đổi text nút thành "Đang xử lý..." để tăng trải nghiệm (UX)
            let originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
            this.style.pointerEvents = 'none'; // Chặn click đúp

            // 2. Gửi ngầm dữ liệu lên server
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(cartCount => {
                // 3. THÀNH CÔNG: Chuyển hướng khách thẳng sang trang Giỏ Hàng
                window.location.href = '<?php echo BASE_URL; ?>cart'; 
                
                // (Ghi chú: Nếu hệ thống của bạn muốn nhảy thẳng qua bước thanh toán, 
                // bạn có thể đổi 'cart' thành 'onestepcheckout' nhé)
            })
            .catch(error => {
                console.error("Lỗi khi mua ngay:", error);
                alert("Có lỗi xảy ra, vui lòng thử lại!");
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            });
        });
    }
</script>