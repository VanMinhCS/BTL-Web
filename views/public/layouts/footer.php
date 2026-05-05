</main>

<?php
$siteLogo = $siteLogo ?? ($data['siteLogo'] ?? '');
$logoSrc = !empty($siteLogo)
    ? (BASE_URL . 'assets/img/' . $siteLogo)
    : (BASE_URL . 'assets/img/logo88.png');
?>

<footer class="main-footer pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">

            <!-- CỘT 1: LOGO + MÔ TẢ -->
            <div class="col-12 col-md-3 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <!-- Logo ảnh -->
                    <img src="<?php echo $logoSrc; ?>"
                         alt="Logo" height="50"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                    <!-- Fallback text nếu không có logo -->
                    <span class="footer-brand fw-bold fst-italic" style="display:none">BK88-logo</span>
                    <span class="footer-brand fw-bold">BK88</span>
                </div>

                <p class="footer-muted mt-3 small">
                    Website cung cấp giáo trình hàng đầu.
                </p>
            </div>

            <!-- CỘT 2: LIÊN KẾT NHANH -->
            <div class="col-12 col-md-3 mb-4">
                <h6 class="footer-heading fw-bold mb-3">LIÊN KẾT NHANH</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo BASE_URL; ?>home" class="footer-link">Trang chủ</a></li>
                    <li><a href="<?php echo BASE_URL; ?>about" class="footer-link">Giới thiệu</a></li>
                    <li><a href="<?php echo BASE_URL; ?>product" class="footer-link">Sản phẩm</a></li>
                    <li><a href="<?php echo BASE_URL; ?>news" class="footer-link">Tin tức</a></li>
                    <li><a href="<?php echo BASE_URL; ?>faq" class="footer-link">Hỏi/đáp</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact" class="footer-link">Liên hệ</a></li>
                </ul>
            </div>

            <!-- CỘT 3: NEWSLETTER + MẠNG XÃ HỘI -->
            <div class="col-12 col-md-6 mb-4">
                <h6 class="footer-heading fw-bold mb-2">NEWSLETTER</h6>
                <p class="footer-muted small">Đăng ký nhận ưu đãi và tin tức mới nhất từ chúng tôi.</p>

                <!-- Form email -->
                <div class="newsletter-form d-flex align-items-center mb-4">
                    <input type="email"
                           class="newsletter-input flex-grow-1"
                           placeholder="Nhập email của bạn">
                    <button class="newsletter-btn">→</button>
                </div>

                <!-- MẠNG XÃ HỘI (bí quá thì bỏ :)) -->
                <div class="social-icons d-flex gap-3">
                    <a href="javascript:void(0)" class="social-icon" title="Facebook">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Twitter/X">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Instagram">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="TikTok">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <hr class="footer-divider mt-2">

        <!-- BOTTOM BAR -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-2">
            <p class="footer-muted small mb-2 mb-md-0">
                © 2026 <strong class="text-white">BK-88</strong>
            </p>
            <div class="d-flex gap-2">
                <a href="<?php echo BASE_URL; ?>contact" class="footer-link small">Liên hệ</a>
                <span class="footer-muted">·</span>
                <a href="<?php echo BASE_URL; ?>about" class="footer-link small">Giới thiệu</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
<?php if (!empty($data['pageJs']) && is_array($data['pageJs'])): ?>
    <?php foreach ($data['pageJs'] as $jsPath): ?>
        <script src="<?= BASE_URL . $jsPath ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>