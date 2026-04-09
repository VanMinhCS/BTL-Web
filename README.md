# Ý tưởng của btl sẽ là code chung giao diện cho guest và member, sử dụng php để ẩn hiện các nút cần thiết (đăng nhập, đăng xuất,...), admin code riêng. Các thư mục chính được setup theo hệ thống MVC.

## Để làm tốt thì hãy tìm hiểu về OOP của PHP
## Sẽ không sử dụng các file .html như truyền thống mà sử dụng file .php + code html, phải làm vậy thì khi bỏ vô xampp mới chạy được
## Trong config của xampp, web root trỏ vào thư mục ./public
## Nhớ đọc file README trong từng folder

# Ông nào siêng thì sau này sửa lại file README này cho đẹp :))

NOTE để đồng bộ quá trình làm: Đưa phần source vào xampp/htdocs. Sau khi đưa source code vào thì vào cái folder apache/conf/httpd.conf rồi kéo xuống dòng 252 và 253 sửa cái đường dẫn thành C:/xampp/htdocs. Sau khi chạy XAMPP control panel thì để chạy web thì paste http://localhost/đường_dẫn_đến_source_code/abcxyz.php
