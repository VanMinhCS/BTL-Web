<?php
/**
 * @var array $products
 */
?>
<div class="row">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <h4 class="header-title mb-0">Danh sách sản phẩm</h4>
                    
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="max-width: 250px;">
                            <input type="text" id="adminSearchInput" class="form-control" placeholder="Tìm tên sản phẩm...">
                            <button class="btn btn-dark" type="button" id="adminSearchBtn"><i class="ti-search"></i></button>
                        </div>
                        <a href="<?php echo BASE_URL; ?>admin/product/create" class="btn btn-primary btn-sm text-nowrap">
                            <i class="fa fa-plus me-1"></i>Thêm mới
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>STT</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá bán</th>
                                <th>Kho hàng</th>
                                <th>Đã bán</th>
                                <th>Đánh giá</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="adminProductList">
                            <?php $stt = 1; ?>
                            <?php foreach ($products as $item): ?>
                            <tr class="admin-product-row">
                                <td><?php echo $stt++; ?></td>
                                <td>
                                    <img src="<?php echo BASE_URL; ?>assets/img/products/<?php echo $item['item_image']; ?>" 
                                         alt="Hình ảnh sản phẩm" 
                                         style="width: 80px; height: auto; object-fit: cover;"
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
                                    <span class="badge bg-info text-dark">
                                        <?php echo isset($item['sold_qty']) ? $item['sold_qty'] : 0; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php 
                                    $avg = isset($item['average_rating']) ? round((float)$item['average_rating'], 1) : 0;
                                    $total = isset($item['total_reviews']) ? (int)$item['total_reviews'] : 0;
                                    if ($total > 0): 
                                    ?>
                                        <span class="fw-bold text-dark"><?= $avg ?></span>
                                        <span style="color: gold; font-size: 1.1rem;">★</span><br>
                                        <a href="<?php echo BASE_URL; ?>admin/product/reviews?id=<?php echo $item['item_id']; ?>" class="text-primary" style="font-size: 0.85rem; text-decoration: underline;">
                                            (<?= $total ?> lượt)
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.85rem;">Chưa có</span>
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
                                            <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete(<?php echo $item['item_id']; ?>, this)">
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
                
                <div id="adminPagination" class="d-flex justify-content-end mt-4"></div>
                
            </div>
        </div>
    </div>
</div>

<script>
// --- 1. HÀM XÓA BẰNG AJAX CỰC MƯỢT ---
async function confirmDelete(id, btnElement) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
        // Lưu lại icon cũ và đổi sang biểu tượng Loading
        const originalHtml = btnElement.innerHTML;
        btnElement.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
        btnElement.style.pointerEvents = 'none'; // Khóa nút không cho bấm 2 lần

        try {
            // Gọi lệnh xóa ngầm lên server
            const response = await fetch('<?php echo BASE_URL; ?>admin/product/delete?id=' + id);
            
            // Vì Controller PHP của bạn dùng lệnh header() để chuyển về trang có ?status=deleted
            // Nên ta chỉ cần kiểm tra xem URL trả về có chứa chữ 'status=deleted' hay không
            if (response.ok && response.url.includes('status=deleted')) {
                
                // Xóa luôn dòng <tr> chứa sản phẩm đó khỏi màn hình (hiệu ứng tức thì)
                const row = btnElement.closest('.admin-product-row');
                if (row) row.remove();
                
                // Gọi hàm cập nhật lại số trang
                if (typeof window.reRenderProductTable === 'function') {
                    window.reRenderProductTable();
                }

            } else {
                // Nếu PHP trả về thông báo lỗi 1451 (sản phẩm đã có người mua) mà ta làm lúc nãy
                alert('Không thể xóa! Sản phẩm này đã nằm trong lịch sử đơn hàng của khách.');
                btnElement.innerHTML = originalHtml;
                btnElement.style.pointerEvents = 'auto';
            }
        } catch (error) {
            alert('Lỗi kết nối máy chủ!');
            btnElement.innerHTML = originalHtml;
            btnElement.style.pointerEvents = 'auto';
        }
    }
}


// --- 2. SCRIPT TÌM KIẾM & PHÂN TRANG (Đã đóng gói chống xung đột) ---
(function() {
    const productList = document.getElementById("adminProductList");
    const paginationContainer = document.getElementById("adminPagination");
    const searchInput = document.getElementById("adminSearchInput");
    const searchBtn = document.getElementById("adminSearchBtn");
    
    if (!productList) return;

    // Đổi const thành let để lát có thể cập nhật lại mảng sau khi Xóa
    let allRows = Array.from(productList.getElementsByClassName("admin-product-row"));
    let filteredRows = [...allRows]; 
    
    const itemsPerPage = 10;
    let currentPage = 1;

    function filterTable() {
        const keyword = searchInput.value.trim().toLowerCase();
        currentPage = 1;

        if (keyword === "") {
            filteredRows = [...allRows]; 
        } else {
            filteredRows = allRows.filter(row => {
                const nameCell = row.getElementsByTagName("td")[2]; 
                const nameText = nameCell.textContent || nameCell.innerText;
                return nameText.toLowerCase().includes(keyword);
            });
        }
        allRows.forEach(row => row.style.display = "none");
        renderTable();
    }

    function renderTable() {
        filteredRows.forEach(row => row.style.display = "none");
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredRows.slice(start, end).forEach(row => row.style.display = "");
        renderPagination(Math.ceil(filteredRows.length / itemsPerPage));
    }

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

    if (searchBtn) searchBtn.addEventListener("click", filterTable);
    if (searchInput) {
        searchInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                filterTable();
            }
        });
    }

    // Hàm toàn cục này sẽ được gọi ở bước xóa thành công (Bên trên)
    window.reRenderProductTable = function() {
        allRows = Array.from(productList.getElementsByClassName("admin-product-row"));
        filterTable(); 
    };

    renderTable();
})();
</script>