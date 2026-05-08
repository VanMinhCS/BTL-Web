<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="main-content-inner">
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="header-title">Cập nhật trang Giới Thiệu (About)</h4>
            <form action="<?php echo BASE_URL; ?>admin/about/update" method="POST">
                <div class="form-group">
                    <label>Tiêu đề trang</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $data['about']['title']; ?>">
                </div>
                <div class="form-group">
                    <label>Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="6"><?php echo $data['about']['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Các tính năng (Ngăn cách bằng dấu phẩy)</label>
                    <input type="text" name="features" class="form-control" value="<?php echo $data['about']['features']; ?>">
                    <small class="text-muted">Ví dụ: Bảo mật cao, Giao diện đẹp, Hỗ trợ 24/7</small>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>