<?php

/**
 * Create Form Template base on Elements
 * @param array $elements
 */
function render_alert_html_message_area($class = '')
{
    $xhtml = sprintf('<div class="%s m-t-20">
                        <div class="ajax-alert-message"></div>
                    </div>', $class);

    return $xhtml;
}

/**
 * Create Form Template base on Elements
 * @param array $elements
 */
function render_elements_form($elements)
{
    $xhtml = null;
    if (!empty($elements)) {
        foreach ($elements as $element) {
            $xhtml .= render_element_form($element);
        }
    }
    return $xhtml;
}

function render_element_form($element, $param = null)
{
    $xhtml = null;

    $type = (isset($element['type'])) ? $element['type'] : 'input';
    switch ($type) {

        case 'input':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        %s
                        <div class="invalid-feedback"></div>
                    </div>
                </div> ',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'password':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        %s
                        <div class="invalid-feedback"></div>
                    </div>
                </div> ',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'switch':
            $xhtml = sprintf(
                '<div class="%s">
                    <label class="custom-switch">
                        %s
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">%s</span>
                    </label>
                </div> ', $element['class_main'], $element['element'], $element['label']
            );
            break;

        case 'checkbox':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        <div class="custom-controls-stacked">
                            <label class="form-check">
                                %s
                                <span class="custom-control-label">&nbsp;%s</span>
                            </label>
                        </div>
                    </div>
                </div> ', $element['class_main'], $element['element'], $element['label']
            );
            break;
        case 'checkbox-switch':
            $input_name = $element['element']['input_name'];
            $input_class = $element['element']['input_class'];
            $is_checked = ($element['element']['value'] == 1) ? 'checked' : '';
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        <div>%s</div>
                        <label class="custom-switch">
                            <input type="hidden" name="%s" value="0">
                            <input type="checkbox" name="%s" class="%s" value="1" %s>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> Active</span>
                        </label>
                    </div>
                </div>', $element['class_main'], $element['label'], $input_name, $input_name, $input_class, $is_checked
            );
            break;
        case 'general-url-slug':
            $base_url_html = null;
            if (!empty($element['base_url'])) {
                $base_url_html = sprintf('<span class="input-group-prepend" id="basic-addon3">
                                    <span class="input-group-text text-muted">%s</span>
                                </span>', $element['base_url']);
            }
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        <div class="input-group">
                            %s
                            %s
                            <span class="input-group-text">
                                <a href="#" class="link-secondary btn-general-slug" data-toggle="tooltip" data-placement="top" title="" data-original-title="General URL Slug">
                                    <svg class="icon svg-icon-ti-ti-wand" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 21l15 -15l-3 -3l-15 15l3 3"></path>
                                    <path d="M15 6l3 3"></path>
                                    <path d="M9 3a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path>
                                    <path d="M19 13a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path>
                                    </svg>                    
                                </a>
                            </span>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $base_url_html, $element['element']
            );
            break;

        case 'exchange_option':
            $item1_title = $element['item1']['name'];
            $item2_title = $element['item2']['name'];
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">1 %s =</span>
                            </span>
                            %s
                            <span class="input-group-append">
                                <span class="input-group-text new-currency-code"> %s </span>
                            </span>
                        </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $item1_title, $element['element'], $item2_title
            );
            break;

        case 'admin-change-provider-service-list':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="dimmer">
                    <div class="loader"></div>
                    <div class="dimmer-content">
                        %s
                        %s
                    </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $element['element']
            );
            break;

        case 'button':
            $xhtml = sprintf(
                '<div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        %s
                    </div>
                </div>',
                $element['element']
            );
            break;

        case 'upload-image-input':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        <div class="input-group">
                            %s
                            <span class="input-group-append btn-elFinder">
                                <button class="btn btn-info" type="button" data-toggle="tooltip" title="Upload an image"><i class="fe fe-upload"></i>
                                </button>
                            </span>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $element['element']
            );
            break;

        case 'upload-image-input-elfinder-directly':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        <div class="input-group">
                            %s
                            <span class="input-group-append btnUploadImage">
                                <button class="btn btn-info" type="button" data-toggle="tooltip" title="Upload an image"><i class="fe fe-upload"></i>
                                </button>
                            </span>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $element['element']
            );
            break;
    }

    return $xhtml;
}

function render_button_form($options = '')
{
    $xhtml = null;
    $class_alert_html = '';
    $xhtml = '<button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1" type="button">
                <span class="spinner spinner-border d-none" role="status" aria-hidden="true"></span> Submit
            </button>';
    if (isset($options['back_url'])) {
        $link = $options['back_url'];
        $xhtml .= sprintf('<a href="%s" class="btn btn-outline-primary btn-min-width mr-1 mb-1">Back</a>', $link);
    }
    if (isset($options['modal_close_btn'])) {
        $xhtml .= '<button type="button" class="btn btn-dark" data-dismiss="modal"> CLOSE</button>';
        $class_alert_html = 'col-12';
    }
    // Alert Html
    $xhtml .= render_alert_html_message_area($class_alert_html);
    return $xhtml;
}

function render_overplay_form($options = '')
{
    $xhtml = null;
    $xhtml = '<div class="overlay position-absolute d-none">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>';
    return $xhtml;
}

/**
 * Get validation rules for jQuery Validate format from CodeIgniter rules.
 *
 * @param array $rules CodeIgniter validation rules array.
 * @return array Converted rules for jQuery Validate.
 */
if (!function_exists('get_validate_rules_for_js')) {
    /**
     * Get specific validation rules for jQuery Validate format from CodeIgniter rules.
     *
     * @param array $rules CodeIgniter validation rules array.
     * @param array $fields_to_validate (optional) Array of field names for which we want the rules.
     * @return array Converted rules for jQuery Validate, or an empty array if input is invalid.
     */
    function get_validate_rules_for_js($rules = [])
    {
        if (!is_array($rules) || empty($rules)) {
            return [];
        }

        $converted = [];

        foreach ($rules as $field => $rule_string) {
            $field_rules = explode('|', $rule_string);
            $converted_field_rules = [];
            
            foreach ($field_rules as $rule) {
                if (strpos($rule, 'min_length') !== false) {
                    $converted_field_rules['minlength'] = (int) filter_var($rule, FILTER_SANITIZE_NUMBER_INT);
                } elseif (strpos($rule, 'max_length') !== false) {
                    $converted_field_rules['maxlength'] = (int) filter_var($rule, FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rule === 'required') {
                    $converted_field_rules['required'] = true;
                } elseif ($rule === 'valid_email') {
                    $converted_field_rules['email'] = true;
                } elseif ($rule === 'numeric') {
                    $converted_field_rules['number'] = true;
                } elseif (strpos($rule, 'matches') !== false) {
                    $match_field = str_replace('matches[', '', str_replace(']', '', $rule));
                    $converted_field_rules['equalTo'] = '[name="' . $match_field . '"]';
                } elseif ($rule === 'valid_url') {
                    $converted_field_rules['url'] = true;
                }
            }
            if (!empty($converted_field_rules)) {
                $converted[$field] = $converted_field_rules;
            }
        }
        if (!empty($converted)) {
            return json_encode($converted);
        }
        
        return null;
    }
}

/**
 * Convert CodeIgniter validation messages to a format that jQuery Validate can use.
 *
 * @param array $messages CodeIgniter validation messages array.
 * @return array Converted messages.
 */
if (!function_exists('get_validation_messages_for_js')) {
    /**
     * Get validation messages for jQuery Validate format from CodeIgniter validation messages.
     *
     * @param array $messages CodeIgniter validation messages array.
     * @return string|array Converted validation messages for jQuery Validate, or an empty array if input is invalid.
     */
    function get_validation_messages_for_js($messages = [])
    {
        if (!is_array($messages) || empty($messages)) {
            return [];
        }

        $converted_messages = [];

        $rule_map = [
            'min_length' => 'minlength',
            'max_length' => 'maxlength',
            'valid_email' => 'email',
            'exact_length' => 'rangelength', 
            'greater_than' => 'greaterThan',
            'less_than' => 'lessThan',
            'is_natural' => 'digits',  
            'is_natural_no_zero' => 'digits',
            'in_list' => 'in', 
        ];
        foreach ($messages as $field => $message_rules) {
            if (is_array($message_rules) && !empty($message_rules)) {
                $converted_field_messages = [];

                foreach ($message_rules as $rule => $message) {
                    if (!empty($message)) {
                        $rule_key = isset($rule_map[$rule]) ? $rule_map[$rule] : $rule;
                        $converted_field_messages[$rule_key] = $message;
                    }
                }
                if (!empty($converted_field_messages)) {
                    $converted_messages[$field] = $converted_field_messages;
                }
            }
        }
        if (!empty($converted_messages)) {
            return json_encode($converted_messages);
        }

        return null;
    }
}

/**
 * This function formats an array of error messages by appending a <br> tag
 * to each message, making it ready for display in an alert box or HTML content.
 *
 * @param array $messages An array of error messages that need to be formatted.
 * Each element in the array is a string representing a validation error message.
 *
 * @return string A string containing all the error messages concatenated, each followed by a <br> tag.
 * This formatted string is suitable for display in an HTML alert or as part of a notification.
 */

if (!function_exists('get_validation_message_for_alert')) {
    function get_validation_message_for_alert($messages = [])
    {
        $formattedMessages = array_map(function ($message) {
            return $message . '<br>'; // Append <br> to each error message
        }, $messages);

        return implode('', $formattedMessages); // Return the concatenated string with <br>
    }
}



if (!function_exists('app_real_time')) {
    function app_real_time() {
        $cache_time_limit   = 5 * 24 * 3600;
        $cache_key          = get_cache_key('app_token');
        $app_token          = cache_get($cache_key);
        if (!$app_token) {
            $db_row = db_get('name, value', TB_OPTIONS, ['name' => 'app_token_data']);
            $app_token = $db_row['value'];
            cache_save($cache_key, $db_row['value'], $cache_time_limit);
        }
        $app_token = ($app_token) ? json_decode($app_token, true) : [];
        if (!isset($app_token['time'])) {
            return false;
        }
        if (strtotime($app_token['time']) > strtotime(NOW)) {
            return true;
        }
        $item = db_get('*', 'purchase', ['id' => 1]);
        if (!empty($item)) {
            $hash_key = generate_hash_key(get_base_host(), $item['purchase_code']); 
            if ($hash_key === $app_token['token']) {
                return update_app_token($app_token);
            }
            $config = get_config_data();
            if (isset($config->public_key)) {
                $item['base_url'] = get_base_host();
                $result = call_curl_json_data(base64_decode($config->public_key) . "/api/item/info", $item);
                if ($result && $result['state'] && $result['status'] === 'APPROVED') {
                    $app_token['token'] = $result['domain_token'] ?? generate_hash_key(get_base_host(), $item['purchase_code']);
                    $next_time  = $result['next_request'] ?? '';
                    return update_app_token($app_token, $next_time);
                }
            }
        }
        return false; 
    }

    function update_app_token($data = [], $next_time = '') {
        if (!empty($data)) {
            if ($next_time == '') {
                $data['time']  = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 180 * 24 * 3600);
            }
            $result = db_update('options', ['value' => json_encode($data)], ['name' => 'app_token_data']);
            cache_delete(get_cache_key('app_token'));
            return $result;
        }
        return false;
    }
}



if (!function_exists('render_payment_note_html')) {
    function render_payment_note_html($notes = []) {
        $notes_list = null;
        $xhtml = null;
        if ($notes) {
            foreach ($notes as $note) {
                $notes_list .= sprintf('<li>%s</li>', $note);
            }
            $xhtml = sprintf('<div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label><span class="text-danger">Notes</label>
                                            <ul>
                                              %s
                                            </ul>
                                        </div>
                                    </div>', $notes_list);
            return $xhtml;
        }
    }
}