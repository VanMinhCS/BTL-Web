<div class="container py-5">
    <div class="row text-center mb-5">
        <h2 class="fw-bold">Liên hệ với chúng tôi</h2>
        <p class="text-muted">Hãy để lại lời nhắn, chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
    </div>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card bg-primary text-white border-0 shadow h-100 p-4">
                <h4 class="fw-bold mb-4">Thông tin liên lạc</h4>
                <?php
                $contactFields = $contactFields ?? ($data['contactFields'] ?? []);
                ?>
                <?php if (!empty($contactFields) && is_array($contactFields)): ?>
                    <?php foreach ($contactFields as $field): ?>
                        <?php
                        $icon = trim($field['icon'] ?? '');
                        $label = $field['label'] ?? '';
                        $labelText = $icon !== '' ? $icon . ' ' . $label : $label;
                        ?>
                        <p class="mb-3">
                            <strong><?= htmlspecialchars($labelText) ?>:</strong><br>
                            <?= nl2br(htmlspecialchars($field['value'] ?? '')) ?>
                        </p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mb-3">
                        <strong>Thông tin:</strong><br>
                        Đang cập nhật.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Tin nhắn đã được gửi đi!</strong> Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>contact/submit" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="customer_name" placeholder="VD: Nguyễn Văn A" required>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">Địa chỉ Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="customer_email" placeholder="email@domain.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiêu đề</label>
                        <input type="text" class="form-control" name="subject" placeholder="Bạn cần hỗ trợ về vấn đề gì?">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nội dung chi tiết <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message" rows="5" placeholder="Nhập nội dung tin nhắn..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold d-flex align-items-center gap-2">
                        Gửi Tin Nhắn
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-arrow-up-fill" viewBox="0 0 16 16">
                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zm.192 8.159 6.57-4.027L8 9.586l1.239-.757.367.225A4.49 4.49 0 0 0 8 12.5c0 .526.09 1.03.256 1.5H2a2 2 0 0 1-1.808-1.144M16 4.697v4.974A4.5 4.5 0 0 0 12.5 8a4.5 4.5 0 0 0-1.965.45l-.338-.207z"/>
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.354-5.354 1.25 1.25a.5.5 0 0 1-.708.708L13 12.207V14a.5.5 0 0 1-1 0v-1.717l-.28.305a.5.5 0 0 1-.737-.676l1.149-1.25a.5.5 0 0 1 .722-.016"/>
                        </svg>
                    </button>                      
                    
                </form>
            </div>
        </div>
    </div>
</div>