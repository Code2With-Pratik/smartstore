<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class MenuRequest extends MyAdminRequest
{
    protected $items_language; 

    public function __construct()
    {
        parent::__construct();
        $this->table = TB_MENU;
        $this->items_language = db_fetch('code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    protected function get_rules($task = '')
    {
        $rules = [
            'status' => get_status_rule_by_request($this->request_name),
            'type'   => 'required|in_list[' . implode(',', array_keys(config('AppConfig')->template['menu_type'])) . ']',
            'target' => 'required|in_list[self,blank]',
        ];

        $fields_translation_rules = $this->generate_rule_message_for_fields_translation('rule');
        if (!empty($fields_translation_rules)) {
            $rules = array_merge($rules, $fields_translation_rules);
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'status' => [
                'required' => 'The field is required',
                'in_list'  => 'Invalid format',
            ],
            'target' => [
                'required' => 'The field is required',
                'in_list'  => 'Invalid target. Please choose a valid target from the list.',
            ],
            'type' => [
                'required' => 'The field is required',
                'in_list'  => 'Invalid type. Please choose a valid type from the list.',
            ],
        ];
        $fields_translation_message = $this->generate_rule_message_for_fields_translation('message');
        if (!empty($fields_translation_message)) {
            $message = array_merge($message, $fields_translation_message);
        }
        return $message; 
    }

    private function generate_rule_message_for_fields_translation($task = 'rule') 
    {
        $rules_messages = [];
        $items_language = $this->items_language;
        if (!empty($items_language)) {
            foreach ($items_language as $key => $item) {
                if ($task == 'rule') {
                    $rules_messages['name_lang.' . $item['code']] = 'required|min_length[3]|max_length[40]';
                    if (get_post('type') == 'link') {
                        $rules_messages['menu_params.url_slug.' . $item['code']] = 'required|min_length[3]|regex_match[/^[a-z0-9-]+$/]';
                    }
                } else if ($task == 'message') {
                    $rules_messages['name_lang.' . $item['code']] = [
                        'required'      => 'The field is required (e.g., "Contact Us" or "FAQs" or "Blog")',
                        'min_length'    => 'The field must be at least 3 characters long (e.g., "Contact Us" or "FAQs" or "Blog")',
                        'max_length'    => 'The field must not exceed 40 characters (e.g., "Contact Us" or "FAQs" or "Blog")',
                    ];

                    if (get_post('type') == 'link') {
                        $rules_messages['menu_params.url_slug.' . $item['code']] = [
                            'required'      => 'The Url slug is required. Example: "contact-us"',
                            'min_length'    => 'The Url slug must be at least 3 characters long. Example: "contact-us"',
                            'regex_match'   => 'The Url slug must only contain lowercase letters, numbers, and hyphens. Example: "contact-us"',
                        ];
                    }
                }
            }
        }
        return $rules_messages;
    }
}
