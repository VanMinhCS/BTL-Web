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

  for (let i = 1; i <= totalPages; i++) {
    const pageItem = document.createElement("li");
    pageItem.className = "page-item" + (i === currentPage ? " active" : "");
    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    pageItem.addEventListener("click", (e) => {
      e.preventDefault();
      fetchNews(i, keyword);
    });
    pagination.appendChild(pageItem);
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

  document.getElementById("optionArticles").addEventListener("change", function(){
    if(this.checked){
      document.getElementById("pagination").innerHTML = "";
      document.getElementById("article-list").innerHTML = "";
      fetchNews(1);
    }
  });

  document.getElementById("optionReviews").addEventListener("change", function(){
    if(this.checked){
      // tạm thời cũng gọi loadArticles để test
       document.getElementById("article-list").innerHTML = "";
       document.getElementById("pagination").innerHTML = "";
      // sau này thay bằng loadReviews()
    }
  });
});


function loadNotifications(){
    fetch("/admin/news/getNotifications")
    .then(res => res.json())
    .then(data => {
        if(data.success){
            const bellCount = document.querySelector(".ti-bell span");
            bellCount.textContent = data.count > 99 ? "+99" : data.count;

            const notifyTitle = document.querySelector(".notify-title");
            notifyTitle.innerHTML = data.count > 0
                ? `Bạn có ${data.count} thông báo mới <a href="#">xem tất cả</a>`
                : `Bạn không có thông báo mới <a href="#">xem tất cả</a>`;

            const list = document.querySelector(".notify-list");
            list.innerHTML = "";
            data.notifications.forEach(n => {
                const item = document.createElement("a");
                item.href = "#";
                item.className = "notify-item";
                item.dataset.id = n.id;
                item.innerHTML = `
                    <div class="notify-thumb"><i class="ti-info bg-info"></i></div>
                    <div class="notify-text">
                        <p>${n.message ?? "Thông báo mới"}</p>
                        <span>${n.created_at}</span>
                    </div>`;
                item.addEventListener("click", function(e){
                    e.preventDefault();
                    fetch("/admin/news/markRead", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "id=" + this.dataset.id
                    }).then(() => loadNotifications());
                });
                list.appendChild(item);
            });
        }
    });
}


// Gọi ngay khi trang vừa load
document.addEventListener("DOMContentLoaded", function(){
    loadNotifications(); // chạy ngay khi load trang
    setInterval(loadNotifications, 1000); // polling mỗi 1 phút
});

// nút read all
document.querySelector(".notify-title a").addEventListener("click", function(e){
    e.preventDefault();
    fetch("/admin/notification/markAllRead", {
        method: "POST"
    }).then(() => loadNotifications());
});


document.addEventListener("DOMContentLoaded", function(){
    const mainSwitch = document.getElementById("switch-main");
    const subSwitches = {
        comment: document.getElementById("switch-comment"),
        reply: document.getElementById("switch-reply"),
        edit: document.getElementById("switch-edit"),
        vote: document.getElementById("switch-vote")
    };

    // Load settings từ DB
    fetch("/admin/news/getNotificationSettings")
    .then(res => res.json())
    .then(data => {
        if(data.success){
            mainSwitch.checked = data.is_enabled == 1;
            subSwitches.comment.checked = data.enable_comment == 1;
            subSwitches.reply.checked   = data.enable_reply == 1;
            subSwitches.edit.checked    = data.enable_edit == 1;
            subSwitches.vote.checked    = data.enable_vote == 1;

            // nếu nút chính tắt thì disable các nút con
            Object.values(subSwitches).forEach(sw => sw.disabled = !mainSwitch.checked);
        }
    });

    // Khi bật/tắt nút chính
    mainSwitch.addEventListener("change", function(){
        const enabled = this.checked;
        Object.values(subSwitches).forEach(sw => sw.disabled = !enabled);
        saveSettings();
    });

    // Khi bật/tắt nút con
    Object.values(subSwitches).forEach(sw => {
        sw.addEventListener("change", saveSettings);
    });

    function saveSettings(){
        const data = new URLSearchParams();
        data.append("enable_notifications", mainSwitch.checked ? 1 : 0);
        data.append("enable_comment", subSwitches.comment.checked ? 1 : 0);
        data.append("enable_reply", subSwitches.reply.checked ? 1 : 0);
        data.append("enable_edit", subSwitches.edit.checked ? 1 : 0);
        data.append("enable_vote", subSwitches.vote.checked ? 1 : 0);

        fetch("/admin/news/updateNotificationSettings", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: data.toString()
        });
    }
});

