<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class ProvidersRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_API_PROVIDERS;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    protected function get_rules($task = '')
    {
        $rules = [];
        $rules = [
            'name'   => 'required|min_length[3]',
            'url'    => 'required|valid_url|valid_url_strict',
            'key'    => 'required|min_length[10]',
            'status' => get_status_rule_by_request($this->request_name),
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [];
        $message = [
            'name' => [
                'min_length' => 'The title must be at least 3 characters long'
            ],
            'url' => [
                'valid_url' => 'Invalid API URL'
            ],
            'key' => [
                'min_length' => 'Invalid API KEY'
            ],
            'status' => [
                'in_list' => 'Invalid Status!'
            ],
        ];
        return $message; 
    }
}
