<?php require_once '../views/public/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/public/about.css">

<div class="about-wrapper">
    
    <div class="hero-card">
        <h1><?php echo $data['title'] ?? 'Về Chúng Tôi'; ?></h1>
        <p><?php echo nl2br($data['description'] ?? 'Chào mừng bạn đến với hệ thống của chúng tôi.'); ?></p>
    </div>

    <div class="features-grid">
        <?php if(!empty($data['features'])): ?>
            <?php foreach($data['features'] as $feature): ?>
                <div class="feature-card">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">
                        <?php echo trim($feature); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: var(--text-muted);">
                Đang cập nhật các tính năng nổi bật...
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($data['featured_products'])): ?>
    <div class="featured-products-section mt-5 pt-4 border-top">
        <h3 class="text-center mb-4 text-uppercase fw-bold text-primary">Giáo trình Tiêu biểu</h3>
        <div class="row">
            <?php foreach ($data['featured_products'] as $item): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo BASE_URL; ?>/assets/img/products/<?php echo $item['item_image']; ?>" 
                             class="card-img-top p-2" 
                             alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                             style="height: 250px; object-fit: contain;">
                        
                        <div class="card-body d-flex flex-column text-center">
                            <h6 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($item['item_name']); ?></h6>
                            <p class="card-text text-danger fw-bold fs-5 mb-3"><?php echo number_format($item['price']); ?>đ</p>
                            
                            <div class="mt-auto">
                                <a href="<?php echo BASE_URL; ?>product/detail?id=<?php echo $item['item_id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="cta-card">
        <a href="<?php echo BASE_URL; ?>home" class="btn-primary">Quay Về Trang Chủ</a>
    </div>

</div>

<?php require_once '../views/public/layouts/footer.php'; ?>