'use strict';
// Class to handle the "Load More" button functionality
class LoadMore {
    constructor(button) {
        // Initialize the button and extract data attributes
        this.button_selector = $(button);  // Store the current button as jQuery object
        this.url = this.button_selector.data('url');  // Get URL for AJAX request
        this.options = this.button_selector.data('options');
        this.container_selector = this.options.container_selector || '#result-html-container';  // Get the container selector from the options object
        this.spinner_selector = this.options.spinner_selector || '.spinner';  // Default is '.spinner' if not provided
        this.timeout = this.options.timeout || 2000;  // Set timeout for delay in showing content (default 2000ms)
        this.button_text = this.options.text || 'Load More';  // Default text for the button
        this.page = this.button_selector.data('page') || 1;  // Current page (default to 1)
        this.method = this.button_selector.data('method') || 'GET';  // HTTP method for AJAX request (default is GET)
        this.init();  // Initialize button event
    }

    // Initialize the click event for the button
    init() {
        const _this = this;
        $(document).ready(function() {
            // Attach click event handler to the button
            _this.button_selector.on('click', function() {
                _this.load_more_data();  // Trigger loading more data when the button is clicked
            });
        });
    }

    // Load more data using AJAX
    load_more_data() {
        const _this = this;
        const next_page = this.page + 1;  // Increment the page number for the next request

        // Show spinner and disable the button to prevent multiple clicks
        _this.toggle_button_state(true);  // Enable spinner and disable button

        // Send AJAX request to fetch more data
        $.ajax({
            url: _this.url,  // The URL for the AJAX request
            type: _this.method,  // HTTP method for the request (GET or POST)
            dataType: 'json',  // Expecting JSON response
            data: { page: next_page },  // Send the next page number as data
            success: function(response) {
                setTimeout(() => {
                    // Hide spinner and re-enable button after timeout
                    _this.toggle_button_state(false);  // Hide spinner and enable button
                    
                    if (response.status === 'success') {
                        const reviews_html = response.html_content || '';  // Get HTML content from the response
                        $(_this.container_selector).append(reviews_html);  // Append the new content to the specified container

                        // Update the page number on the button
                        _this.page = next_page;  // Update the `this.page` variable
                        _this.button_selector.data('page', _this.page);  // Update the jQuery data
                        _this.button_selector.attr('data-page', _this.page);  // Update the DOM attribute

                        // If there are no more items, hide the button
                        if (!response.has_more) {
                            _this.button_selector.addClass('d-none');  // Hide the "Load More" button if no more data is available
                        }
                    } else {
                        _this.handle_error();  // Handle error if the response status is not success
                    }
                }, _this.timeout);  // Wait for a timeout before displaying the new content
            },
            error: function() {
                _this.handle_error();  // Handle error if the AJAX request fails
            }
        });
    }

    // Toggle the state of the button (enable/disable) and show/hide spinner
    toggle_button_state(disabled) {
        this.button_selector.prop('disabled', disabled);  // Enable or disable the button
        if (disabled) {
            // Show spinner when disabled
            this.button_selector.find(this.spinner_selector).removeClass('d-none').addClass('spinner-border-sm');
        } else {
            // Hide spinner when re-enabled
            this.button_selector.find(this.spinner_selector).addClass('d-none');
        }
    }

    // Handle error when the AJAX request fails or the response is not successful
    handle_error() {
        console.log('An error occurred while loading data.');
        this.toggle_button_state(false);  // Re-enable button and hide spinner
    }
}


class FormHandler {
    constructor(form_selector) {
        // Lấy form và các tùy chọn từ data-options (nếu có)
        this.form = $(form_selector);
        this.options = this.form.data('options');
        this.csrf_token_selector = this.options.csrf_token_selector || 'meta[name="csrf_name"]'; // CSRF token name selector
        this.csrf_token_value_selector = this.options.csrf_token_value_selector || 'meta[name="csrf_value"]'; // CSRF token value selector
        this.spinner_selector = this.options.spinner_selector || '.spinner'; // Spinner selector (optional)
        // Message container: Nếu không có 'data-options', tìm phần tử '.form-message' trong form
        this.message_container = this.options.message_container || this.form.find('.form-message');

        // HTML content container: Nếu không có 'data-options', tìm phần tử '.dynamic-content' trong form
        this.html_content_container = this.options.html_content_container || this.form.find('#result-html-content');

        this.url = this.options.url || this.form.attr('action'); // URL for form submission (can be passed or retrieved from form action)
        this.method = this.options.method || 'POST'; // HTTP method (default POST)
        this.data_type = this.options.data_type || 'json'; // Expected response type (default is JSON)
        this.redirect_delay = this.options.redirect_delay || 4000; // Delay before redirect (default is 4 seconds)
        this.hide_message_delay = this.options.hide_message_delay || 10000; // Delay before hiding the message (default is 10 seconds)
        
        this._initialize(); // Initialize submit event
    }

    // Khởi tạo sự kiện submit cho form
    _initialize() {
        const _this = this;
        this.form.on('submit', function(e) {
            _this.submit_form(e);  // Trigger form submission
        });
    }

    // Gửi form qua AJAX
    async submit_form(e) {
        e.preventDefault(); // Prevent default form submission

        // Reset form và các lỗi trước khi xử lý
        this.reset_form();

        // Hiển thị spinner và vô hiệu hóa form để tránh gửi nhiều lần
        this.show_spinner(true);

        const form_data = this.prepare_form_data(); // Chuẩn bị dữ liệu form
        try {
            const response = await this.send_form_data(form_data); // Gửi dữ liệu form qua AJAX

            // Xử lý phản hồi từ server
            this.handle_response(response);
        } catch (error) {
            // Xử lý lỗi khi gửi AJAX
            this.handle_error(error);
        } finally {
            // Ẩn spinner sau khi có phản hồi
            this.show_spinner(false);
        }
    }

    // Chuẩn bị dữ liệu form (bao gồm cả CSRF token)
    prepare_form_data() {
        let form_data = this.form.serialize(); // Serialize form data

        // Lấy CSRF token từ các thẻ meta
        const csrf_token_name = $(this.csrf_token_selector).attr('content');
        const csrf_token_value = $(this.csrf_token_value_selector).attr('content');

        // Nếu có cả tên và giá trị của CSRF token thì thêm vào form data
        if (csrf_token_name && csrf_token_value) {
            form_data += `&${csrf_token_name}=${csrf_token_value}`;
        }

        return form_data;
    }

    // Gửi dữ liệu form qua AJAX
    async send_form_data(form_data) {
        try {
            return await $.ajax({
                url: this.url, // URL gửi form
                method: this.method, // HTTP method (POST, PUT, DELETE, ...)
                data: form_data, // Dữ liệu form gửi đi
                dataType: this.data_type, // Kiểu dữ liệu trả về (JSON)
            });
        } catch (error) {
            throw error; // Ném lỗi ra ngoài để xử lý
        }
    }

    // Xử lý phản hồi từ server
    handle_response(response) {
        if (this.data_type === 'json') {
            this.handle_json_response(response);
        } else {
            // Nếu không phải JSON, chỉ hiển thị thông báo đơn giản
            this.handle_message_response(response);
        }
        // Xử lý nội dung HTML nếu có
        this.handle_html_content(response);
        // Xử lý chuyển hướng nếu có URL
        this.handle_redirect(response);
    }

    // Phương thức xử lý phản hồi JSON
    handle_json_response(response) {
        switch (response.status) {
            case 'success':
                this.handle_success(response); // Xử lý thành công
                break;

            case 'error':
                // Kiểm tra xem có phải lỗi validation không
                if (response.type === 'validation') {
                    this.handle_validation_errors(response.errors); // Xử lý lỗi validation
                } else {
                    this.handle_message_response(response); // Xử lý lỗi chung
                }
                break;

            default:
                console.error('Unexpected status:', response.status);
                this.handle_message_response(response); // Xử lý lỗi chung khi status không phải success hoặc error
                break;
        }
    }

    // Chèn nội dung HTML vào form hoặc container
    handle_html_content(response) {
        if ($(this.html_content_container).length && response.html_content) {
            $(this.html_content_container).html(response.html_content);
        }
    }

    // Xử lý chuyển hướng nếu có URL
    handle_redirect(response) {
        if (response.redirect_url) {
            setTimeout(() => {
                window.location.href = response.redirect_url; // Chuyển hướng sau một khoảng thời gian delay
            }, this.redirect_delay);
        }
    }

    // Phương thức xử lý thông báo thành công
    handle_success(response) {
        this.show_message(response.message, 'success');
    }

    // Phương thức xử lý lỗi validation
    handle_validation_errors(errors) {
        $.each(errors, (key, message) => {
            const errorContainer = this.form.find('.error_' + key);
            const inputField = this.form.find('.' + key);
            errorContainer.text(message).css('display', 'block');
            inputField.addClass('is-invalid');
        });
    }

    // Hiển thị hoặc ẩn spinner
    show_spinner(show) {
        if (this.spinner_selector && this.form.find(this.spinner_selector).length > 0) {
            const button = this.form.find(this.spinner_selector).closest('button'); // Tìm nút chứa spinner

            if (show) {
                button.prop('disabled', true); // Vô hiệu hóa nút
                button.find('.spinner-border').removeClass('d-none'); // Hiển thị spinner
            } else {
                button.prop('disabled', false); // Kích hoạt lại nút
                button.find('.spinner-border').addClass('d-none'); // Ẩn spinner
            }
        }
    }

    // Xử lý lỗi chung khi gửi form
    handle_error(error) {
        console.error('Form submission error:', error);
        this.show_message('An error occurred while submitting the form. Please try again later.', 'error');
    }

    // Xử lý phản hồi thành công
    handle_success(response) {
        this.show_message(response.message, 'success');
        this.form[0].reset(); // Reset form khi thành công
    }

    // Xử lý lỗi validation từ server
    handle_validation_errors(errors) {
        $.each(errors, (key, message) => {
            const error_container = this.form.find('.error_' + key); // Tìm phần tử chứa lỗi cho mỗi trường
            const input_field = this.form.find('.' + key); // Tìm trường input theo class

            error_container.text(message).show(); // Hiển thị lỗi
            input_field.addClass('is-invalid'); // Đánh dấu trường input là lỗi
        });
    }

    // Hiển thị thông báo thành công hoặc lỗi trong form
    show_message(message, type) {
        const alert_type = type === 'success' ? 'alert-success' :
                          type === 'error' ? 'alert-danger' :
                          type === 'info' ? 'alert-info' :
                          'alert-warning';

        const alert_html = `
            <div class="alert ${alert_type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Chèn HTML của thông báo vào container
        $(this.message_container).html(alert_html).removeClass('d-none');

        // Ẩn thông báo sau một khoảng thời gian
        setTimeout(() => {
            $(this.message_container).addClass('d-none');
        }, this.hide_message_delay);
    }

    // Reset form và các lỗi validation
    reset_form() {
        this.form.find('.invalid-feedback').text(''); // Xóa các lỗi
        this.form.find('.form-control').removeClass('is-invalid'); // Reset các trường input lỗi
        this.hide_message(); // Ẩn bất kỳ thông báo nào đang hiển thị
    }

    // Ẩn thông báo
    hide_message() {
        if ($(this.message_container).length) {
            $(this.message_container).addClass('d-none');
        }
    }

    // Xử lý các phản hồi không phải là JSON (nếu có)
    handle_message_response(response) {
        const message = response.message || 'An unknown error occurred.';
        this.show_message(message, 'error');
    }
}
