const urlParams = new URLSearchParams(window.location.search);
const articleId = urlParams.get("id"); 
const uploadInput = document.getElementById("uploadImage");
const previewImg = document.getElementById("previewImg");
const perPage = 5;

let userRole = "member"; 
let currentPage = 1;
let sortType = "newest";
let comments = [];   
let quill;
let articleData = {
  content: []
};

async function fetchArticle() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  try {
    const response = await fetch(`/article/getArticleAdmin?id=${id}`);
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

async function loadComments(page = 1){
  const response = await fetch(`/article/getComments?id=${articleId}`);
  const data = await response.json();

  // Gán lại dữ liệu mới vào biến toàn cục
  comments = data.items;

  // Render lại danh sách và phân trang
  renderComments();
  renderPagination(data.totalItems);
}

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
            ` : ''}
            <li><a class="dropdown-item delete-btn" data-id="${c.id}" href="#">Xóa</a></li>
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
      const url = new URL(window.location);
      url.searchParams.delete("comment");
      url.searchParams.set("page", i);
      window.history.pushState({}, "", url);

      loadComments(i); // gọi lại API để lấy dữ liệu mới
    });
    ul.appendChild(li);
  }
}

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
    textarea.focus();

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


});

document.addEventListener("click", e => {
  if(e.target.classList.contains("edit-btn")){
    e.preventDefault();
    const commentId = e.target.dataset.id;
    const commentDiv = document.querySelector(`[data-comment-id="${commentId}"]`);
    const textP = commentDiv.querySelector("p.mb-2");

    // thay nội dung bằng textarea
    const oldText = textP.textContent;
    textP.innerHTML = `
      <textarea class="form-control edit-textarea">${oldText}</textarea>
      <button class="btn btn-sm btn-primary save-edit" data-id="${commentId}">Lưu</button>
      <button class="btn btn-sm btn-secondary cancel-edit" data-id="${commentId}">Hủy</button>
    `;
    textP.querySelector(".edit-textarea").focus();
  }


  if(e.target.classList.contains("save-edit")){
    const commentId = e.target.dataset.id;
    const commentDiv = document.querySelector(`[data-comment-id="${commentId}"]`);
    const newText = commentDiv.querySelector(".edit-textarea").value;

    fetch("/article/editComment", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "comment_id=" + encodeURIComponent(commentId) +
            "&text=" + encodeURIComponent(newText)
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        // cập nhật lại giao diện
        commentDiv.querySelector("p.mb-2").textContent = data.comment.text;
      } else {
        alert("Không thể chỉnh sửa");
      }
    });
  }

  if(e.target.classList.contains("cancel-edit")){
    const commentId = e.target.dataset.id;
    const commentDiv = document.querySelector(`[data-comment-id="${commentId}"]`);
    const textarea = commentDiv.querySelector(".edit-textarea");
    const oldText = textarea.value;
    commentDiv.querySelector("p.mb-2").textContent = oldText;
  }
});

document.addEventListener("click", e => {
  const btn = e.target.closest(".delete-btn");
  if(btn){
    e.preventDefault();
    const commentId = btn.dataset.id;

    if(confirm("Bạn có chắc muốn xóa bình luận này?")){
      fetch("/article/deleteComment", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "comment_id=" + encodeURIComponent(commentId)
      })
      .then(res => res.json())
      .then(data => {
        if(data.success){
          loadComments(currentPage);
        } else {
          alert(data.error || "Không thể xóa bình luận");
        }
      })
      .catch(err => console.error("Fetch error:", err));
    }
  }
});

document.addEventListener("click", e=>{
  if(userRole==="guest") return; // guest không được ghi nhận
  if(e.target.closest(".like-btn")){
    const id = e.target.closest(".like-btn").dataset.id;
    const c = comments.find(x=>x.id==id);
    c.likes++;
    renderComments();
  }
  if(e.target.closest(".dislike-btn")){
    const id = e.target.closest(".dislike-btn").dataset.id;
    const c = comments.find(x=>x.id==id);
    c.dislikes++;
    renderComments();
  }
});

document.getElementById("commentForm").addEventListener("submit", e => {
  e.preventDefault();
  if(userRole === "guest") return; // guest không được gửi

  const textarea = e.target.querySelector("textarea");
  const text = textarea.value.trim();
  if(text){
    const newComment = {
      id: comments.length+1,
      user: "Bạn", // giả lập tên người dùng
      text: text,
      likes: 0,
      dislikes: 0,
      date: new Date().toISOString().split("T")[0] // yyyy-mm-dd
    };
    comments.unshift(newComment); // thêm vào đầu danh sách
    textarea.value = "";
    currentPage = 1;
    renderComments();
  }
});

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

document.addEventListener("DOMContentLoaded", fetchArticle);

document.getElementById("commentForm").addEventListener("submit", async e => {
  e.preventDefault();
  if (userRole === "guest") return;

  const textarea = e.target.querySelector("textarea");
  const text = textarea.value.trim();
  if (text) {
    try {
      const response = await fetch("/article/addComment", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `article_id=${articleId}&text=${encodeURIComponent(text)}`
      });

      const raw = await response.text();
      console.log("Raw response:", raw);
      const data = JSON.parse(raw);

      if (data.success) {
        comments.unshift(data.comment); 
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

document.getElementById("sortComments").addEventListener("change", e=>{
  sortType = e.target.value;
  currentPage = 1;
  renderComments();
});

document.getElementById("openEditor").addEventListener("click", async () => {
  const contentDiv = document.querySelector(".row.content");
  const editorSection = document.getElementById("editorSection");

  // Nếu editor đang mở thì nhấn lại sẽ tắt
  if (editorSection.style.display === "block") {
    editorSection.style.display = "none";
    contentDiv.style.display = "block";
    return; // không load lại nội dung, chỉ thoát
  }

  // Nếu editor đang tắt thì bật lên
  contentDiv.style.display = "none";
  editorSection.style.display = "block";

  if (!quill) {
    quill = new Quill('#editor', {
      modules: { syntax: true, toolbar: '#toolbar-container' },
      theme: 'snow'
    });
  }

  // Lấy id bài viết từ URL
  const urlParams = new URLSearchParams(window.location.search);
  const articleId = urlParams.get("id");

  // Gọi API lấy nội dung từ DB
  const res = await fetch("/admin/article/getContent?id=" + articleId);
  const data = await res.json();

  if(data.success){
    quill.root.innerHTML = data.content || "";
  } else {
    quill.root.innerHTML = "";
  }
});

document.getElementById("btnSave").addEventListener("click", async () => {
  if (!quill) return;
  const newContent = quill.root.innerHTML;

  const urlParams = new URLSearchParams(window.location.search);
  const articleId = urlParams.get("id");

  const res = await fetch("/admin/article/updateContent", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "content=" + encodeURIComponent(newContent) + "&id=" + articleId
  });
  const data = await res.json();

  if (data.success) {
    const contentDiv = document.querySelector(".row.content");
    contentDiv.innerHTML = newContent;
    contentDiv.style.display = "block";

    document.getElementById("editorSection").style.display = "none";

    // 🔔 Thay alert bằng notification
    showNotification("Nội dung đã lưu thành công");
  } else {
    showNotification("Lưu nội dung thất bại");
  }
});

document.getElementById("editPanelBtn").addEventListener("click", function(){
  const modal = new bootstrap.Modal(document.getElementById("editPanelModal"));
  modal.show();
});

document.getElementById("saveTitleBtn").addEventListener("click", async function(){
  const newTitle = document.getElementById("titleInput").value.trim();
  if(newTitle){
    const urlParams = new URLSearchParams(window.location.search);
    const articleId = urlParams.get("id");

    const res = await fetch("/admin/article/updateTitle", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "title=" + encodeURIComponent(newTitle) + "&id=" + articleId
    });
    const data = await res.json();
    if(data.success){
      document.getElementById("articleTitle").textContent = newTitle;
      showNotification("Tiêu đề đã được cập nhật");
    } else {
      showNotification("Cập nhật tiêu đề thất bại");
    }
  }
});

document.getElementById("saveDescriptionBtn").addEventListener("click", async function(){
  const newDescription = document.getElementById("descriptionInput").value.trim();
  if(newDescription){
    const urlParams = new URLSearchParams(window.location.search);
    const articleId = urlParams.get("id");

    const res = await fetch("/admin/article/updateDescription", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "description=" + encodeURIComponent(newDescription) + "&id=" + articleId
    });
    const data = await res.json();
    if(data.success){
      document.getElementById("articleDescription").textContent = newDescription;
      showNotification("Mô tả đã được cập nhật");
    } else {
      showNotification("Cập nhật mô tả thất bại");
    }
  }
});

document.getElementById("saveImageBtn").addEventListener("click", async function(){
  const file = document.getElementById("uploadImage").files[0];
  if(file){
    const urlParams = new URLSearchParams(window.location.search);
    const articleId = urlParams.get("id");

    const formData = new FormData();
    formData.append("image", file);
    formData.append("id", articleId);

    const res = await fetch("/admin/article/uploadBackground", {
      method: "POST",
      body: formData
    });
    const data = await res.json();

  if(data.success){
    const newUrl = `${data.url}?t=${new Date().getTime()}`;
    document.querySelector(".background_image").style.backgroundImage = `url(${newUrl})`;
    showNotification("Ảnh nền đã được cập nhật");
  } else {
    showNotification("Upload ảnh thất bại");
  }
  }
});

uploadInput.addEventListener("change", function(){
  const file = this.files[0];
  if(file){
    const reader = new FileReader();
    reader.onload = function(e){
      previewImg.src = e.target.result;   // gán ảnh base64 vào thẻ <img>
      previewImg.style.display = "block"; // hiện ảnh mini
    }
    reader.readAsDataURL(file);
  } else {
    previewImg.style.display = "none"; // nếu không chọn file thì ẩn
  }
});





