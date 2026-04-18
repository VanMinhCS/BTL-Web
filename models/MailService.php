<?php
// Nhúng 3 file "xương sống" của PHPMailer mà bạn vừa copy vào
require_once __DIR__ . '/../libs/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer.php';
require_once __DIR__ . '/../libs/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    public static function sendOTP($toEmail, $otpCode) {
        $mail = new PHPMailer(true);

        try {
            // 1. Cấu hình Server "Bưu điện" (Google SMTP)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;             
            
            // THAY BẰNG EMAIL VÀ MẬT KHẨU ỨNG DỤNG CỦA BẠN VÀO ĐÂY:
            $mail->Username   = 'hongocanhtuan2004@gmail.com'; 
            $mail->Password   = 'aydc vbog kurx fhqt'; // 16 chữ cái bạn vừa tạo
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465; // Cổng bảo mật của Google
            $mail->CharSet    = 'UTF-8'; // Hỗ trợ tiếng Việt có dấu

            // 2. Thông tin người gửi & người nhận
            $mail->setFrom('email_cua_ban@gmail.com', 'Hệ thống BK88');
            $mail->addAddress($toEmail); // Email của khách hàng

            // 3. Nội dung Email
            $mail->isHTML(true);
            $mail->Subject = 'Mã Xác thực OTP - Đăng ký tài khoản BK88';
            
            // Thiết kế giao diện email cơ bản cho đẹp mắt
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                    <div style='max-width: 500px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
                        <h2 style='color: #0d6efd;'>Chào mừng đến với BK88!</h2>
                        <p>Vui lòng sử dụng mã OTP dưới đây để xác thực email/lấy lại mật khẩu:</p>
                        <h1 style='font-size: 40px; color: #dc3545; letter-spacing: 5px; margin: 20px 0;'>{$otpCode}</h1>
                        <p style='color: #666; font-size: 14px;'>Mã này sẽ hết hạn sau <b>5 phút</b>. Vui lòng không chia sẻ mã này cho bất kỳ ai.</p>
                    </div>
                </div>
            ";

            // 4. Bấm nút Gửi
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Nếu lỗi (như sai mật khẩu), in ra để debug
            error_log("Lỗi gửi mail: {$mail->ErrorInfo}");
            return false;
        }
    }
}
?>