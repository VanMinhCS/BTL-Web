<div class="card shadow mb-4">
	<div class="card-header py-3 d-flex align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Chi tiết liên hệ</h6>
		<a href="<?= BASE_URL ?>admin/contact?page=<?= (int)($data['page'] ?? 1) ?>" class="btn btn-sm btn-primary fw-bold">Quay lại</a>
	</div>
	<div class="card-body">
		<?php if (!empty($data['contact'])): ?>
			<div class="card border-0 shadow-sm p-4">
				<form>
					<div class="row mb-3">
						<div class="col-md-6">
							<label class="form-label fw-semibold">Họ và tên</label>
							<input type="text" class="form-control" value="<?= htmlspecialchars($data['contact']['customer_name'] ?? '') ?>" readonly>
						</div>
						<div class="mb-3 col-md-6">
							<label class="form-label fw-semibold">Địa chỉ Email</label>
							<input type="email" class="form-control" value="<?= htmlspecialchars($data['contact']['customer_email'] ?? '') ?>" readonly>
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label fw-semibold">Tiêu đề</label>
						<input type="text" class="form-control" value="<?= htmlspecialchars($data['contact']['subject'] ?? '') ?>" readonly>
					</div>

					<div class="mb-4">
						<label class="form-label fw-semibold">Nội dung chi tiết</label>
						<textarea class="form-control" rows="6" readonly><?= htmlspecialchars($data['contact']['message'] ?? '') ?></textarea>
					</div>

					<!-- <div class="d-flex justify-content-end">
						<a href="<?= BASE_URL ?>admin/contact?page=<?= (int)($data['page'] ?? 1) ?>" class="btn btn-secondary px-4">Quay lại</a>
					</div> -->
				</form>
			</div>
		<?php else: ?>
			<div class="alert alert-warning">Không tìm thấy liên hệ.</div>
		<?php endif; ?>
	</div>
</div>
