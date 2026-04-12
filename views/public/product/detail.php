<?php
// 1. MẢNG DỮ LIỆU TẠM THỜI (Sẽ thay bằng truy vấn Database sau)
$products = [
    ['id' => 1, 'img' => 'gt1.png', 'name' => 'Giải Tích 1', 'price' => '70.000₫', 'reviews' => 105, 'badge' => '', 'desc' => 'Giáo trình cốt lõi dành cho sinh viên năm nhất. Bao gồm giới hạn, đạo hàm, và tích phân một biến.'],
    ['id' => 2, 'img' => 'gt2.png', 'name' => 'Giải Tích 2', 'price' => '70.000₫', 'reviews' => 89, 'badge' => '', 'desc' => 'Tiếp nối Giải tích 1, đi sâu vào hàm nhiều biến, tích phân bội, và giải tích véc-tơ.'],
    ['id' => 3, 'img' => 'dstt.png', 'name' => 'Đại Số Tuyến Tính', 'price' => '65.000₫', 'reviews' => 120, 'badge' => '', 'desc' => 'Nền tảng của toán học hiện đại và khoa học máy tính. Ma trận, định thức, và không gian véc-tơ.'],
    ['id' => 4, 'img' => 'hdc.png', 'name' => 'Hóa Đại Cương', 'price' => '75.000₫', 'reviews' => 75, 'badge' => '', 'desc' => 'Cung cấp kiến thức cơ bản về cấu tạo chất, nhiệt động lực học và động hóa học.'],
    ['id' => 5, 'img' => 'triethoc.png', 'name' => 'Triết Học Mác - Lênin', 'price' => '78.000₫', 'reviews' => 666, 'badge' => 'TÂM LINH!', 'desc' => 'Môn học mang đậm tính "tâm linh". Cần sự giác ngộ cao độ để vượt qua kỳ thi cuối kỳ.'],
    ['id' => 6, 'img' => 'ktct.png', 'name' => 'Kinh Tế Chính Trị Mác - Lênin', 'price' => '48.000₫', 'reviews' => 404, 'badge' => '', 'desc' => 'Nghiên cứu các quy luật kinh tế của phương thức sản xuất tư bản chủ nghĩa.'],
    ['id' => 7, 'img' => 'cnxhkh.png', 'name' => 'Chủ Nghĩa Xã Hội Khoa Học', 'price' => '46.000₫', 'reviews' => 200, 'badge' => '', 'desc' => 'Một trong ba bộ phận cấu thành chủ nghĩa Mác - Lênin.'],
    ['id' => 8, 'img' => 'lsd.png', 'name' => 'Lịch Sử Đảng Cộng Sản Việt Nam', 'price' => '70.000₫', 'reviews' => 300, 'badge' => '', 'desc' => 'Tìm hiểu về chặng đường lịch sử hào hùng và sự lãnh đạo của Đảng.'],
    ['id' => 9, 'img' => 'tthcm.png', 'name' => 'Tư Tưởng Hồ Chí Minh', 'price' => '45.000₫', 'reviews' => 500, 'badge' => 'HOT!', 'desc' => 'Hệ thống quan điểm toàn diện và sâu sắc về những vấn đề cơ bản của cách mạng Việt Nam.'],
    ['id' => 10, 'img' => 'ktlt.png', 'name' => 'Kỹ Thuật Lập Trình', 'price' => '150.000₫', 'reviews' => 999, 'badge' => 'BEST SELLER', 'desc' => 'Bí kíp nhập môn C/C++. First rule of coding: If it works, don\'t touch.'],
    ['id' => 11, 'img' => 'ctdlgt.png', 'name' => 'Cấu Trúc Dữ Liệu & Giải Thuật', 'price' => '100.000₫', 'reviews' => 888, 'badge' => 'NỖI ÁM ẢNH', 'desc' => 'Chặn đường gian nan nhất của sinh viên IT. Bí kíp giúp bạn tối ưu hóa thuật toán và thoát khỏi vòng lặp vô hạn.'],
];

// 2. TÌM SẢN PHẨM HIỆN TẠI VÀ CÁC SẢN PHẨM LIÊN QUAN
$currentProduct = null;
$relatedProducts = [];

foreach ($products as $p) {
    if ($p['id'] == $productId) {
        $currentProduct = $p;
    } else {
        $relatedProducts[] = $p; // Đưa vào mảng liên quan nếu không phải sản phẩm đang xem
    }
}

// Nếu nhập ID linh tinh trên URL, quay về trang sản phẩm
if (!$currentProduct) {
    echo "<script>window.location.href = '" . BASE_URL . "product';</script>";
    exit;
}
?>

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
                <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $currentProduct['img']; ?>" 
                     alt="<?php echo $currentProduct['name']; ?>" 
                     class="img-fluid object-fit-contain" 
                     style="max-height: 100%;"
                     onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($currentProduct['name']); ?>'">
            </div>
        </div>

        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h6 class="text-muted text-uppercase mb-2">SÁCH GIÁO TRÌNH BÁCH KHOA</h6>
            <h1 class="fw-bold text-uppercase mb-3" style="font-size: 2.5rem;"><?php echo $currentProduct['name']; ?></h1>
            
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">★★★★★</div>
                <span class="text-muted small"><?php echo $currentProduct['reviews']; ?> Đánh giá</span>
            </div>

            <h3 class="fw-bold mb-4"><?php echo $currentProduct['price']; ?></h3>

            <form action="<?php echo BASE_URL; ?>cart/add" method="POST">
                
                <input type="hidden" name="product_id" value="<?php echo $currentProduct['id']; ?>">

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
                    
                    <button type="button" class="btn py-3 fw-bold text-uppercase text-white" style="background-color: #5a31f4; letter-spacing: 1px;">
                        Mua ngay
                    </button>
                </div>
                
            </form>

            <div class="mt-5">
                <h6 class="fw-bold">Mô tả sản phẩm:</h6>
                <p class="text-muted" style="line-height: 1.8;">
                    <?php echo isset($currentProduct['desc']) ? $currentProduct['desc'] : 'Nội dung mô tả đang được cập nhật...'; ?>
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
                        <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['id']; ?>" class="text-decoration-none">
                            <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; display: flex; align-items: center; justify-content: center;">
                                <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['img']; ?>" 
                                     alt="<?php echo $item['name']; ?>" 
                                     class="w-100 h-100 object-fit-contain p-3"
                                     onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($item['name']); ?>'">
                            </div>
                        </a>
                        <div class="card-body text-center pt-3 pb-4">
                            <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark">
                                <h6 class="card-title fw-bold text-uppercase mb-1" style="height: 40px; overflow: hidden;">
                                    <?php echo $item['name']; ?>
                                </h6>
                            </a>
                            <p class="card-text mb-0">
                                <span class="fw-bold text-primary"><?php echo $item['price']; ?></span>
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
            // 1. CẬP NHẬT CON SỐ TRÊN ICON GIỎ HÀNG
            let badge = document.querySelector('.badge.bg-danger');
            let cartLink = document.querySelector('a[href*="cart"]');
            
            if (badge) {
                badge.innerText = cartCount; // Đã có số rồi thì cập nhật số mới
            } else if (cartLink) {
                // Nếu giỏ hàng đang trống, tạo ra cục màu đỏ và nhét vào
                cartLink.innerHTML += `<span class="position-absolute badge rounded-pill bg-danger" style="font-size: 0.65rem; top: 0px; right: -5px; padding: 0.25em 0.5em; border: 1px solid #0d6efd;">${cartCount}</span>`;
            }

            // 2. HIỆU ỨNG UX: HIỂN THỊ POPUP (TOAST NOTIFICATION)
            let toast = document.getElementById('cart-toast');
            
            // Nếu chưa có popup trong trang thì tạo mới
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'cart-toast';
                
                // CSS cho popup nằm đè lên mọi thứ ở góc trên bên phải
                toast.style.position = 'fixed';
                toast.style.top = '100px'; // Cách mép trên (tránh bị che bởi Header)
                toast.style.right = '20px'; // Cách mép phải
                toast.style.backgroundColor = '#198754'; // Màu xanh lá mạ (success)
                toast.style.color = '#fff';
                toast.style.padding = '12px 24px';
                toast.style.borderRadius = '8px';
                toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
                toast.style.zIndex = '9999';
                toast.style.fontWeight = 'bold';
                toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                toast.style.transform = 'translateY(-20px)'; // Hơi dịch lên trên để làm hiệu ứng trượt
                toast.style.opacity = '0';
                
                toast.innerHTML = '✓ Đã thêm vào giỏ hàng!';
                document.body.appendChild(toast);
            }

            // Kích hoạt hiệu ứng hiện popup (Trượt xuống và rõ dần)
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            // Tự động mờ đi và biến mất sau 1 giây (1000 ms)
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
            }, 1000);
        });
    });
</script>