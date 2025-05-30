<?php 

if (!function_exists("client_get_order_link")) {
    function client_get_order_link($item_service = [])
    {
        $query_link_array =  [
            'sid' => $item_service['ids'],
        ];
        $order_link = 'order?' . http_build_query($query_link_array);
        return $order_link;
    }
}


if (!function_exists("client_url")) {
    function client_url($route_name = '')
    {
        return base_url('/' . $route_name);
    }
}


if (!function_exists('blog_post_single_url')) {
    function blog_post_single_url($url_slug = "")
    {
        if (!empty($url_slug)) {
            $url_slug 	= 'blog/'. (sanitize_output($url_slug));
            return render_language_url($url_slug);
        } 
        return client_url();
    }
}

if (!function_exists('blog_post_category_url')) {
    function blog_post_category_url($url_slug = "")
    {
        if (!empty($url_slug)) {
            $url_slug 	= 'blog/category/'. (sanitize_output($url_slug));
            return render_language_url($url_slug);
        } 
        return client_url();
    }
}


if (!function_exists("generate_client_order_id")) {
    function generate_client_order_id() {
        $date = date('Ymd'); 
        try {
            $random_string = strtoupper(bin2hex(random_bytes(4)));
        } catch (Exception $e) {
            $random_string = strtoupper(uniqid('', true)); 
        }
        $order_id = $date . $random_string;
        return $order_id;
    }
}


if (!function_exists('show_item_post_released_time')) {
    function show_client_date_time($datetime)
    {
        $config = config('AppConfig')->template;
        $result = date($config['datetime']['client'], strtotime($datetime));
        return $result;
    }
}

if (!function_exists("get_client_menu_cache")) {
    function get_client_menu_cache() {
        $menu_cache_key = get_cache_key('client_header_menu') . '_' . current_locale();
        $menu_cached    = cache_get($menu_cache_key);
        if ($menu_cached) {
            return $menu_cached;
        } else {
            $items_menu  = db_fetch('id, name, options, name_lang, type, status, target, sort', TB_MENU, ['status' => 1], 'sort', 'ASC');
            $xhtml_menu = null;
            $xhtml_content = '';
            if ($items_menu) {
                $i = 1;
                foreach ($items_menu as $key => $item_menu) {
                    $class_center_menu = ($i == 1) ? 'ms-xl-auto': '';
                    $item_name_lang = get_value_by_key($item_menu['name_lang'], current_locale());
                    $item_menu_name = $item_name_lang ?? $item_menu['name'];
                    switch ($item_menu['type']) {
                        case 'blog':
                        case 'track_order':
                        case 'link':
                            $item_link_url = get_value_by_key($item_menu['options'], 'url_slug');
                            $item_link_url = ($item_menu['type'] == 'link' && isset($item_link_url[current_locale()])) ? $item_link_url[current_locale()] : '';
                            $item_link_url = render_language_url($item_link_url);
                            $link_target = ($item_menu['target'] == 'blank') ? '_blank' : '_self';
                            $item_nav_class = ($item_menu['type'] !== 'track_order') ? 'text-dark bg-light-hover' : 'text-white bg-primary';
                            $xhtml_link_content = sprintf('<li class="nav-item %s">
                                                            <a href="%s" target="%s" class="px-3  %s nav-link rounded-3 text-base leading-6">
                                                                %s
                                                            </a>
                                                        </li>', $class_center_menu, $item_link_url, $link_target, $item_nav_class, $item_menu_name);
                            $xhtml_content .= $xhtml_link_content;
                            
                            break;
                        case 'social_network_option':
                            $item_sncate_id  = get_value_by_key($item_menu['options'], 'sncate_id');
                            $items_category  = db_fetch_social_category_by_language_for_menu($item_sncate_id, current_locale());
                            if (empty($items_category)) break;
                            $xhtml_dropdown_content = null;
                            $xhtml_dropdown_content .= '<li class="nav-item '. $class_center_menu .'">';
                            $xhtml_dropdown_content .= '<div class="dropdown">';
                            $xhtml_dropdown_content .= sprintf('
                                                            <a class="btn w-100 d-flex justify-content-between align-items-center text-dark bg-light-hover nav-link rounded-3 text-base leading-6" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="text-start">%s</span>
                                                                <svg class="ms-1" width="10" height="7" viewBox="0 0 10 7"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill="currentColor"
                                                                        d="M7.918 0.995L4.615 4.297 1.313 0.995c-.302-.291-.782-.287-1.079.009-.3.298-.304.778-.008 1.08L4.072 5.928c.3.3.787.3 1.088 0L9.005 2.082c.2-.193.28-.479.215-.748-.065-.27-.276-.48-.545-.55-.27-.07-.556.01-.749.215z" />
                                                                </svg>
                                                            </a>',$item_menu_name);

                            $xhtml_dropdown_content .= '<ul class="dropdown-menu dropdown-menu-end dropdown-menu-hover end-0 text-sm shadow bg-white" style="--bs-dropdown-min-width: 9rem;">';
                            $xhtml_dropdown_content .= '<li class="d-none d-xl-block" style="color: var(--bs-white);">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                fill="currentColor"
                                                                class="mt-n1 d-inline-block position-absolute top-0 end-0 translate-middle"
                                                                viewBox="0 0 16 16">
                                                                <path class="carret-dropdown-path"
                                                                    d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" />
                                                            </svg>
                                                        </li>';
                            if ($items_category) {
                                foreach ($items_category as $key => $item_category) {
                                    $item_category_url_slug = $item_category['url_slug'];
                                    $item_category_name = $item_category['name'];
                                    $xhtml_dropdown_content .= sprintf('
                                    <li>
                                        <a class="dropdown-item text-dark bg-primary-hover text-white-hover py-2 text-base leading-6"
                                            href="%s">
                                            %s
                                        </a>
                                    </li>', render_language_url($item_category_url_slug), $item_category_name);
                                }
                            }

                            $xhtml_dropdown_content .= '</ul></div></li>';
                            $xhtml_content .= $xhtml_dropdown_content;
                            break;
                    }
                    ++$i;
                }
            }
            
            $xhtml_menu = '<div class="offcanvas-body">
                                <ul class="navbar-nav align-items-xl-center flex-grow-1 column-gap-4 row-gap-4 row-gap-xl-2">';
                
            $xhtml_menu .= '</ul></div>';
            $xhtml_menu = sprintf('<div class="offcanvas-body">
                                    <ul class="navbar-nav align-items-xl-center flex-grow-1 column-gap-4 row-gap-4 row-gap-xl-2">%s
                                    </ul>
                                </div>', $xhtml_content);
            cache_save($menu_cache_key, $xhtml_menu, 86400); 
            return $xhtml_menu;
        }    
    }
}

if (!function_exists('clear_client_menu_cache')) {
    function clear_client_menu_cache()
    {
        $prefix_cache_key = get_cache_key('client_header_menu') . '_';
        $items_language = get_active_languages();
        if ($items_language) {
            foreach ($items_language as $key => $item) {
                $cache_key = $prefix_cache_key . $item['code'];
                cache_delete($cache_key);
            }
        }
        return false;
    }
}

if (!function_exists('get_active_languages')) {
    function get_active_languages()
    {
        $items = db_fetch('ids, code, country_code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        return $items;
    }
}


/**
 * Generates an HTML form with hidden inputs based on the provided parameters
 * and automatically submits it using JavaScript once the page is loaded.
 *
 * @param array $param_list Associative array of parameters to be included as hidden inputs in the form.
 * @param string $action_url The URL where the form data will be submitted (default is '#').
 * @param string $method The HTTP method to use for form submission (default is 'POST').
 * @param string $form_id The unique ID for the form (default is 'payment_method_form').
 * 
 * @return string The generated HTML form with JavaScript for automatic submission.
 */
if (!function_exists('generate_payment_form_html')) {
    function generate_payment_form_html($param_list, $action_url = '#', $method = 'POST', $form_id = 'payment_method_form') {
        if (!filter_var($action_url, FILTER_VALIDATE_URL)) {
            return 'Invalid URL provided for form action.';
        }
        // Start building the form HTML
        $form_html = sprintf(
            '<form id="%s" action="%s" method="%s">',
            htmlspecialchars($form_id),
            htmlspecialchars($action_url),
            htmlspecialchars($method)
        );

        // Loop through each parameter in the param_list to create hidden input fields
        foreach ($param_list as $key => $value) {
            // Add each parameter as a hidden input field in the form using sprintf
            $form_html .= sprintf(
                '<input type="hidden" name="%s" value="%s">',
                htmlspecialchars($key),
                htmlspecialchars($value)
            );
        }

        // Add JavaScript to automatically submit the form once the page is loaded using sprintf
        $form_html .= sprintf(
            '<script type="text/javascript">
                $(function() {
                    document.getElementById("%s").submit();
                });
            </script>',
            htmlspecialchars($form_id)
        );

        // Close the form tag
        $form_html .= '</form>';

        // Return the generated form HTML
        return $form_html;
    }

}


