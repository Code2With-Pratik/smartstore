<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class TicketsRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_TICKETS;
    }

    protected function get_rules($task = '')
    {
        $rules = [
            'reply_message'     => 'required|min_length[50]|max_length[1000]',
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'reply_message' => [
                'required'    => 'The field is required', 
                'min_length'  => 'The message must be at least 50 characters long.', 
                'max_length'  => 'The message cannot be longer than 1000 characters.' 
            ],
        ];
        return $message; 
    }
}
