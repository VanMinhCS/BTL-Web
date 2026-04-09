// Giả lập role: "guest" hoặc "member"
let userRole = "guest"; // đổi thành "member" để thử

// Hàm xử lý giao diện theo role
function applyRolePermissions() {
  const commentForm = document.querySelector(".comments form");
  if (userRole === "guest") {
    // Guest không được nhập bình luận
    commentForm.style.display = "none";
  } else {
    commentForm.style.display = "block";
  }
}

const articleData = {
  title: "Bài viết mẫu về BK88",
  time_upload: "12/05/2025",
  content: [
    "Đây là trang bài viết của BK88. Tại đây, bạn sẽ tìm thấy những bài viết mới nhất về các chủ đề liên quan đến BK88, bao gồm tin tức, hướng dẫn, đánh giá sản phẩm và nhiều hơn nữa. Chúng tôi cam kết cung cấp thông tin chính xác và hữu ích để giúp bạn có trải nghiệm tốt nhất khi sử dụng dịch vụ của chúng tôi.",
    "Hãy thường xuyên truy cập trang này để cập nhật những bài viết mới nhất và đừng quên chia sẻ những bài viết mà bạn thấy hữu ích với bạn bè và người thân của mình. Cảm ơn bạn đã quan tâm đến BK88!"
  ],
  background: "../../assets/img/mountain.jpg" // thêm đường dẫn ảnh nền
};

// Hàm load dữ liệu vào HTML
function loadArticle() {
  // Title
  document.querySelector(".title").textContent = articleData.title;

  // Time upload
  document.querySelector(".time_upload").textContent = articleData.time_upload;

  // Content
  const contentDiv = document.querySelector(".row.content");
  contentDiv.innerHTML = ""; // xóa nội dung cũ
  articleData.content.forEach(paragraph => {
    const p = document.createElement("p");
    p.textContent = paragraph;
    contentDiv.appendChild(p);
  });

  // Background image
  const bgDiv = document.querySelector(".background_image");
  bgDiv.style.backgroundImage = `url('${articleData.background}')`;
  bgDiv.style.backgroundSize = "cover";
  bgDiv.style.backgroundPosition = "center";
}


// Gọi hàm khi trang load
document.addEventListener("DOMContentLoaded", loadArticle);

let comments = [
  {id:1, user:"Người dùng A", text:"Bài viết rất hữu ích!", likes:10, dislikes:2, date:"2025-05-12"},
  {id:2, user:"Người dùng B", text:"Mình thấy phần hướng dẫn khá rõ ràng.", likes:5, dislikes:1, date:"2025-05-11"},
  {id:3, user:"Người dùng C", text:"Thông tin khá đầy đủ.", likes:2, dislikes:0, date:"2025-05-10"},
  {id:4, user:"Người dùng D", text:"Hay lắm!", likes:8, dislikes:3, date:"2025-05-09"},
  {id:5, user:"Người dùng E", text:"Cần thêm ví dụ.", likes:1, dislikes:4, date:"2025-05-08"},
  {id:6, user:"Người dùng F", text:"Rất chi tiết.", likes:12, dislikes:0, date:"2025-05-07"},
];


const perPage = 5;
let currentPage = 1;
let sortType = "newest";

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

  // Phân trang
  const start = (currentPage - 1) * perPage;
  const pageComments = sorted.slice(start, start + perPage);

  pageComments.forEach(c => {
    const div = document.createElement("div");
    div.className = "comment mb-3 text-start border p-3 rounded";
    div.innerHTML = `
      <div class="d-flex justify-content-between">
        <p class="mb-1"><strong>${c.user}</strong></p>
        <small class="text-muted">${c.date}</small>
      </div>
      <p class="mb-2">${c.text}</p>
      <div class="d-flex gap-4 align-items-center">
        <a href="javascript:void(0)" class="like-btn ${userRole==='guest'?'disabled':''}" data-id="${c.id}" title="Like">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M2 21h4V9H2v12zm20-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32
                     c0-.41-.17-.79-.44-1.06L13.17 1 6.59 7.59C6.22 7.95 6 8.45 6 9v10
                     c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05
                     c.09-.23.14-.47.14-.73v-1z"/>
          </svg> ${c.likes}
        </a>
        <a href="javascript:void(0)" class="dislike-btn ${userRole==='guest'?'disabled':''}" data-id="${c.id}" title="Dislike">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22 3H18v12h4V3zm-6 0H7c-.83 0-1.54.5-1.84 1.22L2.14 11.27
                     c-.09.23-.14.47-.14.73v1c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32
                     c0 .41.17.79.44 1.06l1.12 1.12 6.59-6.59c.37-.36.59-.86.59-1.41V5
                     c0-1.1-.9-2-2-2z"/>
          </svg> ${c.dislikes}
        </a>
      </div>
    `;
    list.appendChild(div);
  });

  renderPagination(sorted.length);
}


function renderPagination(total) {
  const ul = document.getElementById("commentPagination");
  ul.innerHTML = "";
  const pages = Math.ceil(total/perPage);
  for(let i=1;i<=pages;i++){
    const li = document.createElement("li");
    li.className = "page-item"+(i===currentPage?" active":"");
    li.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
    li.addEventListener("click", ()=>{currentPage=i; renderComments();});
    ul.appendChild(li);
  }
}

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

// Xử lý gửi bình luận mới
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


// Sort handler
document.getElementById("sortComments").addEventListener("change", e=>{
  sortType = e.target.value;
  currentPage = 1;
  renderComments();
});

document.addEventListener("DOMContentLoaded", ()=>{
  loadArticle();
  applyRolePermissions();
  if(userRole==="member"){
    renderComments();
  }
});

// Load mặc định
renderComments();
