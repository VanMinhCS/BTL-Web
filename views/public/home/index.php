<section class="bg-light text-center">
    <div class="d-flex align-items-center justify-content-center mb-5" 
        style="min-height: 400px; 
                background-color: #1a1a1a; 
                background-image: url('<?php echo BASE_URL; ?>assets/img/banner.png'); 
                background-size: cover; 
                background-position: center; 
                position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,20,50,0.6);"></div>
        <div class="container py-5">
            <h1 class="fw-bold display-3 text-white" style="position: relative; z-index: 1; letter-spacing: 2px;">
            Nền tảng cung cấp giáo trình hàng đầu
            </h1>
            <br>
            <a href="<?php echo BASE_URL; ?>product" class="btn btn-primary btn-lg px-2 me-md-1" style="position: relative; z-index: 1; letter-spacing: 0px;">Khám phá các sản phẩm</a>
            <a href="<?php echo BASE_URL; ?>contact" class="btn btn-secondary btn-lg px-2" style="position: relative; z-index: 1; letter-spacing: 0px;">Liên hệ ngay với chúng tôi</a>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row">
        <div class="col-lg-12 col-md-10 mx-auto">
            <div class="main-slider co-founder-slide rounded shadow overflow-hidden">
                <div class="item">
                    <div class="slide-bg" style="background-image: url('<?= BASE_URL ?>assets/img/avt/nvm.png');">
                        <div class="quote-box">
                            <p class="quote-text">"Sách là nguồn tri thức vô tận."</p>
                            <small>- Nguyễn Văn Minh - Co-founder của BK88</small>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="slide-bg" style="background-image: url('<?= BASE_URL ?>assets/img/avt/HNAT.png');">
                        <div class="quote-box">
                            <p class="quote-text">"Đầu tư vào kiến thức là khoản đầu tư lãi nhất."</p>
                            <small>- Hồ Ngọc Anh Tuấn - Co-founder của BK88</small>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="slide-bg" style="background-image: url('<?= BASE_URL ?>assets/img/avt/Trung Nông.png');">
                        <div class="quote-box">
                            <p class="quote-text">"Kiến thức dẫn lối con người."</p>
                            <small>- Nông Văn Trung - Co-founder của BK88</small>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="slide-bg" style="background-image: url('<?= BASE_URL ?>assets/img/avt/Trung Phan.png');">
                        <div class="quote-box">
                            <p class="quote-text">"Kiến thức là kết tinh của tạo hóa."</p>
                            <small>- Phan Huy Trung - Co-founder của BK88</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Tại sao lại chọn chúng tôi?</h2>
        <p class="text-muted">Những giá trị cốt lõi mà BK88 mang lại cho bạn.</p>
    </div>

    <div class="row g-4">
        <!-- Ô 1 -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <h4 class="fw-bold mb-3">Giáo trình chất lượng</h4>
                <p>Cung cấp các bộ giáo trình được biên soạn và kiểm duyệt kỹ lưỡng bởi các chuyên gia hàng đầu trong ngành.</p>
            </div>
        </div>
        <!-- Ô 2 -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <h4 class="fw-bold mb-3">Cập nhật liên tục</h4>
                <p>Nội dung luôn được làm mới để bắt kịp xu hướng và kiến thức mới nhất, đảm bảo tính ứng dụng cao.</p>
            </div>
        </div>
        <!-- Ô 3 -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <h4 class="fw-bold mb-3">Hỗ trợ 24/7</h4>
                <p>Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc của bạn mọi lúc, mọi nơi.</p>
            </div>
        </div>
        <!-- Ô 4 -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <h4 class="fw-bold mb-3">Giá cả hợp lý</h4>
                <p>Mang lại giá trị kiến thức vượt trội với mức chi phí cạnh tranh nhất trên thị trường.</p>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Một số sản phẩm tiêu biểu</h2>
        <p class="text-muted">Tham khảo một số giáo trình tiêu biểu của chúng tôi</p>
    </div>

    <?php if (empty($data['featuredProducts'])): ?>
        <p class="text-center text-muted">Hiện chưa có sản phẩm nào.</p>
    <?php else: ?>
        <div class="featured-products">
            <?php foreach ($data['featuredProducts'] as $item): 
                $isOut = (isset($item['item_stock']) && $item['item_stock'] <= 0);
                $img = !empty($item['item_image']) ? $item['item_image'] : 'default.png';
            ?>
                <div class="fp-card p-2">
                    <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo urlencode($item['item_id']); ?>" class="text-decoration-none text-dark d-block">
                        <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s; border:1px solid transparent;">
                            <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; display:flex; align-items:center; justify-content:center; overflow: hidden;">
                                <img src="<?php echo BASE_URL; ?>assets/img/<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="<?php echo htmlspecialchars($item['item_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                     class="w-100 h-100 object-fit-contain p-3 <?php echo $isOut ? 'img-dimmed' : ''; ?>"
                                     style="transition: transform 0.4s ease;"
                                     onerror="this.src='https://placehold.co/600x800/1a1a1a/FFF?text=BK88'">
                                
                                <?php if ($isOut): ?>
                                    <div style="position:absolute; background:rgba(0,0,0,0.75); color:#fff; width:85px; height:85px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:bold; top:50%; left:50%; transform:translate(-50%,-50%);">
                                        Hết Hàng
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body text-center pt-4 pb-3">
                                <h6 class="card-title fw-bold text-uppercase mb-2" style="font-size:0.95rem; height:44px; overflow:hidden;">
                                    <?php echo htmlspecialchars($item['item_name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                </h6>
                                <p class="mb-0"><span class="fw-bold text-primary fs-6"><?php echo number_format($item['price'] ?? 0, 0, ',', '.') . '₫'; ?></span></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="<?php echo BASE_URL; ?>product" class="btn btn-outline-primary px-5 py-2 fw-bold" style="border-radius: 8px;">XEM TẤT CẢ SẢN PHẨM</a>
    </div>
</section>