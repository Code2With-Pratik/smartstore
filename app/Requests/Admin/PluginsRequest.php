<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class PluginsRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_PURCHASE;
    }

    protected function get_rules()
    {
        $cond_purchase_code = 'is_unique['.$this->table. '.purchase_code]';
        $rules = [
            'purchase_code' => 'required|regex_match[/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/]|' . $cond_purchase_code,
        ];
        return $rules;
    }

    protected function get_messages()
    {
        $message = [
            'purchase_code' => [
                'required'      => 'Purchase code is required',
                'regex_match'   => 'The purchase code must be in the correct format',
                'is_unique'     => 'The purchase code field already exists!'
            ],
        ];
        return $message; 
    }
}
