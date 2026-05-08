<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <h4 class="header-title mb-0">Quản lý Đơn đặt hàng</h4>
                    <div class="input-group input-group-sm" style="max-width: 250px;">
                        <input type="text" id="adminSearchInput" class="form-control" placeholder="Tìm mã đơn hoặc tên khách...">
                        <button class="btn btn-dark" type="button" id="adminSearchBtn"><i class="ti-search"></i></button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>Mã Đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái hiện tại</th>
                                <th style="width: 180px;">Thao tác xử lý</th>
                            </tr>
                        </thead>
                        <tbody id="adminOrderList">
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                <?php 
                                    $isShipping = ($order['shipping_fee'] > 0);
                                    $status = $order['status'];
                                ?>
                                <tr class="admin-order-row">
                                    <td class="fw-bold">#<?php echo $order['order_id']; ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark">
                                            <?php echo trim(($order['lastname'] ?? '') . ' ' . ($order['firstname'] ?? '')) ?: $order['email']; ?>
                                        </div>
                                        <div class="text-muted small"><?php echo $order['phone'] ?: 'Chưa có SĐT'; ?></div>
                                    </td>
                                    
                                    <td><?php echo date('H:i - d/m/Y', strtotime($order['order_date'])); ?></td>
                                    
                                    <td>
                                        <?php if ($order['is_paid'] == 1): ?>
                                            <span class="badge bg-success px-3 py-2">Đã thanh toán</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger px-3 py-2">Chưa thanh toán</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        if ($isShipping) {
                                            switch($status) {
                                                case 0: echo '<span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>'; break;
                                                case 1: echo '<span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị hàng</span>'; break;
                                                case 2: echo '<span class="badge bg-primary text-white px-3 py-2">Đang giao hàng</span>'; break;
                                                case 3: echo '<span class="badge bg-success px-3 py-2">Giao thành công</span>'; break;
                                                case 4: echo '<span class="badge bg-danger px-3 py-2">Thất bại / Đã hủy</span>'; break;
                                                default: echo '<span class="badge bg-danger px-3 py-2">Không xác định</span>'; break;
                                            }
                                        } else {
                                            switch($status) {
                                                case 0: echo '<span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>'; break;
                                                case 1: echo '<span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị hàng</span>'; break;
                                                case 2: echo '<span class="badge bg-primary text-white px-3 py-2">Sẵn sàng nhận</span>'; break;
                                                case 3: echo '<span class="badge bg-success px-3 py-2">Đã nhận hàng</span>'; break;
                                                case 4: echo '<span class="badge bg-danger px-3 py-2">Thất bại / Đã hủy</span>'; break;
                                                default: echo '<span class="badge bg-danger px-3 py-2">Không xác định</span>'; break;
                                            }
                                        }
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($status < 3): ?>
                                            <form action="<?php echo BASE_URL; ?>admin/product/processOrderFlow" method="POST" class="mb-2">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                
                                                <?php if ($status == 0): ?>
                                                    <button type="submit" name="next_status" value="1" class="btn btn-xs btn-info text-white w-100 mb-1">Chuẩn bị hàng</button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</button>
                                                
                                                <?php elseif ($status == 1): ?>
                                                    <?php $btnText = $isShipping ? 'Bắt đầu giao hàng' : 'Báo khách đến lấy'; ?>
                                                    <button type="submit" name="next_status" value="2" class="btn btn-xs btn-primary w-100 mb-1"><?php echo $btnText; ?></button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</button>
                                                
                                                <?php elseif ($status == 2): ?>
                                                    <?php $btnText = $isShipping ? 'Giao xong & Thu tiền' : 'Đã nhận & Thu tiền'; ?>
                                                    <button type="submit" name="next_status" value="3" class="btn btn-xs btn-success w-100 mb-1" onclick="return confirm('Xác nhận hoàn thành và đánh dấu đã thanh toán (COD)?')"><?php echo $btnText; ?></button>
                                                    <button type="submit" name="next_status" value="4" class="btn btn-xs btn-outline-danger w-100" onclick="return confirm('Xác nhận khách boom hàng/hủy đơn?')">Giao thất bại</button>
                                                
                                                <?php endif; ?>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo BASE_URL; ?>admin/product/orderDetail?id=<?php echo $order['order_id']; ?>" class="btn btn-xs btn-secondary w-100">
                                            <i class="ti-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Hệ thống chưa có đơn đặt hàng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div id="adminPagination" class="d-flex justify-content-end mt-4"></div>
                
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const orderList = document.getElementById("adminOrderList");
    const paginationContainer = document.getElementById("adminPagination");
    const searchInput = document.getElementById("adminSearchInput");
    const searchBtn = document.getElementById("adminSearchBtn");
    
    // Lưu trữ toàn bộ dữ liệu (tất cả các thẻ tr)
    const allRows = Array.from(orderList.getElementsByClassName("admin-order-row"));
    let filteredRows = [...allRows];
    
    const itemsPerPage = 10; // Hiện 10 đơn hàng trên 1 trang
    let currentPage = 1;

    // Hàm Lọc dữ liệu khi tìm kiếm
    function filterTable() {
        const keyword = searchInput.value.trim().toLowerCase();
        currentPage = 1;

        if (keyword === "") {
            filteredRows = [...allRows];
        } else {
            // Lọc theo Mã Đơn (cột 0) hoặc Tên Khách Hàng (cột 1)
            filteredRows = allRows.filter(row => {
                const idCell = row.getElementsByTagName("td")[0];
                const nameCell = row.getElementsByTagName("td")[1];
                const textToSearch = (idCell.textContent + " " + nameCell.textContent).toLowerCase();
                return textToSearch.includes(keyword);
            });
        }
        allRows.forEach(row => row.style.display = "none");
        renderTable();
    }

    // Hàm hiển thị dòng theo trang
    function renderTable() {
        filteredRows.forEach(row => row.style.display = "none");
        
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredRows.slice(start, end).forEach(row => row.style.display = "");
        
        renderPagination(Math.ceil(filteredRows.length / itemsPerPage));
    }

    // Hàm vẽ nút bấm phân trang
    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";
        if (totalPages <= 1) return;
        
        const ul = document.createElement("ul");
        ul.className = "pagination mb-0";
        
        const liPrev = document.createElement("li");
        liPrev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        liPrev.innerHTML = `<a class="page-link" href="javascript:void(0)">&laquo;</a>`;
        liPrev.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
        ul.appendChild(liPrev);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${currentPage === i ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
            li.onclick = () => { currentPage = i; renderTable(); };
            ul.appendChild(li);
        }

        const liNext = document.createElement("li");
        liNext.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        liNext.innerHTML = `<a class="page-link" href="javascript:void(0)">&raquo;</a>`;
        liNext.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
        ul.appendChild(liNext);

        paginationContainer.appendChild(ul);
    }

    // Gắn sự kiện cho Tìm kiếm
    if (searchBtn) searchBtn.addEventListener("click", filterTable);
    if (searchInput) {
        searchInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                filterTable();
            }
        });
    }

    // Chạy lần đầu
    renderTable();
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>