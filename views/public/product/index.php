<div class="d-flex align-items-center justify-content-center mb-5" 
     style="min-height: 400px; 
            background-color: #1a1a1a; 
            background-image: url('<?php echo BASE_URL; ?>assets/img/banner.png'); 
            background-size: cover; 
            background-position: center; 
            position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,20,50,0.6);"></div>
    <h1 class="fw-bold display-3 text-white" style="position: relative; z-index: 1; text-transform: uppercase; letter-spacing: 2px;">
        SHOP BK88
    </h1>
</div>

<div class="container mb-5 pb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
        <div class="input-group shadow-sm" style="max-width: 350px;">
            <input type="text" id="searchInput" class="form-control border-dark" placeholder="Nhập tên giáo trình cần tìm...">
            <button class="btn btn-dark px-3" type="button" id="button-addon2">Tìm kiếm</button>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label for="sortBy" class="fw-bold mb-0 text-nowrap">Sort by:</label>
            <select id="sortBy" class="form-select w-auto shadow-sm border-dark">
                <option value="best-selling">Bán chạy nhất</option>
                <option value="name-asc">Theo thứ tự bảng chữ cái: A-Z</option>
                <option value="name-desc">Theo thứ tự bảng chữ cái: Z-A</option>
                <option value="price-asc">Giá: Thấp đến Cao</option>
                <option value="price-desc">Giá: Cao đến Thấp</option>
            </select>
        </div>
    </div>

    <?php
    $products = [
        ['id' => 1, 'img' => 'gt1.png', 'name' => 'Giải Tích 1', 'price' => '70.000₫', 'reviews' => 105, 'badge' => 'BEST SELLER'],
        ['id' => 2, 'img' => 'gt2.png', 'name' => 'Giải Tích 2', 'price' => '70.000₫', 'reviews' => 89, 'badge' => 'BEST SELLER'],
        ['id' => 3, 'img' => 'dstt.png', 'name' => 'Đại Số Tuyến Tính', 'price' => '65.000₫', 'reviews' => 120, 'badge' => ''],
        ['id' => 4, 'img' => 'hdc.png', 'name' => 'Hóa Đại Cương', 'price' => '75.000₫', 'reviews' => 75, 'badge' => ''],
        ['id' => 5, 'img' => 'triethoc.png', 'name' => 'Triết Học Mác - Lênin', 'price' => '78.000₫', 'reviews' => 666, 'badge' => ''],
        ['id' => 6, 'img' => 'ktct.png', 'name' => 'Kinh Tế Chính Trị Mác - Lênin', 'price' => '48.000₫', 'reviews' => 404, 'badge' => ''],
        ['id' => 7, 'img' => 'cnxhkh.png', 'name' => 'Chủ Nghĩa Xã Hội Khoa Học', 'price' => '46.000₫', 'reviews' => 200, 'badge' => ''],
        ['id' => 8, 'img' => 'lsd.png', 'name' => 'Lịch Sử Đảng Cộng Sản Việt Nam', 'price' => '70.000₫', 'reviews' => 300, 'badge' => ''],
        ['id' => 9, 'img' => 'tthcm.png', 'name' => 'Tư Tưởng Hồ Chí Minh', 'price' => '45.000₫', 'reviews' => 500, 'badge' => ''],
        ['id' => 10, 'img' => 'ktlt.png', 'name' => 'Kỹ Thuật Lập Trình', 'price' => '150.000₫', 'reviews' => 999, 'badge' => 'BEST SELLER'],
        ['id' => 11, 'img' => 'ctdlgt.png', 'name' => 'Cấu Trúc Dữ Liệu & Giải Thuật', 'price' => '100.000₫', 'reviews' => 888, 'badge' => ''],
    ];
    ?>

    <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
        <?php foreach ($products as $item): ?>
        <?php $rawPrice = preg_replace('/[^0-9]/', '', $item['price']); ?>
        <div class="col product-item" data-name="<?php echo mb_strtolower($item['name'], 'UTF-8'); ?>" data-price="<?php echo $rawPrice; ?>" data-id="<?php echo $item['id']; ?>">
            <div class="card h-100 border-0 shadow-sm">
                <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['id']; ?>" class="text-decoration-none">
                    <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <?php if (!empty($item['badge'])): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 p-2 rounded-0 border border-white" style="z-index: 2;"><?php echo $item['badge']; ?></span>
                        <?php endif; ?>
                        <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" class="w-100 h-100 object-fit-contain p-3" onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=BK88'">
                    </div>
                </a>
                <div class="card-body text-center pt-4">
                    <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark">
                        <h5 class="card-title fw-bold text-uppercase mb-2" style="font-size: 1.1rem; height: 48px;"><?php echo $item['name']; ?></h5>
                    </a>
                    <p class="card-text mb-2"><span class="fw-bold text-primary fs-5"><?php echo $item['price']; ?></span></p>
                    <div class="text-warning small mb-3">★★★★★ <span class="text-muted">(<?php echo $item['reviews']; ?> Reviews)</span></div>
                    
                    <form action="<?php echo BASE_URL; ?>cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-outline-dark w-100 fw-bold">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const sortSelect = document.getElementById("sortBy");
    const productList = document.getElementById("productList");
    let products = Array.from(productList.getElementsByClassName("product-item"));

    function updateProducts() {
        const keyword = searchInput.value.trim().toLowerCase();
        const sortVal = sortSelect.value;
        let visibleProducts = products.filter(item => {
            const name = item.getAttribute("data-name");
            const isMatch = name.includes(keyword);
            item.style.display = isMatch ? "" : "none";
            return isMatch;
        });
        visibleProducts.sort((a, b) => {
            const nameA = a.getAttribute("data-name"), nameB = b.getAttribute("data-name");
            const priceA = parseInt(a.getAttribute("data-price")), priceB = parseInt(b.getAttribute("data-price"));
            const idA = parseInt(a.getAttribute("data-id")), idB = parseInt(b.getAttribute("data-id"));
            if (sortVal === "name-asc") return nameA.localeCompare(nameB);
            if (sortVal === "name-desc") return nameB.localeCompare(nameA);
            if (sortVal === "price-asc") return priceA - priceB;
            if (sortVal === "price-desc") return priceB - priceA;
            return idA - idB;
        });
        visibleProducts.forEach(item => productList.appendChild(item));
    }
    searchInput.addEventListener("input", updateProducts);
    sortSelect.addEventListener("change", updateProducts);
});
</script>

<script>
    // --- ĐOẠN CODE AJAX CHO GIỎ HÀNG TRÊN TRANG DANH SÁCH ---
    
    // Tìm tất cả các form thêm vào giỏ hàng trên trang
    document.querySelectorAll('form[action*="cart/add"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn load lại trang

            let formData = new FormData(this);
            formData.append('ajax', 1); // Báo hiệu cho Controller xử lý AJAX

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(cartCount => {
                // 1. CẬP NHẬT CON SỐ TRÊN ICON GIỎ HÀNG (HEADER)
                let badge = document.querySelector('.badge.bg-danger');
                let cartLink = document.querySelector('a[href*="cart"]');
                
                if (badge) {
                    badge.innerText = cartCount;
                } else if (cartLink) {
                    // Nếu giỏ hàng đang trống, tạo mới badge số lượng
                    cartLink.innerHTML += `<span class="position-absolute badge rounded-pill bg-danger" style="font-size: 0.65rem; top: 0px; right: -5px; padding: 0.25em 0.5em; border: 1px solid #0d6efd;">${cartCount}</span>`;
                }

                // 2. HIỂN THỊ POPUP THÔNG BÁO (TOAST)
                showCartToast();
            });
        });
    });

    // Hàm tạo và hiển thị Popup thông báo
    function showCartToast() {
        let toast = document.getElementById('cart-toast');
        
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cart-toast';
            // Thiết lập style cho popup giống hệt trang detail
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

        // Hiệu ứng hiện ra
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        // Hiệu ứng biến mất sau 1 giây
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
        }, 1000);
    }
</script>