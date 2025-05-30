<?php
use App\Models\Admin\OrdersModel;

/**
 * @param array $columns
 * @return render html table thead
 * @author Seji2906
 */
if (!function_exists('render_table_thead')) {
    function render_table_thead($columns, $checkItems = true, $showNumber = true, $action =  true, $params = [])
    {
        $xhtml = '<thead><tr>';
        if (isset($params['sort-table']) && $params['sort-table']) {
            $xhtml .= '<th class="text-center w-1"><i class="fe fe-move"></i></th>';
        }
        if ($checkItems) {
            $dataName = (isset($params['checkboxDataName'])) ? $params['checkboxDataName'] : 'check_1';
            $show_checkItems = show_item_checkbox('checkAllItems', '', 'check-all', $dataName);
            $xhtml .= sprintf('<th class="text-center w-1">%s</th>', $show_checkItems);
        }
        if ($showNumber) {
            $xhtml .= '<th class="text-center w-1">No.</th>';
        }
        if (!empty($columns)) {
            foreach ($columns as $column) {
                $xhtml .= sprintf('<th class="%s">%s</th>', $column['class'], $column['name']);
            }
        }
        if ($action) {
            $xhtml .= '<th class="text-center">action</th>';
        }
        $xhtml .= '</tr></thead>';
        return $xhtml;
    }
}

/**
 * @param array $columns
 * @return render html table thead
 * @author Seji2906
 */
if (!function_exists('renderTableTr')) {
    function renderTableTr($item = '', $trElement = [], $params = [])
    {
        $xhtmlTD = '';
        $xhtml = '';
        foreach ($trElement['tdElements'] as $key => $td) {
            $tbAtrr = '';
            $xhtmlTD .= sprintf(
                '<td class="%s" %s>%s</td>', $td['class'], $tbAtrr, $td['element']
            );
        }
        $xhtmlTrAttr = '';
        foreach ($trElement['attr'] as $key => $trAttr) {
            $xhtmlTrAttr .= ' data-'. $key . '="'. $trAttr .'"';
        }
        $xhtml = sprintf(
            '<tr class="%s" %s>%s</tr>', $trElement['class'], $xhtmlTrAttr, $xhtmlTD
        );
        return $xhtml;
    }
}

/**
 * @param array $columns
 * @return render html table thead
 * @author Seji2906
 */
if (!function_exists('render_tr_class')) {
    function render_tr_class($controller_name, $item = [], $options = [])
    {
        $tr_class = isset($item['ids']) ? 'tr_'. $item['ids'] : '';
        $class_row_disabled = null;

        if (isset($item['status']) && in_array($item['status'], [0])) {
            $class_row_disabled = 'row-disabled';
        }
 
        if ($class_row_disabled) {
            $tr_class .= ' '. $class_row_disabled;
        }
        return $tr_class;
    }
}

/**
 * From V2.0
 * @param $controller_name 
 * @return html show_bulk_actions
  * @author Seji2906
 */
if (!function_exists('show_bulk_actions')) {
    function show_bulk_actions($controller_name, $params = '')
    {
        $xhtmlActionsBtn = null;
        $tmplBtn = config('AppConfig')->template['bulk_action'];
        $btn_area     = config('AppConfig')->config['bulk_action'];
        $curentBtnArea = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        if (in_array($controller_name, ['orders'])) {
            if (get('status') != "error") {
                $curentBtnArea = array_diff($curentBtnArea, ['resend']);
            }
        }
        $xhtmlActionsBtn .='<div class="item-action dropdown action-options"><button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Actions <span class="fe fe-chevrons-down"></span></button><div class="dropdown-menu dropdown-menu-right">';
        foreach ($curentBtnArea as $item) {
            $currentBtn = $tmplBtn[$item];
            $link        = admin_url($controller_name . $currentBtn['route-name']);
            $actionType = 'data-type="'. $item .'"';
            $xhtmlActionsBtn .= sprintf('<a href="%s" %s class="dropdown-item %s"><i class="dropdown-icon %s"></i> %s</a>', $link, $actionType, $currentBtn['class'], $currentBtn['icon'], $currentBtn['name']);
        }
        $xhtmlActionsBtn .= '</div></div>';
        return $xhtmlActionsBtn;
    }
}

/**
 * From V2.0
 * @param $controller_name 
 * @return html show_sort_by_on_page_tilte
  * @author Seji2906
 */
if (!function_exists('show_sort_by_on_page_tilte')) {
    function show_sort_by_on_page_tilte($controller_name, $items = [], $params = '')
    {
        $xhtml = null;
        if ($items) {
            $link = admin_url($controller_name);
            $xhtml = sprintf('<select name="status" class="form-select m-t-4 m-r-10 %s" data-url="%s">', $params['class'], $link);
            $xhtml .= '<option value="0">All</option>';
            foreach ($items as $key => $item) {
                $selected = (get('sort_by') == $item['id']) ? 'selected' : '';
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $item['id'], $selected, sanitize_output($item['name']));
            }
            $xhtml .= '</select>';
        }
        return $xhtml;
    }
}

/**
 * @param $ids - items $ids
 * @param $class_input
 * @param $data_name - Input attr
 * @return HTML Created Item Check Box
 * @author Seji2906
 */
if (!function_exists('show_item_checkbox')) {
    function show_item_checkbox($type = null, $ids = '', $class_input = "check-all", $data_name = 'check_1')
    {
        $xhtml       = null;
        $xhtml_input = null;
        switch ($type) {
            case 'checkAllItems':
                $xhtml_input = sprintf('<input type="checkbox" class="form-check-input check-items %s" data-name="%s">', $class_input, $data_name);
                break;
            case 'checkItem':
                $xhtml_input = sprintf('<input type="checkbox" class="form-check-input check-item %s" name="ids[]" value="%s">', $data_name, $ids);
                break;
        }
        $xhtml = sprintf('<div class="custom-controls-stacked">
                            <label class="form-check">%s<span class="custom-control-label"></span>
                            </label>
                        </div>', $xhtml_input);
        return $xhtml;
    }
}

/**
 * From V2.0
 * @param $status - Status input
 * @param name $controller_name
 * @return HTML Created Item Status
 * @author Seji2906
 */
if (!function_exists('show_item_status')) {
    function show_item_status($controller_name, $id, $status, $type = null, $task = null)
    {
        $xhtml = null;
        $config_status       = config('AppConfig')->config['status'];
        $config_tmpl_status = config('AppConfig')->template['status'];
        switch ($type) {
            case 'switch':
                $link = admin_url($controller_name . '/change_status/');
                $checked = ($status) ? 'checked' : '';
                $xhtml = sprintf('<label class="custom-switch">      
                                    <input type="checkbox" name="item_status" data-id="%s" data-status="%s" data-action="%s" class="custom-switch-input ajaxToggleItemStatus" %s>
                                    <span class="custom-switch-indicator"></span>
                                </label>', $id, $status, $link, $checked);
                break;
            default:
                $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name  : 'default';
                if (in_array($controller_name, ['order', 'dripfeed', 'subscriptions', 'refill', 'affiliates'])) {
                    $tmpl_status         = $config_tmpl_status['order'];
                } else {
                    $tmpl_status         = $config_tmpl_status[$current_tmpl_status];
                }
                $current_tmpl_status = (array_key_exists($status, $tmpl_status)) ? $tmpl_status[$status] : $tmpl_status['1'];
                $statusName = $current_tmpl_status['name'];
                $xhtml = sprintf('<span class="badge %s">%s</span>', $current_tmpl_status['class-badge'], $statusName);
                break;
        }
        return $xhtml;
    }
}

/**
 * From V2.0
 * @param int $ids - items $ids
 * @param name $controller_name
 * @param array $params_option - default null
 * @return HTML Show button action for item
 * @author Seji2906
 */
if (!function_exists('show_item_button_action')) {
    function show_item_button_action($controller_name, $ids = '', $format = 'dropdown', $params_option = [])
    {
        $xhtml = null;
        $tmpl_buttons = config('AppConfig')->template['button'];
        $btn_area = config('AppConfig')->config['button'];
        $curent_btn_area = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        switch ($format) {
            case 'btn-group':
                $xhtml .= '<div class="btn-group">';
                foreach ($curent_btn_area as $item) {
                    $current_btn = $tmpl_buttons[$item];
                    $link = admin_url($controller_name . $current_btn['route-name'] . $ids);
                    if (isset($params_option['http_build_query'])) {
                        $link .= '?'. http_build_query($params_option['http_build_query']);
                    }
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "Are you sure you want to delete this item";
                    } else if ($item == 'delete_custom_rate') {
                        $confirm_message = "Are you sure you want to delete custom rates for this service?";
                    }
                    $xhtml .= sprintf(
                        '<a href="%s" class="btn btn-icon btn-outline-info %s" data-confirm_ms="%s" data-toggle="tooltip" data-placement="bottom" title="%s">
                            <i class="%s"></i>
                        </a>', $link, $current_btn['class'], $confirm_message, $current_btn['name'], $current_btn['icon']);
                }
                $xhtml .= '</div>';
                break;
            
            default:
                $xhtml .='<div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                        <div class="dropdown-menu">';
                foreach ($curent_btn_area as $item) {

                    // for manages page
                    if (isset($params_option['item']['is_core_page']) && $item == 'delete' && $params_option['item']['is_core_page']) {
                        continue;
                    }

                    $current_btn = $tmpl_buttons[$item];
                    $link = admin_url($controller_name . $current_btn['route-name'] . $ids);
                    if (isset($params_option['http_build_query'])) {
                        $link .= '?'. http_build_query($params_option['http_build_query']);
                    }
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "Are you sure you want to delete this item";
                    } else if ($item == 'delete_custom_rate') {
                        $confirm_message = "Are you sure you want to delete custom rates for this service?";
                    }
                    $xhtml .= sprintf('<a href="%s" class="dropdown-item %s" data-confirm_ms="%s"><i class="dropdown-icon %s"></i> %s</a>', $link, $current_btn['class'], $confirm_message, $current_btn['icon'], $current_btn['name']);
                }
                $xhtml .= '</div></div>';
                break;
        }
        return $xhtml;
    }
}

/**
 * From V2.0
 * @param array $items_status_count
 * @param name $controller_name
 * @return HTML Create Status Filter Button
 * @author Seji2906
 */
if (!function_exists('show_filter_status_button')) {
    function show_filter_status_button($controller_name, $items_status_count = [], $params = [])
    {
        $xhtml = null;
        $config_status       = config('AppConfig')->config['status'];
        $config_tmpl_status  = config('AppConfig')->template['status'];

        if (in_array($controller_name, ['orders', 'refill'])) {
            $status_in_controller = (in_array($controller_name, array_keys($config_status))) ? $config_status[$controller_name] : $config_status['orders'];
            $status_in_controller = array_keys($status_in_controller);
            $tmpl_orders_status = $config_tmpl_status['orders'];
            $xhtml          = '<ul class="list-inline mb-0 order_btn_group">';
            $param_search   = $params['search'];
            $current_search = array_combine(array_keys($param_search), array_values($param_search));
            foreach ($status_in_controller as $item) {
                $xhtml_count_items = null;
                if ($item == 'error' || $item == 'fail') {
                    $model = new OrdersModel();
                    $count_items_status = $model->count_items_by_item_status(['status' => $item]);
                    if ($count_items_status > 0) {
                        $xhtml_count_items = sprintf('<span class="badge badge-pill bg-red">%s</span></a>', $count_items_status);
                    }
                }
                $link = admin_url($controller_name) . '?status=' . $item;
                if ($current_search['query'] != "") {
                    $link .= '&' . http_build_query($current_search);
                }
                $current_status = (get('status') != "") ? get('status') : 'all';
                $current_class  = ($current_status == $item) ? 'btn-primary' : '';
                $xhtml .= sprintf(
                    '<li class="list-inline-item">
                        <a class="btn %s" href="%s">%s %s</a>
                    </li>', $current_class, $link, $tmpl_orders_status[$item]['name'], $xhtml_count_items 
                );
            }
            $xhtml .= '</ul>';
        } else {
            $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name : 'default';
            $tmpl_status         = $config_tmpl_status[$current_tmpl_status];
            $xhtml .= '<div class="btn-group w-30 m-b-10">';
            if (!in_array($controller_name, ['tickets', 'orders'])) {
                array_unshift($items_status_count, [
                    'status' => 3,
                    'count'  => array_sum(array_column($items_status_count, 'count'))
                ]);
            }
            $param_search = $params['search'];
            $current_search = array_combine(array_keys($param_search), array_values($param_search));
            foreach ($items_status_count as $key => $item) {
                $link = admin_url($controller_name) . '?status=' . $item['status'];
                if (!empty($params['path_link'])) {
                    $link = $params['path_link'] . '?status=' . $item['status'];
                }
                if ($current_search['query'] != "") {
                    $link .= '&' . http_build_query($current_search);
                }
                $current_status = (array_key_exists($item['status'], $tmpl_status)) ? $item['status'] : '3'; //Default
                $current_class  = (get('status') == $item['status'] ) ? 'btn-primary' : '';
                $xhtml .= sprintf('<a href="%s" class="btn %s">%s <span class="badge badge-pill %s">%s</span></a>',
                    $link, $current_class, $tmpl_status[$current_status]['name'], $tmpl_status[$current_status]['class'], $item['count']
                );
            }
            $xhtml .= '</div>';
        }
        
        return $xhtml;
    }
}


/**
 * From V2.0
 * @param array $params
 * @param name $controller_name
 * @return HTML Show Search Area
 * @author Seji2906
 */
if (!function_exists('show_search_area')) {
    function show_search_area($controller_name, $params, $task = 'admin')
    {
        $xhtml = null;
        $controller_name = (in_array($controller_name, ['blacklist'])) ? $controller_name . '_' . service('router')->methodName() : $controller_name;
        $tmplSearchFields   = config('AppConfig')->template['search_field'];
        $fieldInController  = config('AppConfig')->config['search'];
        $current_controller = (array_key_exists($controller_name, $fieldInController)) ? $controller_name : 'default';
        $param_search = $params['search'];
        $xhtml_fields = null;
        $classBtnClear = (!empty($param_search['query'])) ? '' : 'd-none';
        $searchPlaceholder = 'Search for...';
        if ($task == 'admin') {
            $xhtml_fields = '<select name="field" class="form-control" id="">';
            foreach ($fieldInController[$current_controller] as $item) {
                $selected = ($item == $param_search['field']) ? 'selected' : '';
                $xhtml_fields .= sprintf('<option value="%s" %s>%s</option>', $item, $selected,  $tmplSearchFields[$item]['name']);
            }
            $xhtml_fields .= '</select>';
            $searchPlaceholder = 'Search for...';
        }
        $xhtml = sprintf(
                '<div class="form-group">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="%s" value="%s">
                        %s
                        <button class="btn btn-primary btn-square btn-search" type="button"><span class="fe fe-search"></span></button>
                        <button class="btn btn-outline-danger btn-square btn-clear %s" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Clear" type="button"><span class="fe fe-x"></span></button>
                    </div>
                </div>', $searchPlaceholder, $param_search['query'], $xhtml_fields, $classBtnClear);
        return $xhtml;
    }
}

/**
 * Create HightLight class for match of search Field
 * @param string $input
 * @param array  $param_search field, value
 * @param        $field
 */
if (!function_exists('show_high_light')) {
    function show_high_light($input, $param_search = '', $field = '')
    {
        if ($param_search && $param_search['query'] !== "") {
            if ($param_search['field'] == 'all' || $param_search['field'] == $field) {
                $input = preg_replace('#'. preg_quote($param_search['query']) .'#i', '<span class="highlight">\\0</span>', $input);
            }
        }
        return $input;
    }
}

/**
 * Truncate a string and keep the highlighted text intact, adding "..." if the string is too long.
 * This function highlights specific search keywords and then truncates the string to a maximum length.
 * If the string exceeds the specified length, it appends "..." at the end of the string.
 * 
 * @param string $string The string to be truncated.
 * @param int $max_length The maximum length of the string before truncation.
 * @param string $ellipsis The string to be added at the end of the truncated string (default is "...").
 * @param bool $trim Whether to trim the string before processing (default is true).
 * @param array $param_search The search keywords used for highlighting.
 * @param string $field The field to be searched for (optional, default is empty).
 * 
 * @return string The truncated string with highlights and ellipsis if necessary.
 */
if (!function_exists('truncate_string_with_highlight')) {
    function truncate_string_with_highlight($string = "", $max_length = 50, $ellipsis = "...", $trim = true, $param_search = [], $field = '')
    {
        // Ensure the max length is a positive integer
        $max_length = (int) $max_length;
        if ($max_length < 1) {
            $max_length = 50;
        }

        // Make sure the string is valid and trim it if needed
        if (!is_string($string)) {
            $string = "";
        }

        if ($trim) {
            $string = trim($string);
        }

        $string_length = mb_strlen($string);
        $ellipsis_length = mb_strlen($ellipsis);

        if ($string_length > $max_length) {
            // If the ellipsis length is greater than or equal to the max length, just truncate
            if ($ellipsis_length >= $max_length) {
                $string = mb_substr($string, 0, $max_length);
            } else {
                // Truncate the string and add the ellipsis at the end
                $string = mb_substr($string, 0, $max_length - $ellipsis_length) . $ellipsis;
            }
        }

        $highlighted_string = show_high_light($string, $param_search, $field);

        return $highlighted_string;
    }
}


/**
 * From V20
 * @param $dateTime
 * @return new Datetime format
 */
if (!function_exists('show_item_datetime')) {
    function show_item_datetime($datetime, $type = 'long')
    {
        $datetime = convert_timezone($datetime, 'user');
        $new_datetime = date(config('AppConfig')->template['datetime'][$type], strtotime($datetime));
        return $new_datetime;
    }
}


/**
 * From V2.0
 * @param $item data
 * @return html Order Details
 */
if (!function_exists('show_item_order_details')) {
    function show_item_order_details($controller_name, $item = [], $params = [], $task = 'admin')
    {
        $xhtml = null;

        $link = show_high_light(esc($item['link']), $params['search'], 'link');
        if (filter_var($item['link'], FILTER_VALIDATE_URL)) {
            $link = '<a href="https://anon.ws/?' . $item['link'] . '" class="link-word-break" target="_blank">' . show_high_light(esc($item['link']), $params['search'], 'link') . '</a>';
        }

        $provider = 'Manual';
        if ($item['api_service_id']) {
            $provider = $item['api_name'] . " (ID:" . $item['api_service_id'] . ")";
            if ($item['type'] == 'api') {
                $provider .= ' <span class="badge badge-default">API</span>';
            }
        }
        $charge =  (double)$item['charge'];
        if ($item['formal_charge'] != 0) {
            $charge .= ' ('. (double)$item['formal_charge']. ' / <span class="text-info">'. (double)$item['profit'] .'</span>)';
        }
        
        $orderAttrs = [
            'provider'      => $provider,
            'link'          => $link,
            'quantity'      => $item['quantity'],
            'charge'        => $charge,
            'start counter' => ($item['start_counter']) ? $item['start_counter'] : '',
            'remain'        => ($item['remains']) ? $item['remains'] : '',
        ];
        $xhtml_order_attr = null;
        $xhtml_order_attr = '<ul style="margin: 0px;">';
        foreach ($orderAttrs as $key => $attr) {
            $attr_content = ucfirst($key) . ': ' . $attr;
            $xhtml_order_attr .= sprintf('<li>%s</li>', $attr_content);
        }
        $xhtml_order_attr .= '</ul>';
        $serviceName = $item['service_id'] ." - ". $item['service_name'];
        $xhtml .= sprintf(
            '<div class="title">
                <h6>%s
            </div>
            <div>
                %s
            </div>', $serviceName, $xhtml_order_attr);
        return $xhtml;
    }
}


/**
 * From V2.0
 * @param $item data
 * @return html Order ID
 */
if (!function_exists('show_item_orderId')) {
    function show_item_orderId($controller_name, $item = [], $params=[])
    {
        $xhtml    = null;
        $orderId     = show_high_light($item['id'], $params['search'], 'id');
        $apiOrderId = '';
        if ($item['api_order_id'] > 0) {
            $apiOrderId = show_high_light($item['api_order_id'], $params['search'], 'api_order_id');
        }
        $xhtml = sprintf('
            %s
            <div class="text-muted small">
                %s
            </div>
        ', $orderId, $apiOrderId);
        return $xhtml;
    }
}

/**
 * From V2.0
 * Sort Services by ID
 * @param string $order status
 * @return array
 */
if (!function_exists('order_status_update_form')) {
    function order_status_update_form($controller_name, $status)
    {
        $tmpl_status = config('AppConfig')->template['status']['orders'];
        $orderStatusArray = [];
        if ($controller_name == 'subscriptions') {
            $orderStatusArray = ['canceled', 'completed', 'expired'];
        }

        if ($controller_name == 'dripfeed') {
            switch ($status) {
                case 'active':
                    $orderStatusArray = ['completed', 'canceled'];
                    break;

                case 'canceled':
                    $orderStatusArray = ['canceled'];
                    break;

                default:
                    $orderStatusArray = ['canceled', 'completed'];
                    break;
            }
        }

        if ($controller_name == 'orders') {
            switch ($status) {
                case 'canceled':
                    $orderStatusArray = ['canceled'];
                    break;
                case 'completed':
                    $orderStatusArray = ['completed', 'canceled', 'partial'];
                    break;

                case 'partial':
                    $orderStatusArray = ['canceled'];
                    break;

                case 'error':
                    $orderStatusArray = ['canceled', 'error', 'partial', 'pending', 'inprogress', 'completed'];
                    break;

                default:
                    $orderStatusArray = ['pending', 'processing', 'inprogress', 'completed', 'partial', 'canceled'];
                    break;
            }
        }
        $formStatus = array_intersect_key($tmpl_status, array_flip($orderStatusArray));
        $result = array_combine(array_keys($formStatus), array_column($formStatus, 'name'));
        return $result;
    }
}



/**
 * Generate pagination links.
 *
 * @param array $params
 * @return string Pagination links HTML.
 */
if (!function_exists('render_pagination')) {
    function render_pagination($params = [])
    {
        $pager = \Config\Services::pager();
        $only_epected_queries = $params['only_epected_queries'] ?? [];
        $current_page           = (int) (get('page') ?? 1);
        $per_page               = $params['per_page'] ?? 10;
        $total_items            = $params['total_items'];
        // Check if pagination is needed
        if ($total_items <= $per_page) {
            // Return an empty string if no pagination is needed
            return '';
        }
        $result =  $pager->only($only_epected_queries)->makeLinks($current_page, $per_page, $total_items, 'admin_pagination');
        return $result;
    }
}


/**
 * Get the form item status configuration based on the controller name.
 *
 * This function retrieves the status configuration for form items from the AppConfig configuration file.
 * Depending on the provided controller name, it returns the corresponding form item status configuration.
 *
 * @param string $controller_name The name of the controller (optional) to determine the relevant status configuration.
 * @return array The status configuration of the form items.
 */
if (!function_exists('get_form_item_status_config')) {
    function get_form_item_status_config($controller_name = '')
    {
        $app_config_status = config('AppConfig')->config['status'];
        $config_tmpl_status = config('AppConfig')->template['status'];
        $current_config_status = (array_key_exists($controller_name, $app_config_status)) ? $app_config_status[$controller_name] : $app_config_status['default'];

        $status_tmpl_key = (array_key_exists($controller_name, $app_config_status)) ? $controller_name : 'default';
        $current_status_tmpl = $config_tmpl_status[$status_tmpl_key];
        
        // Filter template array, keeping only the keys that exist in the config array
        $filtered_template = array_intersect_key($current_status_tmpl, $current_config_status);
        $result = array_map(function ($item) {
            return $item['name'];
        }, $filtered_template);
        return $result;
    }
}

/**
 */
if (!function_exists('get_status_rule_by_request')) {
    function get_status_rule_by_request($request_name = '')
    {
        $status_rule = 'required';
        $app_config_status = config('AppConfig')->config['status'];
        $current_config_status = (array_key_exists($request_name, $app_config_status)) ? $app_config_status[$request_name] : $app_config_status['default'];
        $current_config_status = array_keys($current_config_status);
        $status_rule .= '|in_list[' . implode(',', $current_config_status) . ']';
        return $status_rule;
    }
}

if (!function_exists('display_rating_with_stars')) {
    function display_rating_with_stars($rating = 1) {
        $rating = max(1, min(5, $rating)); 
        $rating_html = $rating . ' ';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $rating_html .= '<i class="fe fe-star text-yellow"></i>';
            } else {
                $rating_html .= '<i class="fe fe-star text-gray"></i>';
            }
        }
        return $rating_html;
    }
}

/**
 * Render HTML for tooltip or popover with dynamic content and type.
 *
 * @param string $content The content to display in the tooltip/popover.
 * @param string $type The type of the helper element ('popover' or 'tooltip').
 * @param string $placement The placement of the popover or tooltip (optional).
 * @param string $trigger The trigger event for the popover or tooltip (optional).
 * @param string $title The title of the popover (optional, only for popovers).
 * @return string The HTML markup for the tooltip or popover.
 */
if (!function_exists('render_tooltip_popover_html')) {
    function render_tooltip_popover_html($content = '', $type = 'popover', $placement = 'right', $trigger = 'hover', $title = 'Details') {
        // Nếu là Popover
        if ($type == 'popover') {
            $xhtml = '<i class="fa fa-question-circle" data-toggle="popover" data-html="true" data-trigger="%s" data-placement="%s" data-content="%s" data-title="%s"></i>';
            return sprintf($xhtml, $trigger, $placement, $content, $title);
        }
        // Nếu là Tooltip
        else {
            $xhtml = '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="%s" title="%s"></i>';
            return sprintf($xhtml, $placement, $content);
        }
    }
}
