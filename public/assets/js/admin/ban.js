// Bọc toàn bộ code trong sự kiện DOMContentLoaded để đảm bảo HTML đã load xong mới chạy JS
document.addEventListener('DOMContentLoaded', function() {
    let currentUserId = null;
    let currentStatus = null;
    let confirmModal = null; 

    document.querySelectorAll('.btn-ban').forEach(btn => {
        btn.onclick = function() {
            currentUserId = this.dataset.id;
            currentStatus = this.dataset.status;
            
            const actionText = currentStatus == 1 ? "KHÓA" : "MỞ KHÓA";
            const confirmBtn = document.getElementById('btn-confirm-action');
            
            document.getElementById('confirmBanMessage').innerHTML = `Bạn có chắc chắn muốn <strong class="${currentStatus == 1 ? 'text-danger' : 'text-success'}">${actionText}</strong> tài khoản này không?`;
            
            if (currentStatus == 1) {
                confirmBtn.className = "btn btn-danger px-4";
            } else {
                confirmBtn.className = "btn btn-success px-4";
            }

            if (!confirmModal) {
                confirmModal = new bootstrap.Modal(document.getElementById('confirmBanModal'));
            }
            confirmModal.show();
        };
    });

    document.getElementById('btn-confirm-action').onclick = function() {
        const originalText = this.innerText;
        this.innerText = "Đang xử lý...";
        this.disabled = true;

        fetch(APP_BASE_URL + 'admin/user/toggleBan', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_id=${currentUserId}&status=${currentStatus}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload(); 
            } else {
                alert(data.message || "Có lỗi xảy ra!");
                this.innerText = originalText;
                this.disabled = false;
            }
        })
        .catch(err => {
            console.error("Lỗi:", err);
            alert("Lỗi kết nối máy chủ.");
            this.innerText = originalText;
            this.disabled = false;
        });
    };
});