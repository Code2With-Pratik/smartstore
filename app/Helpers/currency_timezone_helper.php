<?php

function get_location_info_by_ip($ip_address = null)
{
    // Initialize session service
    $session = \Config\Services::session();
    
    // Check if location info and IP are already stored in the session
    $stored_ip = session_get('stored_ip');
    $location_info = session_get('location_info');
    $location_info_time = session_get('location_info_time');
    $max_session_duration = 86400; // 24 hours
    
    // If IP address is not provided, fetch the current IP address
    if (empty($ip_address)) {
        $ip_address = service('request')->getIPAddress(); // Get the current IP address
    }
    
    // If location info exists and the stored IP matches the current IP, and it's still valid (not too old)
    if ($stored_ip && $stored_ip == $ip_address && (time() - $location_info_time) <= $max_session_duration) {
        return $location_info;
    }

    // API URL to fetch geolocation data
    $api_url = "http://www.geoplugin.net/json.gp?ip=" . $ip_address;
    
    // Initialize cURL session using CodeIgniter's HTTP client
    $client = \Config\Services::curlrequest();
    $response = $client->get($api_url);
    if ($response->getStatusCode() != 200) {
        log_message('error', 'Geolocation API failed: ' . $response->getBody());
        return [
            'status'        => false,
            'error_message' => 'Failed to fetch data',
            'data' => [ 
                'country_code'  => 'Unknown',
                'country'       => 'Unknown',
                'timezone'      => 'Unknown',
                'city'          => 'Unknown',
            ],
        ];
    }

    // Decode the JSON response
    $ip_data = json_decode($response->getBody(), true);
    
    // Check if the required keys are present in the response data
    if (array_key_exists('geoplugin_countryName', $ip_data) && array_key_exists('geoplugin_countryCode', $ip_data)) {
        $location_info = [
            'status'            => true,
            'error_message'     => 'Local host',
            'data' => [
                'country'       => $ip_data['geoplugin_countryName'] ?? 'Unknown',
                'country_code'  => $ip_data['geoplugin_countryCode'] ?? 'Unknown',
                'timezone'      => $ip_data['geoplugin_timezone'] ?? 'Unknown',
                'city'          => $ip_data['geoplugin_city'] ?? 'Unknown',
            ],
        ];
        // Store IP and location info in session
        session_set('stored_ip', $ip_address);
        session_set('location_info', $location_info);
        session_set('location_info_time', time());
        return $location_info;
    }

    // If no valid response or data, return an error
    return [
        'status'        => false,
        'error_message' => 'Invalid response from API',
        'data' => [ 
            'country_code'  => 'Unknown',
            'country'       => 'Unknown',
            'timezone'      => 'Unknown',
            'city'          => 'Unknown',
        ],
    ];
}


if (!function_exists('get_timezone_by_ip')) {
    function get_timezone_by_ip($ip_address = null)
    {
        $location_info = get_location_info_by_ip($ip_address);
        
        if ($location_info['status'] && isset($location_info['data']['timezone']) && $location_info['data']['timezone'] != 'Unknown') {
            return $location_info['data']['timezone'];
        }
        return date_default_timezone_get(); 
    }
}


/**
 * Return an array of timezones
 *
 * @return array
 */
function tz_list()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int) $currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier,
        );
    }

    // Sort the array by offset, identifier ascending
    usort($tempTimezones, function ($a, $b) {
        return ($a['offset'] == $b['offset'])
        ? strcmp($a['identifier'], $b['identifier'])
        : $a['offset'] - $b['offset'];
    });

    $timezoneList = array();
    foreach ($tempTimezones as $key => $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$key]['time'] = '(UTC ' . $sign . $offset . ') ' . $tz['identifier'];
        $timezoneList[$key]['zone'] = $tz['identifier'];
    }
    return $timezoneList;
}

// Convert time zone for user.
if (!function_exists('convert_timezone')) {
    function convert_timezone($datetime, $case = 'user')
    {
        $zonesystem = date_default_timezone_get();
        $zoneuser   = get_user_timezone();

        if (!in_array($zoneuser, DateTimeZone::listIdentifiers())) {
            $zoneuser = 'UTC'; 
        }

        switch ($case) {
            case 'user':
                $currentTZ = new DateTimeZone($zonesystem);
                $newTZ = new DateTimeZone($zoneuser);
                break;

            case 'system':
                $currentTZ = new DateTimeZone($zoneuser);
                $newTZ = new DateTimeZone($zonesystem);
                break;
        }
        $date = new DateTime($datetime, $currentTZ);
        $date->setTimezone($newTZ);
        $new_datetime = $date->format('Y-m-d H:i:s');
        return $new_datetime;
    }
}

function client_placed_order_date($input_datetime)
{
    $input_datetime = convert_timezone($input_datetime, 'user');
    return date("F j, Y H:i:s", strtotime($input_datetime)); 
}

//Get User's timezone, return zone
if (!function_exists("get_user_timezone")) {
    function get_user_timezone()
    {
        if (is_user_logged_in()) {
            return session_get('user')['timezone'] ?? 'UTC';
        } else {
            return get_timezone_by_ip();
        }
    }
}

/**
 * Get Price format
 * @param $price
 * @return new $price format
 */
if (!function_exists('show_price_format')) {
    function show_price_format($input_price, $show_currency_symbol = false, $is_new_format = false, $option = [])
    {
        $input_price = (double) $input_price;
        $curency_symbol = null;
        if ($show_currency_symbol) {
            $curency_symbol = get_option('currency_symbol', "$");
        }
        return $curency_symbol . $input_price;
    };
}

/**
 * Formats a number as a price, with optional currency placement (before or after the amount).
 *
 * @param float $number The number to format (price).
 * @param string $currency The currency symbol (e.g., 'USD', 'VND', '€', '₹').
 * @param int $decimals The number of decimal places (default is 2).
 * @param string $decimal_separator The separator for decimals (default is '.').
 * @param string $thousand_separator The separator for thousands (default is ',').
 * @param string $currency_position The position of the currency symbol ('before' or 'after', default is 'before').
 * @return string The formatted price with the currency symbol.
 */

if (!function_exists('format_price_with_currency')) {

    function format_price_with_currency($number, $currency = '', $decimals = '', $decimal_separator = '', $thousand_separator = '', $currency_position = '')
    {
        // Check if the provided value is a valid number
        if (!is_numeric($number)) {
            return null; // Return null or a custom error message
        }

        // Get application settings for separators
        $setting_thousand_separator = get_app_setting('currency_thousand_separator');
        $setting_decimal_separator = get_app_setting('currency_decimal_separator');
        
        // Set default separators based on app settings
        if ($setting_thousand_separator == 'space') {
            $setting_thousand_separator = ' ';
        } elseif ($setting_thousand_separator == 'comma') {
            $setting_thousand_separator = ',';
        } else {
            $setting_thousand_separator = '.';
        }

        if ($setting_decimal_separator == 'dot') {
            $setting_decimal_separator = '.';
        } else {
            $setting_decimal_separator = ',';
        }
        // Set default values for parameters
        $decimals = !empty($decimals) ? $decimals : get_app_setting('currency_decimal');
        $currency = !empty($currency) ? $currency : get_app_setting('currency_symbol');
        $currency_position = !empty($currency_position) ? $currency_position : get_app_setting('currency_position');
        $decimal_separator = !empty($decimal_separator) ? $decimal_separator : $setting_decimal_separator;
        $thousand_separator = !empty($thousand_separator) ? $thousand_separator : $setting_thousand_separator;
        // Format the number with specified decimal and thousand separators
        $formatted_number = number_format(
            $number, // The value to format
            $decimals, // Number of decimal places
            $decimal_separator, // Decimal separator (e.g., '.' or ',')
            $thousand_separator // Thousand separator (e.g., ',' or '.')
        );

        // Return formatted number with currency symbol
        if ($currency_position == 'before') {
            return $currency . $formatted_number;
        } else {
            return $formatted_number . $currency;
        }
    }
}


/**
 *
 * Currency function for paypal
 *
 */
if (!function_exists("currency_codes")) {
    function currency_codes()
    {
        $data = array(
            "AUD" => "AUD - Australian dollar",
            "BRL" => "BRL - Brazilian dollar",
            "CAD" => "CAD - Canadian dollar",
            "CZK" => "CZK - Czech koruna",
            "DKK" => "DKK - Danish krone",
            "EUR" => "EUR - Euro",
            "HKD" => "HKD - Hong Kong dollar",
            "HUF" => "HUF - Hungarian forint",
            "INR" => "INR - Indian rupee",
            "ILS" => "ILS - Israeli",
            "JPY" => "JPY - Japanese yen",
            "MYR" => "MYR - Malaysian ringgit",
            "MXN" => "MXN - Mexican peso",
            "TWD" => "TWD - New Taiwan dollar",
            "NZD" => "NZD - New Zealand dollar",
            "NOK" => "NOK - Norwegian krone",
            "PHP" => "PHP - Philippine peso",
            "PLN" => "PLN - Polish złoty",
            "GBP" => "GBP - Pound sterling",
            "RUB" => "RUB - Russian ruble",
            "SGD" => "SGD - Singapore dollar",
            "SEK" => "SEK - Swedish krona",
            "CHF" => "CHF - Swiss franc",
            "THB" => "THB - Thai baht",
            "USD" => "USD - United States dollar",
        );

        return $data;
    }
}

if (!function_exists("currency_format")) {
    function currency_format($number, $number_decimal = "", $decimalpoint = "", $separator = "")
    {
        $decimal = 2;

        if ($number_decimal == "") {
            $decimal = get_option('currency_decimal', 2);
        }

        if ($decimalpoint == "") {
            $decimalpoint = get_option('currency_decimal_separator', 'dot');
        }

        if ($separator == "") {
            $separator = get_option('currency_thousand_separator', 'comma');
        }

        switch ($decimalpoint) {
            case 'dot':
                $decimalpoint = '.';
                break;
            case 'comma':
                $decimalpoint = ',';
                break;
            default:
                $decimalpoint = ".";
                break;
        }

        switch ($separator) {
            case 'dot':
                $separator = '.';
                break;
            case 'comma':
                $separator = ',';
                break;
            default:
                $separator = ',';
                break;
        }
        $number = number_format($number, $decimal, $decimalpoint, $separator);
        return $number;
    }
}

if (!function_exists("coinpayments_coin_setting")) {
    function coinpayments_coin_setting()
    {
        $items_coin = [
            'BTC' => 'Bitcoin',
            'LTC' => 'Litecoin',
            'ETH' => 'Ether',
            'BCH' => 'Bitcoin Cash',
            'DASH' => 'DASH',
            'XRP' => 'Ripple',
            'LTCT' => 'Litecoin Testnet for testing',
        ];
        return $items_coin;
    }
}

if (!function_exists("midtrans_payment_setting")) {
    function midtrans_payment_setting()
    {
        $payment_channel = [
            "credit_card" => 'credit_card',
            "gopay" => 'gopay',
            "mandiri_clickpay" => 'mandiri_clickpay',
            "cimb_clicks" => 'cimb_clicks',
            "bca_klikbca" => 'bca_klikbca',
            "bca_klikpay" => 'bca_klikpay',
            "bri_epay" => 'bri_epay',
            "telkomsel_cash" => 'telkomsel_cash',
            "echannel" => 'echannel',
            "bbm_money" => 'bbm_money',
            "xl_tunai" => 'xl_tunai',
            "indosat_dompetku" => 'indosat_dompetku',
            "mandiri_ecash" => 'mandiri_ecash',
            "permata_va" => 'permata_va',
            "bca_va" => 'bca_va',
            "bni_va" => 'bni_va',
            "danamon_online" => 'danamon_online',
            "other_va" => 'other_va',
            "kioson" => 'kioson',
            "Indomaret" => 'Indomaret',
        ];
        return $payment_channel;
    }
}

if (!function_exists("freekassa_payment_setting")) {
    function freekassa_payment_setting()
    {
        $items = [
            '1' => 'FK WALLET RUB',
            '2' => 'FK WALLET USD',
            '3' => 'FK WALLET EUR',
            '4' => 'VISA RUB',
            '6' => 'Yoomoney',
            '7' => 'VISA UAH',
            '8' => 'MasterCard RUB',
            '9' => 'MasterCard UAH',
            '10' => 'Qiwi',
            '11' => 'VISA EUR',
            '12' => 'МИР',
        ];
        return $items;
    }
}

if (!function_exists("local_currency_code")) {
    function local_currency_code()
    {
        $data = array(
            'USD',
            'EUR',
            'JPY',
            'GBP',
            'AUD',
            'CAD',
            'CHF',
            'CNY',
            'SEK',
            'NZD',
            'MXN',
            'SGD',
            'HKD',
            'NOK',
            'KRW',
            'TRY',
            'RUB',
            'INR',
            'BRL',
            'ZAR',
            'AED',
            'AFN',
            'ALL',
            'AMD',
            'ANG',
            'AOA',
            'ARS',
            'AWG',
            'AZN',
            'BAM',
            'BBD',
            'BDT',
            'BGN',
            'BHD',
            'BIF',
            'BMD',
            'BND',
            'BOB',
            'BSD',
            'BTN',
            'BWP',
            'BYN',
            'BZD',
            'CDF',
            'CLF',
            'CLP',
            'COP',
            'CRC',
            'CUC',
            'CUP',
            'CVE',
            'CZK',
            'DJF',
            'DKK',
            'DOP',
            'DZD',
            'EGP',
            'ERN',
            'ETB',
            'FJD',
            'FKP',
            'GEL',
            'GGP',
            'GHS',
            'GIP',
            'GMD',
            'GNF',
            'GTQ',
            'GYD',
            'HNL',
            'HRK',
            'HTG',
            'HUF',
            'IDR',
            'ILS',
            'IMP',
            'IQD',
            'IRR',
            'ISK',
            'JEP',
            'JMD',
            'JOD',
            'KES',
            'KGS',
            'KHR',
            'KMF',
            'KPW',
            'KWD',
            'KYD',
            'KZT',
            'LAK',
            'LBP',
            'LKR',
            'LRD',
            'LSL',
            'LYD',
            'MAD',
            'MDL',
            'MGA',
            'MKD',
            'MMK',
            'MNT',
            'MOP',
            'MRO',
            'MUR',
            'MVR',
            'MWK',
            'MYR',
            'MZN',
            'NAD',
            'NGN',
            'NIO',
            'NPR',
            'OMR',
            'PAB',
            'PEN',
            'PGK',
            'PHP',
            'PKR',
            'PLN',
            'PYG',
            'QAR',
            'RON',
            'RSD',
            'RWF',
            'SAR',
            'SBD',
            'SCR',
            'SDG',
            'SHP',
            'SLL',
            'SOS',
            'SRD',
            'SSP',
            'STD',
            'SVC',
            'SYP',
            'SZL',
            'THB',
            'TJS',
            'TMT',
            'TND',
            'TOP',
            'TTD',
            'TWD',
            'TZS',
            'UAH',
            'UGX',
            'UYU',
            'UZS',
            'VEF',
            'VND',
            'VUV',
            'WST',
            'XAF',
            'XAG',
            'XAU',
            'XCD',
            'XDR',
            'XOF',
            'XPD',
            'XPF',
            'XPT',
            'YER',
            'ZMW',
            'ZWL',
        );
        return $data;
    }

}
