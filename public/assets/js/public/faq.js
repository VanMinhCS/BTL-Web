document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả các thẻ chứa câu hỏi
    const questions = document.querySelectorAll('.q-text');
    
    questions.forEach(question => {
        question.addEventListener('click', function() {
            // Lấy thẻ câu trả lời ngay bên dưới câu hỏi đó
            const answer = this.nextElementSibling;
            // Lấy icon mũi tên để xoay
            const icon = this.querySelector('.toggle-icon');
            
            // Kiểm tra xem câu trả lời này đang mở hay đóng
            const isOpen = answer.style.display === 'block';

            // 1. (Tùy chọn) Đóng TẤT CẢ các câu trả lời khác lại cho gọn
            document.querySelectorAll('.a-text').forEach(a => {
                a.style.display = 'none';
            });
            document.querySelectorAll('.toggle-icon').forEach(i => {
                i.style.transform = 'rotate(0deg)';
            });

            // 2. Nếu nó đang đóng, thì mở nó ra và xoay mũi tên lên
            if (!isOpen) {
                answer.style.display = 'block';
                // Thêm animation xổ xuống nhẹ nhàng
                answer.animate([
                    { opacity: 0, transform: 'translateY(-10px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ], { duration: 200, fill: 'forwards' });
                
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});