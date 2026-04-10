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
    
    <div class="d-flex justify-content-center justify-content-md-center mb-5">
        <div class="d-flex align-items-center gap-2">
            <label for="sortBy" class="fw-bold mb-0">Sort by:</label>
            <select id="sortBy" class="form-select form-select-sm w-auto shadow-sm border-dark">
                <option value="best-selling">Bán chạy nhất</option>
                <option value="best-selling">Theo thứ tự bảng chữ cái: A-Z</option>
                <option value="best-selling">Theo thứ tự bảng chữ cái: Z-A</option>
                <option value="price-asc">Giá: Thấp đến Cao</option>
                <option value="price-desc">Giá: Cao đến Thấp</option>
            </select>
        </div>
    </div>

    <?php
    $products = [
        ['img' => 'gt1.png', 'name' => 'Giải Tích 1', 'price' => '70.000₫', 'reviews' => 105, 'badge' => ''],
        ['img' => 'gt2.png', 'name' => 'Giải Tích 2', 'price' => '70.000₫', 'reviews' => 89, 'badge' => ''],
        ['img' => 'dstt.png', 'name' => 'Đại Số Tuyến Tính', 'price' => '65.000₫', 'reviews' => 120, 'badge' => ''],
        ['img' => 'hdc.png', 'name' => 'Hóa Đại Cương', 'price' => '75.000₫', 'reviews' => 75, 'badge' => ''],
        ['img' => 'triethoc.png', 'name' => 'Triết Học Mác - Lênin', 'price' => '78.000₫', 'reviews' => 666, 'badge' => ''],
        ['img' => 'ktct.png', 'name' => 'Kinh Tế Chính Trị Mác - Lênin', 'price' => '48.000₫', 'reviews' => 404, 'badge' => ''],
        ['img' => 'cnxhkh.png', 'name' => 'Chủ Nghĩa Xã Hội Khoa Học', 'price' => '46.000₫', 'reviews' => 200, 'badge' => ''],
        ['img' => 'lsd.png', 'name' => 'Lịch Sử Đảng Cộng Sản Việt Nam', 'price' => '70.000₫', 'reviews' => 300, 'badge' => ''],
        ['img' => 'tthcm.png', 'name' => 'Tư Tưởng Hồ Chí Minh', 'price' => '45.000₫', 'reviews' => 500, 'badge' => ''],
        ['img' => 'ktlt.png', 'name' => 'Kỹ Thuật Lập Trình', 'price' => '150.000₫', 'reviews' => 999, 'badge' => ''],
        ['img' => 'ctdlgt.png', 'name' => 'Cấu Trúc Dữ Liệu & Giải Thuật', 'price' => '100.000₫', 'reviews' => 888, 'badge' => ''],
    ];
    ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        
        <?php foreach ($products as $item): ?>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    
                    <?php if (!empty($item['badge'])): ?>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 p-2 rounded-0 border border-white" style="z-index: 2;">
                            <?php echo $item['badge']; ?>
                        </span>
                    <?php endif; ?>
                    
                    <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['img']; ?>" 
                         alt="<?php echo $item['name']; ?>" 
                         class="w-100 h-100 object-fit-contain p-3"
                         onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=<?php echo urlencode($item['name']); ?>'">
                </div>
                
                <div class="card-body text-center pt-4">
                    <h5 class="card-title fw-bold text-uppercase mb-2" style="font-size: 1.1rem; height: 48px;">
                        <?php echo $item['name']; ?>
                    </h5>
                    <p class="card-text mb-2">
                        <span class="fw-bold text-primary fs-5"><?php echo $item['price']; ?></span>
                    </p>
                    <div class="text-warning small mb-3">
                        ★★★★★ <span class="text-muted">(<?php echo $item['reviews']; ?> Reviews)</span>
                    </div>
                    <button class="btn btn-outline-dark w-100 fw-bold">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>