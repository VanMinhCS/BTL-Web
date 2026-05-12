(function () {
    'use strict';

    var alertBox = document.querySelector('[data-info-alert]');
    var alertTimer = null;

    function showAlert(message, type) {
        if (!alertBox) {
            return;
        }
        var cssType = type || 'success';
        alertBox.className = 'alert alert-' + cssType;
        alertBox.textContent = message;
        alertBox.classList.remove('d-none');

        if (alertTimer) {
            clearTimeout(alertTimer);
        }
        alertTimer = setTimeout(function () {
            alertBox.classList.add('d-none');
        }, 3000);
    }

    function requestJson(url, options) {
        var opts = options || {};
        opts.headers = opts.headers || {};
        opts.headers['X-Requested-With'] = 'XMLHttpRequest';
        return fetch(url, opts).then(function (response) {
            return response.json().catch(function () {
                return { success: false, message: 'Invalid server response.' };
            });
        });
    }

    function escapeHtml(value) {
        var text = String(value == null ? '' : value);
        return text.replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[char];
        });
    }

    function formatMultiline(value) {
        return escapeHtml(value).replace(/\n/g, '<br>');
    }

    function formatBadge(isActive) {
        if (Number(isActive) === 1) {
            return '<span class="badge badge-success" style="background-color: #28a745; color: #ffffff;">Hiện</span>';
        }
        return '<span class="badge badge-secondary" style="background-color: #6c757d; color: #ffffff;">Ẩn</span>';
    }

    function formatPrice(value) {
        var number = Number(value) || 0;
        return number.toLocaleString('vi-VN') + '₫';
    }

    function toggleCancel(button, show) {
        if (!button) {
            return;
        }
        if (show) {
            button.classList.remove('d-none');
        } else {
            button.classList.add('d-none');
        }
    }

    function handleResponse(promise, onSuccess) {
        promise.then(function (payload) {
            if (!payload || payload.success !== true) {
                showAlert((payload && payload.message) || 'Request failed.', 'warning');
                return;
            }
            onSuccess(payload.data || {});
            if (payload.message) {
                showAlert(payload.message, 'success');
            }
        }).catch(function () {
            showAlert('Network error. Please try again.', 'danger');
        });
    }

    function initSectionForms() {
        var sectionForms = document.querySelectorAll('[data-section-form]');
        if (!sectionForms.length) {
            return;
        }
        sectionForms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var formData = new FormData(form);
                handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function () {});
            });
        });
    }

    function initQuoteSection() {
        var form = document.querySelector('[data-quote-form]');
        var tableBody = document.querySelector('[data-quote-table]');
        if (!form || !tableBody) {
            return;
        }

        var idInput = form.querySelector('[data-quote-id]');
        var textInput = form.querySelector('[data-quote-text]');
        var authorInput = form.querySelector('[data-quote-author]');
        var sortInput = form.querySelector('[data-quote-sort-order]');
        var activeInput = form.querySelector('[data-quote-active]');
        var imageInput = form.querySelector('[data-quote-image]');
        var currentImage = form.querySelector('[data-quote-current-image]');
        var submitBtn = form.querySelector('[data-quote-submit]');
        var cancelBtn = form.querySelector('[data-quote-cancel]');

        function resetForm() {
            form.reset();
            if (idInput) {
                idInput.value = '0';
            }
            if (submitBtn) {
                submitBtn.textContent = 'Thêm mới';
            }
            toggleCancel(cancelBtn, false);
            if (currentImage) {
                currentImage.textContent = '';
                currentImage.classList.add('d-none');
            }
            if (imageInput) {
                imageInput.value = '';
            }
        }

        function renderTable(quotes) {
            var editBase = tableBody.dataset.editBase || '';
            var deleteBase = tableBody.dataset.deleteBase || '';
            if (!quotes || quotes.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Chưa có trích dẫn nào...</td></tr>';
                return;
            }

            var rows = quotes.map(function (quote, index) {
                var quoteText = escapeHtml(quote.quote_text || '');
                var author = escapeHtml(quote.author || '');
                var image = escapeHtml(quote.image || '');
                var sortOrder = escapeHtml(quote.sort_order || 0);
                var isActive = Number(quote.is_active || 0);
                return '' +
                    '<tr data-quote-id="' + quote.id + '"' +
                    ' data-quote-text="' + quoteText + '"' +
                    ' data-quote-author="' + author + '"' +
                    ' data-quote-image="' + image + '"' +
                    ' data-quote-sort-order="' + sortOrder + '"' +
                    ' data-quote-active="' + isActive + '">' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + quoteText + '</td>' +
                    '<td>' + author + '</td>' +
                    '<td>' + image + '</td>' +
                    '<td>' + sortOrder + '</td>' +
                    '<td>' + formatBadge(isActive) + '</td>' +
                    '<td><div class="d-flex gap-2 justify-content-center">' +
                    '<a href="' + editBase + quote.id + '" class="btn btn-sm btn-info" data-action="edit-quote">Sửa</a>' +
                    '<a href="' + deleteBase + quote.id + '" class="btn btn-sm btn-danger" data-action="delete-quote">Xóa</a>' +
                    '</div></td>' +
                    '</tr>';
            }).join('');
            tableBody.innerHTML = rows;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(form);
            handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function (data) {
                renderTable(data.quotes || []);
                resetForm();
            });
        });

        tableBody.addEventListener('click', function (event) {
            var editBtn = event.target.closest('[data-action="edit-quote"]');
            var deleteBtn = event.target.closest('[data-action="delete-quote"]');
            if (editBtn) {
                event.preventDefault();
                var row = editBtn.closest('tr');
                if (!row) {
                    return;
                }
                if (idInput) {
                    idInput.value = row.dataset.quoteId || '0';
                }
                if (textInput) {
                    textInput.value = row.dataset.quoteText || '';
                }
                if (authorInput) {
                    authorInput.value = row.dataset.quoteAuthor || '';
                }
                if (sortInput) {
                    sortInput.value = row.dataset.quoteSortOrder || 0;
                }
                if (activeInput) {
                    activeInput.checked = String(row.dataset.quoteActive) === '1';
                }
                if (submitBtn) {
                    submitBtn.textContent = 'Cập nhật';
                }
                toggleCancel(cancelBtn, true);
                if (currentImage) {
                    var image = row.dataset.quoteImage || '';
                    if (image) {
                        currentImage.textContent = 'Ảnh hiện tại: ' + image;
                        currentImage.classList.remove('d-none');
                    } else {
                        currentImage.textContent = '';
                        currentImage.classList.add('d-none');
                    }
                }
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            if (deleteBtn) {
                event.preventDefault();
                if (!confirm('Xóa trích dẫn này?')) {
                    return;
                }
                var deleteUrl = deleteBtn.getAttribute('href');
                handleResponse(requestJson(deleteUrl, { method: 'GET' }), function (data) {
                    renderTable(data.quotes || []);
                    resetForm();
                });
            }
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (event) {
                event.preventDefault();
                resetForm();
            });
        }
    }

    function initReasonSection() {
        var form = document.querySelector('[data-reason-form]');
        var tableBody = document.querySelector('[data-reason-table]');
        if (!form || !tableBody) {
            return;
        }

        var idInput = form.querySelector('[data-reason-id]');
        var titleInput = form.querySelector('[data-reason-title]');
        var descInput = form.querySelector('[data-reason-description]');
        var sortInput = form.querySelector('[data-reason-sort-order]');
        var activeInput = form.querySelector('[data-reason-active]');
        var submitBtn = form.querySelector('[data-reason-submit]');
        var cancelBtn = form.querySelector('[data-reason-cancel]');

        function resetForm() {
            form.reset();
            if (idInput) {
                idInput.value = '0';
            }
            if (submitBtn) {
                submitBtn.textContent = 'Thêm mới';
            }
            toggleCancel(cancelBtn, false);
        }

        function renderTable(reasons) {
            var editBase = tableBody.dataset.editBase || '';
            var deleteBase = tableBody.dataset.deleteBase || '';
            if (!reasons || reasons.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Chưa có lý do nào...</td></tr>';
                return;
            }

            var rows = reasons.map(function (reason, index) {
                var title = escapeHtml(reason.title || '');
                var description = escapeHtml(reason.description || '');
                var sortOrder = escapeHtml(reason.sort_order || 0);
                var isActive = Number(reason.is_active || 0);
                return '' +
                    '<tr data-reason-id="' + reason.id + '"' +
                    ' data-reason-title="' + title + '"' +
                    ' data-reason-description="' + description + '"' +
                    ' data-reason-sort-order="' + sortOrder + '"' +
                    ' data-reason-active="' + isActive + '">' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + title + '</td>' +
                    '<td>' + description + '</td>' +
                    '<td>' + sortOrder + '</td>' +
                    '<td>' + formatBadge(isActive) + '</td>' +
                    '<td><div class="d-flex gap-2 justify-content-center">' +
                    '<a href="' + editBase + reason.id + '" class="btn btn-sm btn-info" data-action="edit-reason">Sửa</a>' +
                    '<a href="' + deleteBase + reason.id + '" class="btn btn-sm btn-danger" data-action="delete-reason">Xóa</a>' +
                    '</div></td>' +
                    '</tr>';
            }).join('');
            tableBody.innerHTML = rows;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(form);
            handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function (data) {
                renderTable(data.reasons || []);
                resetForm();
            });
        });

        tableBody.addEventListener('click', function (event) {
            var editBtn = event.target.closest('[data-action="edit-reason"]');
            var deleteBtn = event.target.closest('[data-action="delete-reason"]');
            if (editBtn) {
                event.preventDefault();
                var row = editBtn.closest('tr');
                if (!row) {
                    return;
                }
                if (idInput) {
                    idInput.value = row.dataset.reasonId || '0';
                }
                if (titleInput) {
                    titleInput.value = row.dataset.reasonTitle || '';
                }
                if (descInput) {
                    descInput.value = row.dataset.reasonDescription || '';
                }
                if (sortInput) {
                    sortInput.value = row.dataset.reasonSortOrder || 0;
                }
                if (activeInput) {
                    activeInput.checked = String(row.dataset.reasonActive) === '1';
                }
                if (submitBtn) {
                    submitBtn.textContent = 'Cập nhật';
                }
                toggleCancel(cancelBtn, true);
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            if (deleteBtn) {
                event.preventDefault();
                if (!confirm('Xóa lý do này?')) {
                    return;
                }
                var deleteUrl = deleteBtn.getAttribute('href');
                handleResponse(requestJson(deleteUrl, { method: 'GET' }), function (data) {
                    renderTable(data.reasons || []);
                    resetForm();
                });
            }
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (event) {
                event.preventDefault();
                resetForm();
            });
        }
    }

    function initProductSection() {
        var form = document.querySelector('[data-product-form]');
        var tableBody = document.querySelector('[data-product-table]');
        if (!form || !tableBody) {
            return;
        }

        var idInput = form.querySelector('[data-product-id]');
        var itemSelect = form.querySelector('[data-product-item]');
        var sortInput = form.querySelector('[data-product-sort-order]');
        var activeInput = form.querySelector('[data-product-active]');
        var submitBtn = form.querySelector('[data-product-submit]');
        var cancelBtn = form.querySelector('[data-product-cancel]');

        function resetForm() {
            form.reset();
            if (idInput) {
                idInput.value = '0';
            }
            if (submitBtn) {
                submitBtn.textContent = 'Thêm mới';
            }
            toggleCancel(cancelBtn, false);
        }

        function renderTable(products) {
            var editBase = tableBody.dataset.editBase || '';
            var deleteBase = tableBody.dataset.deleteBase || '';
            if (!products || products.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Chưa có sản phẩm tiêu biểu nào...</td></tr>';
                return;
            }

            var rows = products.map(function (product, index) {
                var itemName = escapeHtml(product.item_name || '');
                var price = formatPrice(product.price || 0);
                var stock = escapeHtml(product.item_stock || 0);
                var sortOrder = escapeHtml(product.sort_order || 0);
                var isActive = Number(product.is_active || 0);
                return '' +
                    '<tr data-product-id="' + product.id + '"' +
                    ' data-product-item-id="' + product.item_id + '"' +
                    ' data-product-sort-order="' + sortOrder + '"' +
                    ' data-product-active="' + isActive + '">' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + itemName + '</td>' +
                    '<td>' + price + '</td>' +
                    '<td>' + stock + '</td>' +
                    '<td>' + sortOrder + '</td>' +
                    '<td>' + formatBadge(isActive) + '</td>' +
                    '<td><div class="d-flex gap-2 justify-content-center">' +
                    '<a href="' + editBase + product.id + '" class="btn btn-sm btn-info" data-action="edit-product">Sửa</a>' +
                    '<a href="' + deleteBase + product.id + '" class="btn btn-sm btn-danger" data-action="delete-product">Xóa</a>' +
                    '</div></td>' +
                    '</tr>';
            }).join('');
            tableBody.innerHTML = rows;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(form);
            handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function (data) {
                renderTable(data.featuredProducts || []);
                resetForm();
            });
        });

        tableBody.addEventListener('click', function (event) {
            var editBtn = event.target.closest('[data-action="edit-product"]');
            var deleteBtn = event.target.closest('[data-action="delete-product"]');
            if (editBtn) {
                event.preventDefault();
                var row = editBtn.closest('tr');
                if (!row) {
                    return;
                }
                if (idInput) {
                    idInput.value = row.dataset.productId || '0';
                }
                if (itemSelect) {
                    itemSelect.value = row.dataset.productItemId || '';
                }
                if (sortInput) {
                    sortInput.value = row.dataset.productSortOrder || 0;
                }
                if (activeInput) {
                    activeInput.checked = String(row.dataset.productActive) === '1';
                }
                if (submitBtn) {
                    submitBtn.textContent = 'Cập nhật';
                }
                toggleCancel(cancelBtn, true);
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            if (deleteBtn) {
                event.preventDefault();
                if (!confirm('Xóa sản phẩm này khỏi danh sách?')) {
                    return;
                }
                var deleteUrl = deleteBtn.getAttribute('href');
                handleResponse(requestJson(deleteUrl, { method: 'GET' }), function (data) {
                    renderTable(data.featuredProducts || []);
                    resetForm();
                });
            }
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (event) {
                event.preventDefault();
                resetForm();
            });
        }
    }

    function initContactSection() {
        var form = document.querySelector('[data-contact-form]');
        var tableBody = document.querySelector('[data-contact-table]');
        if (!form || !tableBody) {
            return;
        }

        var idInput = form.querySelector('[data-contact-id]');
        var labelInput = form.querySelector('[data-contact-label]');
        var valueInput = form.querySelector('[data-contact-value]');
        var iconInput = form.querySelector('[data-contact-icon]');
        var sortInput = form.querySelector('[data-contact-sort-order]');
        var activeInput = form.querySelector('[data-contact-active]');
        var submitBtn = form.querySelector('[data-contact-submit]');
        var cancelBtn = form.querySelector('[data-contact-cancel]');

        function resetForm() {
            form.reset();
            if (idInput) {
                idInput.value = '0';
            }
            if (submitBtn) {
                submitBtn.textContent = 'Thêm mới';
            }
            toggleCancel(cancelBtn, false);
        }

        function renderTable(fields) {
            var editBase = tableBody.dataset.editBase || '';
            var deleteBase = tableBody.dataset.deleteBase || '';
            if (!fields || fields.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Chưa có thông tin nào...</td></tr>';
                return;
            }

            var rows = fields.map(function (field, index) {
                var label = escapeHtml(field.label || '');
                var value = escapeHtml(field.value || '');
                var icon = escapeHtml(field.icon || '');
                var sortOrder = escapeHtml(field.sort_order || 0);
                var isActive = Number(field.is_active || 0);
                return '' +
                    '<tr data-contact-id="' + field.id + '"' +
                    ' data-contact-label="' + label + '"' +
                    ' data-contact-value="' + value + '"' +
                    ' data-contact-icon="' + icon + '"' +
                    ' data-contact-sort-order="' + sortOrder + '"' +
                    ' data-contact-active="' + isActive + '">' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + label + '</td>' +
                    '<td>' + formatMultiline(field.value || '') + '</td>' +
                    '<td>' + icon + '</td>' +
                    '<td>' + sortOrder + '</td>' +
                    '<td>' + formatBadge(isActive) + '</td>' +
                    '<td><div class="d-flex gap-2 justify-content-center">' +
                    '<a href="' + editBase + field.id + '" class="btn btn-sm btn-info" data-action="edit-contact">Sửa</a>' +
                    '<a href="' + deleteBase + field.id + '" class="btn btn-sm btn-danger" data-action="delete-contact">Xóa</a>' +
                    '</div></td>' +
                    '</tr>';
            }).join('');
            tableBody.innerHTML = rows;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(form);
            handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function (data) {
                renderTable(data.fields || []);
                resetForm();
            });
        });

        tableBody.addEventListener('click', function (event) {
            var editBtn = event.target.closest('[data-action="edit-contact"]');
            var deleteBtn = event.target.closest('[data-action="delete-contact"]');
            if (editBtn) {
                event.preventDefault();
                var row = editBtn.closest('tr');
                if (!row) {
                    return;
                }
                if (idInput) {
                    idInput.value = row.dataset.contactId || '0';
                }
                if (labelInput) {
                    labelInput.value = row.dataset.contactLabel || '';
                }
                if (valueInput) {
                    valueInput.value = row.dataset.contactValue || '';
                }
                if (iconInput) {
                    iconInput.value = row.dataset.contactIcon || '';
                }
                if (sortInput) {
                    sortInput.value = row.dataset.contactSortOrder || 0;
                }
                if (activeInput) {
                    activeInput.checked = String(row.dataset.contactActive) === '1';
                }
                if (submitBtn) {
                    submitBtn.textContent = 'Cập nhật';
                }
                toggleCancel(cancelBtn, true);
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            if (deleteBtn) {
                event.preventDefault();
                if (!confirm('Xóa thông tin này?')) {
                    return;
                }
                var deleteUrl = deleteBtn.getAttribute('href');
                handleResponse(requestJson(deleteUrl, { method: 'GET' }), function (data) {
                    renderTable(data.fields || []);
                    resetForm();
                });
            }
        });

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (event) {
                event.preventDefault();
                resetForm();
            });
        }
    }

    function initLogoSection() {
        var form = document.querySelector('[data-logo-form]');
        if (!form) {
            return;
        }

        var input = form.querySelector('[data-logo-input]');
        var preview = form.querySelector('[data-logo-preview]');
        var nameLabel = form.querySelector('[data-logo-name]');
        var basePath = preview ? (preview.dataset.logoBase || '') : '';

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            if (input && input.files && input.files.length === 0) {
                showAlert('Vui lòng chọn ảnh logo.', 'warning');
                return;
            }
            var formData = new FormData(form);
            handleResponse(requestJson(form.action, { method: 'POST', body: formData }), function (data) {
                if (data.siteLogo) {
                    if (preview) {
                        preview.src = basePath + data.siteLogo + '?t=' + Date.now();
                    }
                    if (nameLabel) {
                        nameLabel.textContent = 'Ảnh hiện tại: ' + data.siteLogo;
                    }
                }
                if (input) {
                    input.value = '';
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSectionForms();
        initQuoteSection();
        initReasonSection();
        initProductSection();
        initContactSection();
        initLogoSection();
    });
})();
