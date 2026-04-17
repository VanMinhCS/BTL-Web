const itemsPerPage = 6; // số bài mỗi trang
let newsData = { totalItems: 0, items: [] };

async function fetchNews() {
  try {
    const response = await fetch('/news/getNews'); // đường dẫn tới API PHP
    newsData = await response.json();
    loadNews();
  } catch (error) {
    console.error("Lỗi khi tải dữ liệu news:", error);
  }
}

// Hàm load bài viết theo trang
function loadNews(page = 1) {
  const start = (page - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  const data = newsData.items.slice(start, end);

  const container = document.getElementById('news-container');
  container.innerHTML = '';

  for (let i = 0; i < data.length; i += 3) {
    const row = document.createElement('div');
    row.className = 'row align-items-start mb-4';

    data.slice(i, i + 3).forEach(item => {
      const col = document.createElement('div');
      col.className = 'col';

      col.innerHTML = `
        <a href="${item.link}" class="link-dark link-underline-none">
          <figure class="imghvr-fade">
            <img src="${item.image}" alt="${item.title}" class="img-fluid">
            <figcaption>
              <p class="description">${item.description}</p>
              <h2 class="imghvr-float-up">Xem thêm</h2>
            </figcaption>
          </figure>
          <p class="time_upload mb-0">${item.upload_date}</p>
          <p class="title">${item.title}</p>
        </a>
      `;
      row.appendChild(col);
    });

    container.appendChild(row);
  }

  renderPagination(newsData.totalItems, itemsPerPage, page);
}

// Hàm render phân trang
function renderPagination(totalItems, itemsPerPage, currentPage, callback = loadNews) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  const prevItem = document.createElement('li');
  prevItem.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
  prevItem.innerHTML = `<a class="page-link" href="#">Trước</a>`;
  prevItem.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage > 1) callback(currentPage - 1);
  });
  pagination.appendChild(prevItem);

  for (let i = 1; i <= totalPages; i++) {
    const pageItem = document.createElement('li');
    pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    pageItem.addEventListener('click', (e) => {
      e.preventDefault();
      callback(i);
    });
    pagination.appendChild(pageItem);
  }

  const nextItem = document.createElement('li');
  nextItem.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
  nextItem.innerHTML = `<a class="page-link" href="#">Sau</a>`;
  nextItem.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage < totalPages) callback(currentPage + 1);
  });
  pagination.appendChild(nextItem);
}

// Hàm tìm kiếm bài viết
function searchNews(keyword) {
  const filteredItems = newsData.items.filter(item =>
    item.title.toLowerCase().includes(keyword.toLowerCase()) ||
    item.description.toLowerCase().includes(keyword.toLowerCase())
  );

  const totalItems = filteredItems.length;

  function loadFilteredNews(page = 1) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const data = filteredItems.slice(start, end);

    const container = document.getElementById('news-container');
    container.innerHTML = '';

    for (let i = 0; i < data.length; i += 3) {
      const row = document.createElement('div');
      row.className = 'row align-items-start mb-4';

      data.slice(i, i + 3).forEach(item => {
        const col = document.createElement('div');
        col.className = 'col';

        col.innerHTML = `
          <a href="${item.link}" class="link-dark link-underline-none">
            <figure class="imghvr-fade">
              <img src="${item.image}" alt="${item.title}" class="img-fluid">
              <figcaption>
                <p class="description">${item.description}</p>
                <h2 class="imghvr-float-up">Xem thêm</h2>
              </figcaption>
            </figure>
            <p class="time_upload mb-0">${item.upload_date}</p>
            <p class="title">${item.title}</p>
          </a>
        `;
        row.appendChild(col);
      });

      container.appendChild(row);
    }

    renderPagination(totalItems, itemsPerPage, page, loadFilteredNews);
  }

  loadFilteredNews();
}

// Gắn sự kiện cho form tìm kiếm
document.getElementById('searchForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const keyword = document.getElementById('searchInput').value.trim();
  if (keyword) {
    searchNews(keyword);
  } else {
    loadNews(); // nếu không nhập gì thì load lại toàn bộ
  }
});

// Bắt đầu fetch dữ liệu từ API
fetchNews();
