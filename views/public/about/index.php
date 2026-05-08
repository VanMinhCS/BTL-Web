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

    <div class="cta-card">
        <a href="<?php echo BASE_URL; ?>home" class="btn-primary">Quay Về Trang Chủ</a>
    </div>

</div>

<?php require_once '../views/public/layouts/footer.php'; ?>