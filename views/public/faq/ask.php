<?php require_once '../views/public/layouts/header.php'; ?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/public/faq.css">

<div class="faq-wrapper">
    <h2 class="page-title">Khu Vực Thành Viên</h2>

    <div class="member-grid">
        
        <div class="glass-card">
            <h3>Lịch Sử Câu Hỏi</h3>
            <?php if(!empty($data['my_faqs'])): foreach($data['my_faqs'] as $myQ): ?>
                <div class="history-item">
                    <div class="history-q"><?php echo $myQ['question']; ?></div>
                    <div>
                        <?php if (empty($myQ['answer'])): ?>
                            <span class="badge badge-pending">Đang chờ xử lý</span>
                        <?php else: ?>
                            <span class="badge badge-answered">Đã có phản hồi</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($myQ['answer'])): ?>
                        <div class="history-a">
                            <strong>Admin:</strong> <?php echo $myQ['answer']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; else: ?>
                <p style="font-size: 13px; color: #64748b;">Bạn chưa gửi câu hỏi nào.</p>
            <?php endif; ?>
        </div>

        <div class="glass-card">
            <h3>Gửi Thắc Mắc Mới</h3>
            <form action="<?php echo BASE_URL; ?>faq/submit_faq" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Chọn chủ đề:</label>
                    <select name="category" class="form-input" required>
                        <option value="Kỹ thuật">Lỗi kỹ thuật</option>
                        <option value="Tài khoản">Tài khoản</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Chi tiết vấn đề:</label>
                    <textarea name="question" class="form-input" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-action">Gửi Yêu Cầu</button>
            </form>
        </div>
        
    </div>
</div>

<?php require_once '../views/public/layouts/footer.php'; ?>