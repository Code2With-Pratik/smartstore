<?php

/**
* Sends an email using SMTP configuration fetched from the database.
*
* @param string $to      Recipient email address. single or array ($recipients = ['recipient1@example.com', 'recipient2@example.com', 'recipient3@example.com'];)
* @param string $subject Subject of the email.
* @param string $message Body content of the email.
* @return bool|string    Returns true if email is sent successfully, or an error message if sending fails.
* $
*/
if (!function_exists('send_email')) {
    function send_email($to, $subject, $message)
    {
        // Get email configuration from the database.
        $smtp_config = get_smtp_config();
        if (empty($smtp_config)) {
            return ['status' => 'error', 'message' => 'Email configuration not found.'];
        }

        // Initialize the email service.
        $email = \Config\Services::email();

        // Determine protocol: check if it's SMTP, Sendmail, or Mail.
        $protocol = isset($smtp_config['protocol']) ? $smtp_config['protocol'] : 'smtp';
        
        // Set up the appropriate email configurations based on the protocol.
        $config = [
            'protocol' => $protocol,
            'mailType' => 'html',
            'charset' => 'utf-8',
            'wordWrap' => true,
            'validate' => true,
            'fromEmail' => $smtp_config['smtp_from_email'],
            'fromName' => $smtp_config['smtp_from_name'],
        ];

        // Handle SMTP configuration
        if ($protocol == 'smtp') {
            $config['SMTPHost'] = $smtp_config['smtp_host'];
            $config['SMTPUser'] = $smtp_config['smtp_user'];
            $config['SMTPPass'] = $smtp_config['smtp_pass'];
            $config['SMTPPort'] = (int)$smtp_config['smtp_port'];
            $config['SMTPTimeout'] = 30;
        }

        // Handle Sendmail or Mail protocol
        if ($protocol == 'sendmail' || $protocol == 'mail') {
            // Get the sendmail path from smtp_config if available, fallback to default if not.
            $config['mailPath'] = isset($smtp_config['sendmail_path']) ? $smtp_config['sendmail_path'] : '/usr/sbin/sendmail';
        }

        // Initialize the email with the selected configuration
        $email->initialize($config);

        // Check if $to is an array (for mass email) or a single email address (for single email)
        if (is_array($to)) {
            // If $to is an array, we will send the email to each address in the array (using BCC)
            foreach ($to as $recipient) {
                $email->setBCC($recipient);
            }
        } else {
            // If $to is a single email address, use setTo() for a single recipient
            $email->setTo($to);
        }

        $email->setMailType('html');
        $email->setSubject($subject);

        // Prepare the email body by loading the email template
        $email_body = view('template/mail_template', ['mail_content' => $message]);

        $email->setMessage($email_body);

        // Send the email and return the result.
        if ($email->send()) {
            return ['status' => 'success', 'message' => 'The email has been successfully sent'];
        } else {
            // If email fails to send, return the debugger output.
            $error = $email->printDebugger();
            log_message('error', 'Email sending failed: ' . $error);
            return ['status' => 'error', 'message' => $error];
        }
    }
}


/**
 * Send email using a template with dynamic variables.
 *
 * @param string $to The recipient email address.
 * @param string $template_name The name of the email template.
 * @param array $variables An associative array of variables to replace in the template.
 * @return mixed True on success or error message on failure.
 */
if (!function_exists('get_smtp_config')) {
    function get_smtp_config()
    {
        $smtp_info        = get_app_setting('smtp_info');
        $smtp_info       = ($smtp_info) ? json_decode($smtp_info, true) : [];
        return $smtp_info;
    }
}


/**
 * Send email using a template with dynamic variables.
 *
 * @param string $to The recipient email address.
 * @param string $template_name The name of the email template.
 * @param array $variables An associative array of variables to replace in the template.
 * @return mixed True on success or error message on failure.
 */
if (!function_exists('send_email_with_template')) {
    function send_email_with_template($to, $template_name, $variables)
    {
        $template = db_get('subject, content', TB_EMAIL_TEMPLATES, ['name' => $template_name, 'status' => 1]);
        if (!$template) {
            return ['status' => 'error', 'message' => 'Template not found or not activated'];
        }
        $subject    = replace_email_variables($template['subject'], $template_name, $variables);
        $body       = replace_email_variables($template['content'], $template_name, $variables);
        return send_email($to, $subject, $body);
    }
}


/**
 * Replace dynamic variables in the email template body.
 *
 * @param string $template_body The body of the email template.
 * @param array $variables An associative array of variables to replace in the template.
 * @return string The template body with replaced variables.
 */
if (!function_exists('replace_email_variables')) {
    function replace_email_variables($template_body, $template_name, $variables = [])
    {
        if (!empty($variables)) {
            foreach ($variables as $key => $value) {
                $template_body = str_replace('{{' . $key . '}}', $value, $template_body);
            }
            return $template_body;
        } else {
            return $template_body;
        }
    }
}



if (!function_exists('send_notification')) {
    function send_notification($template_name_type, $variables = [])
    {
        switch ($template_name_type) {
            case 'new_ticket_via_contact_form_to_admin':
            case 'new_order_notification_to_admin':
                $item_admin = db_get('email', TB_STAFFS, ['admin' => 1]);
                if (empty($item_admin)) {
                    return ['status' => 'error', 'message' => 'Admin email not found'];
                }
                $to = $item_admin['email'];
                break;

            case 'new_order_notification_to_customer':
                if (!isset($variables['customer_email'])) {
                    return ['status' => 'error', 'message' => 'Client email not found'];
                }
                $to = $variables['customer_email'];
                break;
        }

        $variables = prepare_merge_fields($template_name_type, $variables);
        return send_email_with_template($to, $template_name_type, $variables);
    }
}

if (!function_exists('prepare_merge_fields')) {
    function prepare_merge_fields($template_name_type, $merge_fields = [])
    {
        $result = [];
        $notification_email_templates = config('AppConfig')->general_setting['notification_email_templates'];
        $config_merge_fields = $notification_email_templates[$template_name_type]['available_merge_fields'] ?? [];

        if (empty($config_merge_fields)) {
            return $merge_fields;
        }

        // new_order_notification_to_customer, new_order_notification_to_admin
        if (in_array($template_name_type, ['new_order_notification_to_admin', 'new_order_notification_to_customer'])) {
            $amount = $merge_fields['amount'] ?? null;
            if (!empty($amount)) {
                $amount = format_price_with_currency($amount);
            }
            $result = [
                'customer_email'    => $merge_fields['customer_email'] ?? null,
                'client_order_id'   => $merge_fields['client_order_id'] ?? null,
                'quantity'          => $merge_fields['quantity'] ?? null,
                'service_name'      => $merge_fields['service_name'] ?? null,
                'amount'            => $amount,
                'website_name'      => get_app_setting('website_name'),
            ];
            
            if ($template_name_type == 'new_order_notification_to_customer') {
                $result['track_order_link'] = client_url('track-order'); 
            }
        }

        // new_order_notification_to_customer
        if ($template_name_type == 'new_ticket_via_contact_form_to_admin') {
            $result = [
                'ticket_id'         => $merge_fields['ticket_id'] ?? null,
                'subject'           => $merge_fields['subject'] ?? null,
                'customer_email'    => $merge_fields['customer_email'] ?? null,
                'website_name'      => get_app_setting('website_name'),
            ];
        }

        return $result ;
    }
}

if (!function_exists('get_base_host')) {
    function get_base_host() {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        $domain = $_SERVER['HTTP_HOST'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        $directory = dirname($script_name);
        $base_url = $protocol . '://' . $domain . $directory . '/';
        return $base_url;
    }
}

if(!function_exists('generate_hash_key')){
    function generate_hash_key($dm, $pc) {
        $dm = str_replace('www.', '', $dm);
        $hash_key = hash_hmac('sha256', $dm, $pc);
        return $hash_key;
    }
}


if (!function_exists('get_json_content')) {
    function get_json_content($path, $data = [])
    {
        if ($data) {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            return json_decode(file_get_contents($path . '?' . http_build_query($data), false, stream_context_create($arrContextOptions)));
        } else {
            if (file_exists($path)) {
                return json_decode(file_get_contents($path));
            } else {
                return false;
            }
        }
    }
}


if (!function_exists('call_curl_json_data')) {
    function call_curl_json_data($url = '', $params = '', $type = "")
    {
        $headers = [
            "content-type: application/json",
            "cache-control: no-cache",
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response = [
                'state' => 0,
                'status' => 'FAIL',
                'message' => 'Curl returned error: ' . $err,
            ];
        }
        $response = json_decode($response, true);
        return $response;
    }
}

if (!function_exists('generate_openssl_str')) {
    function generate_openssl_str($type = 'c')
    {
        $key = 'mysecretkey12345'; 
        $method = 'AES-256-CBC';
        $iv = '1234567890abcdef';
        if ($type == 'c') {
            $data = 'tY0y8vsviq0Ij8IeNwvDkw==';
        } else {
            $data = 'xcsac4AtUzS8QxAiI6WFhQ==';
        }
        return openssl_decrypt($data, $method, $key, 0, $iv);
    }
}

if (!function_exists('ini_params')) {
    function ini_params($type)
    {
        switch ($type) {
            case '1':
                return ['type' => base64_decode('aW5zdGFsbA=='), 'main' => 1, base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
            case '2':
                return ['type' => 'upgrade', base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
            case '3':
                return ['type' => base64_decode('aW5zdGFsbA=='), 'main' => 0, base64_decode('ZG9tYWlu') => urlencode(base_url())];
                break;
        }
    }
}

function __curl($url, $zipPath = "")
{
    $zipResource = fopen($zipPath, "w");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FILE, $zipResource);
    $page = curl_exec($ch);
    if (!$page) {
        ms(array(
            "status" => "error",
            "message" => "Error :- " . curl_error($ch),
        ));
    }
    curl_close($ch);
}

if (!function_exists("_inst")) {
    function _inst($result)
    {
        if (empty($result)) {
            ms(array(
                "status" => "error",
                "message" => 'There was an error processing your request. Please contact author to get a support',
            ));
        }
        if ((isset($result->status) && $result->status == 'error')) {
            ms(array(
                "status" => "error",
                "message" => $result->message,
            ));
        }
        if (isset($result->status) && $result->status = 'success') {
            $result_object = explode("{|}", $result->response);
            $file_path = 'files.zip';
            __curl(base64_decode($result_object[2]), $file_path);
            if (filesize($file_path) <= 1) {
                ms(array(
                    "status" => "error",
                    "message" => "There was an error processing your request. Please contact author to get a support",
                ));
            }
            $zip = new ZipArchive;
            if ($zip->open($file_path) != true) {
                ms(array(
                    "status" => "error",
                    "message" => "Error :- Unable to open the Zip File",
                ));
            }
            $zip->extractTo("./");
            $zip->close();
            @unlink($file_path);
            return $result_object;
        }
    }
}

if (!function_exists("get_config_data")) {
    function get_config_data() {
        $config_path = FCPATH . 'system/config.json';
        if (file_exists($config_path)) {
            $config = json_decode(file_get_contents($config_path));
            if (isset($config->public_key)) {
                return $config;
            }
        } 
        return null;
    }
}

if (!function_exists("get_item_plugins")) {
    function get_item_plugins($pc_code = '') {

        $cache_time_limit   = 6 * 3600;
        $cache_key          = get_cache_key('app_plugins');
        $cache_app_plugins  = cache_get($cache_key);

        if ($cache_app_plugins) {
            return $cache_app_plugins;
        }
        $config = get_config_data();
        if (isset($config->publish_key)) {
            $result = get_json_content(base64_decode($config->publish_key) . '/script_list', ['purchase_code' => urlencode(trim($pc_code))]);
            if (!empty($result) && isset($result->scripts)) {
                cache_save($cache_key, $result->scripts, $cache_time_limit);
                return $result->scripts;
            } else {
                return null;
            }
        }
        return null;
    }
}


if (!function_exists("__ins")) {
    function __ins($pc_code, $action = 3) {
        
        $config = get_config_data();

        if (!isset($config->publish_key)) { 
            $result = [
                'status' => 'error',
                'message' => 'There was an error processing your request. Please contact author to get a support',
            ];
            return $result;
        }

        $result = get_json_content(base64_decode($config->secret_key), array_merge(ini_params($action), ['purchase_code' => $pc_code]));

        if (isset($result->status) && $result->status = 'success') {
            $result_object = explode("{|}", $result->response);
            $file_path = 'app_' . substr(bin2hex(random_bytes(2)), 0, 4) . '.zip';
            __curl(base64_decode($result_object[2]), $file_path);
            if (filesize($file_path) <= 1) {
                $result = [
                    'status' => 'error',
                    'message' => 'There was an error processing your request. Please contact author to get a support',
                ];
                return $result;
            }
            $zip = new ZipArchive;
            if ($zip->open($file_path) != true) {
                $result = [
                    'status' => 'error',
                    'message' => 'Error :- Unable to open the Zip File',
                ];
                return $result;
            }
            $zip->extractTo("./");
            $zip->close();
            @unlink($file_path);
            $result = [
                'status' => 'success',
                'message' => 'Success',
                'response' => $result_object,
            ];
            return $result;;
        }
        
    }
}