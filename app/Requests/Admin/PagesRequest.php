<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class PagesRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_PAGES;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    /**
     * Get the validation rules for the request.
     * @return array The validation rules.
     */
    protected function get_rules()
    {
        $cond_url_slug = 'is_unique['.$this->table. '.url_slug]';

        if (get_post('id')) {
            $cond_url_slug = 'is_unique['.$this->table. '.url_slug,id,'.get_post('id').']';
        }
        $rules = [
            'name'               => 'required|min_length[3]',
            'status'             => get_status_rule_by_request($this->request_name),
            'url_slug'           => 'required|min_length[3]|regex_match[/^[a-z0-9-]+$/]|' . $cond_url_slug,
        ];

        if (in_array(get_post('page_type'), ['home_page', 'blog'])) {
            unset($rules['url_slug']);
        }
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
                'min_length' => 'The name must be at least 3 characters long',
            ],
            'status' => [
                'in_list' => 'The status field is invalid value'
            ],
            'url_slug' => [
                'is_unique' => 'The Permalink already exists. Please choose another one',
                'required' => 'The Permalink is required. Example: "contact-us"',
                'min_length' => 'The Permalink must be at least 3 characters long. Example: "contact-us"',
                'regex_match' => 'The Permalink must only contain lowercase letters, numbers, and hyphens. Example: "contact-us"',
            ],
        ];
        
        $sections_messages = $this->generate_rule_message_for_section('message');
        if (isset($sections_messages) && !empty($sections_messages)) {
            $message = array_merge($message, $sections_messages);
        }
        return $message; 
    }
}
