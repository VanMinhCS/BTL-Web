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
                            <input type="text" id="adminSearchInput" class="form-control" placeholder="Tìm tên giáo trình...">
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
                                <th>Tên giáo trình</th>
                                <th>Giá bán</th>
                                <th>Kho hàng</th>
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
                                         alt="Hình ảnh giáo trình" 
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
                                    <ul class="d-flex justify-content-center">
                                        <li class="me-3">
                                            <a href="<?php echo BASE_URL; ?>admin/product/edit?id=<?php echo $item['item_id']; ?>" class="text-secondary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete(<?php echo $item['item_id']; ?>)">
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
function confirmDelete(id) {
    if (confirm('Bạn có chắc chắn muốn xóa giáo trình này không?')) {
        window.location.href = '<?php echo BASE_URL; ?>admin/product/delete?id=' + id;
    }
}

// SCRIPT TÌM KIẾM & PHÂN TRANG CHO BẢNG ADMIN
document.addEventListener("DOMContentLoaded", function() {
    const productList = document.getElementById("adminProductList");
    const paginationContainer = document.getElementById("adminPagination");
    const searchInput = document.getElementById("adminSearchInput");
    const searchBtn = document.getElementById("adminSearchBtn");
    
    // Lưu trữ toàn bộ dữ liệu ban đầu
    const allRows = Array.from(productList.getElementsByClassName("admin-product-row"));
    let filteredRows = [...allRows]; // Mảng này sẽ thay đổi khi tìm kiếm
    
    const itemsPerPage = 10;
    let currentPage = 1;

    // HÀM TÌM KIẾM
    function filterTable() {
        const keyword = searchInput.value.trim().toLowerCase();
        currentPage = 1; // Reset về trang 1 khi tìm kiếm

        if (keyword === "") {
            filteredRows = [...allRows]; // Rỗng thì trả lại toàn bộ
        } else {
            // Lọc ra các dòng có chứa từ khóa ở cột "Tên giáo trình" (cột thứ 3, index = 2)
            filteredRows = allRows.filter(row => {
                const nameCell = row.getElementsByTagName("td")[2]; 
                const nameText = nameCell.textContent || nameCell.innerText;
                return nameText.toLowerCase().includes(keyword);
            });
        }

        // Giấu TẤT CẢ đi trước khi render lại
        allRows.forEach(row => row.style.display = "none");
        renderTable();
    }

    // HÀM HIỂN THỊ DỮ LIỆU
    function renderTable() {
        // Đảm bảo các dòng trong mảng filtered cũng đang bị giấu
        filteredRows.forEach(row => row.style.display = "none");
        
        // Chỉ hiện số dòng thuộc trang hiện tại (lấy từ mảng đã lọc)
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredRows.slice(start, end).forEach(row => row.style.display = "");
        
        // Vẽ nút phân trang dựa trên số lượng kết quả tìm được
        renderPagination(Math.ceil(filteredRows.length / itemsPerPage));
    }

    // HÀM VẼ NÚT PHÂN TRANG
    function renderPagination(totalPages) {
        paginationContainer.innerHTML = "";
        if (totalPages <= 1) return;
        
        const ul = document.createElement("ul");
        ul.className = "pagination mb-0";
        
        // Nút Prev
        const liPrev = document.createElement("li");
        liPrev.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        liPrev.innerHTML = `<a class="page-link" href="javascript:void(0)">&laquo;</a>`;
        liPrev.onclick = () => { if (currentPage > 1) { currentPage--; renderTable(); } };
        ul.appendChild(liPrev);

        // Các nút số
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${currentPage === i ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
            li.onclick = () => { currentPage = i; renderTable(); };
            ul.appendChild(li);
        }

        // Nút Next
        const liNext = document.createElement("li");
        liNext.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        liNext.innerHTML = `<a class="page-link" href="javascript:void(0)">&raquo;</a>`;
        liNext.onclick = () => { if (currentPage < totalPages) { currentPage++; renderTable(); } };
        ul.appendChild(liNext);

        paginationContainer.appendChild(ul);
    }

    // Bắt sự kiện bấm nút Tìm kiếm
    searchBtn.addEventListener("click", filterTable);

    // Bắt sự kiện gõ Enter trong ô tìm kiếm
    searchInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            filterTable();
        }
    });

    // Chạy lần đầu tiên khi load web
    renderTable();
});
</script>