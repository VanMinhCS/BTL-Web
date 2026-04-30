<?php 
/**
 * @var array $product
 */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Sửa Thông Tin Giáo Trình</h4>
                <p class="text-muted font-14 mb-4">Cập nhật các trường thông tin cần thiết bên dưới.</p>
                
                <form action="<?php echo BASE_URL; ?>admin/product/update?id=<?php echo $product['item_id']; ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_name" class="col-form-label">Tên giáo trình <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($product['item_name']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cost_price" class="col-form-label">Giá vốn (VNĐ) <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="cost_price" id="cost_price" value="<?php echo $product['cost_price'] ?? 0; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price" class="col-form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="price" id="price" value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_stock" class="col-form-label">Số lượng trong kho <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="item_stock" id="item_stock" value="<?php echo $product['item_stock']; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label class="col-form-label">Hình ảnh giáo trình (Bỏ trống nếu không muốn đổi)</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="item_image" id="item_image" accept="image/*">
                                <span class="input-group-text">Upload File</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-muted" style="font-size: 13px;">Ảnh hiện tại: </span>
                                <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $product['item_image']; ?>" alt="Ảnh hiện tại" style="height: 50px; border-radius: 4px; border: 1px solid #ddd;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Mô tả chi tiết</label>
                                <textarea class="form-control" name="description" id="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary pe-4 ps-4"><i class="ti-save"></i> Cập nhật</button>
                        <a href="<?php echo BASE_URL; ?>admin/product" class="btn btn-secondary pe-4 ps-4 ms-2">Hủy bỏ</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>