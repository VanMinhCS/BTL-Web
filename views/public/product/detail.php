<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<style>
    .slick-prev:before, .slick-next:before { color: #1a1a1a; font-size: 24px; }
    .slick-prev { left: -30px; }
    .slick-next { right: -30px; }
    .qty-btn { width: 40px; border: 1px solid #ced4da; background: #fff; font-weight: bold; }
    .qty-input { width: 60px; text-align: center; border: 1px solid #ced4da; border-left: none; border-right: none; }
</style>

<div class="container py-5 mt-4">
    
    <div class="row gx-5 mb-5 pb-5 border-bottom">
        
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="bg-light d-flex justify-content-center align-items-center p-5 rounded" style="aspect-ratio: 1/1;">
                <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $currentProduct['item_image']; ?>" 
                    alt="<?php echo htmlspecialchars($currentProduct['item_name']); ?>" 
                    class="img-fluid object-fit-contain" 
                    style="max-height: 100%;"
                    onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($currentProduct['item_name']); ?>'">
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
                    <button type="submit" class="btn btn-outline-dark py-3 fw-bold text-uppercase" style="border-width: 2px; letter-spacing: 1px;">
                        Thêm vào giỏ hàng
                    </button>
                    
                    <button type="button" class="btn py-3 fw-bold text-uppercase text-white" style="background-color: #0d6efd; letter-spacing: 1px;">
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
                                <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['item_image']; ?>" 
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
</script>