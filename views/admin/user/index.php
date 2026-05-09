<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="main-content-inner">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Quản lý Thành viên</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Họ và Tên</th>
                                    <th>Email</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['users'] as $user): ?>
                                <tr>
                                    <td><?php echo $user['user_id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars(trim($user['full_name'] ?? '') !== '' ? $user['full_name'] : 'Chưa cập nhật'); ?></strong></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    
                                    <td>
                                        <?php if ($user['is_banned'] == 1): ?>
                                            <span class="badge bg-danger">Đã khóa</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($user['is_banned'] == 1): ?>
                                            <button class="btn btn-xs btn-success btn-ban" data-id="<?php echo $user['user_id']; ?>" data-status="0">
                                                Mở khóa
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-xs btn-danger btn-ban" data-id="<?php echo $user['user_id']; ?>" data-status="1">
                                                Khóa tài khoản
                                            </button>
                                        <?php endif; ?>
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
<?php require_once __DIR__ . '/ban.html'; ?>
<script>
    const APP_BASE_URL = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>assets/js/admin/ban.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>