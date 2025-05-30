<?php
use App\Libraries\CustomRecaptcha;

// Check if the function get_recaptcha_settings() exists before defining it.
if (!function_exists('get_recaptcha_settings')) {

    /**
     * Get the Google reCAPTCHA settings from the app configuration.
     *
     * @return array The reCAPTCHA settings including status, site_key, secret_key, and options.
     */
    function get_recaptcha_settings()
    {
        // Get the reCAPTCHA settings from the app configuration
        $app_recaptcha = get_app_setting('google_recaptcha');
        return ($app_recaptcha) ? json_decode($app_recaptcha, true) : [];
    }
}

/**
 * Check if reCAPTCHA is enabled and site_key and secret_key are available for a specific form.
 *
 * @param string $form_name The form name to check if reCAPTCHA is enabled.
 * @return mixed Returns true if the reCAPTCHA is enabled and site_key/secret_key are valid, false otherwise.
 */
if (!function_exists('check_recaptcha_settings')) {

    function check_recaptcha_settings($form_name = '')
    {
        // Get reCAPTCHA settings
        $app_recaptcha = get_recaptcha_settings();

        // Check if reCAPTCHA is enabled and the form has reCAPTCHA enabled
        if ($app_recaptcha['status'] == 1 && isset($app_recaptcha['options'][$form_name]) && $app_recaptcha['options'][$form_name] == 1) {
            
            // Check if site_key and secret_key are set and not null
            if (isset($app_recaptcha['site_key']) && !empty($app_recaptcha['site_key']) && 
                isset($app_recaptcha['secret_key']) && !empty($app_recaptcha['secret_key'])) {
                return $app_recaptcha; // Return the settings if everything is valid
            }
        }

        // Return false if reCAPTCHA is not enabled or site_key/secret_key is missing
        return false;
    }
}

/**
 * Render the Google reCAPTCHA HTML code for a specific form.
 *
 * @param string $form_name The form name to check the reCAPTCHA status.
 * @return string|false The HTML for reCAPTCHA or false if not enabled.
 */
if (!function_exists('render_recaptcha_html')) {

    function render_recaptcha_html($form_name = '')
    {
        // Check reCAPTCHA settings
        $app_recaptcha = check_recaptcha_settings($form_name);

        // If reCAPTCHA settings are valid, render the reCAPTCHA
        if ($app_recaptcha) {
            // Initialize the CustomRecaptcha class with the site_key and secret_key
            $recaptcha = new CustomRecaptcha($app_recaptcha['site_key'], $app_recaptcha['secret_key']);
            
            // Return the rendered reCAPTCHA HTML
            return $recaptcha->render_html();
        }

        // Return false if reCAPTCHA is not enabled or site_key/secret_key is missing
        return false;
    }
}

/**
 * Verify the reCAPTCHA response from the form.
 *
 * @param string $response The reCAPTCHA response received from the form.
 * @param string $remoteIp The IP address of the user.
 * @param string $form_name The form name to check if reCAPTCHA is enabled.
 * @return bool Returns true if reCAPTCHA is valid, false otherwise.
 */
if (!function_exists('verify_captcha')) {

    function verify_captcha($response, $remoteIp, $form_name = '')
    {
        // Check reCAPTCHA settings
        $app_recaptcha = check_recaptcha_settings($form_name);
        if ($app_recaptcha) {
            $recaptcha = new CustomRecaptcha($app_recaptcha['site_key'], $app_recaptcha['secret_key']);
            return $recaptcha->verify($response, $remoteIp);
        }
        return true;
    }
}

/**
 * Verify the reCAPTCHA response from the form using values from the request (POST and IP).
 *
 * @param string $form_name The form name to check if reCAPTCHA is enabled.
 * @return bool|string Returns true if reCAPTCHA is valid, false otherwise. Returns an error message if invalid.
 */
if (!function_exists('verify_recaptcha_from_request')) {

    function verify_recaptcha_from_request($form_name = '')
    {
        $response = get_post('g-recaptcha-response');
        $remoteIp = service('request')->getIPAddress();
        $isValid = verify_captcha($response, $remoteIp, $form_name);
        if (!$isValid) {
            json_response([
                'status' => 'error',
                'message' => __l("Please_kindly_verify_the_reCAPTCHA_to_proceed"),
            ]);
        }
        return true;
    }
}
