<?php


if (!function_exists('render_section_form')) {
    function render_content_section_layout_form($item_db = null, $sections = [], $task = 'right')
    {
        $xhml = null;
        if (!empty($sections)) {
            $i = 1;
            $form_type = ($task == 'left') ? 'input_form' : '';
            foreach ($sections as $key => $row) {
                $section_order = ($task == 'left') ? $i : 'default_form';
                $xhml .= render_section_form($item_db, $key, $section_order, $form_type);
                $i++;
            }
        }
        return $xhml;
    }
}

// Function to render a section form with dynamic content based on section type, order, and data
if (!function_exists('render_section_form')) {
    function render_section_form($section_data, $section_type = 'header_section', $section_order = 1, $section_form_type = 'default_form')
    {
        $section_form_type = ($section_form_type == '') ? 'default_form' : 'input_form';
        if ($section_form_type == 'default_form') {
            $section_order = 'default_form'; 
        }
        $section_title = ucfirst(str_replace('_', ' ', $section_type));
        return view('template/section_form', [
            'title'             => $section_title, 
            'section_type'      => $section_type, 
            'section_order'     => $section_order, 
            'section_content'   => view("template/child_section/{$section_type}", [
                'item'                  => $section_data, 
                'section_type'          => $section_type,
                'section_order'         => $section_order, 
                'section_form_type'     => $section_form_type 
            ])
        ]);
        
    }
}

if (!function_exists('get_ui_components_list')) {
    function get_ui_components_list($page_type = '', $task = 'right')
    {
        $template = config('AppConfig')->client_template['default_ui_components_lists'];
        if ($task == 'right') {
            if (!in_array($page_type, ['category_page', 'home_page'])) {
                unset($template['packages_section']);
            }
            return $template;
        }
        $config_content_section = config('AppConfig')->config['content_section_layout_edit_form'];
        if (in_array($page_type, array_keys($config_content_section))) {
            $sections_list = $config_content_section[$page_type];
        } else {
            $sections_list = $config_content_section['default'];
        }
        $filtered_array = array_intersect_key($template, array_flip($sections_list));
        if (!empty($filtered_array)) {
            return $filtered_array; 
        }
        return $template; 
    }
}


/**
 * Converts a snake_case string to Title Case with the first letter capitalized.
 *
 * This function replaces underscores ('_') with spaces and capitalizes the first 
 * letter of each word to make the string more readable as a title.
 *
 * @param string $section_key The input string in snake_case format.
 * @return string The formatted string in Title Case format.
 */
function format_section_title($section_key)
{
    return ucfirst(str_replace('_', ' ', $section_key));  // Replaces underscores with spaces and capitalizes the first letter.
}





// Function to render a section form with dynamic content based on section type, order, and data
if (!function_exists('render_card_component')) {
    function render_card_component($card_data = [''])
    {   
        $card_data['is_card_collapsed'] = $card_data['is_card_collapsed'] ?? false;
        $card_data['collapse_title'] = $card_data['collapse_title'] ?? '';
        return view('template/card_component', $card_data);
    }
}


/**
 * This function generates a final error message and modifies the original error messages.
 * The final message includes a general message and lists the sections with errors.
 * The modified errors array excludes the section names from the error messages.
 *
 * @param array $errors An associative array containing validation errors.
 * @return array An array with two values:
 *               - 'final_message': The final error message.
 *               - 'errors': The modified error array with section names removed.
 */
if (!function_exists('generate_section_layout_errors')) {
    function generate_section_layout_errors($errors = []) {
        $general_error_message = ''; // Stores the general error message
        $section_errors = []; // Stores the section names that have errors
        $modified_errors = []; // Array to store errors with section names removed

        $general_error_message = 'Please complete all required fields.';
        
        // Loop through each error in the errors array
        foreach ($errors as $key => $message) {

            // Check if the error is related to a specific section (e.g., sections.1.fields.title)
            if (strpos($key, 'sections.') === 0) {
                // Extract the section name (e.g., "Header Section", "Counter Section")
                preg_match('/^sections\.(\d+)\.fields\.(\w+)/', $key, $matches);

                // If a valid section is found, extract the section name
                if (isset($matches[1])) {
                    // Extract the section name from the error message (before the colon)
                    $section_name = explode(":", $message)[0];

                    // Add the section name to the section_errors array if it's not already there
                    if (!in_array($section_name, $section_errors)) {
                        $section_errors[] = $section_name;
                    }

                    // Remove the section name from the error message and store it
                    $modified_errors[$key] = explode(":", $message)[1] ?? $message;
                }
            } else {
                // For general errors (not section-specific), keep them in the modified errors array
                $modified_errors[$key] = $message;
            }
        }

        // Start building the final error message
        $final_message = $general_error_message;

        // If there are sections with errors, append them to the final message
        if (!empty($section_errors)) {
            $final_message .= '<br>The following sections have errors:';
            foreach ($section_errors as $section) {
                $final_message .= '<br>- ' . $section;
            }
        }

        // Return the generated error message and the modified error array
        return [
            'final_message' => $final_message,
            'errors' => $modified_errors
        ];
    }
}
