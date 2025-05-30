<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class CategoryRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table        = TB_CATEGORIES;
        $this->table_lang   = TB_CATEGORIES_LANG;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    /**
     * Get the validation rules for the request.
     * @return array The validation rules.
     */
    protected function get_rules()
    {
        $lang_code = get_post('lang_code') ?? get_default_lang_code();
        $unique_name = "is_unique[{$this->table_lang}.name]";
        $unique_url = "is_unique[{$this->table_lang}.url_slug]";
        if (get_post('id')) {
            $id = get_post('id');
            $unique_name = "is_unique[{$this->table_lang}.name,cate_id,{$id}]";
            $unique_url = "is_unique[{$this->table_lang}.url_slug,cate_id,{$id}]";
        }
        $rules = [
            'name'               => 'required|min_length[6]|' . $unique_name,
            'required_field'     => 'required|min_length[3]',
            'unit_name'          => 'required|min_length[3]',
            'icon_class'         => 'required|validate_icon_class',
            'sncate_id'          => 'required|greater_than[0]',
            'status'             => get_status_rule_by_request($this->request_name),
            'url_slug'           => 'required|min_length[3]|regex_match[/^[a-z0-9-]+$/]|' . $unique_url,
        ];

        // Section Content
        $sections_rules = $this->generate_rule_message_for_section('rule');
        if (!empty($sections_rules)) {
            $rules = array_merge($rules, $sections_rules);
        }
        return $rules;
    }

    protected function get_messages()
    {
        $message = [
            'name' => [
                'required' => 'The name is required',
                'min_length' => 'Name must be at least 6 characters long',
                'is_unique' => 'Name field already exists',
            ],
            'unit_name' => [
                'required' => 'The field is required',
                'min_length' => 'The field must be at least 3 characters long',
            ],
            'icon_class' => [
                'required' => 'The icon field is required',
                'validate_icon_class' => 'Please use Bootstrap 5 icon class format, such as "bi bi-person-plus".',
            ],
            'sncate_id' => [
                'required' => 'Please choose Social network',
                'greater_than' => 'Please choose Social network'
            ],
            'required_field' => [
                'required' => 'The field is required',
                'min_length' => 'The field must be at least 3 characters long. Eg: "Username" or "Post link" ',
            ],
            'status' => [
                'in_list' => 'The status field is invalid value'
            ],
            'url_slug' => [
                'required' => 'The Url Slug is required. Eg: "buy-instagram-likes"',
                'min_length' => 'The Url Slug  must only contain lowercase letters, numbers, and hyphens. Eg: "buy-instagram-likes"',
                'regex_match' => 'The Url Slug  must only contain lowercase letters, numbers, and hyphens. Eg: "buy-instagram-likes"',
                'is_unique' => 'Url Slug already exists',
            ],
        ];
        
        $sections_messages = $this->generate_rule_message_for_section('message');
        if (isset($sections_messages) && !empty($sections_messages)) {
            $message = array_merge($message, $sections_messages);
        }
        return $message; 
    }



}
