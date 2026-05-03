function loadNotifications(){
    fetch("/admin/notification/getNotifications")
    .then(res => res.json())
    .then(data => {
        if(data.success){
            // Hiển thị số thông báo chưa đọc trên chuông
            const bellCount = document.querySelector(".ti-bell span");
            if (bellCount) {
                bellCount.textContent = data.count > 99 ? "+99" : data.count;
            }

            // Tiêu đề dropdown
            const notifyTitle = document.querySelector(".notify-title");
            if (notifyTitle) {
                notifyTitle.innerHTML = data.count > 0
                    ? `Bạn có ${data.count} thông báo mới <a href="/admin/notification">xem tất cả</a>`
                    : `Bạn không có thông báo mới <a href="/admin/notification">xem tất cả</a>`;

                const markAllLink = notifyTitle.querySelector("a");
                if (markAllLink) {
                    markAllLink.addEventListener("click", function(e){
                        e.preventDefault();
                        fetch("/admin/notification/markAllRead", { method: "POST" })
                            .then(() => loadNotifications());
                    });
                }
            }

            // Danh sách dropdown
            const list = document.querySelector(".notify-list");
            if (list) {
                list.innerHTML = "";
                data.notifications.forEach(n => {
                    const item = document.createElement("a");

                    if (n.id_article && n.id_comment) {
                        item.href = `/article?id=${n.id_article}&comment=${n.id_comment}`;
                    } else if (n.id_article) {
                        item.href = `/article?id=${n.id_article}`;
                    } else {
                        item.href = "#";
                    }

                    item.className = "notify-item";
                    item.dataset.id = n.id;
                    item.innerHTML = `
                        <div class="notify-thumb"><i class="ti-info bg-info"></i></div>
                        <div class="notify-text">
                            <p>${n.message}</p>
                            <span>${n.created_at}</span>
                        </div>`;
                    
                    item.addEventListener("click", function(e){
                        e.preventDefault();
                        fetch("/admin/news/markRead", {   // API markRead cho từng thông báo
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: "id=" + this.dataset.id
                        }).then(() => {
                            window.location.href = this.href;
                        });
                    });
                    list.appendChild(item);
                });

                // Nếu có nhiều hơn 3 thông báo, thêm link "Xem tất cả"
                if (data.count > 3) {
                    const more = document.createElement("a");
                    more.href = "/admin/notification";
                    more.className = "notify-item text-center fw-bold";
                    more.textContent = "Xem tất cả thông báo";
                    list.appendChild(more);
                }
            }

            const readAllBtn = document.getElementById("readAllBtn");
            if (readAllBtn) {
                readAllBtn.onclick = () => {
                    fetch("/admin/notification/markAllRead", { method: "POST" })
                        .then(() => loadNotifications());
                };
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
  const markAllLink = document.querySelector(".notify-title a");
  if (markAllLink) {
    markAllLink.addEventListener("click", function(e){
      e.preventDefault();
      fetch("/admin/notification/markAllRead", { method: "POST" })
        .then(() => loadNotifications());
    });
  }
});

document.addEventListener("DOMContentLoaded", function(){
    loadNotifications(); // chạy ngay khi load trang
    setInterval(loadNotifications, 1000); // polling mỗi 1 phút
});

document.addEventListener("DOMContentLoaded", function(){
    const mainSwitch = document.getElementById("switch-main");
    const subSwitches = {
        comment: document.getElementById("switch-comment"),
        reply: document.getElementById("switch-reply"),
        edit: document.getElementById("switch-edit"),
        vote: document.getElementById("switch-vote")
    };

    // Load settings từ DB
    fetch("/admin/news/getNotificationSettings")
    .then(res => res.json())
    .then(data => {
        if(data.success){
            mainSwitch.checked = data.is_enabled == 1;
            subSwitches.comment.checked = data.enable_comment == 1;
            subSwitches.reply.checked   = data.enable_reply == 1;
            subSwitches.edit.checked    = data.enable_edit == 1;
            subSwitches.vote.checked    = data.enable_vote == 1;

            // nếu nút chính tắt thì disable các nút con
            Object.values(subSwitches).forEach(sw => sw.disabled = !mainSwitch.checked);
        }
    });

    // Khi bật/tắt nút chính
    mainSwitch.addEventListener("change", function(){
        const enabled = this.checked;
        Object.values(subSwitches).forEach(sw => sw.disabled = !enabled);
        saveSettings();
    });

    // Khi bật/tắt nút con
    Object.values(subSwitches).forEach(sw => {
        sw.addEventListener("change", saveSettings);
    });

    function saveSettings(){
        const data = new URLSearchParams();
        data.append("enable_notifications", mainSwitch.checked ? 1 : 0);
        data.append("enable_comment", subSwitches.comment.checked ? 1 : 0);
        data.append("enable_reply", subSwitches.reply.checked ? 1 : 0);
        data.append("enable_edit", subSwitches.edit.checked ? 1 : 0);
        data.append("enable_vote", subSwitches.vote.checked ? 1 : 0);

        fetch("/admin/news/updateNotificationSettings", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: data.toString()
        });
    }
});

