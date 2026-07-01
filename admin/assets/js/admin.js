/**
 * Khodiyar Steel Industries - Admin JavaScript
 * Dark Glassmorphism Admin Panel
 */

(function ($) {
    'use strict';

    const ADMIN = {
        init: function () {
            this.sidebar();
            this.dropdown();
            this.toasts();
            this.modals();
            this.tabs();
            this.tableSearch();
            this.selectAll();
            this.confirmDelete();
            this.imagePreview();
            this.dropzone();
            this.autoHideAlerts();
            this.setupCsrf();
            this.popstate();
        },

        /* ============================================================
           SIDEBAR TOGGLE
           ============================================================ */
        sidebar: function () {
            const $sidebar = $('#sidebar');
            const $toggle = $('#sidebarToggle');
            const $close = $('#sidebarClose');
            const $overlay = $('#sidebarOverlay');

            function openSidebar() {
                $sidebar.addClass('open');
                $('body').css('overflow', 'hidden');
            }

            function closeSidebar() {
                $sidebar.removeClass('open');
                $('body').css('overflow', '');
            }

            $toggle.on('click', openSidebar);
            $close.on('click', closeSidebar);
            $overlay.on('click', closeSidebar);

            $(window).on('resize', function () {
                if ($(window).width() > 991) {
                    closeSidebar();
                }
            });

            /* Nav items with children toggle */
            $('.nav-item-has-children > .nav-link').on('click', function (e) {
                e.preventDefault();
                const $parent = $(this).parent('.nav-item-has-children');
                $parent.toggleClass('active');

                $('.nav-item-has-children').not($parent).removeClass('active');
            });
        },

        /* ============================================================
           ADMIN DROPDOWN
           ============================================================ */
        dropdown: function () {
            const $toggle = $('#adminDropdownToggle');
            const $menu = $('#adminDropdownMenu');
            const $parent = $toggle.closest('.admin-dropdown');

            $toggle.on('click', function (e) {
                e.stopPropagation();
                $parent.toggleClass('open');
            });

            $(document).on('click', function () {
                $parent.removeClass('open');
            });

            $menu.on('click', function (e) {
                e.stopPropagation();
            });
        },

        /* ============================================================
           TOAST NOTIFICATIONS
           ============================================================ */
        toasts: function () {
            const $container = $('#toastContainer');

            window.showToast = function (message, type, title) {
                type = type || 'info';
                title = title || type.charAt(0).toUpperCase() + type.slice(1);

                const icons = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    warning: 'fa-exclamation-triangle',
                    info: 'fa-info-circle'
                };

                const icon = icons[type] || icons.info;

                const $toast = $(
                    '<div class="toast ' + type + '">' +
                        '<div class="toast-icon"><i class="fas ' + icon + '"></i></div>' +
                        '<div class="toast-content">' +
                            '<div class="toast-title">' + title + '</div>' +
                            '<div class="toast-message">' + message + '</div>' +
                        '</div>' +
                        '<button class="toast-close"><i class="fas fa-times"></i></button>' +
                    '</div>'
                );

                $container.append($toast);

                $toast.find('.toast-close').on('click', function () {
                    ADMIN.removeToast($toast);
                });

                setTimeout(function () {
                    ADMIN.removeToast($toast);
                }, 5000);
            };
        },

        removeToast: function ($toast) {
            if ($toast.hasClass('removing')) return;
            $toast.addClass('removing');
            setTimeout(function () {
                $toast.remove();
            }, 300);
        },

        /* ============================================================
           MODALS
           ============================================================ */
        modals: function () {
            $(document).on('click', '[data-modal]', function () {
                const target = $(this).data('modal');
                $(target).addClass('open');
                $('body').css('overflow', 'hidden');
            });

            $(document).on('click', '.modal-overlay', function (e) {
                if ($(e.target).is('.modal-overlay')) {
                    ADMIN.closeModal($(this));
                }
            });

            $(document).on('click', '.modal-close', function () {
                ADMIN.closeModal($(this).closest('.modal-overlay'));
            });

            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    $('.modal-overlay.open').each(function () {
                        ADMIN.closeModal($(this));
                    });
                }
            });
        },

        closeModal: function ($overlay) {
            $overlay.removeClass('open');
            $('body').css('overflow', '');
        },

        /* ============================================================
           TABS
           ============================================================ */
        tabs: function () {
            $(document).on('click', '.tab-item', function () {
                const target = $(this).data('tab');
                const $parent = $(this).closest('.tabs').parent();

                $(this).closest('.tabs').find('.tab-item').removeClass('active');
                $(this).addClass('active');

                $parent.find('.tab-content').removeClass('active');
                $parent.find(target).addClass('active');
            });
        },

        /* ============================================================
           TABLE SEARCH / FILTER
           ============================================================ */
        tableSearch: function () {
            $(document).on('input', '.table-search input', function () {
                const query = $(this).val().toLowerCase().trim();
                const $table = $(this).closest('.table-container').find('table');
                const $rows = $table.find('tbody tr');

                if (!query) {
                    $rows.show();
                    return;
                }

                $rows.each(function () {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.indexOf(query) > -1);
                });
            });
        },

        /* ============================================================
           SELECT ALL CHECKBOX
           ============================================================ */
        selectAll: function () {
            $(document).on('change', '.select-all', function () {
                const isChecked = $(this).prop('checked');
                const $table = $(this).closest('table');
                $table.find('.table-checkbox:not(.select-all)').prop('checked', isChecked);
            });
        },

        /* ============================================================
           CONFIRM DELETE
           ============================================================ */
        confirmDelete: function () {
            $(document).on('click', '[data-confirm]', function (e) {
                const message = $(this).data('confirm') || 'Are you sure you want to delete this item?';
                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            });

            $(document).on('submit', '[data-confirm-form]', function (e) {
                const message = $(this).data('confirm-form') || 'Are you sure you want to proceed?';
                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            });
        },

        /* ============================================================
           IMAGE PREVIEW BEFORE UPLOAD
           ============================================================ */
        imagePreview: function () {
            $(document).on('change', '[data-preview]', function () {
                const $input = $(this);
                const $preview = $($input.data('preview'));
                const file = this.files[0];

                if (!file) {
                    $preview.html('<i class="fas fa-image placeholder-icon"></i>');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    $preview.html('<img src="' + e.target.result + '" alt="Preview">');
                };
                reader.readAsDataURL(file);
            });
        },

        /* ============================================================
           DRAG AND DROP UPLOAD ZONE
           ============================================================ */
        dropzone: function () {
            $(document).on('dragover dragenter', '.dropzone', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $(document).on('dragleave dragend', '.dropzone', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $(document).on('drop', '.dropzone', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const $zone = $(this);
                $zone.removeClass('dragover');

                const files = e.originalEvent.dataTransfer.files;
                const $fileInput = $zone.find('input[type="file"]');

                if ($fileInput.length) {
                    $fileInput.prop('files', files);
                    $fileInput.trigger('change');
                }

                /* Show preview thumbnails */
                const $preview = $zone.find('.dropzone-preview');
                if ($preview.length) {
                    $preview.empty();
                    $.each(files, function (i, file) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $preview.append(
                                    '<div class="dropzone-preview-item">' +
                                        '<img src="' + e.target.result + '" alt="Preview">' +
                                        '<button type="button" class="remove-file" data-index="' + i + '">' +
                                            '<i class="fas fa-times"></i>' +
                                        '</button>' +
                                    '</div>'
                                );
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });

            $(document).on('click', '.remove-file', function () {
                const $item = $(this).closest('.dropzone-preview-item');
                $item.remove();

                const $zone = $(this).closest('.dropzone');
                const $fileInput = $zone.find('input[type="file"]');
                if ($fileInput.length) {
                    $fileInput.val('');
                }
            });
        },

        /* ============================================================
           AUTO-HIDE ALERTS
           ============================================================ */
        autoHideAlerts: function () {
            $('.alert:not(.alert-permanent)').each(function () {
                const $alert = $(this);
                setTimeout(function () {
                    $alert.fadeOut(300, function () {
                        $(this).remove();
                    });
                }, 5000);
            });

            $(document).on('click', '.alert-close', function () {
                $(this).closest('.alert').fadeOut(300, function () {
                    $(this).remove();
                });
            });
        },

        /* ============================================================
           CSRF PROTECTION FOR AJAX/FETCH
           ============================================================ */
        setupCsrf: function () {
            function getCSRFToken() {
                const $meta = $('meta[name="csrf-token"]');
                if ($meta.length) {
                    return $meta.attr('content');
                }
                return '';
            }

            /* Attach CSRF token to all AJAX requests */
            $(document).on('ajaxSend', function (event, jqXHR, settings) {
                const token = getCSRFToken();
                if (token && settings.type && settings.type.toUpperCase() !== 'GET') {
                    /* If FormData, append token */
                    if (settings.processData === false && settings.contentType === false) {
                        /* Let the request handle it via the form if needed */
                    } else if (typeof settings.data === 'string') {
                        settings.data += '&csrf_token=' + encodeURIComponent(token);
                    }
                }
            });

            /* Intercept fetch to add CSRF header */
            const originalFetch = window.fetch;
            window.fetch = function (url, options) {
                options = options || {};
                options.credentials = options.credentials || 'same-origin';

                if (options.method && options.method.toUpperCase() !== 'GET') {
                    const token = getCSRFToken();
                    if (token) {
                        options.headers = options.headers || {};
                        if (Array.isArray(options.headers)) {
                            options.headers.push(['X-CSRF-Token', token]);
                        } else if (options.headers instanceof Headers) {
                            options.headers.set('X-CSRF-Token', token);
                        } else {
                            options.headers['X-CSRF-Token'] = token;
                        }
                    }
                }

                return originalFetch.call(window, url, options);
            };
        },

        /* ============================================================
           POPSTATE - Close sidebar on back
           ============================================================ */
        popstate: function () {
            $(window).on('popstate', function () {
                $('#sidebar').removeClass('open');
                $('body').css('overflow', '');
            });
        }
    };

    /* Initialize on DOM ready */
    $(function () {
        ADMIN.init();
    });

})(jQuery);
