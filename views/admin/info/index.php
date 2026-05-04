<?php
$sections = $data['sections'] ?? [];
$quotes = $data['quotes'] ?? [];
$reasons = $data['reasons'] ?? [];
$featuredProducts = $data['featuredProducts'] ?? [];
$products = $data['products'] ?? [];

$editQuote = $data['editQuote'] ?? null;
$editReason = $data['editReason'] ?? null;
$editProduct = $data['editProduct'] ?? null;

$isEditingQuote = !empty($editQuote);
$isEditingReason = !empty($editReason);
$isEditingProduct = !empty($editProduct);

$sectionAction = BASE_URL . 'admin/info/saveSection';
$quoteAction = BASE_URL . 'admin/info/saveQuote';
$quoteDeleteBase = BASE_URL . 'admin/info/deleteQuote';
$reasonAction = BASE_URL . 'admin/info/saveReason';
$reasonDeleteBase = BASE_URL . 'admin/info/deleteReason';
$productAction = BASE_URL . 'admin/info/saveProduct';
$productDeleteBase = BASE_URL . 'admin/info/deleteProduct';

$quoteSection = $sections['quote'] ?? ['is_active' => 1, 'title' => '', 'subtitle' => ''];
$reasonSection = $sections['reason'] ?? ['is_active' => 1, 'title' => '', 'subtitle' => ''];
$productSection = $sections['product'] ?? ['is_active' => 1, 'title' => '', 'subtitle' => ''];
?>

<style>
	.home-section-toggle {
		background: none;
		border: none;
		padding: 0;
	}
	.home-section-toggle .collapse-icon {
		transition: transform 0.2s ease;
	}
	.home-section-toggle[aria-expanded="true"] .collapse-icon {
		transform: rotate(180deg);
	}
	.home-section-subtitle {
		font-size: 0.85rem;
	}
</style>

<?php if (isset($_GET['error'])): ?>
	<?php if ($_GET['error'] === 'missing'): ?>
		<div class="alert alert-warning">Vui lòng nhập đầy đủ thông tin bắt buộc.</div>
	<?php elseif ($_GET['error'] === 'invalid_image'): ?>
		<div class="alert alert-warning">Ảnh không hợp lệ. Vui lòng chọn file JPG, PNG, GIF hoặc WEBP.</div>
	<?php elseif ($_GET['error'] === 'upload'): ?>
		<div class="alert alert-warning">Tải ảnh lên thất bại. Vui lòng thử lại.</div>
	<?php endif; ?>
<?php endif; ?>

<div class="alert d-none" role="alert" data-info-alert></div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<button class="home-section-toggle d-flex align-items-center justify-content-between w-100" type="button"
				data-bs-toggle="collapse" data-bs-target="#homeQuoteSection" aria-expanded="true" aria-controls="homeQuoteSection">
			<div class="text-start">
				<h6 class="m-0 font-weight-bold text-primary">Thiết lập Quote</h6>
				<span class="text-muted home-section-subtitle">Bật/tắt và quản lý danh sách trích dẫn</span>
			</div>
			<i class="fa-solid fa-chevron-down collapse-icon"></i>
		</button>
	</div>
	<div id="homeQuoteSection" class="collapse show">
		<div class="card-body">
		<form method="POST" action="<?= $sectionAction ?>" class="mb-4" data-section-form="quote">
			<input type="hidden" name="section_key" value="quote">
			<input type="hidden" name="title" value="<?= htmlspecialchars($quoteSection['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
			<input type="hidden" name="subtitle" value="<?= htmlspecialchars($quoteSection['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="quoteActive" name="is_active" <?= (!isset($quoteSection['is_active']) || (int)$quoteSection['is_active'] === 1) ? 'checked' : '' ?>>
					<label class="form-check-label" for="quoteActive">Hiển thị Quote</label>
				</div>
				<button type="submit" class="btn btn-primary">Lưu trạng thái</button>
			</div>
		</form>

		<form method="POST" action="<?= $quoteAction ?>" class="mb-4" enctype="multipart/form-data" data-quote-form>
			<input type="hidden" name="id" data-quote-id value="<?= (int)($editQuote['id'] ?? 0) ?>">
			<div class="mb-3">
				<label class="form-label fw-semibold">Nội dung trích dẫn</label>
				<textarea name="quote_text" class="form-control" rows="3" data-quote-text required><?= htmlspecialchars($editQuote['quote_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Tác giả</label>
					<input type="text" name="author" class="form-control" data-quote-author value="<?= htmlspecialchars($editQuote['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Ảnh nền (chọn từ máy)</label>
					<input type="file" name="image" class="form-control" data-quote-image accept="image/*">
					<div class="text-muted mt-1 <?= ($isEditingQuote && !empty($editQuote['image'])) ? '' : 'd-none' ?>" data-quote-current-image>
						<?php if ($isEditingQuote && !empty($editQuote['image'])): ?>
							Ảnh hiện tại: <?= htmlspecialchars($editQuote['image'], ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Thứ tự</label>
					<input type="number" name="sort_order" class="form-control" data-quote-sort-order value="<?= htmlspecialchars($editQuote['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
				</div>
				<div class="col-md-4 mb-3 d-flex align-items-end">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="quoteItemActive" name="is_active" data-quote-active <?= (!isset($editQuote['is_active']) || (int)$editQuote['is_active'] === 1) ? 'checked' : '' ?>>
						<label class="form-check-label" for="quoteItemActive">Hiển thị?</label>
					</div>
				</div>
				<div class="col-md-4 mb-3 d-flex align-items-end justify-content-end gap-2">
					<button type="submit" class="btn btn-primary" data-quote-submit><?= $isEditingQuote ? 'Cập nhật' : 'Thêm mới' ?></button>
					<a href="<?= BASE_URL ?>admin/info" class="btn btn-outline-secondary <?= $isEditingQuote ? '' : 'd-none' ?>" data-quote-cancel>Hủy</a>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th style="width: 60px;">#</th>
						<th>Nội dung</th>
						<th>Tác giả</th>
						<th>Ảnh</th>
						<th style="width: 100px;">Thứ tự</th>
						<th style="width: 120px;">Trạng thái</th>
						<th style="width: 160px;">Hành động</th>
					</tr>
				</thead>
				<tbody data-quote-table data-edit-base="<?= BASE_URL ?>admin/info?quote_id=" data-delete-base="<?= $quoteDeleteBase ?>?id=">
					<?php if (!empty($quotes)): ?>
						<?php foreach ($quotes as $index => $quote): ?>
							<tr data-quote-id="<?= (int)$quote['id'] ?>"
								data-quote-text="<?= htmlspecialchars($quote['quote_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-quote-author="<?= htmlspecialchars($quote['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-quote-image="<?= htmlspecialchars($quote['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-quote-sort-order="<?= htmlspecialchars($quote['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
								data-quote-active="<?= (int)($quote['is_active'] ?? 0) ?>">
								<td><?= $index + 1 ?></td>
								<td><?= htmlspecialchars($quote['quote_text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($quote['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($quote['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($quote['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<?php if ((int)($quote['is_active'] ?? 0) === 1): ?>
										<span class="badge badge-success" style="background-color: #28a745; color: #ffffff;">Hiện</span>
									<?php else: ?>
										<span class="badge badge-secondary" style="background-color: #6c757d; color: #ffffff;">Ẩn</span>
									<?php endif; ?>
								</td>
								<td>
									<div class="d-flex gap-2 justify-content-center">
										<a href="<?= BASE_URL ?>admin/info?quote_id=<?= (int)$quote['id'] ?>" class="btn btn-sm btn-info" data-action="edit-quote">Sửa</a>
										<a href="<?= $quoteDeleteBase ?>?id=<?= (int)$quote['id'] ?>" class="btn btn-sm btn-danger" data-action="delete-quote">Xóa</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="7" class="text-center">Chưa có trích dẫn nào...</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<button class="home-section-toggle d-flex align-items-center justify-content-between w-100" type="button"
				data-bs-toggle="collapse" data-bs-target="#homeReasonSection" aria-expanded="true" aria-controls="homeReasonSection">
			<div class="text-start">
				<h6 class="m-0 font-weight-bold text-primary">Thiết lập Lý do (Reason)</h6>
				<span class="text-muted home-section-subtitle">Đổi tiêu đề và danh sách lý do</span>
			</div>
			<i class="fa-solid fa-chevron-down collapse-icon"></i>
		</button>
	</div>
	<div id="homeReasonSection" class="collapse show">
		<div class="card-body">
		<form method="POST" action="<?= $sectionAction ?>" class="mb-4" data-section-form="reason">
			<input type="hidden" name="section_key" value="reason">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Tiêu đề</label>
					<input type="text" name="title" class="form-control" value="<?= htmlspecialchars($reasonSection['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Phụ đề</label>
					<input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($reasonSection['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
				</div>
			</div>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="reasonActive" name="is_active" <?= (!isset($reasonSection['is_active']) || (int)$reasonSection['is_active'] === 1) ? 'checked' : '' ?>>
					<label class="form-check-label" for="reasonActive">Hiển thị Reason</label>
				</div>
				<button type="submit" class="btn btn-primary">Lưu thiết lập</button>
			</div>
		</form>

		<form method="POST" action="<?= $reasonAction ?>" class="mb-4" data-reason-form>
			<input type="hidden" name="id" data-reason-id value="<?= (int)($editReason['id'] ?? 0) ?>">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Tiêu đề lý do</label>
					<input type="text" name="title" class="form-control" data-reason-title value="<?= htmlspecialchars($editReason['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Thứ tự</label>
					<input type="number" name="sort_order" class="form-control" data-reason-sort-order value="<?= htmlspecialchars($editReason['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
				</div>
			</div>
			<div class="mb-3">
				<label class="form-label fw-semibold">Mô tả</label>
				<textarea name="description" class="form-control" rows="3" data-reason-description><?= htmlspecialchars($editReason['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3 d-flex align-items-end">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="reasonItemActive" name="is_active" data-reason-active <?= (!isset($editReason['is_active']) || (int)$editReason['is_active'] === 1) ? 'checked' : '' ?>>
						<label class="form-check-label" for="reasonItemActive">Hiển thị?</label>
					</div>
				</div>
				<div class="col-md-6 mb-3 d-flex align-items-end justify-content-end gap-2">
					<button type="submit" class="btn btn-primary" data-reason-submit><?= $isEditingReason ? 'Cập nhật' : 'Thêm mới' ?></button>
					<a href="<?= BASE_URL ?>admin/info" class="btn btn-outline-secondary <?= $isEditingReason ? '' : 'd-none' ?>" data-reason-cancel>Hủy</a>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th style="width: 60px;">#</th>
						<th>Tiêu đề</th>
						<th>Mô tả</th>
						<th style="width: 100px;">Thứ tự</th>
						<th style="width: 120px;">Trạng thái</th>
						<th style="width: 160px;">Hành động</th>
					</tr>
				</thead>
				<tbody data-reason-table data-edit-base="<?= BASE_URL ?>admin/info?reason_id=" data-delete-base="<?= $reasonDeleteBase ?>?id=">
					<?php if (!empty($reasons)): ?>
						<?php foreach ($reasons as $index => $reason): ?>
							<tr data-reason-id="<?= (int)$reason['id'] ?>"
								data-reason-title="<?= htmlspecialchars($reason['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-reason-description="<?= htmlspecialchars($reason['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-reason-sort-order="<?= htmlspecialchars($reason['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
								data-reason-active="<?= (int)($reason['is_active'] ?? 0) ?>">
								<td><?= $index + 1 ?></td>
								<td><?= htmlspecialchars($reason['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($reason['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($reason['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<?php if ((int)($reason['is_active'] ?? 0) === 1): ?>
										<span class="badge badge-success" style="background-color: #28a745; color: #ffffff;">Hiện</span>
									<?php else: ?>
										<span class="badge badge-secondary" style="background-color: #6c757d; color: #ffffff;">Ẩn</span>
									<?php endif; ?>
								</td>
								<td>
									<div class="d-flex gap-2 justify-content-center">
										<a href="<?= BASE_URL ?>admin/info?reason_id=<?= (int)$reason['id'] ?>" class="btn btn-sm btn-info" data-action="edit-reason">Sửa</a>
										<a href="<?= $reasonDeleteBase ?>?id=<?= (int)$reason['id'] ?>" class="btn btn-sm btn-danger" data-action="delete-reason">Xóa</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="6" class="text-center">Chưa có lý do nào...</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<button class="home-section-toggle d-flex align-items-center justify-content-between w-100" type="button"
				data-bs-toggle="collapse" data-bs-target="#homeProductSection" aria-expanded="true" aria-controls="homeProductSection">
			<div class="text-start">
				<h6 class="m-0 font-weight-bold text-primary">Thiết lập Sản phẩm tiêu biểu</h6>
				<span class="text-muted home-section-subtitle">Chọn sản phẩm và sắp xếp hiển thị</span>
			</div>
			<i class="fa-solid fa-chevron-down collapse-icon"></i>
		</button>
	</div>
	<div id="homeProductSection" class="collapse show">
		<div class="card-body">
		<form method="POST" action="<?= $sectionAction ?>" class="mb-4" data-section-form="product">
			<input type="hidden" name="section_key" value="product">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Tiêu đề</label>
					<input type="text" name="title" class="form-control" value="<?= htmlspecialchars($productSection['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Phụ đề</label>
					<input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($productSection['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
				</div>
			</div>
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="productActive" name="is_active" <?= (!isset($productSection['is_active']) || (int)$productSection['is_active'] === 1) ? 'checked' : '' ?>>
					<label class="form-check-label" for="productActive">Hiển thị sản phẩm tiêu biểu</label>
				</div>
				<button type="submit" class="btn btn-primary">Lưu thiết lập</button>
			</div>
		</form>

		<form method="POST" action="<?= $productAction ?>" class="mb-4" data-product-form>
			<input type="hidden" name="id" data-product-id value="<?= (int)($editProduct['id'] ?? 0) ?>">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Chọn sản phẩm</label>
					<select name="item_id" class="form-control" data-product-item required>
						<option value="">-- Chọn sản phẩm --</option>
						<?php foreach ($products as $product): ?>
							<?php $selected = ((int)($editProduct['item_id'] ?? 0) === (int)$product['item_id']) ? 'selected' : ''; ?>
							<option value="<?= (int)$product['item_id'] ?>" <?= $selected ?>><?= htmlspecialchars($product['item_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label fw-semibold">Thứ tự</label>
					<input type="number" name="sort_order" class="form-control" data-product-sort-order value="<?= htmlspecialchars($editProduct['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>">
				</div>
				<div class="col-md-3 mb-3 d-flex align-items-end">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="productItemActive" name="is_active" data-product-active <?= (!isset($editProduct['is_active']) || (int)$editProduct['is_active'] === 1) ? 'checked' : '' ?>>
						<label class="form-check-label" for="productItemActive">Hiển thị?</label>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-end gap-2">
				<button type="submit" class="btn btn-primary" data-product-submit><?= $isEditingProduct ? 'Cập nhật' : 'Thêm mới' ?></button>
				<a href="<?= BASE_URL ?>admin/info" class="btn btn-outline-secondary <?= $isEditingProduct ? '' : 'd-none' ?>" data-product-cancel>Hủy</a>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th style="width: 60px;">#</th>
						<th>Sản phẩm</th>
						<th style="width: 140px;">Giá</th>
						<th style="width: 120px;">Tồn kho</th>
						<th style="width: 100px;">Thứ tự</th>
						<th style="width: 120px;">Trạng thái</th>
						<th style="width: 160px;">Hành động</th>
					</tr>
				</thead>
				<tbody data-product-table data-edit-base="<?= BASE_URL ?>admin/info?product_id=" data-delete-base="<?= $productDeleteBase ?>?id=">
					<?php if (!empty($featuredProducts)): ?>
						<?php foreach ($featuredProducts as $index => $product): ?>
							<tr data-product-id="<?= (int)$product['id'] ?>"
								data-product-item-id="<?= (int)$product['item_id'] ?>"
								data-product-sort-order="<?= htmlspecialchars($product['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
								data-product-active="<?= (int)($product['is_active'] ?? 0) ?>">
								<td><?= $index + 1 ?></td>
								<td><?= htmlspecialchars($product['item_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>₫</td>
								<td><?= htmlspecialchars($product['item_stock'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></td>
								<td><?= htmlspecialchars($product['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<?php if ((int)($product['is_active'] ?? 0) === 1): ?>
										<span class="badge badge-success" style="background-color: #28a745; color: #ffffff;">Hiện</span>
									<?php else: ?>
										<span class="badge badge-secondary" style="background-color: #6c757d; color: #ffffff;">Ẩn</span>
									<?php endif; ?>
								</td>
								<td>
									<div class="d-flex gap-2 justify-content-center">
										<a href="<?= BASE_URL ?>admin/info?product_id=<?= (int)$product['id'] ?>" class="btn btn-sm btn-info" data-action="edit-product">Sửa</a>
										<a href="<?= $productDeleteBase ?>?id=<?= (int)$product['id'] ?>" class="btn btn-sm btn-danger" data-action="delete-product">Xóa</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="7" class="text-center">Chưa có sản phẩm tiêu biểu nào...</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
