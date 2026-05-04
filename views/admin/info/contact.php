<?php
$fields = $data['fields'] ?? [];
$editField = $data['editField'] ?? null;
$isEditing = !empty($editField);
$pageTitle = $data['pageTitle'] ?? 'Thiết lập thông tin liên hệ ở trang Contact';
$pageDesc = $data['pageDesc'] ?? '';
$formAction = $data['formAction'] ?? (BASE_URL . 'admin/info/saveContact');
$editBaseUrl = $data['editBaseUrl'] ?? (BASE_URL . 'admin/info/contact');
$deleteBaseUrl = $data['deleteBaseUrl'] ?? (BASE_URL . 'admin/info/deleteContact');
$cancelUrl = $data['cancelUrl'] ?? $editBaseUrl;
?>

<div class="card shadow mb-4">
	<div class="card-header py-3 d-flex align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary"><?= htmlspecialchars($pageTitle) ?></h6>
		<span class="text-muted"><?= htmlspecialchars($pageDesc) ?></span>
	</div>
	<div class="card-body">
		<?php if (isset($_GET['error']) && $_GET['error'] === 'missing'): ?>
			<div class="alert alert-warning">Vui lòng nhập đầy đủ Tiêu đề và Nội dung.</div>
		<?php endif; ?>

		<div class="alert d-none" role="alert" data-info-alert></div>

		<form method="POST" action="<?= $formAction ?>" class="mb-4" data-contact-form>
			<input type="hidden" name="id" data-contact-id value="<?= (int)($editField['id'] ?? 0) ?>">

			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Tiêu đề</label>
					<input type="text" name="label" class="form-control" data-contact-label value="<?= htmlspecialchars($editField['label'] ?? '') ?>" required>
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Icon (tùy chọn)</label>
					<input type="text" name="icon" class="form-control" data-contact-icon placeholder="VD: 📍 hoac icon-class" value="<?= htmlspecialchars($editField['icon'] ?? '') ?>">
				</div>
			</div>

			<div class="mb-3">
				<label class="form-label fw-semibold">Nội dung</label>
				<textarea name="value" class="form-control" rows="3" data-contact-value required><?= htmlspecialchars($editField['value'] ?? '') ?></textarea>
			</div>

			<div class="row">
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Thứ tự</label>
					<input type="number" name="sort_order" class="form-control" data-contact-sort-order value="<?= htmlspecialchars($editField['sort_order'] ?? 0) ?>">
				</div>
				<div class="col-md-4 mb-3 d-flex align-items-end">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="isActive" name="is_active" data-contact-active <?= (!isset($editField['is_active']) || (int)$editField['is_active'] === 1) ? 'checked' : '' ?>>
						<label class="form-check-label" for="isActive">Hiển thị?</label>
					</div>
				</div>
				<div class="col-md-4 mb-3 d-flex align-items-end justify-content-end gap-2">
					<button type="submit" class="btn btn-primary" data-contact-submit><?= $isEditing ? 'Cập nhật' : 'Thêm mới' ?></button>
					<a href="<?= $cancelUrl ?>" class="btn btn-outline-secondary <?= $isEditing ? '' : 'd-none' ?>" data-contact-cancel>Hủy</a>
				</div>
			</div>
		</form>

		<div class="table-responsive d-flex justify-content-center">
			<table class="table table-bordered text-center" style="width: 100%;">
				<thead>
					<tr>
						<th style="width: 60px;">#</th>
						<th>Tiêu đề</th>
						<th>Nội dung</th>
						<th style="width: 120px;">Icon</th>
						<th style="width: 100px;">Thứ tự</th>
						<th style="width: 120px;">Trạng thái</th>
						<th style="width: 160px;">Hành động</th>
					</tr>
				</thead>
				<tbody data-contact-table data-edit-base="<?= $editBaseUrl ?>?id=" data-delete-base="<?= $deleteBaseUrl ?>?id=">
					<?php if (!empty($fields)): ?>
						<?php foreach ($fields as $index => $field): ?>
							<tr data-contact-id="<?= (int)$field['id'] ?>"
								data-contact-label="<?= htmlspecialchars($field['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-contact-value="<?= htmlspecialchars($field['value'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-contact-icon="<?= htmlspecialchars($field['icon'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
								data-contact-sort-order="<?= htmlspecialchars($field['sort_order'] ?? 0, ENT_QUOTES, 'UTF-8'); ?>"
								data-contact-active="<?= (int)($field['is_active'] ?? 0) ?>">
								<td><?= $index + 1 ?></td>
								<td><?= htmlspecialchars($field['label'] ?? '') ?></td>
								<td><?= nl2br(htmlspecialchars($field['value'] ?? '')) ?></td>
								<td><?= htmlspecialchars($field['icon'] ?? '') ?></td>
								<td><?= htmlspecialchars($field['sort_order'] ?? 0) ?></td>
								<td class="text-center">
									<?php if ((int)($field['is_active'] ?? 0) === 1): ?>
										<span class="badge badge-success" style="background-color: #28a745; color: #ffffff;">Hiện</span>
									<?php else: ?>
										<span class="badge badge-secondary" style="background-color: #6c757d; color: #ffffff;">Ẩn</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<div class="d-flex gap-2 justify-content-center">
										<a href="<?= $editBaseUrl ?>?id=<?= (int)$field['id'] ?>" class="btn btn-sm btn-info" data-action="edit-contact">Sửa</a>
										<a href="<?= $deleteBaseUrl ?>?id=<?= (int)$field['id'] ?>" class="btn btn-sm btn-danger" data-action="delete-contact">Xóa</a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="7" class="text-center">Chưa có thông tin nào...</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
