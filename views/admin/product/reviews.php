<?php
/**
 * @var array $product
 * @var array $reviews
 */
?>
<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="header-title mb-0">
                        Đánh giá sản phẩm: <span class="text-primary"><?php echo htmlspecialchars($product['item_name']); ?></span>
                    </h4>
                    <a href="<?php echo BASE_URL; ?>admin/product" class="btn btn-secondary btn-sm">
                        <i class="ti-arrow-left"></i> Quay lại
                    </a>
                </div>

                <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thành công!</strong> Đã xóa bình luận.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>STT</th>
                                <th>Khách hàng</th>
                                <th>Số sao</th>
                                <th class="text-start">Nội dung bình luận</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reviews)): ?>
                                <tr>
                                    <td colspan="6" class="text-muted py-4">Sản phẩm này chưa có bài đánh giá nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php $stt = 1; foreach ($reviews as $review): ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td class="fw-bold"><?php echo htmlspecialchars($review['firstname'] . ' ' . $review['lastname']); ?></td>
                                        <td>
                                            <span class="fw-bold"><?php echo $review['rating']; ?></span> <span style="color: gold;">★</span>
                                        </td>
                                        <td class="text-start" style="max-width: 300px; white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-danger" 
                                               onclick="confirmDeleteReview(<?php echo $review['id']; ?>, <?php echo $product['item_id']; ?>)">
                                                <i class="ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteReview(reviewId, productId) {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này không? Hành động này không thể hoàn tác.')) {
        window.location.href = '<?php echo BASE_URL; ?>admin/product/deleteReview?id=' + reviewId + '&product_id=' + productId;
    }
}
</script>