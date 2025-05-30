<?php

/**
 * Get Account Loginned infor after login
 *
 * @return account Loginned data
 */
if (!function_exists('get_logged_in_user_info ')) {
    function get_logged_in_user_info ($field = '') {
        if (session_get('user')) {
            $user = session_get('user');
            return ($field && isset($user[$field])) ? $user[$field] : $user;
        }
        return null;
    }
}


/**
 * Check if the user is logged in.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
if (!function_exists('is_user_logged_in')) {
    function is_user_logged_in() {
        return session_get('user') && session_get('user')['is_logged_in'];
    }
}

/**
 * Check if the logged-in user is an admin.
 *
 * @return bool True if the user is an admin, false otherwise.
 */
if (!function_exists('is_user_admin')) {
    function is_user_admin() {
        return session_get('user') && session_get('user')['is_admin'];
    }
}

/**
 * Check if the user is logged in and is an admin.
 *
 * @return bool True if the user is logged in and is an admin, false otherwise.
 */
if (!function_exists('check_admin_status')) {
    function check_admin_status() {
        return is_user_logged_in() && is_user_admin();
    }
}

if (!function_exists('admin_url')) {
    function admin_url($route_name = '', $is_url_string = false)
    {
        $prefix_admin = config('AppConfig')->prefixAdmin;
        if ($is_url_string ) {
            return '/' . $prefix_admin . '/' . $route_name;
        } else {
            return base_url($prefix_admin . '/' . $route_name);
        }
    }
}


if (!function_exists('generate_admin_title')) {
    function generate_admin_title($controller_name = '')
    {
        $segments = service('uri')->getSegments();
        $config_tpl = config('AppConfig')->adminMenu;
        $controllers_arr = array_keys($config_tpl);
        $site_name = get_app_setting('website_name'); 
        if (!empty($controller_name) && in_array($controller_name, $controllers_arr)) {
            $main_title = $config_tpl[$controller_name]['name'];
        } else {
            $main_title = 'Admin Dashboard';
        }
        $main_title = $main_title . ' | ' . $site_name;
        return $main_title;
    }
}
