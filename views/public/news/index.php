<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết</title>
  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css-lib/Hover/css/hover-min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css-lib/imagehover.css/css/imagehover.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/news.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap&subset=vietnamese" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
</head>
<body>
  <div class="container text-center">

    <div class="row align-items-start">
      <section class="col bg-light py-3 text-center">
        <div class="container">
          <h1 class="display-10 fw-bold mb-4">Bài viết</h1>
        </div>
      </section>
    </div>

    <!-- Thanh tìm kiếm -->
    <div class="row mb-3">
      <div class="col-12">
        <form id="searchForm" class="d-flex justify-content-center">
          <input type="text" id="searchInput" class="form-control w-50" placeholder="Tìm kiếm bài viết...">
          <button type="submit" class="btn btn-primary ms-2">Tìm</button>
        </form>
      </div>
    </div>

    <!-- Danh sách bài viết -->
    <div id="news-container" class="container text-center"></div>

    <!-- Phân trang -->
    <nav aria-label="Page navigation">
      <ul id="pagination" class="pagination justify-content-center"></ul>
    </nav>
  </div>

  <script src="<?php echo BASE_URL; ?>assets/js/news.js"></script>
</body>
</html>
