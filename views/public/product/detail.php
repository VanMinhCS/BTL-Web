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

    /* ADD RATING STYLES */
    .star-rating .star {
        font-size: 35px;
        color: #e9ecef;
        cursor: pointer;
        transition: color 0.2s ease;
    }
    .star-rating .star:hover,
    .star-rating .star.active {
        color: gold;
    }

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

    <!-- ========================================== -->
    <!-- REVIEWS & RATING SECTION START             -->
    <!-- ========================================== -->
    <div class="row mt-5 pt-5 border-top">
        <div class="col-12">
            <h2 class="fw-bold mb-4">Đánh giá sản phẩm</h2>
            
            <div class="row">
                <!-- Left side: Summary & Form -->
                <div class="col-lg-4 mb-4">
                    <div class="bg-light p-4 rounded text-center mb-4">
                        <h1 class="display-4 fw-bold text-dark mb-0">
                            <?php echo isset($ratingSummary['average_rating']) ? $ratingSummary['average_rating'] : '0.0'; ?>
                            <span style="color: gold; font-size: 2.5rem;">★</span>
                        </h1>
                        <p class="text-muted mb-0">Dựa trên <?php echo isset($ratingSummary['total_reviews']) ? $ratingSummary['total_reviews'] : 0; ?> lượt đánh giá</p>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="review-form-container">
                            <h5 class="fw-bold mb-3">Viết đánh giá của bạn</h5>
                            <form id="reviewForm">
                                <input type="hidden" id="productId" value="<?php echo $currentProduct['item_id']; ?>">
                                
                                <div class="star-rating mb-3 d-flex justify-content-center" style="gap: 5px;">
                                    <span class="star active" data-value="1">★</span>
                                    <span class="star active" data-value="2">★</span>
                                    <span class="star active" data-value="3">★</span>
                                    <span class="star active" data-value="4">★</span>
                                    <span class="star active" data-value="5">★</span>
                                    <input type="hidden" id="ratingValue" value="5"> 
                                </div>

                                <textarea id="reviewComment" class="form-control mb-3" rows="3" placeholder="Chia sẻ cảm nhận của bạn (Không bắt buộc)"></textarea>
                                <button type="submit" class="btn btn-dark w-100 fw-bold">Gửi đánh giá</button>
                            </form>
                            <div id="reviewMessage" class="mt-2 text-center fw-bold"></div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            Vui lòng <a href="<?php echo BASE_URL; ?>auth/login" class="fw-bold text-dark">Đăng nhập</a> để viết đánh giá.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right side: Review List -->
                <div class="col-lg-8">
                    <h5 class="fw-bold mb-4">Bình luận gần đây</h5>
                    <?php if (!empty($reviewList)): ?>
                        <div class="review-list" id="reviewContainer">
                            <?php foreach ($reviewList as $review): ?>
                                <!-- BỔ SUNG CLASS 'review-item-paginate' -->
                                <div class="review-item review-item-paginate mb-4 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($review['firstname'] . ' ' . $review['lastname']); ?></h6>
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></small>
                                    </div>
                                    <div class="mb-2 text-warning" style="font-size: 1.1rem; letter-spacing: 2px;">
                                        <?php echo str_repeat('★', $review['rating']) . str_repeat('<span class="text-muted opacity-50">★</span>', 5 - $review['rating']); ?>
                                    </div>
                                    <?php if (!empty($review['comment'])): ?>
                                        <p class="mb-0 text-dark"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- KHU VỰC HIỂN THỊ NÚT PHÂN TRANG -->
                        <div id="reviewPagination" class="d-flex justify-content-center mt-4"></div>
                        
                    <?php else: ?>
                        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================== -->
    <!-- REVIEWS & RATING SECTION END               -->
    <!-- ========================================== -->

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

    // ==========================================
    // 4. XỬ LÝ ĐÁNH GIÁ (RATING)
    // ==========================================
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingInput = document.getElementById('ratingValue');
        const reviewForm = document.getElementById('reviewForm');
        const messageBox = document.getElementById('reviewMessage');

        if (stars.length > 0) {
            // Hover effect
            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= value) {
                            s.style.color = 'gold';
                        } else {
                            s.style.color = '#e9ecef';
                        }
                    });
                });
                
                // Reset to clicked value on mouseout
                star.addEventListener('mouseout', function() {
                    const value = parseInt(ratingInput.value);
                    updateStars(value);
                });

                // Click to set value
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    updateStars(value);
                });
            });
        }

        function updateStars(value) {
            stars.forEach(star => {
                if (parseInt(star.getAttribute('data-value')) <= parseInt(value)) {
                    star.classList.add('active');
                    star.style.color = 'gold';
                } else {
                    star.classList.remove('active');
                    star.style.color = '#e9ecef';
                }
            });
        }

        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang gửi...';
                submitBtn.disabled = true;

                const formData = new URLSearchParams();
                formData.append('product_id', document.getElementById('productId').value);
                formData.append('rating', ratingInput.value);
                formData.append('comment', document.getElementById('reviewComment').value);

                fetch('<?php echo BASE_URL; ?>product/submitReview', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                })
                .then(res => res.json())
                .then(data => {
                    messageBox.innerHTML = `<span class="${data.success ? 'text-success' : 'text-danger'}">${data.message}</span>`;
                    if (data.success) {
                        reviewForm.reset();
                        updateStars(5);
                        setTimeout(() => window.location.reload(), 1500); // Reload to show the new review
                    }
                })
                .catch(error => {
                    console.error("Error submitting review:", error);
                    messageBox.innerHTML = '<span class="text-danger">Đã có lỗi xảy ra.</span>';
                })
                .finally(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
            });
        }
    });

    // ==========================================
    // 5. PHÂN TRANG BÌNH LUẬN BẰNG JAVASCRIPT
    // ==========================================
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy tất cả các thẻ chứa bình luận
        const reviewItems = Array.from(document.getElementsByClassName('review-item-paginate'));
        const paginationContainer = document.getElementById('reviewPagination');
        
        // Nếu không có bình luận nào thì dừng lại
        if (reviewItems.length === 0 || !paginationContainer) return; 

        const itemsPerPage = 3;
        let currentPage = 1;
        const totalPages = Math.ceil(reviewItems.length / itemsPerPage);

        // Hàm hiển thị bình luận theo trang
        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Lặp qua tất cả bình luận: Thuộc trang này thì hiện, không thì ẩn
            reviewItems.forEach((item, index) => {
                if (index >= start && index < end) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });

            // Vẽ lại các nút phân trang cho đúng trạng thái (active/disabled)
            renderPagination();
        }

        // Hàm vẽ các nút bấm
        function renderPagination() {
            // Nếu chỉ có 1 trang hoặc ít hơn thì không cần hiện nút
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }

            let ul = document.createElement('ul');
            ul.className = 'pagination justify-content-center shadow-sm m-0';

            // Nút Lùi (Prev)
            let liPrev = document.createElement('li');
            liPrev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            liPrev.innerHTML = `<a class="page-link text-dark" href="javascript:void(0)">&laquo;</a>`;
            liPrev.addEventListener('click', () => {
                if (currentPage > 1) showPage(currentPage - 1);
            });
            ul.appendChild(liPrev);

            // Các nút Số (1, 2, 3...)
            for (let i = 1; i <= totalPages; i++) {
                let li = document.createElement('li');
                li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                // Đổi màu cho nút đang chọn (active)
                let linkClass = currentPage === i ? 'bg-dark border-dark text-white fw-bold' : 'text-dark';
                li.innerHTML = `<a class="page-link ${linkClass}" href="javascript:void(0)">${i}</a>`;
                li.addEventListener('click', () => showPage(i));
                ul.appendChild(li);
            }

            // Nút Tiến (Next)
            let liNext = document.createElement('li');
            liNext.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            liNext.innerHTML = `<a class="page-link text-dark" href="javascript:void(0)">&raquo;</a>`;
            liNext.addEventListener('click', () => {
                if (currentPage < totalPages) showPage(currentPage + 1);
            });
            ul.appendChild(liNext);

            // Xóa bộ nút cũ và gắn bộ nút mới vào giao diện
            paginationContainer.innerHTML = '';
            paginationContainer.appendChild(ul);
        }

        // Khởi động trang web bằng cách hiển thị trang số 1
        showPage(1);
    });
</script>