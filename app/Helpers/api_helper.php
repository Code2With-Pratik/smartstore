<?php

if (!function_exists('hide_api_key')) {
    function hide_api_key($api_key = '')
    {
        if ($api_key) {
            $len = strlen($api_key);
            $api_key = substr($api_key, 0, 10) . str_repeat('*', $len - 20) . substr($api_key, $len - 10, 10);
        }
        return $api_key;
    }
}


if (!function_exists("get_random_time")) {
    function get_random_time($type = "")
    {
        $rand_time = mt_rand(600, 1200);
        if ($type == "api") {
            $rand_time = mt_rand(14400, 28000);
        }
        return $rand_time;
    }
}


/**
 * From Ver2.0
 * @param string $input_status order status
 * @return string $status new status format
 * @author Joe Nguyen
 */
if (!function_exists('order_status_format')) {
    function order_status_format($input_status, $task = 'default')
    {
        $status = $input_status;
        switch ($task) {
            case 'subscriptions':
                if ($status == "Completed") {
                    $status = strtolower($status);
                }
                if ($status == "Canceled") {
                    $status = 'canceled';
                }
                break;

            case 'dripfeed':
                if (strrpos($status, 'progress') || strrpos($status, 'active')) {
                    $status = 'inprogress';
                } else {
                    $status = str_replace(" ", "", $input_status);
                    $status = str_replace("_", "", $status);
                    $status = strtolower($status);
                }

                if (!in_array($status, array('canceled', 'inprogress', 'completed'))) {
                    $status = 'inprogress';
                }
                break;

            default:
                $status = str_replace(" ", "", $input_status);
                if (!in_array($status, array('Completed', 'Processing', 'Rejected', 'In progress', 'Inprogress', 'Partial', 'Canceled', 'Refunded', 'Completed'))) {
                    $status = 'Pending';
                }
                if ($status == 'In progress') {
                    $status = 'Inprogress';
                }
                break;
        }
        return strtolower($status);
    }
}

/**
 * From Ver2.0
 * @param string $input_remains
 * @return string $remains
 * @author Joe Nguyen
 */
if (!function_exists('order_remains_format')) {
    function order_remains_format($input_remains)
    {
        $remains = $input_remains;
        if ($remains < 0) {
            $remains = abs((int) $remains);
            $remains = "+" . $remains;
        }
        return $remains;
    }
}


/**
 * Calculate the order values based on the order status and remaining quantity.
 *
 * @param array $data_order Order data, including charge, formal_charge, profit, and quantity.
 * @param array $params Parameters including order status and remaining quantity.
 * @return array An array containing real_charge, refund_money, formal_charge, and profit.
 * @author Joe Nguyen
 */
if (!function_exists('calculate_order_by_status')) {
    function calculate_order_by_status($data_order = [], $params = [])
    {
        
        // Initialize result array
        $result     = [];
        $remains    = (int) $params['remains']; 
        $api_charge = (int) $params['api_charge']; 

        $real_charge = $formal_charge = $profit = 0;

        // Handle the case for 'partial' status
        if ($params['status'] == 'partial') {
            // Calculate values based on the partial status
            $real_charge = $data_order['charge'] * (1 - ($remains / (int) $data_order['quantity']));
            $profit =  $real_charge - $api_charge;
        }

        // Calculate refund money (the difference between charge and real charge)
        $refund_money = $data_order['charge'] - $real_charge;

        // Return the calculated results
        $result = [
            'real_charge'   => $real_charge,
            'profit'        => $profit,
            'refund_money'  => $refund_money,
        ];

        return $result;
    }
}


/**
 * @return cronjob key
 */
if (!function_exists('get_cron_key')) {
    function get_cron_key()
    {
        $cron_key = null;
        $encryption_key = env('encryption.key');
        if ($encryption_key) {
            $length = config('AppConfig')->cronjobs['cron_key_length'];
            $cron_key =  mb_substr($encryption_key, 0, $length);
        }
        return $cron_key;
    }
}   