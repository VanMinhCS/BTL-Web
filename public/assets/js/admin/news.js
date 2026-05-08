const itemsPerPage = 5; 
let bulkMode = false;
let selectedIds = [];
let newsData = { totalItems: 0, items: [] };

async function fetchNews(page = 1, keyword = "") {
  try {
    const response = await fetch(`/admin/news/getNews?page=${page}&keyword=${encodeURIComponent(keyword)}`);
    const result = await response.json();
    newsData = result;

    // KHÔNG slice nữa, vì server đã cắt theo trang
    renderArticles(newsData.items);
    renderPagination(newsData.totalItems, itemsPerPage, page, keyword);
  } catch (error) {
    console.error("Lỗi khi tải dữ liệu news:", error);
  }
}

function renderPagination(totalItems, itemsPerPage, currentPage, keyword = "") {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  const maxVisible = 3; // số trang hiển thị quanh currentPage
  let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
  let end = start + maxVisible - 1;

  if (end > totalPages) {
    end = totalPages;
    start = Math.max(1, end - maxVisible + 1);
  }

  // Trang đầu
  if (start > 1) {
    const first = document.createElement("li");
    first.className = "page-item";
    first.innerHTML = `<a class="page-link" href="#">1</a>`;
    first.addEventListener("click", (e) => {
      e.preventDefault();
      fetchNews(1, keyword);
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
      fetchNews(i, keyword);
    });
    pagination.appendChild(pageItem);
  }

  // Trang cuối
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
      fetchNews(totalPages, keyword);
    });
    pagination.appendChild(last);
  }
}

function renderArticles(articles) {
  const list = document.getElementById("article-list");
  list.innerHTML = "";

  articles.forEach(article => {
    const div = document.createElement("div");
    div.className = "article-entry d-flex align-items-start p-3 border-bottom";
    div.innerHTML = `
      <div class="me-3">
        <i class="ti-file ${article.status === 1 ? 'bg-primary' : 'bg-danger'} article-icon"
           data-id="${article.id}"
           style="height:45px;width:45px;line-height:45px;display:block;border-radius:50%;text-align:center;color:#fff;font-size:18px;cursor:pointer;"></i>
      </div>
      <div class="flex-grow-1 article-content">
        <h6 class="mb-1">${article.title}</h6>
        <p class="text-muted mb-1">${article.description}</p>
        <small class="text-muted">Đăng ngày: ${article.upload_date}</small>
      </div>
      <button class="btn btn-sm btn-outline-primary"
              onclick="window.location.href='article?id=${article.id}'">Edit</button>
      <button class="btn btn-sm ${article.status === 1 ? 'btn-outline-secondary' : 'btn-outline-danger'} toggle-btn"
              data-id="${article.id}">
        ${article.status === 1 ? 'Hide' : 'Show'}
      </button>
    `;
    list.appendChild(div);
  });
}

function bulkAction(action) {
  if(selectedIds.length === 0) {
    alert("Chưa chọn bài viết nào");
    return;
  }

  fetch("/admin/news/bulkAction", {
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
          message = "Xóa bài viết thành công";
          break;
        case "hide":
          message = "Ẩn bài viết thành công";
          break;
        case "show":
          message = "Hiện bài viết thành công";
          break;
      }
      showNotification(message);
      fetchNews(1);
      selectedIds = []; // reset sau khi thao tác
    }
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

document.addEventListener("click", function(e){
  if(bulkMode && e.target.classList.contains("article-icon")){
    const id = e.target.dataset.id;
    if(selectedIds.includes(id)){
      // bỏ chọn
      selectedIds = selectedIds.filter(x => x !== id);
      e.target.style.outline = "none";
      e.target.style.backgroundColor = e.target.classList.contains("bg-primary") ? "#0d6efd" : "#dc3545";
    } else {
      // chọn
      selectedIds.push(id);
      e.target.style.outline = "3px solid #28a745"; 
    }
  }
});

document.addEventListener("click", function(e) {
  if(e.target.classList.contains("toggle-btn")){
    const btn = e.target;
    const id = btn.getAttribute("data-id");

    fetch("/admin/news/toggleStatus", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        if(data.status === 1){
          btn.textContent = "Hide";
          btn.classList.remove("btn-outline-danger");
          btn.classList.add("btn-outline-secondary");
        } else {
          btn.textContent = "Show";
          btn.classList.remove("btn-outline-secondary");
          btn.classList.add("btn-outline-danger");
        }
      }
    });
  }
});

document.getElementById("searchForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const keyword = document.getElementById("searchInput").value.trim();

  // Luôn gọi fetchNews với keyword, nếu rỗng thì load toàn bộ
  fetchNews(1, keyword);
});

document.getElementById("addArticleBtn").addEventListener("click", function(e){
  e.preventDefault(); // chặn chuyển trang ngay lập tức

  // gọi API tạo bài viết mới (ví dụ)
  fetch("/admin/news/create", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "title=Bài viết mới" // tuỳ theo backend
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      showNotification("Thêm bài viết thành công");
      // reload danh sách
      fetchNews();
    } else {
      showNotification("Thêm bài viết thất bại");
    }
  });
});


document.addEventListener("DOMContentLoaded", async function() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  if(id){
    try {
      const response = await fetch(`/admin/news/getNews?id=${id}`);
      const article = await response.json();

      if(article.error){
        document.getElementById("article-container").innerHTML = `<p>${article.error}</p>`;
        return;
      }

      // render dữ liệu ra trang
      document.getElementById("article-container").innerHTML = `
        <h2>${article.title}</h2>
        <p><strong>Mô tả:</strong> ${article.description}</p>
        <p><strong>Ngày đăng:</strong> ${article.upload_date}</p>
        <div class="content">${article.content}</div>
        <img src="${article.background}" alt="Background" class="img-fluid mt-2">
      `;
    } catch (error) {
      console.error("Lỗi khi tải bài viết:", error);
    }
  }
});

document.addEventListener("DOMContentLoaded", function() {
  fetchNews();

  document.getElementById("toggle-bulk").addEventListener("click", function(){
    bulkMode = !bulkMode;
    document.getElementById("bulk-actions").classList.toggle("d-none", !bulkMode);
    selectedIds = [];
    document.querySelectorAll(".article-icon").forEach(icon => {
      icon.style.outline = "none";
      icon.style.backgroundColor = icon.classList.contains("bg-primary") ? "#0d6efd" : "#dc3545";
    });
  });

  // Bulk actions
  document.getElementById("bulk-delete").addEventListener("click", () => bulkAction("delete"));
  document.getElementById("bulk-hide").addEventListener("click", () => bulkAction("hide"));
  document.getElementById("bulk-show").addEventListener("click", () => bulkAction("show"));

  document.querySelector("#notification-panel .btn-close").addEventListener("click", hideNotification);

  // Đã bỏ phần optionArticles / optionReviews
});





