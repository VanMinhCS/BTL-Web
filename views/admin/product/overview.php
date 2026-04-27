<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="sales-report-area sales-style-two">
    <div class="row">
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Tổng doanh thu</h4>
                        <div class="dropdown">
                            <button id="btn-revenue" class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">24 Giờ Qua</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('revenue', '24h', '24 Giờ Qua')">24 Giờ Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('revenue', '3d', '3 Ngày Qua')">3 Ngày Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('revenue', '7d', '7 Ngày Qua')">7 Ngày Qua</a>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?> ₫</h2>
                </div>
                <div style="position: relative; height: 100px; width: 100%;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report border-left-primary">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Lợi nhuận gộp</h4>
                        <div class="dropdown">
                            <button id="btn-profit" class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">24 Giờ Qua</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('profit', '24h', '24 Giờ Qua')">24 Giờ Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('profit', '3d', '3 Ngày Qua')">3 Ngày Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('profit', '7d', '7 Ngày Qua')">7 Ngày Qua</a>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3"><?php echo number_format($stats['gross_profit'], 0, ',', '.'); ?> ₫</h2>
                </div>
                <div style="position: relative; height: 100px; width: 100%;">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Sản phẩm đã bán</h4>
                        <div class="dropdown">
                            <button id="btn-sold" class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">24 Giờ Qua</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('sold', '24h', '24 Giờ Qua')">24 Giờ Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('sold', '3d', '3 Ngày Qua')">3 Ngày Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('sold', '7d', '7 Ngày Qua')">7 Ngày Qua</a>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3"><?php echo number_format($stats['total_sold'], 0, ',', '.'); ?> cuốn</h2>
                </div>
                <div style="position: relative; height: 100px; width: 100%;">
                    <canvas id="soldChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
            <div class="single-report">
                <div class="s-sale-inner pt--30 mb-3">
                    <div class="s-report-title d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Tổng đơn hàng</h4>
                        <div class="dropdown">
                            <button id="btn-orders" class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">24 Giờ Qua</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('orders', '24h', '24 Giờ Qua')">24 Giờ Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('orders', '3d', '3 Ngày Qua')">3 Ngày Qua</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="updateChart('orders', '7d', '7 Ngày Qua')">7 Ngày Qua</a>
                            </div>
                        </div>
                    </div>
                    <h2 class="mt-3"><?php echo $stats['total_orders']; ?> đơn</h2>
                </div>
                <div style="position: relative; height: 100px; width: 100%;">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-body">
        <h4 class="header-title">Danh sách đơn hàng gần đây</h4>
        <div class="table-responsive">
            <table class="dbkit-table">
                <tbody>
                    <tr class="heading-td">
                        <td>Mã Đơn</td>
                        <td>Ngày đặt</td>
                        <td>Trạng thái</td>
                        <td>Thanh toán</td>
                        <td>Thao tác</td>
                    </tr>
                    <?php if (!empty($recentOrders)): ?>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $order['order_id']; ?></td>
                            <td><?php echo date('H:i - d/m/Y', strtotime($order['order_date'])); ?></td>
                            <td>
                                <?php if($order['status'] == 0): ?>
                                    <span class="pending_dot">Chờ xử lý</span>
                                <?php elseif($order['status'] == 1): ?>
                                    <span class="shipment_dot">Đang giao</span>
                                <?php else: ?>
                                    <span class="confirmed _dot">Đã hoàn thành</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $order['is_paid'] ? '<span class="text-success fw-bold">Đã thanh toán</span>' : '<span class="text-danger fw-bold">Chưa thanh toán</span>'; ?>
                            </td>
                            <td><a href="<?php echo BASE_URL; ?>admin/product/order" class="text-primary">Xem chi tiết</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Chưa có đơn hàng nào!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-5 mb-5">
    <div class="card-body">
        <h4 class="header-title">Top 5 Sản phẩm bán chạy nhất</h4>
        <div class="table-responsive">
            <table class="dbkit-table">
                <tbody>
                    <tr class="heading-td">
                        <td>Tên giáo trình</td>
                        <td>Số lượng đã bán</td>
                        <td>Doanh thu mang về</td>
                        <td>Hành động</td>
                    </tr>
                    <?php foreach ($topSelling as $row): ?>
                    <tr>
                        <td class="fw-bold"><?php echo $row['item_name']; ?></td>
                        <td><span class="badge bg-info px-3"><?php echo $row['sold_qty']; ?> cuốn</span></td>
                        <td class="text-danger fw-bold"><?php echo number_format($row['revenue'], 0, ',', '.'); ?> ₫</td>
                        <td><a href="<?php echo BASE_URL; ?>admin/product" class="btn btn-xs btn-outline-primary">Xem kho</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let charts = {};

function updateChart(type, range, labelText = null) {
    
    // Nếu có truyền tên nhãn mới thì cập nhật lại text cho cái nút bấm
    if (labelText) {
        let btn = document.getElementById('btn-' + type);
        if (btn) btn.innerText = labelText;
    }

    fetch(`<?php echo BASE_URL; ?>admin/product/getChartData?type=${type}&range=${range}`)
        .then(res => res.json())
        .then(data => {
            const canvasId = type + 'Chart';
            const ctx = document.getElementById(canvasId).getContext('2d');
            
            if (charts[type]) { charts[type].destroy(); }

            const colors = {
                'revenue': '#8914fe', 
                'profit': '#0d6efd',  
                'sold': '#28a745',    
                'orders': '#ffc107'   
            };

            charts[type] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: colors[type],
                        borderRadius: 3
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { display: false },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 10 }, color: '#999' }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Lỗi khi tải dữ liệu biểu đồ:', error));
}

// Khởi chạy mặc định
document.addEventListener('DOMContentLoaded', () => {
    updateChart('revenue', '24h');
    updateChart('profit', '24h');
    updateChart('sold', '24h');
    updateChart('orders', '24h');
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>