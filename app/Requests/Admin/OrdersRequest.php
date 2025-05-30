<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class OrdersRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_ORDERS;
    }

    protected function get_rules($task = '')
    {
        $rules = [
            'status' => 'required|in_list[awaiting,processing,inprogress,pending,completed,partial,canceled,error,fail]',
        ];
        if (get_post('start_counter')) {
            $rules['start_counter'] = 'required|numeric';
        }
        if (get_post('remains')) {
            $rules['remains'] = 'required|numeric';
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'status' => [
                'in_list[awaiting,processing,inprogress,pending,completed,partial,canceled,error,fail]' => 'Invalid Order Status!'
            ],
        ];
        return $message; 
    }
}
