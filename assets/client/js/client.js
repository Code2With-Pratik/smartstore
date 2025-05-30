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
        console.log("Binding events...");
        // General Form
        $(document).on("submit", ".sendForm", this.handleFormSubmit.bind(this));
        // apply-coupon
        $(document).on("click", ".btnApplyCoupon", this.handleApplyCoupon.bind(this));
        // load more button
        $(document).on("click", ".btnLoadMore", this.handleLoadMore.bind(this));
    }

    handleFormSubmit(e) {
        e.preventDefault();
        const form = $(e.currentTarget);
        const formData = form.serialize();
        console.log(formData);
        
        // if(input_phone_field.length > 0 && this.validatePhoneNumber() === false) return false;

        this.ajaxHandler.set_options_from_dom(e.currentTarget);
        this.ajaxHandler.send_request(form.attr('action'), formData);
    }

    handleApplyCoupon(e) {
        e.preventDefault();
        const coupon_code = $('#couponCode').val().trim();
        const currentUrl = window.location.href;
        const _url = `${this.currentUrl.replace('checkout', '')}/apply-coupon`
        const _data = { coupon_code: coupon_code };
        this.ajaxHandler.set_options_from_dom(e.currentTarget);
        this.ajaxHandler.send_request(_url, _data);
    }

    validatePhoneNumber() {
        var message_area = $("#error-phone-msg");
        update_phone_hidden_inputs();
        if (iti && iti.isValidNumber()) {
            message_area.addClass('d-none');
            return true;
        } else {
            message_area.removeClass('d-none');
            return false;
        }
    }

    handleLoadMore(e) {
        e.preventDefault();
        const element = $(e.currentTarget);
        const _url = element.data('url');
        const _next_page = element.data('page') + 1;
        const _data = { page: _next_page };
        this.ajaxHandler.set_options_from_dom(e.currentTarget);
        this.ajaxHandler.success_callback = (response) => {
            if (response.status === 'success') {
                element.data('page', _next_page);
                element.attr('data-page', _next_page);
                if (!response.has_more) {
                    element.addClass('d-none');
                }
            }
        };
        this.ajaxHandler.send_request(_url, _data);
    }
}

$(function () {
    new MainJS();
});




/**
* Initializes the Owl Carousel with dynamic item counts based on screen size.
* 
* @param {string} element_selector - The selector of the element to which Owl Carousel will be applied.
* @param {number} items_0 - Number of items to display when the screen width is between 0px and 599px.
* @param {number} items_600 - Number of items to display when the screen width is between 600px and 999px.
* @param {number} items_1000 - Number of items to display when the screen width is 1000px and above.
*/
function initialize_owl_carousel(element_selector, items_0, items_600, items_1000) {
    // Initialize Owl Carousel for the specified element
    $(element_selector).owlCarousel({
        loop: true, // Enable loop (carousel will loop back to the start)
        margin: 10, // Set margin between items
        responsiveClass: true, // Allow dynamic CSS class changes based on screen size
        responsive: {
            // For screen widths from 0px to 599px (mobile view)
            0: {
                items: items_0, // Number of items to display
                nav: true // Show navigation buttons (prev/next)
            },
            // For screen widths from 600px to 999px (tablet view)
            600: {
                items: items_600, // Number of items to display
                nav: false // Hide navigation buttons
            },
            // For screen widths from 1000px and above (desktop view)
            1000: {
                items: items_1000, // Number of items to display
                nav: true, // Show navigation buttons
                loop: false // Disable looping (carousel will not loop)
            }
        }
    });
}


/**
 * Function to check and display the cookie popup based on user consent.
 * @param {string} cookie_popup_id - The ID of the cookie popup element to show/hide.
 * @param {string} accept_button_id - The ID of the button that the user clicks to accept the cookies.
 */
function check_cookie_popup(cookie_popup_id, accept_button_id) {
    // localStorage.clear();

    var position = document.getElementById(cookie_popup_id).getAttribute('data-position');  // Get position of the popup
    var consentExpiryDays = document.getElementById(cookie_popup_id).getAttribute('data-expirydays');  // Get consent expiry days
    
    document.getElementById(cookie_popup_id).classList.add(position);
    
    var consentTime = localStorage.getItem('cookieConsentTime'); 
    var currentTime = new Date().getTime();  // Get current time
    var consentExpiryTime = consentExpiryDays * 24 * 60 * 60 * 1000; 
    
    if (sessionStorage.getItem('cookieConsentClosed') === 'true') {
        document.getElementById(cookie_popup_id).style.display = 'none';
        return;  
    }
    
    // Check if consent is not stored or has expired
    if (!localStorage.getItem('cookieConsent') || (consentTime && currentTime - new Date(consentTime).getTime() > consentExpiryTime)) {
        document.getElementById(cookie_popup_id).style.display = 'block'; 
    }

    // On click, hide the popup and store consent
    document.getElementById(accept_button_id).addEventListener('click', function() {
        document.getElementById(cookie_popup_id).style.display = 'none';  
        localStorage.setItem('cookieConsent', 'true');  // Store consent status
        localStorage.setItem('cookieConsentTime', new Date().toISOString());  
    });

    // On click "Close", hide the popup and store state in sessionStorage
    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById(cookie_popup_id).style.display = 'none';  
        sessionStorage.setItem('cookieConsentClosed', 'true');  // Store close status in sessionStorage
        sessionStorage.setItem('cookieConsentCloseTime', new Date().toISOString());  
    });
}

 // Function to start the countdown
 function startCountdown(default_limit_coupon_hours, default_limit_coupon_minutes) {
    var $couponBanner = $('#coupon-banner');
    var $hours = $couponBanner.find('.hours');
    var $minutes = $couponBanner.find('.minutes'); 
    var $seconds = $couponBanner.find('.seconds'); 
    // Calculate the countdown end time
    var countdownDate = new Date().getTime() + (default_limit_coupon_hours * 60 * 60 * 1000) + (default_limit_coupon_minutes * 60 * 1000);

    // Update the countdown every second
    var x = setInterval(function() {

        // Get the current time
        var now = new Date().getTime();
        // Calculate the remaining time
        var distance = countdownDate - now;
        
        // Calculate hours, minutes, and seconds left
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Display the updated countdown
        $hours.text(hours < 10 ? "0" + hours : hours); 
        $minutes.text(minutes < 10 ? "0" + minutes : minutes); 
        $seconds.text(seconds < 10 ? "0" + seconds : seconds); 

        // If the countdown finishes (distance < 0), stop the interval and hide the banner
        if (distance < 0) {
            clearInterval(x);
            $couponBanner.addClass("d-none"); 
        }
    }, 1000); // Run this every second
}

