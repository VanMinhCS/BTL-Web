<?php require_once '../views/public/layouts/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/public/faq.css">

<div class="faq-wrapper">
    <h2 class="page-title">TRUNG TÂM GIẢI ĐÁP</h2>
    <p style="text-align: center; color: #64748b; margin-bottom: 30px;">Tổng hợp các câu hỏi đã được hệ thống kiểm duyệt.</p>

    <div class="glass-card public-faq-area">
        <?php if(!empty($data['public_faqs'])): foreach($data['public_faqs'] as $faq): ?>
            <div class="q-item">
                <div class="q-text">
                    <div>
                        <span class="category-tag"><?php echo $faq['category']; ?></span><br>
                        <?php echo $faq['question']; ?>
                    </div>
                    <span class="toggle-icon">▼</span>
                </div>
                <div class="a-text">
                    <div class="admin-reply">
                        <strong>Admin Phản Hồi:</strong><br>
                        <?php echo nl2br($faq['answer']); ?>
                    </div>
                    <?php if(!empty($faq['image'])): ?>
                        <img src="<?php echo BASE_URL; ?>assets/img/uploads/<?php echo $faq['image']; ?>" style="max-width: 100%; margin-top: 15px; border-radius: 8px;">
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; else: ?>
            <div style="text-align: center; color: #64748b; padding: 20px;">Chưa có câu hỏi nào được công khai.</div>
        <?php endif; ?>
    </div>

    <div class="public-cta">
        <h3>Bạn Cần Hỗ Trợ Riêng?</h3>
        <p>Gửi câu hỏi trực tiếp cho đội ngũ kỹ thuật của chúng tôi.</p>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?php echo BASE_URL; ?>member" class="btn-primary">Vào Khu Vực Thành Viên</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>auth/login" class="btn-primary">Đăng Nhập Để Đặt Câu Hỏi</a>
        <?php endif; ?>
    </div>

</div>

<script src="<?php echo BASE_URL; ?>assets/js/public/faq.js"></script>
<?php require_once '../views/public/layouts/footer.php'; ?>