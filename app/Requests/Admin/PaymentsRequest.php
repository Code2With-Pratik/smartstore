<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class PaymentsRequest extends MyAdminRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_PAYMENTS_METHOD;
    }

    protected function get_rules($task = '')
    {
        $rules = [
            'name' => 'required|min_length[6]',
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'name' => [
                'required' => 'The name is required',
                'min_length' => 'The name must be at least 6 characters long',
            ],
        ];
        return $message; 
    }

}
