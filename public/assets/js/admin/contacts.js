(function () {
    var wrapper = document.getElementById('contactsTableWrapper');
    var toggleBtn = document.getElementById('toggleSelectBtn');
    var bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    var selectAll = document.getElementById('selectAll');
    var statusFilter = document.getElementById('statusFilter');
    var sortOrder = document.getElementById('sortOrder');
    var form = document.getElementById('bulkDeleteForm');
    var checkboxes = wrapper ? wrapper.querySelectorAll('.row-checkbox') : [];

    if (!wrapper || !toggleBtn || !bulkDeleteBtn || !form) {
        return;
    }

    function setSelectionMode(enabled) {
        if (enabled) {
            wrapper.classList.add('selection-mode');
            toggleBtn.textContent = 'Hủy';
        } else {
            wrapper.classList.remove('selection-mode');
            toggleBtn.textContent = 'Chọn';
            if (selectAll) {
                selectAll.checked = false;
            }
            checkboxes.forEach(function (cb) {
                cb.checked = false;
            });
        }
    }

    function updateQuery(params) {
        var url = new URL(window.location.href);
        Object.keys(params).forEach(function (key) {
            url.searchParams.set(key, params[key]);
        });
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    }

    toggleBtn.addEventListener('click', function () {
        setSelectionMode(!wrapper.classList.contains('selection-mode'));
    });

    if (statusFilter) {
        statusFilter.addEventListener('change', function () {
            updateQuery({
                status: statusFilter.value,
                sort: sortOrder ? sortOrder.value : 'newest'
            });
        });
    }

    if (sortOrder) {
        sortOrder.addEventListener('change', function () {
            updateQuery({
                status: statusFilter ? statusFilter.value : 'all',
                sort: sortOrder.value
            });
        });
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', function () {
            if (!selectAll) {
                return;
            }
            var allChecked = true;
            checkboxes.forEach(function (item) {
                if (!item.checked) {
                    allChecked = false;
                }
            });
            selectAll.checked = allChecked;
        });
    });

    var markReadButtons = wrapper.querySelectorAll('.js-mark-read');

    markReadButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            var url = new URL(button.getAttribute('href'), window.location.origin);
            url.searchParams.set('ajax', '1');

            button.disabled = true;

            fetch(url.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (!data || !data.success) {
                        throw new Error('Mark read failed');
                    }

                    var row = button.closest('tr');
                    if (row) {
                        row.style.backgroundColor = '';
                        row.style.fontWeight = '';
                        row.setAttribute('data-status', '1');
                    }

                    var badge = row ? row.querySelector('.row-actions .badge') : null;
                    if (badge) {
                        badge.classList.remove('badge-danger');
                        badge.classList.add('badge-success');
                        badge.textContent = 'Đã đọc';
                    }

                    button.remove();

                    if (statusFilter && statusFilter.value === 'unread') {
                        row.style.display = 'none';
                    }
                })
                .catch(function () {
                    button.disabled = false;
                    alert('Không thể đánh dấu đã đọc. Vui lòng thử lại.');
                });
        });
    });

    bulkDeleteBtn.addEventListener('click', function () {
        var selected = Array.prototype.filter.call(checkboxes, function (cb) {
            return cb.checked;
        });

        if (selected.length === 0) {
            alert('Vui lòng chọn liên hệ để xóa.');
            return;
        }

        var hasUnread = selected.some(function (cb) {
            var row = cb.closest('tr');
            return row && row.getAttribute('data-status') === '0';
        });

        var message = hasUnread
            ? 'Có liên hệ chưa đọc, xác nhận xóa?'
            : 'Xác nhận xóa các liên hệ đã chọn?';

        if (confirm(message)) {
            form.submit();
        }
    });

})();
