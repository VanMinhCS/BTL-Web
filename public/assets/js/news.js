const itemsPerPage = 6; // 3 cột × 2 hàng

const mockData = {
  totalItems: 12,
  items: [
    {image:"../assets/img/logo.png", upload_date:"12/05/2025", title:"Hello 1", description:"Mô tả bài viết 1", link:"article"},
    {image:"../assets/img/logo.png", upload_date:"13/05/2025", title:"Hello 2", description:"Mô tả bài viết 2", link:"san-pham2.html"},
    {image:"../assets/img/logo.png", upload_date:"14/05/2025", title:"Hello 3", description:"Mô tả bài viết 3", link:"san-pham3.html"},
    {image:"../assets/img/logo.png", upload_date:"15/05/2025", title:"Hello 4", description:"Mô tả bài viết 4", link:"san-pham4.html"},
    {image:"../assets/img/logo.png", upload_date:"16/05/2025", title:"Hello 5", description:"Mô tả bài viết 5", link:"san-pham5.html"},
    {image:"../assets/img/logo.png", upload_date:"17/05/2025", title:"Hello 6", description:"Mô tả bài viết 6", link:"san-pham6.html"},
    {image:"../assets/img/logo.png", upload_date:"18/05/2025", title:"Hello 7", description:"Mô tả bài viết 7", link:"san-pham7.html"},
    {image:"../assets/img/logo.png", upload_date:"19/05/2025", title:"Hello 8", description:"Mô tả bài viết 8", link:"san-pham8.html"},
    {image:"../assets/img/logo.png", upload_date:"20/05/2025", title:"Hello 9", description:"Mô tả bài viết 9", link:"san-pham9.html"},
    {image:"../assets/img/logo.png", upload_date:"21/05/2025", title:"Hello 10", description:"Mô tả bài viết 10", link:"san-pham10.html"},
    {image:"../assets/img/logo.png", upload_date:"22/05/2025", title:"Hello 11", description:"Mô tả bài viết 11", link:"san-pham11.html"},
    {image:"../assets/img/logo.png", upload_date:"23/05/2025", title:"Hello 12", description:"Mô tả bài viết 12", link:"san-pham12.html"}
  ]
};

// Hàm load bài viết theo trang
function loadNews(page = 1) {
  const start = (page - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  const data = mockData.items.slice(start, end);

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

  renderPagination(mockData.totalItems, itemsPerPage, page);
}

function renderPagination(totalItems, itemsPerPage, currentPage) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  const prevItem = document.createElement('li');
  prevItem.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
  prevItem.innerHTML = `<a class="page-link" href="#">Trước</a>`;
  prevItem.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage > 1) loadNews(currentPage - 1);
  });
  pagination.appendChild(prevItem);

  for (let i = 1; i <= totalPages; i++) {
    const pageItem = document.createElement('li');
    pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
    pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    pageItem.addEventListener('click', (e) => {
      e.preventDefault();
      loadNews(i);
    });
    pagination.appendChild(pageItem);
  }

  const nextItem = document.createElement('li');
  nextItem.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
  nextItem.innerHTML = `<a class="page-link" href="#">Sau</a>`;
  nextItem.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage < totalPages) loadNews(currentPage + 1);
  });
  pagination.appendChild(nextItem);
}

loadNews();
