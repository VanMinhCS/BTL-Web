<div class="card shadow mb-4">
    <div class="card-body" id="contactsTableWrapper">
        <h6 class="header-title">Danh sách liên hệ</h6>
        
        <?php
        $pagination = $data['pagination'] ?? ['page' => 1, 'totalPages' => 1];
        $page = (int)($pagination['page'] ?? 1);
        $totalPages = (int)($pagination['totalPages'] ?? 1);
        $filters = $data['filters'] ?? ['status' => 'all', 'sort' => 'newest'];
        $statusFilter = $filters['status'] ?? 'all';
        $sortOrder = $filters['sort'] ?? 'newest';
        $querySuffix = 'status=' . urlencode($statusFilter) . '&sort=' . urlencode($sortOrder);
        $keyword = htmlspecialchars($data['keyword'] ?? '');
        ?>

        <form method="GET" action="<?= BASE_URL ?>admin/contact" class="mb-3">
            <div class="input-group">
                <input type="text" 
                    name="q" 
                    class="form-control" 
                    placeholder="Tìm theo tên, email, chủ đề, nội dung..."
                    value="<?= $keyword ?>">
                <?php if ($keyword !== ''): ?>
                    <a href="<?= BASE_URL ?>admin/contact" class="btn btn-outline-secondary">✕</a>
                <?php endif; ?>
                <button class="btn btn-primary" type="submit">Tìm</button>
            </div>
            <?php if ($keyword !== ''): ?>
                <small class="text-muted mt-1 d-block">
                    Kết quả tìm kiếm cho: <strong>"<?= $keyword ?>"</strong> 
                    (<?= $pagination['total'] ?> kết quả)
                </small>
            <?php endif; ?>
        </form>

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <label for="statusFilter" class="mb-0">Lọc:</label>
                    <select id="statusFilter" class="form-select form-select-sm" style="min-width: 140px;">
                        <option value="all" <?php echo ($statusFilter === 'all') ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="unread" <?php echo ($statusFilter === 'unread') ? 'selected' : ''; ?>>Chưa đọc</option>
                        <option value="read" <?php echo ($statusFilter === 'read') ? 'selected' : ''; ?>>Đã đọc</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2 flex-nowrap">
                    <label for="sortOrder" class="mb-0 text-nowrap">Sắp xếp:</label>
                    <select id="sortOrder" class="form-select form-select-sm" style="min-width: 140px;">
                        <option value="newest" <?php echo ($sortOrder === 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="oldest" <?php echo ($sortOrder === 'oldest') ? 'selected' : ''; ?>>Cũ nhất</option>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" id="toggleSelectBtn" class="btn btn-sm btn-outline-primary">Chọn</button>
                <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger bulk-delete-btn">Xóa</button>
            </div>
        </div>

        <form id="bulkDeleteForm" method="POST" action="<?= BASE_URL ?>admin/contact/bulkDelete?page=<?= $page ?>&<?= $querySuffix ?>">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Chủ đề</th>
                        <th>Nội dung</th>
                        <th style="width: 180px;" class="text-center">
                            <span class="actions-label">Hành động</span>
                            <div class="select-label">
                                <input type="checkbox" class="form-check-input" id="selectAll" aria-label="Chọn tất cả">
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['contacts']) && is_array($data['contacts'])): ?>
                        <?php foreach($data['contacts'] as $item): ?>
                        <tr data-status="<?= (int)$item['status'] ?>" data-created="<?= htmlspecialchars($item['created_at'] ?? '') ?>"<?php echo ($item['status'] == 0) ? ' style="background-color: #E8F4FF; font-weight: 600;"' : ''; ?>>
                            <td><?= htmlspecialchars($item['customer_name']) ?></td>
                            <td><?= htmlspecialchars($item['customer_email']) ?></td>
                            <td><?= htmlspecialchars($item['subject']) ?></td>
                            <td><?= nl2br(htmlspecialchars($item['message'])) ?></td>
                            <td class="text-center">
                                <div class="row-actions">
                                    <?php if($item['status'] == 0): ?>
                                        <a href="<?= BASE_URL ?>admin/contact/read?id=<?= $item['contact_id'] ?>&page=<?= $page ?>&<?= $querySuffix ?>" class="btn btn-sm btn-info mb-2 js-mark-read" data-id="<?= $item['contact_id'] ?>">Đánh dấu đã đọc</a>
                                    <?php endif; ?>

                                    <div class="d-flex justify-content-center gap-2 mt-2">
                                        <a href="<?= BASE_URL ?>admin/contact/detail?id=<?= $item['contact_id'] ?>&page=<?= $page ?>&<?= $querySuffix ?>" class="btn btn-sm btn-secondary">Xem</a>
                                        <a href="<?= BASE_URL ?>admin/contact/delete?id=<?= $item['contact_id'] ?>&page=<?= $page ?>&<?= $querySuffix ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa liên hệ này?');">Xóa</a>
                                    </div>
                                </div>

                                <div class="row-select">
                                    <input type="checkbox" class="form-check-input row-checkbox" name="ids[]" value="<?= $item['contact_id'] ?>" aria-label="Chọn liên hệ">
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Không có dữ liệu liên hệ nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($totalPages > 1): ?>
                <nav aria-label="Contacts pagination">
                    <ul class="pagination justify-content-center mt-3">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?= BASE_URL ?>admin/contact?page=<?= max(1, $page - 1) ?>&<?= $querySuffix ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?= BASE_URL ?>admin/contact?page=<?= $i ?>&<?= $querySuffix ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?= BASE_URL ?>admin/contact?page=<?= min($totalPages, $page + 1) ?>&<?= $querySuffix ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            </form>
        </div>

    </div>
</div>