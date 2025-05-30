"use strict";

class AjaxHandler {
    constructor() {
        // Lấy CSRF token từ meta tag, có thể thay đổi tùy theo dự án
        this.csrf_token = $('meta[name="csrf_value"]').attr('content') || null;
        this.csrf_token_name = $('meta[name="csrf_name"]').attr('content') || null;  
        this.element_selector = '';
        this.closest_form = '';
        this.method = 'POST';           
        this.data_type = 'json';             
        this.response_html_container = '#content';  
        this.spinner_selector = '.spinner';  // Selector cho spinner
        this.overlay = '.overlay';           // Selector cho overlay
        this.message_container = '.ajax-alert-message'; // Container thông báo
        this.redirect_delay = 3000;          // Thời gian chuyển hướng (nếu có)
        this.hide_message_delay = 10000;   // Thời gian ẩn thông báo
        this.response_deplay = 1200;   
        this.action_type = 'form';           // Callback trước khi gửi request
        this.before_send = null;             // Callback trước khi gửi request
        this.success_callback = null;        // Callback khi thành công
        this.error_callback = null;          // Callback khi lỗi
        this.complete_callback = null;       // Callback khi hoàn thành request
    }

    // Phương thức lấy cấu hình từ data-options của DOM
    set_options_from_dom(selector) {
        const element = $(selector);
        this.element_selector = element;
        if (element.length) {
            const data_options = element.data('options');
            // console.log(data_options);
            if (data_options) {
                console.log(data_options);
                
                // Cập nhật các thuộc tính từ data-options vào đối tượng hiện tại
                if (data_options.method) this.method = data_options.method;
                if (data_options.data_type) this.data_type = data_options.data_type;
                if (data_options.response_html_container) this.response_html_container = data_options.response_html_container;
                if (data_options.spinner_selector) this.spinner_selector = data_options.spinner_selector;
                if (data_options.overlay) this.overlay = data_options.overlay;
                if (data_options.message_container) this.message_container = data_options.message_container;
                if (data_options.redirect_delay) this.redirect_delay = data_options.redirect_delay;
                if (data_options.hide_message_delay) this.hide_message_delay = data_options.hide_message_delay;
                if (data_options.action_type) this.action_type = data_options.action_type;
                if (data_options.before_send) this.before_send = data_options.before_send;
                if (data_options.success_callback) this.success_callback = data_options.success_callback;
                if (data_options.error_callback) this.error_callback = data_options.error_callback;
                if (data_options.complete_callback) this.complete_callback = data_options.complete_callback;
            } else {
                this.spinner_selector = element.closest('form').find('.spinner').length ? '.spinner' : this.spinner_selector;
                this.message_container = element.closest('form').find('.ajax-alert-message').length ? '.ajax-alert-message' : this.message_container;
            }
        }

        // Initialize closestForm and elements to reuse
        this.closest_form                   = $(this.element_selector).closest('form');
        this.spinner_element                = this.closest_form.find(this.spinner_selector);
        this.message_container_element      = this.closest_form.find(this.message_container);
        this.overlay_element                = this.closest_form.find(this.overlay);
    }

    prepare_overlay(element) {
        var $element = $(element);
        if ($element.length > 0 && $element.outerHeight() > 0) {
            $element.addClass('position-relative')
                .append(`
                    <div class="overlay position-absolute d-none">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `);
        }
    }

    prepare_data(data) { 
        if (typeof data === 'string') { 
            let params = new URLSearchParams(data); 
            let dataObject = {}; 
            params.forEach((value, key) => { 
                dataObject[key] = value; 
            }); 
            data = dataObject; 
        } 
        // check csrf token
        if (this.method.toUpperCase() === 'POST' && this.csrf_token && !data.hasOwnProperty(this.csrf_token_name)) { 
            data[this.csrf_token_name] = this.csrf_token; 
        } 
        return data; 
    };

    send_request(url, data) {
        data = this.prepare_data(data);
        // console.log(data);
        
        if (!this.validate_data(data)) {
            this.show_message('Required data is missing or invalid.', 'error');
            return;
        }
        // Gọi callback trước khi gửi (nếu có)
        if (this.before_send) {
            this.before_send();
        }
        this.reset_form();

        $.ajax({
            url: url,
            type: this.method,
            data: data,
            dataType: this.data_type,
            beforeSend: () => {
                this.show_spinner(true);  
            },
            success: (response) => {
                setTimeout(() => { 
                    this.handle_response(response); 
                    if (this.success_callback) { 
                        this.success_callback(response); 
                    } 
                }, this.response_deplay);
            },
            error: (xhr, status, error) => {
                setTimeout(() => { 
                    this.handle_error(xhr, status, error);
                    if (this.error_callback) {
                        this.error_callback(xhr, status, error);
                    }
                }, this.response_deplay);
                
            },
            complete: () => {
                setTimeout(() => { 
                    this.show_spinner(false);  
                    if (this.complete_callback) {
                        this.complete_callback();
                    }
                }, this.response_deplay);
            }
        });
    }

    // Xử lý phản hồi từ server
    handle_response(response) {
        if (this.data_type === 'json') {
            this.handle_json_response(response);
        } else if (this.data_type === 'html') {
            this.handle_html_content(response);
        } else if (this.data_type === 'text') {
            this.handle_text_response(response);
        } else if (this.data_type === 'xml') {
            this.handle_xml_response(response);
        } else {
            this.handle_message_response(response);
        }
        this.handle_redirect(response);
        this.handle_html_content(response)
    }

    // Xử lý phản hồi JSON
    handle_json_response(response) {
        switch (response.status) {
            case 'success':
                this.handle_success(response);
                break;
            case 'error':
                $(this.response_html_container).html('');
                if (response.type === 'validation') {
                    this.handle_validation_errors(response);
                } else {
                    this.handle_message_response(response);
                }
                break;
            default:
                $(this.response_html_container).html('');
                this.handle_message_response(response);
                break;
        }
    }

    // Handle the HTML response based on the specified action type
    handle_html_content(response) {
        // Check if response contains html_data and target_selector exists in the DOM
        if (response.js_content) {
            this.handle_execute_js(response.js_content);
        }

        if (response.html_update && $(response.html_update.target_selector).length) {
            const action_type = response.html_update.action_type;
            const html_content = response.html_update.html_content;
            this.response_html_container = response.html_update.target_selector; //update response id
            // Perform different actions based on the type specified in the response
            switch (action_type) {
                case 'html':
                    // Replace the entire content inside the target container
                    $(this.response_html_container).html(html_content);
                    break;
                case 'append':
                    // Append the new content to the end of the target container
                    $(this.response_html_container).append(html_content);
                    break;
                case 'prepend':
                    // Prepend the new content to the beginning of the target container
                    $(this.response_html_container).prepend(html_content);
                    break;
                case 'before':
                    // Insert the new content before the target container
                    $(this.response_html_container).before(html_content);
                    break;
                case 'after':
                    // Insert the new content after the target container
                    $(this.response_html_container).after(html_content);
                    break;
                case 'replaceWith':
                    // Replace the entire DOM element with the new content
                    $(this.response_html_container).replaceWith(html_content);
                    break;
                default:
                    // If no valid type is provided, default to replacing the content inside the target container
                    $(this.response_html_container).html(html_content);
                    break;
            }
        }
    }

    handle_execute_js(js_content) {
        const script = document.createElement('script');
        script.innerHTML = js_content;
        document.body.appendChild(script);
    }

    // Xử lý phản hồi text
    handle_text_response(response) {
        console.log('Text Response:', response);
    }

    // Xử lý phản hồi XML
    handle_xml_response(response) {
        console.log('XML Response:', response);
    }

    reset_form() {
        const _form = $(this.element_selector);
        _form.find('.invalid-feedback').text(''); 
        _form.find('.form-control').removeClass('is-invalid');
        
        this.hide_message(); 
    }

    // Xử lý thông báo thành công
    handle_success(response) {
        this.show_message(response.message, 'success');
    }
    
    // Xử lý lỗi validation
    handle_validation_errors(response) {
        const errors = response.errors;
        const message = response.message || 'Please correct the errors before saving';
        const _form = $(this.element_selector);

        _form.find('.is-invalid').removeClass('is-invalid'); 
        _form.find('.invalid-feedback').text('').hide();
        this.show_message(message, 'error');
        $.each(errors, (key, message) => {
            const parts = key.split('.');
            // Xử lý các phần từ phần thứ hai trở đi, thêm dấu ngoặc vuông
            const input_name = parts[0] + parts.slice(1).map(part => `[${part}]`).join('');
            const input_field = _form.find('[name="' + input_name + '"]');
            const error_container = input_field.siblings('.invalid-feedback');
            // Nếu tìm thấy container lỗi, hiển thị lỗi
            if (error_container.length) {
                error_container.text(message).show();  // Hiển thị thông báo lỗi
            }
            // Thêm lớp 'is-invalid' vào input để đánh dấu lỗi
            input_field.addClass('is-invalid');
        });
    }

    // Display message with an alert
    show_message(message, type = 'error') {
        // Determine the alert type, title, icon, and CSS class based on the message type (success, error, info, or warning)
        let title = '';
        let icon = '';
        let alertClass = '';
      
        switch (type) {
            case 'success':
                icon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                        </svg>`;

                alertClass = 'alert-success';  // CSS class for success alerts
                break;
            case 'error':
                icon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>`; 
                alertClass = 'alert-danger';  // CSS class for warning/error alerts
                break;
            default:
                icon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>`; 
                alertClass = 'alert-warning';  // Default CSS class
                break;
        }

        // Generate the HTML for the alert message
        
        const alertHtml = `
            <div class="alert ${alertClass} d-flex align-items-center" role="alert">
                ${icon}
                <div class = "ms-2 m-l-10">
                    ${message}  
                </div>
            </div>
        `;

        // Insert the alert HTML into the message container and show it
        this.message_container_element.html(alertHtml).removeClass('d-none');
        
        // Hide the alert message after a certain delay (defined by this.hide_message_delay)
        setTimeout(() => {
            this.message_container_element.addClass('d-none');
        }, this.hide_message_delay);
    }   

    // Xử lý chuyển hướng nếu có
    handle_redirect(response) {
        if (response.redirect_url) {
            setTimeout(() => {
                window.location.href = response.redirect_url;  // Chuyển hướng sau một khoảng thời gian delay
            }, this.redirect_delay);
        }
    }

    // Hiển thị hoặc ẩn spinner
    show_spinner(show) {
        if (this.spinner_element.length) {
            const button = this.spinner_element.closest('button');
            const overlay = this.closest_form.find(this.overlay);
            if (show) {
                button.prop('disabled', true);
                this.spinner_element.removeClass('d-none');
                overlay.removeClass('d-none');
            } else {
                button.prop('disabled', false);
                this.spinner_element.addClass('d-none');
                overlay.addClass('d-none');
            }
        }
    }

    // Xử lý lỗi
    handle_error(xhr, status, error) {
        let message = 'An error occurred: ' + error;
        if (xhr.status === 0) {
            message = 'Network error: Please check your internet connection.';
        } else if (xhr.status >= 500) {
            message = 'Server error: Something went wrong on the server.';
        } else if (xhr.status === 404) {
            message = 'Not Found: The requested resource could not be found.';
        }

        this.show_message(message, 'error');
    }

    hide_message() {
        const _form = $(this.element_selector);
        if (_form.find(this.message_container).length) {
            _form.find(this.message_container).addClass('d-none');
        }
    }

    // Kiểm tra dữ liệu trước khi gửi
    validate_data(data) {
        if (!data || Object.keys(data).length === 0) {
            return false;
        }
        return true;
    }

    // Xử lý phản hồi không phải JSON (nếu có)
    handle_message_response(response) {
        const message = response.message || 'An unknown error occurred.';
        this.show_message(message, 'error');
    }
}
