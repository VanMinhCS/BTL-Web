// Khai báo ở đầu file article.js
const urlParams = new URLSearchParams(window.location.search);
const articleId = urlParams.get("id"); // sẽ là "1" trong ví dụ

let userRole = "member"; // mặc định
const perPage = 5;
let currentPage = 1;
let sortType = "newest";
let comments = [];   // thêm dòng này

function fetchUserRole() {
  fetch("/article/getRole")
    .then(res => res.json())
    .then(data => {
      // giả sử API trả về { "role": 1 } hoặc { "role": 0 }
      if (data.role == 1) {
        userRole = "admin"; // hoặc "admin" nếu bạn muốn phân quyền cao hơn
      } else {
        userRole = "member";
      }
      applyRolePermissions();
      renderComments();
    })
    .catch(err => {
      console.error("Lỗi khi lấy role:", err);
      userRole = "guest";
    });
}

function applyRolePermissions() {
  const commentForm = document.getElementById("commentForm");
  if (userRole === "guest") {
    commentForm.style.display = "none";   // Guest không thấy form
  } else {
    commentForm.style.display = "block";  // Member thấy form
  }
}

async function fetchArticle() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  try {
    const response = await fetch(`/article/getArticle?id=${id}`);
    const articleData = await response.json();

    if (articleData.error) {
      document.querySelector(".title").textContent = articleData.error;
      return;
    }

    // Title
    document.querySelector(".title").textContent = articleData.title;

    // Time upload (chỉ ngày/tháng/năm)
    document.querySelector(".time_upload").textContent = articleData.upload_date;

    // Content (giữ nguyên HTML)
    const contentDiv = document.querySelector(".row.content");
    contentDiv.innerHTML = articleData.content;

    // Background image
    const bgDiv = document.querySelector(".background_image");
    bgDiv.style.backgroundImage = `url('${articleData.background}')`;
    bgDiv.style.backgroundSize = "cover";
    bgDiv.style.backgroundPosition = "center";
  } catch (error) {
    console.error("Lỗi khi tải bài viết:", error);
  }
}

document.addEventListener("DOMContentLoaded", fetchArticle);


async function fetchComments(articleId) {
  try {
    const response = await fetch(`article/getComments?id=${articleId}`);
    const data = await response.json();

    // Gán dữ liệu vào mảng comments toàn cục
    comments = data.items;
    currentPage = 1;
    renderComments();
  } catch (error) {
    console.error("Lỗi khi tải comments:", error);
  }
}

function renderComments() {
  const list = document.getElementById("commentList");
  list.innerHTML = "";

  // Sắp xếp
  let sorted = [...comments];
  if (sortType === "newest") {
    sorted.sort((a, b) => new Date(b.date) - new Date(a.date));
  } else {
    sorted.sort((a, b) => b.likes - a.likes);
  }

    // Nếu có query ?comment=ID thì tính lại currentPage
  const urlParams = new URLSearchParams(window.location.search);
  const commentId = urlParams.get("comment");
  if(commentId){
    const idx = sorted.findIndex(c => c.id == commentId);
    if(idx !== -1){
      currentPage = Math.floor(idx / perPage) + 1;
    }
  }
  
  // Phân trang
  const start = (currentPage - 1) * perPage;
  const pageComments = sorted.slice(start, start + perPage);

  pageComments.forEach(c => {
    const div = document.createElement("div");
    div.className = "comment mb-3 text-start border p-3 rounded";
    div.dataset.commentId = c.id; 
    div.innerHTML = `
      <div class="d-flex justify-content-between align-items-center">
        <p class="mb-1">
          <strong>${c.user}</strong>
          ${c.isAdmin ? '<span class="badge bg-primary ms-2">Admin</span>' : ''}
        </p>
        <small class="text-muted">
          ${new Date(c.date).toLocaleDateString("vi-VN")}
          ${c.isEdited ? '<em class="ms-2">(Đã chỉnh sửa)</em>' : ''}
        </small>
      </div>

      <p class="mb-2">${c.text}</p>

      <div class="d-flex gap-4 align-items-center">
        <!-- Nút Like -->
        <a href="javascript:void(0)" 
          class="like-btn ${userRole==='guest'?'disabled':''} ${c.userVote==='like'?'active-vote':''}" 
          data-id="${c.id}" title="Like">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M2 21h4V9H2v12zm20-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32
                    c0-.41-.17-.79-.44-1.06L13.17 1 6.59 7.59C6.22 7.95 6 8.45 6 9v10
                    c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05
                    c.09-.23.14-.47.14-.73v-1z"/>
          </svg> ${c.likes}
        </a>

        <!-- Nút Dislike -->
        <a href="javascript:void(0)" 
          class="dislike-btn ${userRole==='guest'?'disabled':''} ${c.userVote==='dislike'?'active-vote':''}" 
          data-id="${c.id}" title="Dislike">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22 3H18v12h4V3zm-6 0H7c-.83 0-1.54.5-1.84 1.22L2.14 11.27
                    c-.09.23-.14.47-.14.73v1c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32
                    c0 .41.17-.79.44-1.06l1.12 1.12 6.59-6.59c.37-.36.59-.86.59-1.41V5
                    c0-1.1-.9-2-2-2z"/>
          </svg> ${c.dislikes}
        </a>

        <!-- Menu hành động -->
        <div class="dropdown ms-auto">
          <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
            ...
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item reply-btn" data-id="${c.id}" href="#">Phản hồi</a></li>
            ${c.isOwner ? `
              <li><a class="dropdown-item edit-btn" data-id="${c.id}" href="#">Chỉnh sửa</a></li>
              <li><a class="dropdown-item delete-btn" data-id="${c.id}" href="#">Xóa</a></li>
            ` : ''}
            <li><a class="dropdown-item report-btn" data-id="${c.id}" href="#">Báo cáo</a></li>
          </ul>
        </div>
      </div>
      ${c.repliedId 
    ? `<span class="text-muted replied-link" data-id="${c.repliedId}">
          Phản hồi: ${c.repliedUser}
      </span>` 
    : ''}
    `;
    list.appendChild(div);
  });

  renderPagination(sorted.length);
  
  if(commentId){
    setTimeout(() => {
      const targetComment = document.querySelector(`[data-comment-id="${commentId}"]`);
      if(targetComment){
        targetComment.scrollIntoView({behavior:"smooth"});
      }
    }, 300);
  }
}

// Listener click cho replied-link
document.addEventListener("click", e => {
  if(e.target.classList.contains("replied-link")){
    const targetId = e.target.dataset.id;
    const targetComment = document.querySelector(`[data-comment-id="${targetId}"]`);
    if(targetComment){
      targetComment.scrollIntoView({behavior:"smooth"});
    } else {
      // Nếu comment nằm ở trang khác
      window.location.href = `/article?id=${articleId}&comment=${targetId}`;
    }
  }
});

function renderPagination(total) {
  const ul = document.getElementById("commentPagination");
  ul.innerHTML = "";
  const pages = Math.ceil(total/perPage);
  for(let i=1;i<=pages;i++){
    const li = document.createElement("li");
    li.className = "page-item"+(i===currentPage?" active":"");
    li.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
    li.addEventListener("click", ()=>{
      currentPage = i;
      // Xóa tham số comment khỏi URL
      const url = new URL(window.location);
      url.searchParams.delete("comment");
      url.searchParams.set("page", i); // nếu muốn lưu page vào URL
      window.history.pushState({}, "", url);

      renderComments();
    });
    ul.appendChild(li);
  }
}


document.addEventListener("click", async e => {
  if (userRole === "guest") return;

  const likeBtn = e.target.closest(".like-btn");
  const dislikeBtn = e.target.closest(".dislike-btn");

  if (likeBtn) {
    const id = likeBtn.dataset.id;
    await sendVote(id, "like");
  }

  if (dislikeBtn) {
    const id = dislikeBtn.dataset.id;
    await sendVote(id, "dislike");
  }

  if(e.target.classList.contains("reply-btn")){
    e.preventDefault(); 

    const id = e.target.dataset.id;
    const c = comments.find(x=>x.id==id);
    const parent = e.target.closest(".comment");

    // nếu đã có form reply thì không thêm nữa
    if(parent.querySelector(".reply-area")) return;

    const textarea = document.createElement("textarea");
    textarea.className = "reply-area form-control mt-2";
    textarea.placeholder = "Nhập phản hồi...";
    parent.appendChild(textarea);

    const sendBtn = document.createElement("button");
    sendBtn.type = "button";
    sendBtn.textContent = "Gửi phản hồi";
    sendBtn.className = "btn btn-sm btn-primary mt-2 me-2";
    parent.appendChild(sendBtn);

    const cancelBtn = document.createElement("button");
    cancelBtn.type = "button";
    cancelBtn.textContent = "Cancel";
    cancelBtn.className = "btn btn-sm btn-secondary mt-2";
    parent.appendChild(cancelBtn);

    sendBtn.addEventListener("click", () => {
      const replyText = textarea.value.trim();
      if(replyText){
        fetch("/article/replyComment", {
          method: "POST",
          headers: {"Content-Type": "application/x-www-form-urlencoded"},
          body: `article_id=${articleId}&parent_id=${id}&text=${encodeURIComponent(replyText)}`
        })
        .then(res => res.json())
        .then(data => {
          if(data.success){
            comments.push(data.comment); // thêm phản hồi vào mảng
            renderComments();
          } else {
            alert(data.error);
          }
        });
      }
    });

    cancelBtn.addEventListener("click", () => {
      // Xóa textarea và nút đi
      textarea.remove();
      sendBtn.remove();
      cancelBtn.remove();
    });
  }


  if(e.target.classList.contains("report-btn")){
    const id = e.target.dataset.id;
    alert("Bạn đã báo cáo comment #" + id);
    // TODO: gọi API báo cáo
  }

});


async function sendVote(commentId, voteType) {
  try {
    const response = await fetch("/article/voteComment", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `comment_id=${commentId}&vote=${voteType}`
    });

    const text = await response.text();
    console.log("Raw response:", text);

    const data = JSON.parse(text);

    if (data.success) {
      const c = comments.find(x => x.id == commentId);
      c.likes = data.likes;
      c.dislikes = data.dislikes;
      c.userVote = data.userVote; // lấy từ server, có thể null/like/dislike
      renderComments();
    } else {
      console.error("Vote lỗi:", data.error);
    }
  } catch (err) {
    console.error("Vote lỗi:", err);
  }
}

// Xử lý gửi bình luận mới
document.getElementById("commentForm").addEventListener("submit", async e => {
  e.preventDefault();
  if (userRole === "guest") return;

  const textarea = e.target.querySelector("textarea");
  const text = textarea.value.trim();
  if (text) {
    try {
      const response = await fetch("http://localhost:8080/article/addComment", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `article_id=${articleId}&text=${encodeURIComponent(text)}`
      });

      const raw = await response.text();
      console.log("Raw response:", raw);
      const data = JSON.parse(raw);

      if (data.success) {
        comments.unshift(data.comment); // thêm comment mới từ server
        textarea.value = "";
        currentPage = 1;
        renderComments();
      } else {
        console.error("Lỗi thêm bình luận:", data.error);
      }
    } catch (err) {
      console.error("Lỗi AJAX:", err);
    }
  }
});

// Sort handler
document.getElementById("sortComments").addEventListener("change", e=>{
  sortType = e.target.value;
  currentPage = 1;
  renderComments();
});

document.addEventListener("DOMContentLoaded", ()=>{
  const params = new URLSearchParams(window.location.search);
  const articleId = params.get("id");
  fetchArticle();
  fetchUserRole();
  fetchComments(articleId); // sẽ gán comments và gọi renderComments bên trong
});


