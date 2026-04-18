<?php
class ProductController extends Controller {
    
    // Hàm hiển thị trang danh sách 11 sản phẩm (Mặc định)
    public function index() {
        $data['title'] = "Sản phẩm - BK88";
        $data['currentPage'] = 'product'; 
        
        $this->view('public/product/index', $data);
    }

    // HÀM MỚI: Xử lý khi người dùng click vào xem chi tiết 1 sản phẩm
    public function detail() {
        // Lấy ID từ đường dẫn URL (ví dụ: product/detail?id=5 thì lấy số 5)
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        // Bắt lỗi: Nếu người dùng cố tình gõ link không có ID, ép quay về trang sản phẩm
        if (!$id) {
            header("Location: " . BASE_URL . "product");
            exit();
        }

        // Truyền dữ liệu sang giao diện chi tiết dưới dạng MẢNG (Array)
        $data['title'] = "Chi tiết giáo trình - BK88";
        $data['currentPage'] = 'product'; // Vẫn giữ sáng menu "SẢN PHẨM" trên Header
        $data['productId'] = $id; // Gửi ID này sang file detail.php để lọc đúng cuốn sách

        // Gọi ra file giao diện
        $this->view('public/product/detail', $data);
    }
}