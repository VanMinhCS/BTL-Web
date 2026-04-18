<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết</title>

  <!-- CSS riêng -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/article.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap&subset=vietnamese" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">  
  <!-- Quill -->
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
  <!-- Highlight.js -->

  <!-- KaTeX -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
</head>
<body>


<!-- Header -->
<div class="row text-start">
  <div class="col background_image d-flex flex-column justify-content-center">
    <p class="row time_upload me-5">12/05/2025</p>
    <div class="row">
      <div class="row justify-content-end">
        <!-- Nút chỉnh sửa title -->
        <div class="fw-icons col-lg-3 col-sm-6 d-flex">
          <a href="javascript:void(0)" id="editTitleBtn" class="btn">
            <i class="fa-solid fa-pen-to-square"></i>
          </a>
        </div>
      </div>
      <!-- Title -->
      <p class="col title pt-0" id="articleTitle">Bài viết</p>
      <!-- Ô nhập title (ẩn mặc định) -->
      <div class="col" id="titleEditorSection" style="display:none;">
        <input type="text" id="titleInput" class="form-control mb-2" />
        <button id="saveTitleBtn" class="btn btn-success btn-sm">
          <i class="fa-solid fa-save"></i> Lưu tiêu đề
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Nút mở Quill -->
<div class="row justify-content-end mt-4">
  <div class="fw-icons col-lg-3 col-sm-6 d-flex ">
    <a href="javascript:void(0)" id="openEditor" class="btn btn-light">
      <i class="fa-solid fa-pen-to-square fa-2x"></i>
    </a>
  </div>
</div>

<div class="container justify-content-start">
  <!-- Nội dung -->
  <div class="row content">
    <p>Đây là trang bài viết của BK88...</p>
    <p>Hãy thường xuyên truy cập trang này...</p>
  </div>



  <!-- Toolbar + Editor (ẩn mặc định) -->
  <div id="editorSection" style="display:none;">
    <div id="toolbar-container">
      <!-- Định dạng văn bản -->
      <span class="ql-formats">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
      </span>
      <span class="ql-formats">
        <select class="ql-size"></select>
        <select class="ql-color"></select>
        <select class="ql-background"></select>
      </span>
      <span class="ql-formats">
        <select class="ql-align"></select>
      </span>

      <!-- Cấu trúc nội dung -->
      <span class="ql-formats">
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
        <button class="ql-list" value="check"></button>
      </span>
      <span class="ql-formats">
        <button class="ql-link"></button>
        <button class="ql-image"></button>
        <button class="ql-video"></button>
      </span>
      <span class="ql-formats">
        <button class="ql-script" value="sub"></button>
        <button class="ql-script" value="super"></button>
      </span>
      <span class="ql-formats">
        <button class="ql-clean"></button>
      </span>
    </div>

    <div id="editor" style="height:300px;"></div>
    <button id="btnSave" class="btn btn-success mt-3">
      <i class="fa-solid fa-save"></i> Lưu nội dung
    </button>
  </div>

  <!-- Bình luận -->
  <div class="row comments mt-4">
    <div class="col-12">
      <h5 class="mb-3">Bình luận</h5>
      <form class="mb-4" id="commentForm">
        <div class="mb-3">
          <textarea class="form-control form_area" rows="3" placeholder="Viết bình luận..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
      </form>
      <div class="mb-3 text-end">
        <select id="sortComments" class="form-select w-auto d-inline-block">
          <option value="newest" selected>Mới nhất</option>
          <option value="popular">Nổi bật nhất</option>
        </select>
      </div>
      <div id="commentList"></div>
      <nav aria-label="Comment pagination" class="mt-3">
        <ul class="pagination justify-content-center" id="commentPagination"></ul>
      </nav>
    </div>
  </div>

  <!-- Social icons -->
  <div class="social-icons d-flex gap-3 justify-content-center pb-5">
    <a href="#" class="social-icon" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
    <a href="#" class="social-icon" title="Twitter"><i class="fa-brands fa-twitter"></i></a>
    <a href="#" class="social-icon" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/article.js"></script>
</body>
</html>
