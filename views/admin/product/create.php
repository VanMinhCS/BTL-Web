<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Thêm Sản Phẩm Mới</h4>
                <p class="text-muted font-14 mb-4">Vui lòng điền đầy đủ thông tin bên dưới để thêm một sản phẩm mới vào hệ thống.</p>
                
                <form action="<?php echo BASE_URL; ?>admin/product/store" method="POST" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_name" class="col-form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="item_name" id="item_name" placeholder="Nhập tên sản phẩm" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cost_price" class="col-form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="cost_price" id="cost_price" placeholder="VD: 60000" required>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price" class="col-form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="price" id="price" placeholder="VD: 75000" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="item_stock" class="col-form-label">Số lượng nhập kho <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="item_stock" id="item_stock" placeholder="VD: 100" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-form-label">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="item_image" id="item_image" accept="image/*" required>
                                <span class="input-group-text">Upload File</span>
                            </div>
                            <small class="form-text text-muted" style="margin-top: -10px; display: block; margin-bottom: 15px;">Hỗ trợ định dạng: .jpg, .png. Nên chọn ảnh có tỉ lệ đứng (Ví dụ: 3x4).</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Mô tả chi tiết</label>
                                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Nhập tóm tắt nội dung sản phẩm..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary pe-4 ps-4"><i class="ti-save"></i> Lưu sản phẩm</button>
                        <a href="<?php echo BASE_URL; ?>admin/product" class="btn btn-secondary pe-4 ps-4 ms-2">Hủy bỏ</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>