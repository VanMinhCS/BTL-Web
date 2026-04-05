<?php require_once '../views/public/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row text-center mb-5">
        <h2 class="fw-bold">Liên hệ với chúng tôi</h2>
        <p class="text-muted">Hãy để lại lời nhắn, chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
    </div>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="card bg-primary text-white border-0 shadow h-100 p-4">
                <h4 class="fw-bold mb-4">Thông tin liên lạc</h4>
                <p class="mb-3">
                    <strong>📍 Trụ sở chính:</strong><br>
                    268 Lý Thường Kiệt, Phường Diên Hồng, TP.Hồ Chí Minh
                </p>
                <p class="mb-3">
                    <strong>📞 Đường dây nóng:</strong><br>
                    1900 8198
                </p>
                <p class="mb-4">
                    <strong>✉️ Hỗ trợ khách hàng:</strong><br>
                    bk88@hcmut.edu.vn
                </p>
                <hr class="border-light">
                <p class="small mt-3">Giờ làm việc: Thứ 2 - Thứ 6 (8:00 - 17:30)</p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 h-100">
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

                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Gửi Tin Nhắn 📧</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/public/layouts/footer.php'; ?>