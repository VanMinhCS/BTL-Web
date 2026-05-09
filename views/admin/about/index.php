<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="main-content-inner">
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="header-title">Cập nhật trang Giới Thiệu (About)</h4>
            <form action="<?php echo BASE_URL; ?>admin/about/update" method="POST">
                <div class="form-group">
                    <label>Tiêu đề trang</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($data['about']['title']); ?>">
                </div>
                
                <div class="form-group">
                    <label>Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="6"><?php echo htmlspecialchars($data['about']['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Các tính năng (Ngăn cách bằng dấu phẩy)</label>
                    <input type="text" name="features" class="form-control" value="<?php echo htmlspecialchars($data['about']['features']); ?>">
                    <small class="text-muted">Ví dụ: Bảo mật cao, Giao diện đẹp, Hỗ trợ 24/7</small>
                </div>

                <div class="form-group mt-4">
                    <label class="font-weight-bold text-primary">Kéo thả chọn Sản phẩm nổi bật (Hiển thị ở trang Giới thiệu)</label>
                    <div class="border p-3 rounded bg-light" style="max-height: 250px; overflow-y: auto;">
                        <?php 
                        // Chuyển chuỗi "1,3,5" từ DB thành mảng để check xem cái nào đã được chọn
                        $selected_items = [];
                        if (!empty($data['about']['featured_items'])) {
                            $selected_items = explode(',', $data['about']['featured_items']);
                        }
                        
                        // Lặp qua toàn bộ sản phẩm để in ra checkbox
                        if (isset($data['all_items']) && !empty($data['all_items'])):
                            foreach ($data['all_items'] as $item): 
                                $isChecked = in_array($item['item_id'], $selected_items) ? 'checked' : '';
                        ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="featured_items[]" 
                                       value="<?php echo $item['item_id']; ?>" 
                                       id="item_<?php echo $item['item_id']; ?>" <?php echo $isChecked; ?>>
                                <label class="form-check-label" style="cursor: pointer;" for="item_<?php echo $item['item_id']; ?>">
                                    <strong><?php echo htmlspecialchars($item['item_name']); ?></strong> 
                                    <span class="text-danger ml-2">(<?php echo number_format($item['price']); ?>đ)</span>
                                    <span class="text-muted ml-2">- Tồn kho: <?php echo $item['item_stock']; ?></span>
                                </label>
                            </div>
                        <?php 
                            endforeach; 
                        else:
                        ?>
                            <p class="text-muted mb-0">Chưa có sản phẩm nào trong hệ thống.</p>
                        <?php endif; ?>
                    </div>
                    <small class="text-muted">Bạn có thể tích chọn nhiều giáo trình để làm nổi bật.</small>
                </div>

                <button type="submit" class="btn btn-primary mt-3 px-5">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>