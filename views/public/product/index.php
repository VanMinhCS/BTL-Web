<?php
/**
 * @var array $products
 */
?>
<style>
    /* Hiệu ứng làm mờ ảnh khi hết hàng */
    .img-dimmed {
        opacity: 0.4; /* Làm mờ nhiều hơn chút để nổi bật chữ */
        filter: grayscale(100%); /* Chuyển ảnh sang trắng đen */
        transition: 0.3s ease;
    }

    /* ========================================================
    HIỆU ỨNG HOVER CHO SẢN PHẨM (Nảy, Viền xanh, Đổ bóng)
    ======================================================== */
    .product-item .card {
        transition: all 0.3s ease-in-out;
        border: 1px solid transparent !important; /* Dùng border trong suốt để thẻ không bị giật khi thêm viền màu */
    }

    .product-item .card:hover {
        transform: translateY(-8px); /* Sản phẩm nảy lên 8px */
        box-shadow: 0 12px 25px rgba(13, 110, 253, 0.15) !important; /* Đổ bóng có ánh xanh dương */
        border-color: #0d6efd !important; /* Viền màu xanh dương (primary) */
    }

    /* ========================================================
    HIỆU ỨNG ZOOM ẢNH SẢN PHẨM
    ======================================================== */
    .product-item .product-img-wrapper img {
        transition: transform 0.4s ease; /* Thời gian zoom mượt mà */
    }

    .product-item .card:hover .product-img-wrapper img {
        transform: scale(1.08); /* Hình ảnh hơi to ra 8% */
    }

    /* ========================================================
    LỚP PHỦ VÀ CHỮ "CHI TIẾT" KHI HOVER
    ======================================================== */
    .detail-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.3); /* Lớp phủ trắng mờ nhẹ */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0; /* Mặc định ẩn hoàn toàn */
        transition: all 0.3s ease;
        z-index: 5; /* Đảm bảo nằm trên ảnh */
        pointer-events: none; /* Tránh cản trở việc click vào ảnh */
    }

    .detail-text {
        color: #0d6efd; /* Chữ màu xanh dương */
        font-size: 1.1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0;
        transform: translateY(15px); /* Kéo chữ xuống dưới một chút để chuẩn bị hiệu ứng trượt */
        transition: all 0.4s ease;
    }

    /* Kích hoạt hiển thị lớp phủ và chữ khi hover vào Card */
    .product-item .card:hover .detail-overlay {
        opacity: 1;
    }

    .product-item .card:hover .detail-text {
        opacity: 1;
        transform: translateY(0); /* Trượt chữ về đúng vị trí trung tâm */
    }

    /* Vòng tròn đen mờ chứa chữ Hết Hàng */
    .out-of-stock-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.75);
        color: #ffffff !important; /* Ép buộc chữ màu trắng, không bị dính màu xanh của thẻ link */
        width: 85px;
        height: 85px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        pointer-events: none;
        z-index: 10;
        text-decoration: none !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Ép hiển thị icon cấm khi di chuột vào nút */
    .btn-disabled-strict {
        opacity: 0.5;
        cursor: not-allowed !important;
        pointer-events: none; /* Cấm click tuyệt đối */
    }
</style>

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


    <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
        <?php foreach ($products as $item): ?>
        <?php $rawPrice = $item['price']; ?>
        <div class="col product-item" data-name="<?php echo mb_strtolower($item['item_name'], 'UTF-8'); ?>" data-price="<?php echo $rawPrice; ?>" data-id="<?php echo $item['item_id']; ?>">
            <div class="card h-100 border-0 shadow-sm">
                <?php $isOutOfStock = ($item['item_stock'] <= 0); ?>
                <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="text-decoration-none">
                    <div class="position-relative bg-light product-img-wrapper" style="aspect-ratio: 1/1.2; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        <?php if (!empty($item['badge'] ?? '')): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 p-2 rounded-0 border border-white" style="z-index: 2;"><?php echo $item['badge']; ?></span>
                        <?php endif; ?>
                        
                        <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['item_image']; ?>" 
                        alt="<?php echo $item['item_name']; ?>" 
                        class="w-100 h-100 object-fit-contain p-3 <?php echo $isOutOfStock ? 'img-dimmed' : ''; ?>" 
                        onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=BK88'">

                        <?php if ($isOutOfStock): ?>
                            <div class="out-of-stock-overlay">Hết Hàng</div>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="card-body text-center pt-4">
                    <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="text-decoration-none text-dark">
                        <h5 class="card-title fw-bold text-uppercase mb-2" style="font-size: 1.1rem; height: 48px;"><?php echo $item['item_name']; ?></h5>
                    </a>

                    <!-- ADDED RATING SECTION HERE -->
                    <?php 
                        $avgRating = isset($item['average_rating']) ? round((float)$item['average_rating'], 1) : 0;
                        $totalReviews = isset($item['total_reviews']) ? (int)$item['total_reviews'] : 0;
                    ?>
                    <div class="mb-2" style="font-size: 0.9rem;">
                        <?php if ($totalReviews > 0): ?>
                            <span class="fw-bold text-dark"><?php echo $avgRating; ?></span>
                            <span style="color: gold; font-size: 1.1rem;">★</span>
                            <span class="text-muted">(<?php echo $totalReviews; ?>)</span>
                        <?php else: ?>
                            <span class="text-muted" style="font-size: 0.85rem;">Chưa có đánh giá</span>
                        <?php endif; ?>
                    </div>
                    <!-- END RATING SECTION -->
                     
                    <p class="card-text mb-2"><span class="fw-bold text-primary fs-5"><?php echo number_format($item['price'], 0, ',', '.') . '₫'; ?></span></p>
                    
                    <form action="<?php echo BASE_URL; ?>cart/add" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $item['item_id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-outline-dark w-100 fw-bold <?php echo $isOutOfStock ? 'btn-disabled-strict' : ''; ?>" <?php echo $isOutOfStock ? 'disabled' : ''; ?>>
                            <?php echo $isOutOfStock ? 'Hết hàng' : 'Thêm vào giỏ hàng'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="paginationContainer" class="d-flex justify-content-center mt-5 mb-3"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const sortSelect = document.getElementById("sortBy");
    const productList = document.getElementById("productList");
    const paginationContainer = document.getElementById("paginationContainer");
    
    // Lấy toàn bộ sản phẩm ban đầu lưu vào bộ nhớ
    let allProducts = Array.from(productList.getElementsByClassName("product-item"));
    let filteredProducts = [...allProducts];

    // CẤU HÌNH PHÂN TRANG
    const itemsPerPage = 9; // Hiển thị 9 sản phẩm 1 trang
    let currentPage = 1;

    function updateProducts(resetPage = true) {
        if (resetPage) currentPage = 1; // Nếu gõ tìm kiếm hoặc đổi bộ lọc thì quay về trang 1

        const keyword = searchInput.value.trim().toLowerCase();
        const sortVal = sortSelect.value;

        // 1. Lọc sản phẩm theo từ khóa
        filteredProducts = allProducts.filter(item => {
            const name = item.getAttribute("data-name");
            return name.includes(keyword);
        });

        // 2. Sắp xếp sản phẩm
        filteredProducts.sort((a, b) => {
            const nameA = a.getAttribute("data-name"), nameB = b.getAttribute("data-name");
            const priceA = parseInt(a.getAttribute("data-price")), priceB = parseInt(b.getAttribute("data-price"));
            const idA = parseInt(a.getAttribute("data-id")), idB = parseInt(b.getAttribute("data-id"));
            
            if (sortVal === "name-asc") return nameA.localeCompare(nameB);
            if (sortVal === "name-desc") return nameB.localeCompare(nameA);
            if (sortVal === "price-asc") return priceA - priceB;
            if (sortVal === "price-desc") return priceB - priceA;
            return idA - idB; // Mặc định
        });

        // 3. Giấu TẤT CẢ sản phẩm đi trước
        allProducts.forEach(item => {
            item.style.display = "none";
            productList.appendChild(item); // Giữ đúng thứ tự trong DOM
        });

        // 4. Tính toán phân trang và chỉ hiện những cái thuộc trang hiện tại
        const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        const paginatedItems = filteredProducts.slice(startIndex, endIndex);
        paginatedItems.forEach(item => {
            item.style.display = ""; // Hiện lên lại
        });

        // 5. Vẽ bộ nút bấm phân trang (1, 2, 3...)
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        paginationContainer.innerHTML = ""; // Xóa bộ nút cũ

        if (totalPages <= 1) return; // Nếu chỉ có 1 trang hoặc không có sp thì khỏi hiện nút

        const ul = document.createElement("ul");
        ul.className = "pagination justify-content-center shadow-sm";

        // Nút "Lùi" (Previous)
        const liPrev = document.createElement("li");
        liPrev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        liPrev.innerHTML = `<a class="page-link text-dark" href="javascript:void(0)">&laquo;</a>`;
        liPrev.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                updateProducts(false);
                scrollToTop();
            }
        });
        ul.appendChild(liPrev);

        // Các nút số 1, 2, 3...
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${currentPage === i ? 'active' : ''}`;
            // Styling cho nút trang hiện tại
            const linkClass = currentPage === i ? 'bg-dark border-dark text-white fw-bold' : 'text-dark';
            li.innerHTML = `<a class="page-link ${linkClass}" href="javascript:void(0)">${i}</a>`;
            li.addEventListener("click", () => {
                currentPage = i;
                updateProducts(false);
                scrollToTop();
            });
            ul.appendChild(li);
        }

        // Nút "Tiến" (Next)
        const liNext = document.createElement("li");
        liNext.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        liNext.innerHTML = `<a class="page-link text-dark" href="javascript:void(0)">&raquo;</a>`;
        liNext.addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateProducts(false);
                scrollToTop();
            }
        });
        ul.appendChild(liNext);

        paginationContainer.appendChild(ul);
    }

    // Hàm cuộn mượt mà lên đầu danh sách khi chuyển trang
    function scrollToTop() {
        window.scrollTo({ top: productList.offsetTop - 120, behavior: 'smooth' });
    }

    // 1. Lắng nghe sự kiện KHI BẤM NÚT TÌM KIẾM
    const searchBtn = document.getElementById("button-addon2");
    searchBtn.addEventListener("click", () => updateProducts(true));

    // 2. Lắng nghe sự kiện KHI BẤM PHÍM ENTER trong ô nhập liệu
    searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Ngăn hành vi mặc định
            updateProducts(true);
        }
    });

    // Sự kiện đổi bộ lọc (Sort by) vẫn giữ nguyên
    sortSelect.addEventListener("change", () => updateProducts(true));
    
    // Khởi chạy lần đầu khi vừa vào web
    updateProducts(true);
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
                // 1. TÌM VÀ ĐÁNH THỨC CỤC BADGE MÀU ĐỎ TRÊN HEADER
                let badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.innerText = cartCount;         // Cập nhật số lượng mới
                    badge.classList.remove('d-none');    // Gỡ bỏ trạng thái tàng hình (nếu có)
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