const itemsPerPage = 5; 
let bulkMode = false;
let selectedIds = [];
let notificationsData = {};

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
  } catch (error) {
    console.error("Lỗi khi tải dữ liệu thông báo:", error);
  }
}

function renderPagination(totalItems, itemsPerPage, currentPage, keyword = "", status = "", type = "", sort = "desc") {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  // Giới hạn số trang hiển thị
  const maxVisible = 3; // số trang muốn hiển thị
  let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let end = start + maxVisible - 1;

  if (end > totalPages) {
    end = totalPages;
    start = Math.max(1, end - maxVisible + 1);
  }

  // Nút "Trang đầu"
  if (start > 1) {
    const first = document.createElement("li");
    first.className = "page-item";
    first.innerHTML = `<a class="page-link" href="#">1</a>`;
    first.addEventListener("click", (e) => {
      e.preventDefault();
      fetchNotifications(1, keyword, status, type, sort);
    });
    pagination.appendChild(first);

    if (start > 2) {
      const dots = document.createElement("li");
      dots.className = "page-item disabled";
      dots.innerHTML = `<span class="page-link">...</span>`;
      pagination.appendChild(dots);
    }
  }

  // Các trang quanh currentPage
  for (let i = start; i <= end; i++) {
    const pageItem = document.createElement("li");
    pageItem.className = "page-item" + (i === currentPage ? " active" : "");
    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    pageItem.addEventListener("click", (e) => {
      e.preventDefault();
      fetchNotifications(i, keyword, status, type, sort);
    });
    pagination.appendChild(pageItem);
  }

  // Nút "Trang cuối"
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
    last.addEventListener("click", (e) => {
      e.preventDefault();
      fetchNotifications(totalPages, keyword, status, type, sort);
    });
    pagination.appendChild(last);
  }
}

function renderNotifications(notifications) {
  const list = document.getElementById("notification-list");
  list.innerHTML = "";

  notifications.forEach(n => {
    const div = document.createElement("div");
    div.className = "notification-entry d-flex align-items-start p-3 border-bottom";

    const readStatus = n.is_read == 1 ? "Read" : "Unread";

    div.innerHTML = `
      <div class="me-3">
        <i class="ti-info bg-info notification-icon"
           data-id="${n.id}"
           style="height:45px;width:45px;line-height:45px;display:block;border-radius:50%;text-align:center;color:#fff;font-size:18px;cursor:pointer;"></i>
      </div>
      <div class="flex-grow-1 notification-content">
        <h6 class="mb-1">${n.message}</h6>
        <small class="text-muted">Ngày: ${n.created_at} | Status: ${readStatus}</small>
      </div>
      <button class="btn btn-sm btn-outline-primary"
              onclick="window.location.href='/admin/article?id=${n.id_article}${n.id_comment ? '&comment='+n.id_comment : ''}'">
        View
      </button>
    `;
    list.appendChild(div);
  });
}

function showNotification(message) {
  const panel = document.getElementById("notification-panel");
  const msg = document.getElementById("notification-message");
  const timer = document.getElementById("notification-timer");

  msg.textContent = message;
  panel.classList.remove("d-none");

  // animate timer bar
  timer.style.transition = "none";
  timer.style.width = "100%";
  setTimeout(() => {
    timer.style.transition = "width 3s linear";
    timer.style.width = "0%";
  }, 50);

  // auto hide after 3s
  setTimeout(hideNotification, 3000);
}

function hideNotification() {
  document.getElementById("notification-panel").classList.add("d-none");
}


function bulkAction(action) {
  if(selectedIds.length === 0) {
    alert("Chưa chọn thông báo nào");
    return;
  }

  fetch("/admin/notification/bulkAction", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ids: selectedIds, action })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      let message = "";
      switch(action) {
        case "delete":
          message = "Xóa thông báo thành công";
          break;
        case "read":
          message = "Đánh dấu đã đọc thành công";
          break;
      }
      showNotification(message);
      fetchNotifications(1); // reload danh sách
      selectedIds = []; // reset sau khi thao tác
    }
  });
}

function applyFilters(page = 1) {
  const keyword = document.getElementById("searchInput").value.trim();
  const status  = document.getElementById("filter-status").value;
  const type    = document.getElementById("filter-type").value;
  const sort    = document.getElementById("filter-sort").value;

  fetchNotifications(page, keyword, status, type, sort);
}

document.addEventListener("DOMContentLoaded", () => {
  const searchForm = document.getElementById("searchForm");
  if (searchForm) {
    searchForm.addEventListener("submit", function(e) {
      e.preventDefault();
      applyFilters(1);
    });
  }

  // Nếu muốn tự động lọc khi thay đổi select
  document.getElementById("filter-status").addEventListener("change", () => applyFilters(1));
  document.getElementById("filter-type").addEventListener("change", () => applyFilters(1));
  document.getElementById("filter-sort").addEventListener("change", () => applyFilters(1));
});

document.getElementById("filter-status").addEventListener("change", () => applyFilters(1));

document.getElementById("filter-type").addEventListener("change", () => applyFilters(1));

document.getElementById("filter-sort").addEventListener("change", () => applyFilters(1));

document.addEventListener("click", function(e){
  if(bulkMode && e.target.classList.contains("notification-icon")){
    const id = e.target.dataset.id;
    if(selectedIds.includes(id)){
      // bỏ chọn
      selectedIds = selectedIds.filter(x => x !== id);
      e.target.style.outline = "none";
    } else {
      // chọn
      selectedIds.push(id);
      e.target.style.outline = "3px solid #28a745"; 
    }
  }
});

document.addEventListener("DOMContentLoaded", function() {
  // load trang đầu tiên
  fetchNotifications();

  // nút Read All
  document.getElementById("readAllBtn").addEventListener("click", async () => {
    try {
      await fetch("/admin/news/readAll", { method: "POST" });
      fetchNotifications(); 
      showNotification("Đã đánh dấu tất cả thông báo là đã đọc");
    } catch (err) {
      showNotification("Không thể đánh dấu tất cả thông báo là đã đọc");
      console.error("Lỗi khi Read All:", err);
    }
    
  });

  // form tìm kiếm
  document.getElementById("searchForm").addEventListener("submit", function(e){
    e.preventDefault();
    const keyword = document.getElementById("searchInput").value;
    fetchNotifications(1, keyword);
  });
});

document.addEventListener("DOMContentLoaded", function() {
  fetchNotifications();

  document.getElementById("toggle-bulk").addEventListener("click", function(){
    bulkMode = !bulkMode;
    document.getElementById("bulk-actions").classList.toggle("d-none", !bulkMode);
    selectedIds = [];
    document.querySelectorAll(".notification-icon").forEach(icon => {
      icon.style.outline = "none";
    });
  });

  // Bulk actions
  document.getElementById("bulk-delete").addEventListener("click", () => bulkAction("delete"));
  document.getElementById("bulk-read").addEventListener("click", () => bulkAction("read"));

  document.querySelector("#notification-panel .btn-close").addEventListener("click", hideNotification);

  // Form tìm kiếm
  document.getElementById("searchForm").addEventListener("submit", function(e){
    e.preventDefault();
    const keyword = document.getElementById("searchInput").value;
    fetchNotifications(1, keyword);
  });

  // Nút Read All

});



