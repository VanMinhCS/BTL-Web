<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách liên hệ</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Chủ đề</th>
                        <th>Nội dung</th>
                        <th style="width: 150px;">Trạng thái & Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['contacts']) && is_array($data['contacts'])): ?>
                        <?php foreach($data['contacts'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['customer_name']) ?></td>
                            <td><?= htmlspecialchars($item['customer_email']) ?></td>
                            <td><?= htmlspecialchars($item['subject']) ?></td>
                            <td><?= nl2br(htmlspecialchars($item['message'])) ?></td>
                            <td class="text-center">
                                <?php if($item['status'] == 0): ?>
                                    <span class="badge badge-danger d-block mb-2">Chưa đọc</span>
                                    <a href="<?= BASE_URL ?>admin/contact/read?id=<?= $item['contact_id'] ?>" class="btn btn-sm btn-info">Đánh dấu đã đọc</a>
                                <?php else: ?>
                                    <span class="badge badge-success">Đã đọc</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Không có dữ liệu liên hệ nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>