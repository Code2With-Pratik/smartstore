"use strict";

var pageOverlay = pageOverlay || (function ($) {
  return {
    show: function (message, options) {
      if (!$('#page-overlay').hasClass('active')) {
        $('#page-overlay').addClass('active');
        $('#page-overlay .page-loading-image').removeClass('d-none');
      }
    },

    hide: function () {
      if ($('#page-overlay').hasClass('active')) {
        $('#page-overlay').removeClass('active');
        $('#page-overlay .page-loading-image').addClass('d-none');
      }
    }
  };

})(jQuery);

var alertMessage = alertMessage || (function ($) {
  var $html = $('<div class="alert alert-icon content d-none" role="alert">' +
    '<i class="fe icon-symbol" aria-hidden="true"></i>' +
    '<span class="message">Message is in here</span>' +
    '</div>');
  return {
    show: function (_message, _type) {
      switch (_type) {
        case 'error':
          var _type = 'alert-warning',
            _icon = 'fe-alert-triangle';

          if ($('#alert-message .content').hasClass('alert-success')) {
            $('#alert-message .content').removeClass('alert-success');
          };
          break;
        case 'success':
          var _type = 'alert-success',
            _icon = 'fe-check';
          if ($('#alert-message .content').hasClass('alert-warning')) {
            $('#alert-message .content').removeClass('alert-warning');
          };
          break;
        default:
          var _type = 'alert-warning',
            _icon = 'fe-bell';
      }
      $('#alert-message').html($html);
      $('#alert-message .content').addClass(_type);
      $('#alert-message .icon-symbol').addClass(_icon);
      $('#alert-message .content').removeClass('d-none');
      $('#alert-message .content .message').html(_message);
    },

    hide: function () {
      $('#alert-message').html('');
    }
  };

})(jQuery);

// Confirm notice
function confirm_notice(_ms) {
  switch (_ms) {
    case 'deleteItem':
      return confirm(deleteItem);
      break;
    case 'deleteItems':
      return confirm(deleteItems);
      break;
    default:
      return confirm(_ms);
  }
  return confirm(_ms);
}

/*----------  Check str or json data  ----------*/
function isJsonString(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

// Reload page
function reloadPage(url) {
  if (url) {
    setTimeout(function () { window.location = url; }, 2500);
  } else {
    setTimeout(function () { location.reload() }, 2500);
  }
}

function notify(type, message) {
  var icon = 'warning';
  if (type == 'success') {
    icon = 'success';
  }
  $.toast({
    text: message,
    icon: icon,
    showHideTransition: 'fade',
    allowToastClose: true,
    hideAfter: 4500,
    stack: 5,
    position: 'bottom-center',
    textAlign: 'left',
    loader: true,
    loaderBg: '#0ef1f1',
    beforeShow: function () { },
    afterShown: function () { },
    beforeHide: function () { },
    afterHidden: function () { }
  });
}

/**
 * Call Ajax function with type option
 * @param {element} element 
 * @param {className} className 
 * @param {message} message 
 * @param {option} option 
 */
function notifyJS(element, className, message, option) {
  var options = {
    autoHide: true,
    position: '',
    autoHideDelay: 2000,
    className: className,
  };
  if (element === '') {
    options.position = "bottom center";
    $.notify(message, options);
  } else {
    options.position = "top center";
    element.notify(message, options);
  }
}

/**
 * Call Ajax function with type option
 * @param {element} element 
 * @param {url} url 
 * @param {data} data 
 * @param {option} type action html or json
 * @param {option} redirect, set_html_element or no redirect html or json
 */
function callPostAjax(element, url, data, task = null, option = null) {
  const dataType = (task === 'html') ? 'html' : 'json';
  data = check_csrf_token(data);
  
  $.post(url, data, function (result) {
    switch (task) {
      case 'html':
        setTimeout(function () {
          pageOverlay.hide();
          $("#result_html").html(result);
        }, 1000);
        break;
      case 'status':
        notifyJS(element, result.status, result.message);
        break;
      case 'delete-item':
        pageOverlay.show();
        if (result.status == 'success') {
          $(".tr_" + result.ids).remove();
        }
        setTimeout(function () {
          pageOverlay.hide();
          notify(result.status, result.message);
        }, 1000);
        break;
      case 'copy-to-clipboard':
        pageOverlay.hide();
        if (result.status == 'success') {
          var params = {
            'type': 'text',
            'value': result.value,
          };
          copyToClipBoard(params);
        }
        break;
      case 'sort-table':
        break;
      default:
        setTimeout(function () {
          pageOverlay.hide();
          notify(result.status, result.message);
          if (result.status === 'success') {
            // Replace html if return json has content
            if (result && result.hasOwnProperty('html_content') && option && option.hasOwnProperty('set_html_element')) {
              $(option.set_html_element).replaceWith(result.html_content);
            }
            var redirect_url = '';
            if (result && result.hasOwnProperty('redirect_url')) {
              redirect_url = result.redirect_url;
            } else if (option && option.hasOwnProperty('redirect_url')) {
              redirect_url = option.redirect_url;
            }
            if (redirect_url) {
              reloadPage(redirect_url);
            }
          }
        }, 2000);
        break;
    }
  }, dataType);
  return false;
}


// Function to add CSRF token to form data if it doesn't exist
function check_csrf_token(data) {
  var token_name = $('meta[name="csrf_name"]').attr('content');
  var token_value = $('meta[name="csrf_value"]').attr('content');
  if (typeof data === 'object' && !(data instanceof FormData)) {
    data = $.param(data);
  }

  if (typeof data === 'string' && data.indexOf(token_name + '=') === -1) {
    data += '&' + token_name + '=' + encodeURIComponent(token_value);
  }

  return data;
}

// Retrieves form data, including the token if available
function getFormData(element) {
  const token = element.find("input[name=token]").val();
  let data = element.serialize();
  return data;
}

// Retrieves form options like redirect URL and HTML element selector
function getFormOptions(element) {
  return {
    redirect_url: element.data("redirect"),
    set_html_element: element.data("set_html_element") || '#result_html',
  };
}

// Handles form submission
$(document).on("submit", ".actionFormLogin", function (event) {
  event.preventDefault();
  pageOverlay.show();
  const element = $(this);
  const url = element.attr("action");
  const task = element.data("task");
  const data = getFormData(element);
  const options = getFormOptions(element);

  return callPostAjax(element, url, data, task, options);
});


/**
 * Call Ajax function with type option
 * @param {element} element 
 * @param {type} text or element Dom
 */
function copyToClipBoard(params) {
  if (typeof (params) != 'undefined') {
    var $temp = $("<input>");
    switch (params.type) {
      case 'text':
        var copyText = $temp.val(params.value);
        break;
      default:
        var $element = params.element.closest(".text-to-cliboard").find('.content');
        var copyText = $temp.val($($element).text());
        break;
    }
    console.log(copyText);
    $("body").append($temp);
    copyText.select();
    document.execCommand("copy");
    $temp.remove();
  }
}


/**
 * Configures jQuery Validate for a form with validation rules and error messages from the backend.
 * 
 * @param {string} form_selector - The selector of the form (e.g., ".ajaxSubmitForm")
 * @param {object} validation_rules - The validation rules for the form, containing conditions like required, minlength, email, etc.
 * @param {object} validation_messages - The error messages for the validation rules of the form, such as error messages for missing fields, invalid email, etc.
 */
function setup_form_js_validation(form_selector, validation_rules, validation_messages) {
  // Check if validation_rules and validation_messages are not null or empty
  if (validation_rules && Object.keys(validation_rules).length > 0 && validation_messages && Object.keys(validation_messages).length > 0) {
    // Configure jQuery Validate with the rules and error messages from the backend
    $(form_selector).validate({
      rules: validation_rules,
      messages: validation_messages,
      errorPlacement: function (error, element) {
        // Place the error message into the next .invalid-feedback element
        element.next('.invalid-feedback').text(error.text());
      },
      highlight: function (element) {
        // Add 'is-invalid' class when there is an error and remove 'is-valid' class
        $(element).addClass('is-invalid').removeClass('is-valid');
      },
      unhighlight: function (element) {
        // Remove 'is-invalid' class and add 'is-valid' class when the field is valid
        $(element).removeClass('is-invalid').addClass('is-valid');
      }
    });
  } else {
    // If validation_rules or validation_messages are missing, log a warning in the console
    console.warn("Validation rules or error messages are missing.");
  }
}


