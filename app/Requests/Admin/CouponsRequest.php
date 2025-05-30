<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class CouponsRequest extends MyAdminRequest
{
    protected $class_name;
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_COUPONS;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    public function get_rules($task = '')
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]', 
            'code' => 'required|min_length[6]|max_length[20]', 
            'discount_value' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100]', 
            'start_date' => 'required|valid_date[d-m-Y]', 
            'end_date' => 'required|valid_date[d-m-Y]|valid_end_date[start_date]', 
            'status' => get_status_rule_by_request($this->request_name)
        ];
        return $rules;
    }

    

    public function get_messages($task = '')
    {
        $messages = [ 
            'name' => [ 
                'required' => 'Name is required.', 
                'min_length' => 'Name must be at least 3 characters long.', 
                'max_length' => 'Name cannot exceed 255 characters.', 
            ], 
            'code' => [ 
                'required' => 'Code is required.', 
                'min_length' => 'Code must be at least 6 characters long.', 
                'max_length' => 'Code cannot exceed 20 characters.', 
            ], 
            'discount_value' => [ 
                'required' => 'Discount value is required.', 
                'integer' => 'Discount value must be an integer.', 
                'greater_than_equal_to' => 'Discount value must be at least 1%.', 
                'less_than_equal_to' => 'Discount value cannot exceed 100%.', 
            ], 
            'start_date' => [ 
                'required' => 'Start date is required.', 
                'valid_date' => 'Start date must be in the format DD-MM-YYYY.', 
            ], 
            'end_date' => [ 
                'required' => 'End date is required.', 
                'valid_date' => 'End date must be in the format DD-MM-YYYY.', 
                'valid_end_date' => 'End date must be greater than the start date', 
            ], 
            'status' => [ 
                'required' => 'Status is required.', 
                'in_list' => 'Invalid format', 
            ], 
        ];
        return $messages; 
    }
}
