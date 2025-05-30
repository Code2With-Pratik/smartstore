<?php 

/**
 * Function to sort an associative array by a specified field.
 *
 * This function works with both PHP 7 and PHP 8.
 * 
 * @param array $array The array to be sorted.
 * @param string $field The field to sort by (default is 'position').
 * @param bool $ascending Set to true for ascending order, false for descending order (default is true).
 * 
 * @return array The sorted array.
 */
if (!function_exists('array_sort_by_field')) {
    function array_sort_by_field($array= [], $field = 'position', $ascending = true) {
        // Determine sort order: true for ascending, false for descending.
        $sort_order = $ascending ? SORT_ASC : SORT_DESC;

        // Use uasort to preserve array keys while sorting.
        uasort($array, function($a, $b) use ($field, $sort_order) {
            // If values are equal, return 0 (no change in order)
            if ($a[$field] == $b[$field]) {
                return 0;
            }
            
            // Compare the values based on the specified field
            if ($a[$field] < $b[$field]) {
                return $sort_order == SORT_ASC ? -1 : 1;
            } else {
                return $sort_order == SORT_ASC ? 1 : -1;
            }
        });

        return $array;
    }
}

/**
 * Retrieve an element from an array or JSON string by the specified key.
 *
 * @param mixed $data The array or JSON string from which to extract the value.
 * @param string $key_to_extract The key of the element to be retrieved.
 * @return array An array containing the key-value pair if found, otherwise an empty array.
 */
if (!function_exists('get_array_element_by_key')) {
    function get_array_element_by_key($data, $key_to_extract) {
        // Check if data is a JSON string
        if (is_string($data)) {
            $decoded_data = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return []; 
            }
            $data = $decoded_data; 
        }
        
        // Check if data is an array
        if (!is_array($data)) {
            return []; 
        }
        
        // Filter and return the element by the specified key
        return array_filter($data, function($key) use ($key_to_extract) {
            return $key === $key_to_extract;
        }, ARRAY_FILTER_USE_KEY);
    }
}

/**
 * Retrieve a value from an array or JSON string by the specified key.
 *
 * @param mixed $data The array or JSON string from which to extract the value.
 * @param string $key_to_extract The key of the value to be retrieved.
 * @return mixed The value associated with the specified key, or null if not found.
 */
if (!function_exists('get_value_by_key')) {
    function get_value_by_key($data, $key_to_extract) {
        if (is_string($data)) {
            $decoded_data = json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return null; 
            }
            $data = $decoded_data; 
        }
        
        // Check if data is an array
        if (!is_array($data)) {
            return null; 
        }
        
        // Return the value if the key exists, otherwise return null
        return isset($data[$key_to_extract]) ? $data[$key_to_extract] : null;
    }
}

/**
 * V2.0
 * Group items from an array together by some criteria or value.
 * @param  $arr array The array to group items from
 * @param  $criteria string|callable The key to group by or a function the returns a key to group by.
 * @return array
 *
 */
if (!function_exists('group_by_criteria')) {
    function group_by_criteria($arr, $criteria)
    {
        return array_reduce($arr, function($accumulator, $item) use ($criteria) {
            $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
            if (!array_key_exists($key, $accumulator)) {
                $accumulator[$key] = [];
            }
            array_push($accumulator[$key], $item);
            return $accumulator;
        }, []);
    }
}


/**
 * From V2.0
 * Sort Services by ID
 * @param array $arr
 * @param $new_key string|callable  The new key to re-sort array
 * @return array
 */
if (!function_exists('array_sort_by_new_key')) {
    function array_sort_by_new_key($array = [], $new_key = "")
    {
        $result = [];
        if (is_array($array) && $array) {
            $array_new_keys   = array_column($array, $new_key);
            $result           = array_combine(array_values($array_new_keys), array_values($array));
        }
        return $result;
    }
}



/**
 * V2.0
 * Convert String to array
 * Using for search multi order ID on Order page
 * @param input $string ID lists 
 * @param option $separator - Specifies where to break the string
 */
if (!function_exists('convert_str_to_array')) {
    function convert_str_to_array($str, $separator = null)
    {
        $ar = [];
        if (!is_string($str)) {
            return $ar;
        }
        $str = rtrim($str, ',');
        $str = ltrim($str, ',');
        $separator = ($separator) ? $separator : ',';
        return $ar = explode($separator, $str);
    }
}


/**
 * Generate an array of numbers from 1 to a specified limit with a simple label attached to each number.
 * The array keys are the numbers, and the values are the corresponding values with a label.
 * You can specify a divisor to only include numbers divisible by it, and add a custom label suffix (e.g., "posts", "reviews").
 *
 * @param int|null $divisor The number that the values should be divisible by. If null, all numbers from 1 to the limit are included.
 * @param int|null $limit The maximum value for the numbers. If null, it will go up to 100.
 * @param string $label The label to attach to each value (e.g., "posts", "reviews").
 *
 * @return array An associative array with numbers as keys and their values with the attached label.
 */
if (!function_exists('generate_number_array')) {
    function generate_number_array($divisor = null, $limit = 100, $label = 'item', $i = 1) {
        $result = [];
    
        for ($i ; $i <= $limit; $i++) {
            if ($divisor === null || $i % $divisor == 0) {
                $plural_label = ($i > 1) ? $label . 's' : $label;
                // Attach label to the value
                $result[$i] = $i . ' ' . $plural_label; // e.g. "2 posts", "3 reviews"
            }
        }
    
        return $result;
    }
}


/**
 * Generate an array of percentages from 1 to 100.
 * The array keys are the numbers from 1 to 100, and the values are the corresponding percentage values.
 * If a divisor is specified, only the numbers that are divisible by the divisor will be included in the result.
 *
 * @param int|null $divisor The number that the values should be divisible by. If null, all numbers from 1 to 100 are included.
 * 
 * @return array An associative array with numbers as keys and their percentage values as values (e.g. 1 => "1%", 2 => "2%", ...).
 */
if (!function_exists('generate_percentage_array')) {
    function generate_percentage_array($divisor = null) {
        $result = [];
    
        for ($i = 0; $i <= 100; $i++) {
            if ($divisor === null || $i % $divisor == 0) {
                $result[$i] = $i . '%';
            }
        }
        return $result;
    }
}

/** * Add transaction details to existing data 
 * @param string $existing_data Existing JSON data 
 * @param mixed $new_data_details New data details 
 * @return string Updated JSON string 
 */

if (!function_exists('add_transaction_details')) {
    function add_transaction_details($existing_data, $new_data_details) { 
        if (empty($existing_data) && empty($new_data_details)) { 
            return null; 
        }
        if (empty($new_data_details)) { 
            return $existing_data; 
        }
        $current_time = date('Y-m-d H:i:s'); 
        $new_transaction_details = [ 
            'date_time' => $current_time, 
            'data' => is_array($new_data_details) || is_object($new_data_details) ? json_encode($new_data_details) : $new_data_details 
        ]; 

        if (is_string($existing_data)) { 
            $existing_data_array = json_decode($existing_data, true); 
        } else { 
            $existing_data_array = []; 
        } 
        if (!is_array($existing_data_array)) { 
            $existing_data_array = [];
        }
        array_unshift($existing_data_array, $new_transaction_details); 
        return json_encode($existing_data_array); 
    }
}
