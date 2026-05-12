<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="main-content-inner">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Quản lý Câu hỏi Member</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Người hỏi</th>
                                    <th>Câu hỏi</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['all_faqs'] as $faq): ?>
                                <tr>
                                    <td><?php echo $faq['full_name']; ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($faq['question']); ?>
                                    </td>
                                    <td>
                                        <?php if (empty($faq['answer'])): ?>
                                            <span class="badge bg-warning text-dark">Chờ trả lời</span>
                                        <?php elseif ($faq['status'] == 0): ?>
                                            <span class="badge bg-secondary">Đã trả lời</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Đang Công khai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-primary btn-reply" 
                                                data-id="<?php echo $faq['id']; ?>"
                                                data-q="<?php echo $faq['question']; ?>"
                                                data-a="<?php echo $faq['answer']; ?>">
                                            <?php echo $faq['status'] == 1 ? 'Sửa câu trả lời' : 'Trả lời'; ?>
                                        </button>
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
</div>

<div class="modal fade" id="replyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Phản hồi thắc mắc</h5></div>
            <div class="modal-body">
                <p><strong>Câu hỏi:</strong> <span id="display-q"></span></p>
                <textarea id="admin-answer" class="form-control" rows="5" placeholder="Nhập câu trả lời..."></textarea>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="public-status">
                    <label class="form-check-label" for="public-status">Hiển thị công khai cho mọi người</label>
                </div>
    <input type="hidden" id="faq-id">
                <input type="hidden" id="faq-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="save-reply">Lưu phản hồi</button>
            </div>
        </div>
    </div>
</div>

<script>
    <script src="<?php echo BASE_URL; ?>assets/js/admin/faq_admin.js"></script>
</script>

<?php require_once __DIR__ . '/../layouts/header.php'; ?>