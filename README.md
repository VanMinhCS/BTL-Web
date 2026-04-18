# Ý tưởng của btl sẽ là code chung giao diện cho guest và member, sử dụng php để ẩn hiện các nút cần thiết (đăng nhập, đăng xuất,...), admin code riêng. Các thư mục chính được setup theo hệ thống MVC.

## Để làm tốt thì hãy tìm hiểu về OOP của PHP
## Sẽ không sử dụng các file .html như truyền thống mà sử dụng file .php + code html, phải làm vậy thì khi bỏ vô xampp mới chạy được
## Trong config của xampp, web root trỏ vào thư mục ./public (kh
## Nhớ đọc file README trong từng folder

# Ông nào siêng thì sau này sửa lại file README này cho đẹp :))

NOTE để đồng bộ quá trình làm: Đưa phần source vào xampp/htdocs. Sau khi đưa source code vào thì vào cái folder apache/conf/httpd.conf rồi kéo xuống dòng 252 và 253 sửa cái đường dẫn thành đường dẫn đến folder source code rồi thêm /public phía sau.


Đoạn mã clear toàn bộ dữ liệu trong bk88 SQL (vẫn giữ items):
-- 1. Tắt kiểm tra khóa ngoại
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Dùng DELETE để xóa sạch dữ liệu (An toàn tuyệt đối)
DELETE FROM `order_details`;
DELETE FROM `orders`;
DELETE FROM `otp`;
DELETE FROM `information`;
DELETE FROM `addresses`;
DELETE FROM `users`;

-- 3. Ép số đếm ID (Auto Increment) quay ngược về 1
ALTER TABLE `order_details` AUTO_INCREMENT = 1;
ALTER TABLE `orders` AUTO_INCREMENT = 1;
ALTER TABLE `otp` AUTO_INCREMENT = 1;
ALTER TABLE `information` AUTO_INCREMENT = 1;
ALTER TABLE `addresses` AUTO_INCREMENT = 1;
ALTER TABLE `users` AUTO_INCREMENT = 1;

-- 4. Bật lại kiểm tra khóa ngoại (BẮT BUỘC)
SET FOREIGN_KEY_CHECKS = 1;