<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="sales-report-area sales-style-two">
    <div class="row">
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Sản phẩm đã bán</h4>
                        <select class="custome-select border-0 pe-3">
                            <option selected="">7 ngày qua</option>
                        </select>
                    </div>
                </div>
                <canvas id="coin_sales4" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Lợi nhuận gộp</h4>
                        <select class="custome-select border-0 pe-3">
                            <option selected="">7 ngày qua</option>
                        </select>
                    </div>
                </div>
                <canvas id="coin_sales5" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Đơn đặt hàng</h4>
                        <select class="custome-select border-0 pe-3">
                            <option selected="">7 ngày qua</option>
                        </select>
                    </div>
                </div>
                <canvas id="coin_sales6" height="100"></canvas>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between">
                        <h4 class="header-title mb-0">Khách hàng mới</h4>
                        <select class="custome-select border-0 pe-3">
                            <option selected="">7 ngày qua</option>
                        </select>
                    </div>
                </div>
                <canvas id="coin_sales7" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body">
        <h4 class="header-title">Danh sách đơn hàng hôm nay</h4>
        <div class="table-responsive">
            <table class="dbkit-table">
                <tbody>
                    <tr class="heading-td">
                        <td>Tên sản phẩm</td>
                        <td>Mã đơn hàng</td>
                        <td>Trạng thái</td>
                        <td>Số điện thoại</td>
                        <td>Mã bưu điện</td>
                        <td>Thao tác</td>
                    </tr>
                    <tr>
                        <td>Giải tích 1</td>
                        <td>#894750374</td>
                        <td><span class="pending_dot">Chờ xử lý</span></td>
                        <td>0909 123 456</td>
                        <td>70000</td>
                        <td><a href="#" class="text-primary">Xem chi tiết</a></td>
                    </tr>
                    <tr>
                        <td>Triết học Mác - Lênin</td>
                        <td>#894750375</td>
                        <td><span class="shipment_dot">Đang giao</span></td>
                        <td>0912 345 678</td>
                        <td>70000</td>
                        <td><a href="#" class="text-primary">Xem chi tiết</a></td>
                    </tr>
                    <tr>
                        <td>Lập trình Web PHP</td>
                        <td>#894750376</td>
                        <td><span class="confirmed _dot">Đã xác nhận </span></td>
                        <td>0988 765 432</td>
                        <td>70000</td>
                        <td><a href="#" class="text-primary">Xem chi tiết</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination_area float-end mt-5">
            <ul>
                <li><a href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                <li><a href="#">1</a></li>
                <li><a href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row mb-5">
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="header-title mb-0">Sản phẩm bán chạy</h4>
                    <select class="custome-select border-0 pe-3">
                        <option selected="">Hôm nay</option>
                        <option value="0">7 ngày qua</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="dbkit-table">
                        <tbody>
                            <tr class="heading-td">
                                <td>Tên sản phẩm</td>
                                <td>Doanh thu</td>
                                <td>Đã bán</td>
                                <td>Giảm giá</td>
                            </tr>
                            <tr>
                                <td>Giáo trình Cấu trúc dữ liệu</td>
                                <td>3.500.000 ₫</td>
                                <td>35 cuốn</td>
                                <td>0 ₫</td>
                            </tr>
                            <tr>
                                <td>Kinh tế chính trị</td>
                                <td>1.200.000 ₫</td>
                                <td>25 cuốn</td>
                                <td>50.000 ₫</td>
                            </tr>
                            <tr>
                                <td>Đại số tuyến tính</td>
                                <td>2.800.000 ₫</td>
                                <td>40 cuốn</td>
                                <td>100.000 ₫</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>