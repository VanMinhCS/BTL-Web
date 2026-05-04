
</div> </div> <footer>
            <div class="footer-area">
                <p>© Copyright 2026. All right reserved. Developed by <a href="<?php echo BASE_URL; ?>">BK88 Team</a>.</p>
            </div>
        </footer>
        </div>
        <div class="offset-area">
            <div class="offset-close"><i class="ti-close"></i></div>
            <div class="offset-content tab-content">
                <div id="settings" class="tab-pane fade active show">
                    <div class="offset-settings">
                        <h4>General Settings</h4>
                        <div class="settings-list">
                            <!-- Nút chính -->
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Thông báo</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-main">
                                        <label for="switch-main">Bật/Tắt</label>
                                    </div>
                                </div>
                                <p>Bật để nhận tất cả thông báo.</p>
                            </div>

                            <!-- Các nút con -->
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Bình luận</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-comment" disabled>
                                        <label for="switch-comment">Nhận thông báo bình luận</label>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Phản hồi</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-reply" disabled>
                                        <label for="switch-reply">Nhận thông báo phản hồi</label>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Chỉnh sửa</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-edit" disabled>
                                        <label for="switch-edit">Nhận thông báo chỉnh sửa</label>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Bình chọn</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-vote" disabled>
                                        <label for="switch-vote">Nhận thông báo bình chọn</label>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Đơn hàng</h5>
                                    <div class="s-swtich">
                                        <input type="checkbox" id="switch-order" disabled>
                                        <label for="switch-order">Nhận thông báo đơn hàng</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/swiper-bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/metismenujs.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
    <script src="https://code.highcharts.com/12.5.0/highcharts.js"></script>
    <script src="https://cdn.zingchart.com/2.9.16-1/zingchart.min.js"></script>
    <script>
        if (typeof zingchart !== "undefined") {
            zingchart.MODULESDIR = "https://cdn.zingchart.com/2.9.16-1/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        }
    </script>

    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/line-chart.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/bar-chart.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/pie-chart.js"></script>
    
    <script src="<?php echo BASE_URL; ?>assets/srtdash-admin-dashboard/srtdash/assets/js/scripts.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/admin/header.js"></script>

</body>

</html>