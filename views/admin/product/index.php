<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title mb-0">Danh sách giáo trình hiện có</h4>
                    <a href="<?php echo BASE_URL; ?>admin/product/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-2"></i>Thêm giáo trình mới
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên giáo trình</th>
                                <th>Giá bán</th>
                                <th>Kho hàng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item): ?>
                            <tr>
                                <td><?php echo $item['item_id']; ?></td>
                                <td>
                                    <img src="<?php echo BASE_URL; ?>assets/img/<?php echo $item['item_image']; ?>" 
                                         alt="book" style="width: 50px; height: 60px; object-fit: cover;"
                                         onerror="this.src='https://placehold.co/50x60?text=No+Image'">
                                </td>
                                <td class="text-start fw-bold"><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td class="text-danger fw-bold"><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫</td>
                                <td>
                                    <?php if ($item['item_stock'] > 0): ?>
                                        <span class="badge bg-success"><?php echo $item['item_stock']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hết hàng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <ul class="d-flex justify-content-center">
                                        <li class="me-3">
                                            <a href="<?php echo BASE_URL; ?>admin/product/edit?id=<?php echo $item['item_id']; ?>" class="text-secondary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete(<?php echo $item['item_id']; ?>)">
                                                <i class="ti-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa giáo trình này không?')) {
        window.location.href = '<?php echo BASE_URL; ?>admin/product/delete?id=' + id;
    }
}
</script>