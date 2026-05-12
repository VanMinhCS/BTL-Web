<?php
$homeSections = $homeSections ?? ($data['homeSections'] ?? []);
$homeQuotes = $homeQuotes ?? ($data['homeQuotes'] ?? []);
$homeReasons = $homeReasons ?? ($data['homeReasons'] ?? []);
$homeFeaturedProducts = $homeFeaturedProducts ?? ($data['homeFeaturedProducts'] ?? []);

$quoteSection = $homeSections['quote'] ?? ['is_active' => 1];
$reasonSection = $homeSections['reason'] ?? [
    'is_active' => 1,
    'title' => 'Tại sao lại chọn chúng tôi?',
    'subtitle' => 'Những giá trị cốt lõi mà BK88 mang lại cho bạn.'
];
$productSection = $homeSections['product'] ?? [
    'is_active' => 1,
    'title' => 'Một số sản phẩm tiêu biểu',
    'subtitle' => 'Tham khảo một số giáo trình tiêu biểu của chúng tôi'
];
?>

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

<?php if (!empty($quoteSection['is_active'])): ?>
    <section class="container mb-5">
        <div class="row">
            <div class="col-lg-12 col-md-10 mx-auto">
                <?php if (empty($homeQuotes)): ?>
                    <p class="text-center text-muted">Hiện chưa có trích dẫn nào.</p>
                <?php else: ?>
                    <div class="main-slider co-founder-slide rounded shadow overflow-hidden">
                        <?php foreach ($homeQuotes as $quote): ?>
                            <?php
                            $imagePath = !empty($quote['image'])
                                ? BASE_URL . 'assets/img/' . $quote['image']
                                : BASE_URL . 'assets/img/banner.png';
                            ?>
                            <div class="item">
                                <div class="slide-bg" style="background-image: url('<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>');">
                                    <div class="quote-box">
                                        <p class="quote-text">"<?= htmlspecialchars($quote['quote_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"</p>
                                        <?php if (!empty($quote['author'])): ?>
                                            <small><?= htmlspecialchars($quote['author'], ENT_QUOTES, 'UTF-8'); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($reasonSection['is_active'])): ?>
    <section class="container">
        <div class="text-center mb-5">
            <?php if (!empty($reasonSection['title'])): ?>
                <h2 class="fw-bold"><?= htmlspecialchars($reasonSection['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <?php endif; ?>
            <?php if (!empty($reasonSection['subtitle'])): ?>
                <p class="text-muted"><?= htmlspecialchars($reasonSection['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </div>

        <?php if (empty($homeReasons)): ?>
            <p class="text-center text-muted">Hiện chưa có lý do nào.</p>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($homeReasons as $reason): ?>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded shadow-sm h-100">
                            <h4 class="fw-bold mb-3"><?= htmlspecialchars($reason['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h4>
                            <p><?= htmlspecialchars($reason['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php if (!empty($productSection['is_active'])): ?>
    <section class="container py-5">
        <div class="text-center mb-5">
            <?php if (!empty($productSection['title'])): ?>
                <h2 class="fw-bold"><?= htmlspecialchars($productSection['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <?php endif; ?>
            <?php if (!empty($productSection['subtitle'])): ?>
                <p class="text-muted"><?= htmlspecialchars($productSection['subtitle'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </div>

        <?php if (empty($homeFeaturedProducts)): ?>
            <p class="text-center text-muted">Hiện chưa có sản phẩm nào.</p>
        <?php else: ?>
            <div class="featured-products">
                <?php foreach ($homeFeaturedProducts as $item): 
                    $isOut = (isset($item['item_stock']) && $item['item_stock'] <= 0);
                    $img = !empty($item['item_image']) ? $item['item_image'] : 'default.png';
                ?>
                    <div class="fp-card p-2">
                        <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo urlencode($item['item_id']); ?>" class="text-decoration-none text-dark d-block">
                            <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s; border:1px solid transparent;">
                                <div class="position-relative bg-light" style="aspect-ratio: 1/1.2; display:flex; align-items:center; justify-content:center; overflow: hidden;">
                                    <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>"
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
<?php endif; ?>