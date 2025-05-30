<?php 
if (!function_exists('pr')) {
    function pr($data, $type = 0) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

/**
 * Retrieves configuration values from cache or database, and inserts a new value if not found.
 *
 * This function first checks if the configuration values are available in the cache.
 * If the cache doesn't contain the values, it will fetch them from the database and store them in the cache.
 * If the key is not found in either the cache or the database, it inserts the key and value into the database and updates the cache.
 *
 * @param string $key The configuration key (e.g., 'website_name').
 * @param string|null $value The value to insert if the key is not found. Default is null.
 * @return string|null The configuration value corresponding to the given key, or null if not found.
 */
if (!function_exists('get_app_setting')) {
    function get_app_setting($key, $value = null)
    {
        $cache_time_limit = 24 * 3600;
        $settings = [];
        $cache_key = get_cache_key('general_settings');
        $settings = cache_get($cache_key);
        // cache_delete($cache_key );
        // If cache is empty, fetch from DB and store in cache
        if (!$settings) {
            $db_settings = db_fetch('name, value', TB_OPTIONS);
            $settings = [];
            foreach ($db_settings as $row) {
                $settings[$row['name']] = $row['value'];
            }
            cache_save($cache_key, $settings, $cache_time_limit);
        }
        // If the key exists in cache, return its value
        
        if (isset($settings[$key])) {
            return $settings[$key];
        }
        // Check if the key exists in the database (in case cache is stale)
        $db_row = db_get('name, value', TB_OPTIONS, ['name' => $key]);
        
        // If the key is found in the database, use that value
        if ($db_row) {
            $value = $db_row['value']; 
            $settings[$key] = $value;
            cache_save($cache_key, $settings, $cache_time_limit); 
            return $value;
        }
       
        if ($value) {
            $value = (is_array($value)) ? json_encode($value) : $value;
            $db_row = [
                'name' => $key,
                'value' => $value
            ];
        } else {
            $general_setting = config('AppConfig')->general_setting;
            $value = $general_setting[$key] ?? '';
            $value = (is_array($value)) ? json_encode($value) : $value;
            $db_row = [
                'name' => $key,
                'value' => $value
            ];
        }
        db_insert(TB_OPTIONS, $db_row);
        $settings[$key] = $value;
        cache_save($cache_key, $settings, $cache_time_limit);
        return $value;
    }
}


if (!function_exists('segment')) {
    function segment($index)
    {
        $request = \Config\Services::request();
        return $request->getUri()->getSegment($index);
    }
}


require_once APPPATH . 'Libraries/htmLawed.php';

if (!function_exists('sanitize_output')) {
    function sanitize_output($output_data) {
        if ($output_data) {
            if (is_array($output_data)) {
                return array_map('sanitize_output', $output_data);
            } elseif (is_string($output_data)) {
                $config = [
                    'safe' => 1,  
                    'deny_attribute' => 'onclick', 
                    'deny_element' => 'script' 
                ];
                $output_data = htmLawed($output_data, $config);
            }
        }
        return $output_data;
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        if ($input) {
            if (is_array($input)) {
                foreach ($input as $key => $value) {
                    $input[$key] = sanitize_input($value);
                }
            } else {
                if (is_string($input)) {
                    $config = [
                        'safe' => 1, 
                        'deny_attribute' => 'onclick',  
                        'deny_element' => 'script',    
                    ];
                    $input = htmLawed($input, $config);
                }
            }
        }
        return $input;
    }
}

if (!function_exists('sanitize_data')) {
    function sanitize_data($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize_data($value); 
            }
        } elseif (is_string($data)) {
            $data = trim($data); 
            $data = esc($data); 
        }
        return $data;
    }
}

if (!function_exists('get')) {
    function get($key = "") {
        $request = \Config\Services::request();
        $get_data = $key ? $request->getGet($key) : $request->getGet();
        return sanitize_data($get_data);
    }
}

if (!function_exists('get_post')) {
    function get_post($name = "", $is_escape = TRUE) {
        $request = \Config\Services::request();
        $post_data = $name ? $request->getPost($name) : $request->getPost();
        return sanitize_data($post_data);
    }
}

/**
 * Save data to cache.
 *
 * @param string $key The cache key.
 * @param mixed $value The data to be cached.
 * @param int $ttl The time-to-live for the cache in seconds (default is 3600 seconds = 1 hour).
 */
if (!function_exists('cache_save')) {
    function cache_save($key, $value, $ttl = 3600)
    {
        if (empty($key)) {
            log_message('error', 'Cache key cannot be null or empty');
            return null; 
        }
        $cache = \Config\Services::cache();
        return $cache->save($key, $value, $ttl);
    }
}

/**
 * Get data from cache.
 *
 * @param string $key The cache key.
 * @return mixed|null The cached data, or null if not found.
 */
if (!function_exists('cache_get')) {
    function cache_get($key)
    {
        if (empty($key)) {
            log_message('error', 'Cache key cannot be null or empty');
            return null; 
        }

        $cache = \Config\Services::cache();
        $value = $cache->get($key);
        return $value ? $value : null;
    }
}


/**
 * Delete data from cache.
 *
 * @param string $key The cache key.
 */
if (!function_exists('cache_delete')) {
    function cache_delete($key)
    {
        if (empty($key)) {
            log_message('error', 'Cache key cannot be null or empty');
            return null; 
        }
        $cache = \Config\Services::cache();
        $cache->delete($key);
    }
}

/**
 * Get Cache key from App Config.
 *
 * @param string $key The cache key.
 * @param string|null $locale The locale (optional).
 * @return string|null The formatted cache key, or null if not found.
 */
if (!function_exists('get_cache_key')) {
    function get_cache_key($key) {
        $cache_config_keys = config('AppConfig')->cache_keys;
        if (isset($cache_config_keys[$key])) {
            return $cache_config_keys[$key];
        }
        return null;
    }
}


/**
 * Clear all cached data.
 *
 * This function will delete all cached items from the cache storage.
 */
if (!function_exists('clear_all_cache')) {
    function clear_all_cache()
    {
        $cache = \Config\Services::cache();
        $cache->clean();
    }
}


if (!function_exists('session_get')) {
    function session_get($input)
    {
        $session = \Config\Services::session();
        if (!$session->has($input)) {
            return null; 
        }
        return $session->get($input);
    }
}

if (!function_exists('session_set')) {
    function session_set($name, $input)
    {
        $session = \Config\Services::session();
        $session->set($name, $input);
    }
}

if (!function_exists('session_remove')) {
    function session_remove($name)
    {
        $session = \Config\Services::session();
        $session->remove($name);
    }
}

if (!function_exists('set_custom_cookie')) {
    function set_custom_cookie($name, $value, $expire_time = null)
    {
        helper('cookie');
        $cookie_expire = getenv('cookie.expires') ? getenv('cookie.expires') : 900; 
        $cookie_secure = getenv('cookie.secure') == 'true';  
        $cookie_httponly = getenv('cookie.httponly') == 'true'; 
        $cookie_samesite = getenv('cookie.samesite') ? getenv('cookie.samesite') : 'Lax';  
        $cookie_path = getenv('cookie.path') ? getenv('cookie.path') : '/';  
        $cookie_domain = getenv('cookie.domain') ? getenv('cookie.domain') : ''; 
        
        $expire_time = $expire_time ? $expire_time : $cookie_expire;
        $cookie = [
            'name'     => $name,
            'value'    => $value,
            'expire'   => time() + $expire_time, 
            'secure'   => $cookie_secure,
            'httponly' => $cookie_httponly,
            'samesite' => $cookie_samesite,
            'path'     => $cookie_path,
            'domain'   => $cookie_domain,
        ];
        set_cookie($cookie);
        pr(get_cookie($name), 1);
    }
}



/**
 * Check if the URL slug is valid.
 * 
 * This function checks if the given URL slug contains only lowercase letters, numbers, and hyphens.
 * It does not allow any special characters, spaces, or uppercase letters.
 *
 * @param string $url_slug The URL slug to validate.
 * @return bool Returns `true` if the URL slug is valid, `false` otherwise.
 */
if (!function_exists('is_valid_url_slug')) {
    function is_valid_url_slug($url_slug)
    {
        // Check if the URL slug matches the allowed pattern (lowercase letters, numbers, and hyphens only)
        return preg_match('/^[a-z0-9-]+$/', $url_slug) === 1;
    }
}


/**
 * Show the 404 error page by throwing a PageNotFoundException.
 * 
 * This function will immediately throw a 404 error and display the default
 * 404 page of CodeIgniter without the need to manually trigger it in controllers.
 *
 * @return void
 */
if (!function_exists('show_404_page')) {
    function show_404_page()
    {
        $path_view_controller = 'themes/regular/';
        $view_data = [
            'page_seo'              => '',
            'sections_html'         => '',
            'controller_name'       => '',
            'path_view_controller'  => $path_view_controller,
        ];
        echo view($path_view_controller . '404_page', $view_data);
    }
}



/**
 * Returns a JSON response from an array and ends the script
 *
 * @param array $array
 */
if (!function_exists('json_response')) {
    function json_response($data)
    {
        $response = \Config\Services::response();
        $response->setContentType('application/json')->setBody(json_encode($data));
        $response->send();
        exit;
    }
}


/**
 * Generates a JSON response for validation status and message
 *
 * @param string $status
 * @param string $message
 * @return \CodeIgniter\HTTP\Response
 */
if (!function_exists('_validation')) {
    function _validation($status = '', $message = '')
    {
        return json_response(['status' => $status, 'message' => $message]);
    }
}


 /**
 * @Return array allow fields before insert to database
 * @param array $array
 */
if (!function_exists('get_escaping_data')) {
    function get_escaping_data($input_data = '', $exceptedKeys = [])
    {
        if (is_array($input_data)) {
            foreach ($input_data as $key => $input) {
                if (!in_array($key, $exceptedKeys)) {
                    $input_data[$key] = sanitize_input($input);
                }
            }
        } elseif (is_string($input_data)) {
            $input_data = esc(trim($input_data));
        }
        return $input_data;
    }
}


 /**
 * return random str
 */
if (!function_exists('ids')) {
    function ids()
    {
        // return md5(now());
        return generate_uuid_v4();
    };
}


 /**
 * return random str
 */
if (!function_exists('generate_uuid_v4')) {
    function generate_uuid_v4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return sprintf('%s-%s-%s-%s-%s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }

}

if (!function_exists('strip_tag_css')) {
    function strip_tag_css($text)
    {
        $text = preg_replace('/<style.*?<\/style>/is', '', $text);
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        return $text;
    }
}

if (!function_exists('truncate_string')) {
    function truncate_string($string = "", $max_length = 50, $ellipsis = "...", $trim = true)
    {
        $max_length = (int) $max_length;
        if ($max_length < 1) {
            $max_length = 50;
        }

        if (!is_string($string)) {
            $string = "";
        }

        if ($trim) {
            $string = trim($string);
        }

        if (!is_string($ellipsis)) {
            $ellipsis = "...";
        }

        $string_length = mb_strlen($string);
        $ellipsis_length = mb_strlen($ellipsis);
        if ($string_length > $max_length) {
            if ($ellipsis_length >= $max_length) {
                $string = mb_substr($ellipsis, 0, $max_length);
            } else {
                $string = mb_substr($string, 0, $max_length - $ellipsis_length)
                    . $ellipsis;
            }
        }

        return $string;
    }
}

if (!function_exists('get_plugin_css_js_path')) {
    function get_plugin_css_js_path($params = [], $type = 'js')
    {
        if (!in_array($type, ['js', 'css'])) {
            $type = 'js';
        }
        $plugin_paths = config('AppConfig')->assets_plugin_paths[$type];
        $result_paths = [];
        if ($params) {
            foreach ($params as $key => $plugin_name) {
                if (isset($plugin_paths[$plugin_name]) && $plugin_paths[$plugin_name]) {
                    $result_paths[$plugin_name] = $plugin_paths[$plugin_name];
                }
            }
        }
        return $result_paths;
    }
}


/**
 * Check if the request is an AJAX request.
 *
 * @param \CodeIgniter\HTTP\RequestInterface|null $request
 *        The Request object to check. If not provided, the function will
 *        use the Request object from the CodeIgniter services.
 * @return bool
 *        Returns true if the request is an AJAX request, false otherwise.
 */
if (!function_exists('is_ajax_request')) {
    function is_ajax_request($request = null): bool
    {
        $request = $request ?? \Config\Services::request();
        return $request->isAJAX();
    }
}


/**
 * Check if the request is an AJAX request with post method.
 */
if (!function_exists('is_ajax_post_request')) {
    function is_ajax_post_request($request = null): bool
    {
        return is_ajax_request() && is_request_method('POST');
    }
}


/**
 * Check if the request is an AJAX request with Get method.
 */
if (!function_exists('is_ajax_get_request')) {
    function is_ajax_get_request($request = null): bool
    {
        return is_ajax_request() && is_request_method('GET');
    }
}


/**
 * Check if the request method matches the specified type.
 *
 * @param string $method
 *        The HTTP method to check against (e.g., 'POST', 'GET').
 * @param \CodeIgniter\HTTP\RequestInterface|null $request
 *        The Request object to check. If not provided, the function will
 *        use the Request object from CodeIgniter services.
 * @return bool
 *        Returns true if the request method matches, false otherwise.
 */
if (!function_exists('is_request_method')) {
    function is_request_method($method, $request = null)
    {
        // Use the provided Request object, or get it from CodeIgniter services if not provided
        $request = $request ?? \Config\Services::request();

        // Check and return whether the request method matches the specified type
        return strtoupper($request->getMethod(true)) === strtoupper($method);
    }
}


if (!function_exists('handle_db_operation_result')) {
    /**
     * Handles the result of a database operation and returns the appropriate message.
     *
     * @param bool $result The result of the database operation.
     * @param string $successKey The key for the success message.
     * @param string $errorKey The key for the error message.
     * @param array $optional_msgs Optional custom messages for success or error.
     * @return array An associative array containing the status and message.
     */
    function handle_db_operation_result($result, $success_key, $error_key, $optional_msgs = [])
    {
        $custom_success_msg = isset($optional_msgs[$success_key]) ? $optional_msgs[$success_key] : null;
        $custom_error_msg = isset($optional_msgs[$error_key]) ? $optional_msgs[$error_key] : null;

        if ($result) {
            return get_message($success_key, $custom_success_msg);
        }
        return get_message($error_key, $custom_error_msg);
    }
}


if (!function_exists('get_message')) {
    /**
     * Retrieves a message based on the provided key.
     *
     * @param string $key The key for which to retrieve the message.
     * @param string|null $optional_msg Optional custom message to override the default.
     * @return array An associative array containing the status and message.
     */
    function get_message($key, $optional_msg = null)
    {
        // Array containing predefined messages
        $messages = [
            'error' => [
                'status' => 'error',
                'message' => $optional_msg ?? 'An error occurred. Please try again later.'
            ],
            'success' => [
                'status' => 'success',
                'message' => $optional_msg ?? 'Action successful'
            ],
            'not_found' => [
                'status' => 'error',
                'message' => $optional_msg ?? 'The item you are looking for was not found.'
            ],
            'invalid' => [
                'status' => 'error',
                'message' => $optional_msg ?? 'The input data is invalid. Please correct it.'
            ],
            'deleted' => [
                'status' => 'success',
                'message' => $optional_msg ?? 'Deleted successful.'
            ],
            'duplicated' => [
                'status' => 'success',
                'message' => $optional_msg ?? 'Duplicated successful.'
            ],
            'updated' => [
                'status' => 'success',
                'message' => $optional_msg ?? 'Updated successful.'
            ],
            'added' => [
                'status' => 'success',
                'message' => $optional_msg ?? 'Added successful.'
            ],
            'no_selection' => [
                'status' => 'error',
                'message' => $optional_msg ?? 'No items selected. Please choose at least one item.'
            ]
        ];

        return $messages[$key] ?? [
            'status' => 'error',
            'message' => 'No message found for the provided key.'
        ];
    }
}


/**
 * Render the HTML meta tags for CSRF protection.
 * 
 * This function generates the HTML `<meta>` tags for the CSRF token and its hash.
 * These tags can be added to the header of an HTML page to be used in subsequent form submissions.
 *
 * @return string The HTML meta tags containing the CSRF token and hash.
 */
if (!function_exists('render_html_meta_token')) {
    function render_html_meta_token()
    {
        $name = 'csrf_name';
        $value = 'csrf_value';
        $xhtml = sprintf('<meta name="%s" content="%s">
                        <meta name="%s" content="%s">', 
                        $name, csrf_token(), $value, csrf_hash()
        );
            
        return $xhtml;
    }
}