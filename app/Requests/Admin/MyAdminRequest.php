<?php
namespace App\Requests\Admin;

use App\Requests\BaseRequest;

class MyAdminRequest extends BaseRequest
{
    
    protected $table;
    protected $table_lang;
    protected $not_allowed_fields;

    public function __construct()
    {
        parent::__construct();
        $this->not_allowed_fields_for_js_validate = ['rating', 'status'];
    }

    public function validateData($request_data, $task = '')
    {
        $this->validation->setRules($this->get_rules($task), $this->get_messages($task));
        if (!$this->validation->withRequest($request_data)->run()) {
            return $this->validation->getErrors();
        }
        return null;
    }

    public function js_validation_config($task) {

        $rules = $this->get_rules($task);
        $messages = $this->get_messages($task);

        if (!empty($this->not_allowed_fields_for_js_validate)) {
            $rules = array_diff_key($rules, array_flip($this->not_allowed_fields_for_js_validate));
        }

        $js_validation_config = [
            'rules' => get_validate_rules_for_js($rules),
            'messages' => get_validation_messages_for_js($messages),
        ];
        return $js_validation_config;
    }

    
    /**
     * Generate validation rules or messages for sections dynamically.
     *
     * This method generates additional validation rules or messages for dynamic sections
     * such as 'features', 'steps', 'questions', etc., based on the provided task ('rule' or 'message').
     *
     * @param string $task The task to be performed ('rule' or 'message').
     * @return array The generated rules or messages.
     */
    protected function generate_rule_message_for_section($task = 'rule')
    {
        $result = [];
        $rules_messages = [];
        $input_sections = get_post('sections');
        if (isset($input_sections['default_form'])) {
            unset($input_sections['default_form']);
        }
        if (!empty($input_sections)) {
            foreach ($input_sections as $section_order => $section) {
                if (!empty($section)) {
                    if ($task == 'rule') {
                        $rules_messages = $this->process_section_rules($section, $section_order);
                    } else if ($task == 'message') {
                        $rules_messages = $this->process_section_messages($section, $section_order);
                    }
                    if (!empty($rules_messages)) {
                        $result = array_merge($result, $rules_messages);
                    }
                }
            }
        }
        return $result; 
    }

    /**
     * Process the validation rules for a specific section.
     *
     * This method processes validation rules for a given section's data. It checks for fields 
     * like 'title' and 'short_desc', as well as child fields like 'features', 'steps', and 'questions'.
     *
     * @param string $section_key The key of the section being processed.
     * @param array $inputs_section The input data for the section.
     * @return array The generated validation rules for the section.
     */
    protected function process_section_rules($section = [], $section_key = '')
    {
        $rules = [];
        $section_fields = ($section['fields']) ?? '';
        $section_type = ($section['section_type']) ?? '';
        
        if (isset($section_fields['title']) && !in_array($section['section_type'], ['packages_section'])) {
            $rules['sections.' . $section_key . '.fields.title'] = 'required|min_length[3]';
        }

        // if (isset($section_fields['left_span_text_in_title'])) {
        //     $rules['sections.' . $section_key . '.fields.left_span_text_in_title'] = 'required|min_length[3]';
        // }

        // Short Description
        if (isset($section_fields['short_desc']) && !in_array($section['section_type'], ['packages_section'])) {
            $rules['sections.' . $section_key . '.fields.short_desc'] = 'required|min_length[10]';
        }

        // Short Description
        if (isset($section_fields['headling'])) {
            $rules['sections.' . $section_key . '.fields.headling'] = 'required|min_length[10]';
        }

        // layout_type
        if (isset($section_fields['layout_type'])) {
            $in_list = 'in_list[carousel,tab]';
            if ($section['section_type'] == 'faqs_section') {
                $in_list = 'in_list[center,left]';
            }
            $rules['sections.' . $section_key . '.fields.layout_type'] = 'required|' . $in_list;
        }

        // layout_type
        if (isset($section_fields['items_per_carousel'])) {
            $rules['sections.' . $section_key . '.fields.items_per_carousel'] = 'required|in_list[2,3,4]';
        }
  
        // Content
        if (isset($section_fields['content'])) {
            $rules['sections.' . $section_key . '.fields.content'] = 'required|min_length[50]';
        }

        // image_url
        if (isset($section_fields['image_url'])) {
            $rules['sections.' . $section_key . '.fields.image_url'] = 'required|valid_url|validate_image_url';
        }

        // image_position
        if (isset($section_fields['image_position'])) {
            $rules['sections.' . $section_key . '.fields.image_position'] = 'required|in_list[left,right]';
        }

        // number_steps
        if (isset($section_fields['number_steps'])) {
            $rules['sections.' . $section_key . '.fields.number_steps'] = 'required|in_list[3,4]';
        }

        // background_image_url
        if (isset($section_fields['background_image_url'])) {
            $rules['sections.' . $section_key . '.fields.background_image_url'] = 'required|valid_url|validate_image_url';
        }

        // Button for growing_brands_section
        if ($section_type == 'growing_brands_section') {
            if (isset($section_fields['button_name'])) {
                $rules['sections.' . $section_key . '.fields.button_name'] = 'required|min_length[10]';
            }

            if (isset($section_fields['button_url'])) {
                $rules['sections.' . $section_key . '.fields.button_url'] = 'required|regex_match[/^[a-z0-9-]+$/]';
            }
        }

        // for child input features, steps, questions  option
        if (isset($section_fields['features'])) {
            $features = $section_fields['features'];
            foreach ($features as $index => $feature) {
                if ($section_type == 'how_it_work_section' &&  $index >= (int)$section_fields['number_steps'] ) {
                    continue;
                }
                if (isset($feature['icon'])) {
                    $rules["sections.$section_key.fields.features.$index.icon"] = 'required|validate_icon_class';
                }
                if (isset($feature['title'])) {
                    $rules["sections.$section_key.fields.features.$index.title"] = 'required|min_length[3]';
                }
                if (isset($feature['content'])) {
                    $rules["sections.$section_key.fields.features.$index.content"] = 'required|min_length[10]';
                }
                if (isset($feature['url_slug'])) {
                    $rules["sections.$section_key.fields.features.$index.url_slug"] = 'required|regex_match[/^[a-z0-9-]+$/]';
                }
                if (isset($feature['number'])) {
                    $rules["sections.$section_key.fields.features.$index.number"] = 'required|is_natural_no_zero';
                }
            }
        }
        return $rules;
    }

    /**
     * Process the custom validation messages for a specific section.
     *
     * This method processes custom messages for the validation rules of a given section. It checks 
     * for fields like 'title', 'short_desc', and other child fields like 'features', 'steps', and 'questions'.
     *
     * @param string $section_key The key of the section being processed.
     * @param array $section_data The input data for the section.
     * @return array The generated validation messages for the section.
     */
    protected function process_section_messages($section = [], $section_key = '')
    {
        $messages = [];
        $section_fields = ($section['fields']) ?? '';
        $section_type = ($section['section_type']) ?? '';

        $formatted_title = ucwords(format_section_title($section_type)) . ': ';
        // Title
        if (isset($section_fields['left_span_text_in_title'])) {
            $messages['sections.' . $section_key . '.fields.left_span_text_in_title'] = [
                'required'   =>  $formatted_title . 'The Span text is required.',
                'min_length' => $formatted_title . 'The Span text must be at least 3 characters long',
            ];
        }
        // headling
        if (isset($section_fields['headling'])) {
            $messages['sections.' . $section_key . '.fields.headling'] = [
                'required'   =>  $formatted_title . 'The headling text is required.',
                'min_length' => $formatted_title . 'The headling text must be at least 3 characters long',
            ];
        }
        // Title
        if (isset($section_fields['title'])) {
            $messages['sections.' . $section_key . '.fields.title'] = [
                'required'   =>  $formatted_title . 'Title is required.',
                'min_length' => $formatted_title . 'Title must be at least 3 characters long',
            ];
        }
        // Short description
        if (isset($section_fields['short_desc'])) {
            $messages['sections.' . $section_key . '.fields.short_desc'] = [
                'required'   => $formatted_title . ' The short description is required.',
                'min_length' => $formatted_title . ' The short description must be at least 10 characters long',
            ];
        }

        // Image url
        if (isset($section_fields['image_url'])) {
            $messages['sections.' . $section_key . '.fields.image_url'] = [
                'required'   => $formatted_title . 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => $formatted_title . 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => $formatted_title . 'The image URL must point to a valid image file (e.g., .jpg, .png)',
            ];
        }

        // layout_type
        if (isset($section_fields['items_per_carousel'])) {
            $messages['sections.' . $section_key . '.fields.layout_type'] = [
                'required'   => $formatted_title . 'The layout type is required',
                'in_list'   => $formatted_title . 'Invalid layout',
            ];
        }
        // layout_type
        if (isset($section_fields['items_per_carousel'])) {
            $messages['sections.' . $section_key . '.fields.items_per_carousel'] = [
                'required'   => $formatted_title . 'The field is required',
                'in_list'   => $formatted_title . 'Invalid value',
            ];
        }

        // image_position
        if (isset($section_fields['image_position'])) {
            $messages['sections.' . $section_key . '.fields.image_position'] = [
                'required'   => $formatted_title . 'The field is required',
                'in_list'   => $formatted_title . 'Invalid value',
            ];
        }

        // number_steps
        if (isset($section_fields['number_steps'])) {
            $messages['sections.' . $section_key . '.fields.number_steps'] = [
                'required'   => $formatted_title . 'The field is required',
                'in_list'   => $formatted_title . 'Invalid value',
            ];
        }

        // Background Image url
        if (isset($section_fields['background_image_url'])) {
            $messages['sections.' . $section_key . '.fields.background_image_url'] = [
                'required'   => $formatted_title . 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => $formatted_title . 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => $formatted_title . 'Image URL must point to a valid image file (e.g., .jpg, .png)',
            ];
        }

        // content
        if (isset($section_fields['content'])) {
            $messages['sections.' . $section_key . '.fields.content'] = [
                'required'      => $formatted_title . 'The content  is required!',
            ];
        }

        // Button for growing_brands_section
        if ($section_type == 'growing_brands_section') {
            if (isset($section_fields['button_name'])) {
                $messages['sections.' . $section_key . '.fields.button_name'] = [
                    'required'   =>  $formatted_title . 'Button name is required.',
                    'min_length' => $formatted_title . 'Button name must be at least 10 characters long',
                ];
            }
            if (isset($section_fields['button_url'])) {
                $messages['sections.' . $section_key . '.fields.button_url'] = [
                    'required'   =>  $formatted_title . 'URL slug is required!',
                    'regex_match'   =>  $formatted_title . 'URL slug must only contain lowercase letters, numbers, and hyphens. Eg "buy-instagram-likes"',
                ];
            }
        }

        if (isset($section_fields['features'])) {
            $features = $section_fields['features'];

            foreach ($features as $index => $feature) {
                if ($section_type == 'how_it_work_section' &&  $index >= (int)$section_fields['number_steps'] ) {
                    continue;
                }

                if (isset($feature['title'])) {
                    $messages["sections.$section_key.fields.features.$index.title"] = [
                        'required' => $formatted_title . 'The field is required',
                        'min_length' => $formatted_title . 'The field must be at least 10 characters long.',
                    ];
                }

                if (isset($feature['icon'])) {
                    $messages["sections.$section_key.fields.features.$index.icon"] = [
                        'required'              => $formatted_title . 'Icon Class is required',
                        'validate_icon_class'   => $formatted_title . 'Please use Bootstrap 5 icon class format, such as "bi bi-person-plus".',
                    ];
                }
                if (isset($feature['content'])) {
                    $messages["sections.$section_key.fields.features.$index.content"] = [
                        'required' => $formatted_title . 'Content is required',
                        'min_length' => $formatted_title . 'Content must be at least 10 characters long.',
                    ];
                }
                if (isset($feature['url_slug'])) {
                    $messages["sections.$section_key.fields.features.$index.url_slug"] = [
                        'required' => $formatted_title . 'URL slug is required',
                        'min_length' => $formatted_title . 'URL slug only contain lowercase letters, numbers, and hyphens',
                    ];
                }

                if (isset($feature['number'])) {
                    $messages["sections.$section_key.fields.features.$index.number"] = [
                        'required' => $formatted_title . 'The field is required',
                        'is_natural_no_zero' => $formatted_title . 'The field is invalid',
                    ];
                }
                
            }
        }
        return $messages;
    }


}
