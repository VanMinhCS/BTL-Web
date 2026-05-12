document.querySelectorAll('.btn-reply').forEach(btn => {
    btn.onclick = function() {
        document.getElementById('display-q').innerText = this.dataset.q;
        document.getElementById('admin-answer').value = this.dataset.a;
        document.getElementById('faq-id').value = this.dataset.id;
        document.getElementById('public-status').checked = (this.dataset.status == 1);
        
        new bootstrap.Modal(document.getElementById('replyModal')).show();
    };
});


document.getElementById('save-reply').onclick = function() {
    const id = document.getElementById('faq-id').value;
    const answer = document.getElementById('admin-answer').value;
    const status = document.getElementById('public-status').checked ? 1 : 0;

    fetch('<?php echo BASE_URL; ?>admin/faq/reply', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&answer=${encodeURIComponent(answer)}&status=${status}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) location.reload();
    });
};