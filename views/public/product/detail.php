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
    .qty-btn { width: 40px; border: 1px solid #ced4da; background: #fff; font-weight: bold; transition: 0.2s; }
    .qty-input { width: 60px; text-align: center; border: 1px solid #ced4da; border-left: none; border-right: none; }

    .qty-btn:disabled {
        background-color: #e9ecef;
        color: #adb5bd;
        cursor: not-allowed;
    }

    /* Ẩn mũi tên lên xuống của thẻ input number trên Chrome, Safari, Edge, Opera */
    .qty-input::-webkit-inner-spin-button, 
    .qty-input::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    /* Ẩn mũi tên lên xuống của thẻ input number trên Firefox */
    .qty-input {
        appearance: textfield;
    }

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

    /* Vòng tròn đen mờ chứa chữ Hết Hàng (Dành cho Slider, kích thước nhỏ hơn) */
    .out-of-stock-overlay-sm {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.75);
        color: #fff !important;
        width: 70px; /* Nhỏ hơn vòng tròn chính */
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px; /* Chữ nhỏ hơn */
        font-weight: bold;
        pointer-events: none;
        z-index: 10;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        text-align: center;
        line-height: 1.2;
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
                <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $currentProduct['item_image']; ?>" 
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
                        <button type="button" id="btn-decrease" class="qty-btn rounded-start" onclick="decreaseQty()" disabled>-</button>
                        
                        <input type="number" id="quantity" name="quantity" value="1" class="qty-input" min="1" oninput="checkQtyState()" onblur="validateEmptyQty()">
                        
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
                <?php 
                    // KIỂM TRA TỒN KHO CỦA TỪNG SẢN PHẨM TRONG SLIDER
                    $itemIsOutOfStock = ($item['item_stock'] <= 0); 
                ?>
                <div class="px-2">
                    <div class="card h-100 border-0 shadow-sm">
                        <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="text-decoration-none">
                            <div class="position-relative bg-light product-img-wrapper" style="aspect-ratio: 1/1.2; display: flex; align-items: center; justify-content: center;">
                                
                                <!-- Thêm class img-dimmed nếu hết hàng -->
                                <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['item_image']; ?>" 
                                    alt="<?php echo htmlspecialchars($item['item_name']); ?>" 
                                    class="w-100 h-100 object-fit-contain p-3 <?php echo $itemIsOutOfStock ? 'img-dimmed' : ''; ?>"
                                    onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($item['item_name']); ?>'">
                                
                                <!-- Hiển thị vòng tròn đen nếu hết hàng -->
                                <?php if ($itemIsOutOfStock): ?>
                                    <div class="out-of-stock-overlay-sm">Hết<br>Hàng</div>
                                <?php endif; ?>

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
    // ==========================================
    // 1. TĂNG GIẢM SỐ LƯỢNG SẢN PHẨM
    // ==========================================
    function checkQtyState() {
        let input = document.getElementById('quantity');
        let btnDecrease = document.getElementById('btn-decrease');
        let currentVal = parseInt(input.value);

        if (isNaN(currentVal) || currentVal <= 1) {
            btnDecrease.disabled = true;
        } else {
            btnDecrease.disabled = false;
        }
    }

    function validateEmptyQty() {
        let input = document.getElementById('quantity');
        let currentVal = parseInt(input.value);
        if (isNaN(currentVal) || currentVal < 1) {
            input.value = 1;
        }
        checkQtyState();
    }

    function increaseQty() {
        let input = document.getElementById('quantity');
        let currentVal = parseInt(input.value) || 0; 
        input.value = currentVal + 1;
        checkQtyState();
    }
    
    function decreaseQty() {
        let input = document.getElementById('quantity');
        let currentVal = parseInt(input.value) || 1;
        if (currentVal > 1) {
            input.value = currentVal - 1;
        }
        checkQtyState();
    }

    document.addEventListener("DOMContentLoaded", function() {
        checkQtyState();
        let qtyInput = document.getElementById('quantity');
        if (qtyInput) {
            qtyInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); 
                }
            });
        }
    });

    // ==========================================
    // 2. XỬ LÝ THÊM VÀO GIỎ HÀNG VÀ MUA NGAY
    // ==========================================
    document.querySelector('form[action*="cart/add"]').addEventListener('submit', function(e) {
        e.preventDefault(); 

        let form = this;
        let formData = new FormData(form);
        formData.append('ajax', 1); 

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(cartCount => {
            let badge = document.getElementById('cart-badge');
            if (badge) {
                badge.innerText = cartCount;         
                badge.classList.remove('d-none');    
            }

            let toast = document.getElementById('cart-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'cart-toast';
                toast.style.cssText = `
                    position: fixed; top: 100px; right: 20px;
                    background-color: #198754; color: #fff;
                    padding: 12px 24px; border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 9999; font-weight: bold;
                    transition: opacity 0.3s ease, transform 0.3s ease;
                    transform: translateY(-20px); opacity: 0;
                `;
                toast.innerHTML = '✓ Đã thêm vào giỏ hàng!';
                document.body.appendChild(toast);
            }

            setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateY(0)'; }, 10);
            setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateY(-20px)'; }, 1000);
        })
        .catch(error => {
            console.error("Lỗi khi thêm vào giỏ hàng:", error);
            alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
        });
    });

    // CHỈ KHAI BÁO BIẾN MỘT LẦN DUY NHẤT Ở ĐÂY
    let buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            let form = document.querySelector('form[action*="cart/add"]');
            let formData = new FormData(form);
            formData.append('ajax', 1);

            let originalText = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
            this.style.pointerEvents = 'none'; 

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(cartCount => {
                window.location.href = '<?php echo BASE_URL; ?>cart'; 
            })
            .catch(error => {
                console.error("Lỗi khi mua ngay:", error);
                alert("Có lỗi xảy ra, vui lòng thử lại!");
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            });
        });
    }

    // ==========================================
    // 3. KHỞI TẠO SLIDER SẢN PHẨM LIÊN QUAN
    // ==========================================
    $(document).ready(function(){
        $('.related-products-slider').slick({
            dots: false,           
            infinite: true,        
            speed: 500,            
            slidesToShow: 4,       
            slidesToScroll: 1,     
            autoplay: true,        
            autoplaySpeed: 3000,   
            prevArrow: '<button type="button" class="slick-prev shadow-none border-0 bg-transparent"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next shadow-none border-0 bg-transparent"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                { breakpoint: 992, settings: { slidesToShow: 3 } },
                { breakpoint: 768, settings: { slidesToShow: 2 } },
                { breakpoint: 576, settings: { slidesToShow: 1 } }
            ]
        });
    });
</script>