"use strict";
class MainJS {
    constructor() {
        this.ajaxHandler = new AjaxHandler();  
        this.currentUrl = window.location.href;  
        this.init(); 
    }

    init() {
        this.bindEvents(); 
    }

    bindEvents() {
        $(document).on("submit", ".actionForm", this.handleFormSubmit.bind(this));
    }

    handleFormSubmit(e) {
        if ($(e.currentTarget).valid()) { 
            e.preventDefault(); 
            const form = $(e.currentTarget);
            const formData = form.serialize();
            this.ajaxHandler.set_options_from_dom(e.currentTarget);  
            this.ajaxHandler.send_request(form.attr('action'), formData);
        } else {
            console.log('Form is not valid');
        }  
    }
}

$(function () {
    new MainJS();
});



function Admin() {
    var self = this;
    this.init = function () {
        self.ScriptLicense();
        // self.Item();
        // self.Users();
        // self.FileManager();
        self.Services();
        self.Providers();
        self.Item();
        self.Items();
        if ($(".sortable-content").length > 0) {
            self.sortItems();
        }
        if ($(".navbar-side").length > 0) {
            self.searchArea();
            self.common();
        }
    };

    this.Providers = function () {
        // Update balance
        $(document).on("click", ".ajaxUpdateApiProvider", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                url = element.attr("href"),
                redirect_url = element.data("redirect"),
                data = $.param({});
                data = check_csrf_token(data);
            callPostAjax(element, url, data, '');
        })
    }

    //Items
    this.Items = function () {
        $(document).on("click", ".ajaxActionOptions", function () {
            event.preventDefault();
            var element = $(this),
                type = element.data("type");
            var task_type = type;
            if ((type == 'delete' || type == 'all_deactive' || type == 'clear_all' || type == 'empty')) {
                if (!confirm_notice('deleteItems')) {
                    return;
                }
            }
            var url = element.attr("href");
            var selected_ids = [];
            $(".check-item:checked").each(function () {
                selected_ids.push($(this).val());
            });
            if (selected_ids.length <= 0 && type != 'empty') {
                alert("Please choose at least one item");
                return;
            }
            var array_type_copy_clipboard = ['copy_id', 'copy_order_id', 'copy_api_refill_id', 'copy_api_order_id', 'copy_api_order_id'];
            if (array_type_copy_clipboard.includes(task_type) === true) {
                task_type = 'copy-to-clipboard';
            }
            var data = {
                ids: selected_ids.join(","),
                type: type,
                current_url: window.location.href
            };
            pageOverlay.show();
            callPostAjax(element, url, data, task_type);
        })

        // callback ajaxChange Sort By
        $(document).on("change", ".ajaxSortBy", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                id = element.val();

            if (id == "") {
                pageOverlay.hide();
                return false;
            }
            var pathname = element.data("url") + "?" + "sort_by=" + id;
            window.location.href = pathname;
        })
    }

    // Item
    this.Item = function () {

        const card_header_title = $('.massAction .card-title');
        const card_header_btn_actions = $('.massAction .btnActions');
        const btn_actions_dropdown_menu = $('.massAction .btnActions .action-options .dropdown-menu');
        const check_items = $(".check-item");  // Các checkbox
        const number_items_selected = $('.btnActions .number-items-selected');

        const setItemsSecletedText = () => {
            const selectedCount = check_items.filter(':checked').length;

            if (selectedCount > 0) {
             card_header_title.addClass('d-none');
                card_header_btn_actions.removeClass('d-none');
                btn_actions_dropdown_menu.removeClass('dropdown-menu-right').addClass('dropdown-menu-left');
                number_items_selected.html(`${selectedCount} items selected`); 
            } else {
             card_header_title.removeClass('d-none');
                card_header_btn_actions.addClass('d-none');
                btn_actions_dropdown_menu.removeClass('dropdown-menu-left').addClass('dropdown-menu-right');
                number_items_selected.html(''); 
            }
        };

        // Check item
        $(document).on('click', '.check-item', setItemsSecletedText);

        // Check all items
        $(document).on('click', '.check-all', function () {
            const element = $(this);
            const check_name = element.data('name');

            $(`.${check_name}`).prop('checked', this.checked);

            if (element.is(":checked")) {
                setItemsSecletedText(); 
            } else {
             card_header_title.removeClass('d-none');
                card_header_btn_actions.addClass('d-none');
            }
        });

        // Category | Services collapse
        $(document).on("click", ".btn-services-collapse", function () {
            const element = $(this);
            const items_by_category_area = $(".items-by-category .card");
            if (items_by_category_area.hasClass('card-collapsed')) {
                element.html('<span class="fe fe-chevrons-up"></span> Hide All');
                items_by_category_area.removeClass('card-collapsed');
            } else {
                element.html('<span class="fe fe-chevrons-down"></span> Show All');
                items_by_category_area.addClass('card-collapsed');
            }
        })

        // ajaxToggleItemStatus
        $(document).on("click", ".ajaxToggleItemStatus", function () {
            const element = $(this);
            const id = element.data('id');
            const url = element.data('action');
            let status = 0;
            if (element.is(":checked")) status = 1;
            const data = $.param({ status: status, id: id });
            callPostAjax(element, url, data, 'status');
        });

        // callback Delete item
        $(document).on("click", ".ajaxDeleteItem", function () {
            event.preventDefault();
            pageOverlay.show();
            var element = $(this),
                confirm_message = element.data('confirm_ms');
            if (!confirm_notice(confirm_message)) {
                return;
            }
            var url = element.attr("href"),
                data = $.param({});
            callPostAjax(element, url, data, 'delete-item');
        });

        // callback Duplicate item
        $(document).on("click", ".ajaxDuplicateItem", function () {
            event.preventDefault();
            pageOverlay.show();
            var element = $(this);
            var url = element.attr("href"),
                data = $.param({});
            callPostAjax(element, url, data, 'duplicate-item');
        });

    }

    // Search Area
    this.searchArea = function () {
        // search area
        var btnSearch = ".search-area button.btn-search",
            btnClear = ".search-area button.btn-clear",
            searchArea = $(".search-area"),
            inputSearchQuery = $(".search-area input[name = query]");

        // Click Search
        $(document).on('click', btnSearch, function () {
            searchResult();
        });

        // Enter key
        inputSearchQuery.on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                searchResult();
            }
        });

        // Click Btn Clear Option
        $(document).on('click', btnClear, function () {
            var pathname = window.location.pathname; //Get pathname
            window.location.href = pathname;
        });

        function searchResult() {
            var pathname = window.location.pathname; //Get pathname
            var searchParams = new URLSearchParams(window.location.search);
            var params = ['status'],
                link = '';
            $.each(params, function (key, value) {
                if (searchParams.has(value)) {
                    link += value + "=" + searchParams.get(value) + "&"
                }
            });
            var pathlink = pathname + "?" + link + "query=" + inputSearchQuery.val();
            if (searchArea.find('option:selected').length > 0) {
                pathlink = pathlink + "&field=" + searchArea.find('option:selected').val();
            }
            window.location.href = pathlink;
        }
    }

    this.common = function () {

        
        // btn-general-slug link
        $('.btn-general-slug').on('click', function (event) {
            event.preventDefault();
            var nameValue = $('input[name="name"]').val();

            var url_slug = create_slug(nameValue);
            var url_input = $('input[name="url_slug"]');
            var feedback_div = url_input.closest('.input-group').find('.invalid-feedback');
            if (url_slug.length < 3) {
                feedback_div.show();
                feedback_div.text('The permalink must be at least 3 characters long.');
                url_input.addClass('is-invalid');
            } else {
                feedback_div.hide();
                feedback_div.text('');
                url_input.removeClass('is-invalid');
                url_input.val(url_slug);
            }
        });

        // Upload Image
        $(document).on('click', '.btnUploadImage', function () {
            var target_input = $(this).closest('.input-group').find('input');
            getPathMediaByelFinderBrowser($(this), target_input);
        });

        // Scroll Menu
        const ps1 = new PerfectScrollbar('.navbar-side .scroll-bar', {
            wheelSpeed: 1,
            wheelPropagation: true,
            minScrollbarLength: 10,
            suppressScrollX: true
        });

        $(document).on("click", ".mobile-menu", function () {
            var _that = $(".navbar.navbar-side");
            if (_that.hasClass('navbar-folded')) {
                _that.removeClass('navbar-folded');
            }
            _that.toggleClass("active");
        });

        // ajaxModal
        $(document).on("click", ".ajaxModal", function () {
            var element = $(this);
            var url = element.attr("href");
            $('#modal-ajax').load(url, function () {
                $('#modal-ajax').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-ajax').modal('show');
                $('[data-toggle="popover"]').popover({
                    html: true, 
                });
                $('[data-toggle="tooltip"]').tooltip();
            });
            return false;
        });

        const ajaxHandler = new AjaxHandler();
        $(document).on("submit", ".actionForm1", function (e) {
            e.preventDefault();
            if ($(this).valid()) {
                const formData = $(this).serialize();
                ajaxHandler.set_options_from_dom(this);
                ajaxHandler.prepare_overlay(this);
                ajaxHandler.send_request($(this).attr('action'), formData);
            } else {
                console.log('Form is not valid');
            }
        });


    }

    // Sort items by Sort-table - plugin
    this.sortItems = function () {
        //for category
        $(".sortable-content tbody").sortable({
            handle: '.sort-handler',
            update: function (event, ui) {
                var array = [];
                $(this).find('tr').each(function (i) {
                    $(this).attr('data-sort', i + 1);
                    var params = {};
                    params['id'] = $(this).attr('data-id');
                    params['sort'] = $(this).attr('data-sort');
                    array.push(params);
                });
                var _url = $(".sortable-content table").data('sort_table_url');
                var data = {
                    action: 'sort_table',
                    items: array
                };
                callPostAjax($(this), _url, data, 'sort-table');
            }
        });
    }


    this.Services = function () {
        // Check post type
        var pathGetProviderServicesURL = PATH + '/providers/services/';
        /*----------  Get Services list from API  ----------*/
        $(document).on("change", ".ajaxGetServicesFromAPI", function () {
            event.preventDefault();
            $('.provider-services-list').removeClass('d-none');
            $('.provider-services-list .dimmer').addClass('active');
            var element = $(this),
                id = element.val();
            if (id == "" || id == 0) return;
            var URL = pathGetProviderServicesURL + id;
            var data = $.param({ api_id: id });
            data = check_csrf_token(data);
            $.post(URL, data, function (_result) {
                setTimeout(function () {
                    $(".crud-service-form input[name=api_provider_price]").val('');
                    $(".crud-service-form input[name=api_service_type]").val('');
                    $(".crud-service-form input[name=api_service_dripfeed]").val('');
                    $(".crud-service-form input[name=api_service_refill]").val('');
                    $(".crud-service-form input[name=api_service_id]").val('');
                    $('.provider-services-list .dimmer').removeClass('active');
                    $(".provider-services-list select").html(_result);
                }, 100);
            });
        })

        // Select Provider Service
        $(document).on("change", ".ajaxGetServiceDetail", function () {
            $(".crud-service-form input[name=api_provider_price]").val('');
            $(".crud-service-form input[name=min]").val('');
            $(".crud-service-form input[name=max]").val('');
            var element = $('option:selected', this),
                _name = element.attr('data-name'),
                _min = element.attr('data-min'),
                _max = element.attr("data-max"),
                _rate = element.attr("data-rate"),
                _type = element.attr("data-type"),
                _dripfeed = element.attr("data-dripfeed"),
                _refill = element.attr("data-refill");
            $(".crud-service-form input[name=api_provider_price]").val(_rate);
            $(".crud-service-form input[name=api_service_type]").val(_type);
            $(".crud-service-form input[name=api_service_dripfeed]").val(_dripfeed);
            $(".crud-service-form input[name=api_service_refill]").val(_refill);

            // Refill Option
            $(".refill-type-option").html('<option value="0"> Manual </option>');
            $("#refill-option").prop('checked', false);
            $("#refill-from").removeClass('show');
            if (_refill == 1) {
                $(".refill-type-option").append('<option value="1"> Provider </option>');
            }
            $(".crud-service-form input[name=min]").val(_min);
            $(".crud-service-form input[name=max]").val(_max);
            // $(".crud-service-form input[name=price]").val(_rate);
        })
    }

    this.ScriptLicense = function () {
        $(document).on("click", ".ajaxUpgradeVersion", function () {
            pageOverlay.show();
            event.preventDefault();
            var element = $(this),
                url = element.attr("href");
            var data = {
                action: 'upgrade',
                purchase_code: element.attr('data-purchase_code'),
            };
            callPostAjax(element, url, data, '');
        })
    }

}

Admin = new Admin();
$(function () {
    Admin.init();
});



/*----------  Configure tinymce editor  ----------*/
function plugin_editor(selector, settings) {
    if ($(selector).length === 0) {
        return;
    }
    // if (tinymce.get(selector)) {
    //     return;
    // }
    selector = typeof (selector) == 'undefined' ? '.tinymce' : selector;
    var is_hidden_editor = $(selector).hasClass('d-none');
    
    var _settings = {
        selector: selector,
        theme: "modern",
        branding: false,
        paste_data_images: true,
        relative_urls: false,
        convert_urls: false,
        inline_styles: true,
        verify_html: false,
        cleanup: false,
        autoresize_bottom_margin: 25,
        plugins: [
            "advlist autolink lists link charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "undo redo formatselect | fontselect fontsizeselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | print preview emoticons | pagebreak",
        style_formats: [
            { title: 'Heading 2', format: 'h2' },
            { title: 'Heading 3', format: 'h3' },
            { title: 'Heading 4', format: 'h4' },
            { title: 'Heading 5', format: 'h5' },
            { title: 'Heading 6', format: 'h6' },
            { title: 'Normal', block: 'div' }
        ],
        file_browser_callback: elFinderBrowser,
        setup: function(editor) {
            editor.on('init', function() {
                if (is_hidden_editor) {
                    $('.mce-tinymce').addClass('d-none');
                }
            });
        }
    }

    if (typeof (settings) != 'undefined') {
        for (var key in settings) {
            if (key != 'append_plugins') {
                _settings[key] = settings[key];
            } else {
                _settings['plugins'].push(settings[key]);
            }
        }
    }
    var editor = tinymce.init(_settings);
    return editor;
}


// Open elFinder for the specific input element to upload an image

// FileManage Configs
var fileManagerUrlElfinder = PATH + '/filemanager/elfinder_init';
var fileManagerName = 'File manager';
var fileManagerConfigs = {
    file: fileManagerUrlElfinder,// use an absolute path!
    title: fileManagerName,
    width: 900,
    height: 450,
    resizable: 'yes',
    inline: true
};

function elFinderBrowser(field_name, url, type, win) {
    tinymce.activeEditor.windowManager.open(fileManagerConfigs, {
        setUrl: function (url) {
            win.document.getElementById(field_name).value = url;
        }
    });
    return false;
}

/*----------  Upload media and return path to input selector  ----------*/
function getPathMediaByelFinderBrowser(element, default_selector) {
    var passToElement = typeof (default_selector) == 'undefined' ? element.siblings('input') : default_selector;
    tinymce.activeEditor.windowManager.open(fileManagerConfigs, {
        setUrl: function (url) {
            passToElement.val(url);
        }
    });
    return false;
}


function create_slug(str) {
    str = str.trim(); 
    str = str.toLowerCase();

    //  NFD
    str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    var from = "đĐơƯƠàáãảạăắằẳẵặâấầẩẫậđéèêẽềềíìịîĩòóõỏọôồốổỗộơơòõịúùũủụưưạạ";
    var to = "dDoOaaaaaaaadeeeeiioooooooiuuuuuuu";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    str = str.replace(/[^a-z0-9 -]/g, '') 
        .replace(/\s+/g, '-') 
        .replace(/-+/g, '-'); 

    return str;
}

/**
 * Function to initialize switch toggle behavior
 * @param {string} trigger_selector - Selector for the checkbox input element.
 * @param {string} target_selector - Selector for the DOM elements to show/hide.
 */
function init_switch_toggle(trigger_selector, target_selector, html_container = 'section-item') {
    $(document).ready(function () {
        // Handle onchange event for the toggle switch
        $(trigger_selector).on('change', function () {
            if (html_container == 'section-item') {
                var section_container = $(this).closest(".section-item");
            } else {
                var section_container = $(this).closest("form");
            }
            var target_container = section_container.find(target_selector);
            var checkbox = $(this); // The checkbox input
            var hidden_input = checkbox.prev('input[type="hidden"]');
            if (checkbox.prop('checked')) {
                hidden_input.val('1');
                target_container.removeClass('d-none');
            } else {
                hidden_input.val('0');
                target_container.addClass('d-none');
            }
        });

        // Initialize visibility state based on checkbox state on page load
        $(trigger_selector).each(function () {
            if (html_container == 'section-item') {
                var section_container = $(this).closest(".section-item");
            } else {
                var section_container = $(this).closest("form");
            }
            var target_container = section_container.find(target_selector);
            var checkbox = $(this);
            var hidden_input = checkbox.prev('input[type="hidden"]');
            if (checkbox.prop('checked')) {
                hidden_input.val('1');
                target_container.removeClass('d-none');
            } else {
                hidden_input.val('0');
                target_container.addClass('d-none');
            }
        });
    });
}

