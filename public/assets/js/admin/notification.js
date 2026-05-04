const itemsPerPage = 5; 
let bulkMode = false;
let selectedIds = [];
let notificationsData = {};

// ==========================================
// 1. CÁC HÀM TẢI VÀ HIỂN THỊ DỮ LIỆU
// ==========================================
async function fetchNotifications(page = 1, keyword = "", status = "", type = "", sort = "desc") {
  try {
    const url = `/admin/notification/getAllNotifications?page=${page}&itemsPerPage=${itemsPerPage}`
      + `&keyword=${encodeURIComponent(keyword)}`
      + `&status=${encodeURIComponent(status)}`
      + `&type=${encodeURIComponent(type)}`
      + `&sort=${encodeURIComponent(sort)}`;

    const response = await fetch(url);
    const result = await response.json();
    notificationsData = result;

    renderNotifications(notificationsData.notifications);
    renderPagination(notificationsData.totalItems, itemsPerPage, page, keyword, status, type, sort);

    selectedIds = [];
    if (typeof updateMasterCheckboxState === "function") updateMasterCheckboxState();
  } 
  catch (error) {
    console.error("Lỗi khi tải dữ liệu thông báo:", error);
  }
}

function renderNotifications(notifications) {
  const list = document.getElementById("notification-list");
  list.innerHTML = "";

  notifications.forEach(n => {
    const div = document.createElement("div");
    div.className = "notification-entry d-flex align-items-start p-3 border-bottom";

    const readStatus = n.is_read == 1 ? "Read" : "Unread";
    
    // Tùy chỉnh Icon & Màu sắc
    let iconClass = "ti-info";
    let bgClass = "bg-info";

    if (n.type === "order") {
        iconClass = "ti-shopping-cart"; 
        bgClass = "bg-warning";         
    }

    // Tùy chỉnh đường dẫn URL
    let viewUrl = "#";
    if (n.type === "order") {
        let orderId = n.notify_order_id || ""; 
        viewUrl = `/admin/product/orderDetail?id=${orderId}`;
    } else {
        let artId = n.id_article || n.article_id || "";
        let cmtId = n.id_comment || n.comment_id || "";
        viewUrl = `/admin/article?id=${artId}${cmtId ? '&comment='+cmtId : ''}`;
    }

    // Truyền event vào hàm markAndRedirect
    div.innerHTML = `
      <div class="d-flex align-items-center me-3">
        <!-- BỔ SUNG CHECKBOX TẠI ĐÂY -->
        <input class="form-check-input me-3 row-checkbox shadow-sm" type="checkbox" value="${n.id}" data-read="${n.is_read}" style="width: 1.1rem; height: 1.1rem; cursor: pointer;">
        
        <i class="${iconClass} ${bgClass} notification-icon"
           data-id="${n.id}"
           style="height:45px;width:45px;line-height:45px;display:block;border-radius:50%;text-align:center;color:#fff;font-size:18px;"></i>
      </div>
      <div class="flex-grow-1 notification-content">
        <h6 class="mb-1">${n.message}</h6>
        <small class="text-muted">Ngày: ${n.created_at} | Status: ${readStatus}</small>
      </div>
      <button class="btn btn-sm btn-outline-primary"
              onclick="markAndRedirect(event, ${n.id}, '${viewUrl}')">
        View
      </button>
    `;
    list.appendChild(div);
  });
}

function renderPagination(totalItems, itemsPerPage, currentPage, keyword = "", status = "", type = "", sort = "desc") {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  const maxVisible = 3; 
  let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let end = start + maxVisible - 1;

  if (end > totalPages) {
    end = totalPages;
    start = Math.max(1, end - maxVisible + 1);
  }

  if (start > 1) {
    const first = document.createElement("li");
    first.className = "page-item";
    first.innerHTML = `<a class="page-link" href="#">1</a>`;
    first.addEventListener("click", (e) => { e.preventDefault(); fetchNotifications(1, keyword, status, type, sort); });
    pagination.appendChild(first);

    if (start > 2) {
      const dots = document.createElement("li");
      dots.className = "page-item disabled";
      dots.innerHTML = `<span class="page-link">...</span>`;
      pagination.appendChild(dots);
    }
  }

  for (let i = start; i <= end; i++) {
    const pageItem = document.createElement("li");
    pageItem.className = "page-item" + (i === currentPage ? " active" : "");
    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    pageItem.addEventListener("click", (e) => { e.preventDefault(); fetchNotifications(i, keyword, status, type, sort); });
    pagination.appendChild(pageItem);
  }

  if (end < totalPages) {
    if (end < totalPages - 1) {
      const dots = document.createElement("li");
      dots.className = "page-item disabled";
      dots.innerHTML = `<span class="page-link">...</span>`;
      pagination.appendChild(dots);
    }

    const last = document.createElement("li");
    last.className = "page-item";
    last.innerHTML = `<a class="page-link" href="#">${totalPages}</a>`;
    last.addEventListener("click", (e) => { e.preventDefault(); fetchNotifications(totalPages, keyword, status, type, sort); });
    pagination.appendChild(last);
  }
}

// ==========================================
// 2. XỬ LÝ ĐÁNH DẤU ĐÃ ĐỌC & CHUYỂN TRANG
// ==========================================
function markAndRedirect(event, id, url) {
    // Ngăn chặn việc bấm 2 lần
    const btn = event.currentTarget;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    btn.style.pointerEvents = 'none';

    // CẬP NHẬT: Sử dụng đúng API gốc của hệ thống
    fetch("/admin/news/markRead", { 
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id
    }).then(() => {
        window.location.href = url;
    }).catch(() => {
        window.location.href = url;
    });
}

// ==========================================
// 3. XỬ LÝ CHUÔNG THÔNG BÁO (DROPDOWN)
// ==========================================
function loadNotifications(){
    fetch("/admin/notification/getNotifications")
    .then(res => res.json())
    .then(data => {
        if(data.success){
            const bellCount = document.querySelector(".ti-bell span");
            if (bellCount) {
                bellCount.textContent = data.count > 99 ? "+99" : data.count;
            }

            const notifyTitle = document.querySelector(".notify-title");
            if (notifyTitle) {
                notifyTitle.innerHTML = data.count > 0
                    ? `Bạn có ${data.count} thông báo mới <a href="#">xem tất cả</a>`
                    : `Bạn không có thông báo mới <a href="#">xem tất cả</a>`;

                const markAllLink = notifyTitle.querySelector("a");
                if (markAllLink) {
                    markAllLink.addEventListener("click", function(e){
                        e.preventDefault();
                        fetch("/admin/notification/markAllRead", { method: "POST" })
                            .then(() => { loadNotifications(); applyFilters(1); });
                    });
                }
            }

            const list = document.querySelector(".notify-list");
            if (list) {
                list.innerHTML = "";
                data.notifications.slice(0, 3).forEach(n => {
                    const item = document.createElement("a");
                    item.className = "notify-item";
                    item.dataset.id = n.id;
                    
                    let iconClass = "ti-info bg-info";
                    if (n.type === "order") {
                        let orderId = n.notify_order_id || "";
                        item.href = `/admin/product/orderDetail?id=${orderId}`;
                        iconClass = "ti-shopping-cart bg-warning";
                    } else {
                        let artId = n.id_article || n.article_id || "";
                        let cmtId = n.id_comment || n.comment_id || "";
                        if (artId && cmtId) {
                            item.href = `/admin/article?id=${artId}&comment=${cmtId}`;
                        } else if (artId) {
                            item.href = `/admin/article?id=${artId}`;
                        } else {
                            item.href = "#";
                        }
                    }

                    item.innerHTML = `
                        <div class="notify-thumb"><i class="${iconClass}"></i></div>
                        <div class="notify-text">
                            <p>${n.message ?? "Thông báo mới"}</p>
                            <span>${n.created_at}</span>
                        </div>`;
                        
                    item.addEventListener("click", function(e){
                        e.preventDefault();
                        // CẬP NHẬT: Sử dụng đúng API gốc của hệ thống
                        fetch("/admin/news/markRead", { 
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: "id=" + this.dataset.id
                        }).then(() => {
                            window.location.href = this.href;
                        });
                    });
                    list.appendChild(item);
                });

                if (data.count > 3) {
                    const more = document.createElement("a");
                    more.className = "notify-item text-center fw-bold";
                    more.textContent = "Xem tất cả thông báo";
                    more.href = "#"; 
                    more.addEventListener("click", function(e){
                        e.preventDefault();
                        fetch("/admin/notification/markAllRead", { method: "POST" })
                            .then(() => { loadNotifications(); applyFilters(1); }); 
                    });
                    list.appendChild(more);
                }
            }
        }
    });
}

// ==========================================
// 4. BULK ACTIONS & FILTERS (GMAIL STYLE)
// ==========================================

// Hàm xử lý chọn hàng loạt theo điều kiện
function selectByCondition(condition) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(cb => {
        let shouldCheck = false;
        if (condition === 'all') shouldCheck = true;
        else if (condition === 'none') shouldCheck = false;
        else if (condition === 'read' && cb.dataset.read === "1") shouldCheck = true;
        else if (condition === 'unread' && cb.dataset.read === "0") shouldCheck = true;

        cb.checked = shouldCheck;
        
        const id = cb.value;
        if (shouldCheck && !selectedIds.includes(id)) selectedIds.push(id);
        if (!shouldCheck) selectedIds = selectedIds.filter(x => x !== id);
    });
    updateMasterCheckboxState();
}

// Cập nhật trạng thái hiển thị của Master Checkbox và Nút thao tác
function updateMasterCheckboxState() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const masterIcon = document.getElementById('master-checkbox-icon');
    const bulkActions = document.getElementById('bulk-actions');
    
    if (checkboxes.length === 0) return;

    const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;

    // Thay đổi Icon của nút Checkbox tổng (Giống Gmail)
    if (checkedCount === 0) {
        masterIcon.className = 'ti-square'; // Ô trống
    } else if (checkedCount === checkboxes.length) {
        masterIcon.className = 'ti-check-box'; // Dấu check hoàn toàn
    } else {
        masterIcon.className = 'ti-minus'; // Dấu trừ (chọn một phần)
    }

    // Hiện/ẩn các nút Xóa & Read Selected
    if (selectedIds.length > 0) {
        bulkActions.classList.remove('d-none');
    } else {
        bulkActions.classList.add('d-none');
    }
}

// Đăng ký sự kiện (Gọi trong DOMContentLoaded)
function initGmailStyleSelection() {
    // 1. Khi bấm vào 1 checkbox riêng lẻ
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            const id = e.target.value;
            if (e.target.checked) {
                if (!selectedIds.includes(id)) selectedIds.push(id);
            } else {
                selectedIds = selectedIds.filter(x => x !== id);
            }
            updateMasterCheckboxState();
        }
    });

    // 2. Khi bấm vào nút Checkbox tổng
    document.getElementById('master-checkbox-btn')?.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        if (checkboxes.length === 0) return;
        
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        
        if (checkedCount > 0) {
            selectByCondition('none');
        } else {
            selectByCondition('all');
        }
    });

    // 3. Khi bấm vào các tùy chọn Dropdown
    document.getElementById('select-all')?.addEventListener('click', (e) => { e.preventDefault(); selectByCondition('all'); });
    document.getElementById('deselect-all')?.addEventListener('click', (e) => { e.preventDefault(); selectByCondition('none'); });
    document.getElementById('select-read')?.addEventListener('click', (e) => { e.preventDefault(); selectByCondition('read'); });
    document.getElementById('select-unread')?.addEventListener('click', (e) => { e.preventDefault(); selectByCondition('unread'); });
}

// Hàm gửi yêu cầu xử lý hàng loạt lên Server
function bulkAction(action) {
    if(selectedIds.length === 0) {
        alert("Chưa chọn thông báo nào");
        return;
    }

    // Đổi giao diện nút thành trạng thái đang xử lý để tăng trải nghiệm người dùng (UX)
    const btnId = action === 'delete' ? 'bulk-delete' : 'bulk-read';
    const btn = document.getElementById(btnId);
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
    btn.style.pointerEvents = 'none'; // Khóa nút tránh click đúp

    // Gửi dữ liệu (các ID đã chọn và hành động) lên Server
    fetch("/admin/notification/bulkAction", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ids: selectedIds, action })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            let message = action === "delete" ? "Xóa thông báo thành công" : "Đánh dấu đã đọc thành công";
            showNotification(message); // Hiện thông báo nhỏ góc màn hình
            applyFilters(1); // Tải lại danh sách thông báo chính
            loadNotifications(); // Cập nhật lại số lượng chuông trên Header
            
            // Đặt lại trạng thái mảng và Icon ô checkbox tổng
            selectedIds = []; 
            if (typeof updateMasterCheckboxState === "function") {
                updateMasterCheckboxState();
            }
        }
    })
    .catch(err => {
        console.error("Lỗi thao tác hàng loạt:", err);
        alert("Có lỗi xảy ra khi kết nối máy chủ, vui lòng thử lại!");
    })
    .finally(() => {
        // Trả lại giao diện nút như cũ dù thành công hay thất bại
        if(btn) {
            btn.innerHTML = originalText;
            btn.style.pointerEvents = 'auto';
        }
    });
}

// Hàm áp dụng bộ lọc và làm mới danh sách
function applyFilters(page = 1) {
    const keyword = document.getElementById("searchInput")?.value.trim() || "";
    const status  = document.getElementById("filter-status")?.value || "";
    const type    = document.getElementById("filter-type")?.value || "";
    const sort    = document.getElementById("filter-sort")?.value || "desc";

    fetchNotifications(page, keyword, status, type, sort);
}

// ==========================================
// 5. TOAST NOTIFICATION UI
// ==========================================
function showNotification(message) {
  const panel = document.getElementById("notification-panel");
  const msg = document.getElementById("notification-message");
  const timer = document.getElementById("notification-timer");

  msg.textContent = message;
  panel.classList.remove("d-none");

  timer.style.transition = "none";
  timer.style.width = "100%";
  setTimeout(() => {
    timer.style.transition = "width 3s linear";
    timer.style.width = "0%";
  }, 50);

  setTimeout(hideNotification, 3000);
}

function hideNotification() {
  document.getElementById("notification-panel").classList.add("d-none");
}

// ==========================================
// 6. KHỞI TẠO TẤT CẢ SỰ KIỆN KHI TRANG TẢI XONG
// ==========================================
document.addEventListener("DOMContentLoaded", () => {
    // 6.1 Tải dữ liệu ban đầu
    fetchNotifications();
    loadNotifications(); 
    setInterval(loadNotifications, 1000);

    // 6.2 Các sự kiện Lọc & Tìm kiếm
    const searchForm = document.getElementById("searchForm");
    if (searchForm) searchForm.addEventListener("submit", (e) => { e.preventDefault(); applyFilters(1); });
    
    document.getElementById("filter-status")?.addEventListener("change", () => applyFilters(1));
    document.getElementById("filter-type")?.addEventListener("change", () => applyFilters(1));
    document.getElementById("filter-sort")?.addEventListener("change", () => applyFilters(1));

    // 6.3 Sự kiện Bulk (Chọn nhiều kiểu Gmail)
    initGmailStyleSelection();
    
    // Vẫn giữ lại 2 sự kiện click cho nút Xóa và nút Đánh dấu đã đọc
    document.getElementById("bulk-delete")?.addEventListener("click", () => bulkAction("delete"));
    document.getElementById("bulk-read")?.addEventListener("click", () => bulkAction("read"));

    // 6.4 Sự kiện Read All tổng
    document.getElementById("readAllBtn")?.addEventListener("click", async () => {
        try {
            // CẬP NHẬT: Sử dụng đúng API gốc của hệ thống
            await fetch("/admin/news/readAll", { method: "POST" });
            applyFilters(1); 
            loadNotifications();
            showNotification("Đã đánh dấu tất cả thông báo là đã đọc");
        } catch (err) {
            console.error(err);
        }
    });

    document.querySelector("#notification-panel .btn-close")?.addEventListener("click", hideNotification);

    // 6.5 Cài đặt thông báo (Settings)
    const mainSwitch = document.getElementById("switch-main");
    const subSwitches = {
        comment: document.getElementById("switch-comment"),
        reply: document.getElementById("switch-reply"),
        edit: document.getElementById("switch-edit"),
        vote: document.getElementById("switch-vote"),
        // --- BỔ SUNG: Khai báo công tắc Đơn hàng ---
        order: document.getElementById("switch-order") 
    };

    if (mainSwitch) {
        // Lấy dữ liệu cài đặt khi vừa load trang
        fetch("/admin/notification/getNotificationSettings").then(res => res.json()).then(data => {
            if(data.success){
                mainSwitch.checked = data.is_enabled == 1;
                subSwitches.comment.checked = data.enable_comment == 1;
                subSwitches.reply.checked   = data.enable_reply == 1;
                subSwitches.edit.checked    = data.enable_edit == 1;
                subSwitches.vote.checked    = data.enable_vote == 1;
                
                // --- BỔ SUNG: Nhận giá trị cho công tắc Đơn hàng ---
                if(subSwitches.order) subSwitches.order.checked = data.enable_order == 1; 
                
                // Vô hiệu hóa các nút con nếu nút chính đang tắt
                Object.values(subSwitches).forEach(sw => { if(sw) sw.disabled = !mainSwitch.checked });
            }
        });

        // Bắt sự kiện khi bật/tắt nút chính
        mainSwitch.addEventListener("change", function(){
            Object.values(subSwitches).forEach(sw => { if(sw) sw.disabled = !this.checked });
            saveSettings();
        });

        // Bắt sự kiện khi bật/tắt các nút con
        Object.values(subSwitches).forEach(sw => {
            if(sw) sw.addEventListener("change", saveSettings);
        });

        // Hàm gửi dữ liệu lưu xuống Database
        function saveSettings(){
            const data = new URLSearchParams();
            data.append("enable_notifications", mainSwitch.checked ? 1 : 0);
            data.append("enable_comment", subSwitches.comment.checked ? 1 : 0);
            data.append("enable_reply", subSwitches.reply.checked ? 1 : 0);
            data.append("enable_edit", subSwitches.edit.checked ? 1 : 0);
            data.append("enable_vote", subSwitches.vote.checked ? 1 : 0);
            
            // --- BỔ SUNG: Gửi giá trị của công tắc Đơn hàng ---
            if(subSwitches.order) data.append("enable_order", subSwitches.order.checked ? 1 : 0); 
            
            fetch("/admin/notification/updateNotificationSettings", {
                method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded" }, body: data.toString()
            }).then(() => {
                // (Tùy chọn) Reload lại chuông thông báo nếu cần
                if (typeof loadNotifications === "function") loadNotifications();
            });
        }
    }
});

// ==========================================
// 7. XỬ LÝ LƯU CACHE CỦA NÚT "BACK"
// ==========================================
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        applyFilters(1); 
        loadNotifications();
    }
});