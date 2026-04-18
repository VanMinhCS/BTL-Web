<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết</title>

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/public/article.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap&subset=vietnamese" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
</head>
<body>


<div class="row text-start">
  <div class="background_image d-flex flex-column justify-content-center">
    <p class="time_upload me-5">12/05/2025</p>
    <p class="title pt-0">Bài viết</p>
  </div> 
</div>

<div class="container justify-content-start ">
    <div class="row content ">
      <p>Đây là trang bài viết của BK88. Tại đây, bạn sẽ tìm thấy những bài viết mới nhất về các chủ đề liên quan đến BK88, bao gồm tin tức, hướng dẫn, đánh giá sản phẩm và nhiều hơn nữa. Chúng tôi cam kết cung cấp thông tin chính xác và hữu ích để giúp bạn có trải nghiệm tốt nhất khi sử dụng dịch vụ của chúng tôi.</p>
      <p>Hãy thường xuyên truy cập trang này để cập nhật những bài viết mới nhất và đừng quên chia sẻ những bài viết mà bạn thấy hữu ích với bạn bè và người thân của mình. Cảm ơn bạn đã quan tâm đến BK88!</p>
    </div>

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


      <div id="commentList">
      </div>


      <nav aria-label="Comment pagination" class="mt-3">
        <ul class="pagination justify-content-center" id="commentPagination">

        </ul>
      </nav>
    </div>
  </div>

  <div class="social-icons d-flex gap-3 justify-content-center pb-5">
      <a href="javascript:void(0)" class="social-icon" title="Facebook">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
          </svg>
      </a>
      <a href="javascript:void(0)" class="social-icon" title="Twitter/X">
          <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
          </svg>
      </a>
      <a href="javascript:void(0)" class="social-icon" title="Instagram">
          <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
          </svg>
      </a>
  </div>
  
    <div class="row post_navigation text-center">
      <div class="col-4 text-center">
        <a href="#" class="hvr-icon">&lt; Bài viết cũ nhất</a> 
      </div>
      <div class="col-4 text-center">
      <a href="<?php echo BASE_URL; ?>news" class="hvr-icon">Tin tức</a>
        
      </div>
      <div class="col-4 text-center">
          <a href="#" class="hvr-icon">Bài viết mới nhất &gt;</a>
        </div>
  </div>
</div>
  <script src="<?php echo BASE_URL; ?>assets/js/public/article.js"></script>
</body>
</html>
