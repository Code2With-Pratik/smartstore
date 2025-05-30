<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class ServicesRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_SERVICES;
    }

    protected function get_rules()
    {
        $rules = [
            'name'                  => 'required|min_length[3]',
            'cate_id'               => 'required|greater_than[0]',
            'quantity'              => 'required|numeric|greater_than[0]',
            'original_price'        => 'required|numeric|greater_than_equal_to[0]',
            'discount_value'        => 'required|numeric|greater_than_equal_to[0]',
            'add_type'              => 'required|in_list[api,manual]',
            'status'                => 'required|in_list[0,1]',
            'is_tab_name'           => 'in_list[0,1]',
        ];
        if (get_post('is_tab_name')) {
            $rules['tab_name_background'] = 'required';
            $items_language = db_fetch('code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
            if ($items_language) {
                foreach ($items_language as $key => $item_language) {
                    $rules['tab_name.' . $item_language['code']] = 'permit_empty|min_length[3]|max_length[20]';
                }
            }
        }
        return $rules;
    }

    protected function get_messages()
    {
        $message = [
            'name' => [
                'required' => 'The name field is required',
                'min_length' => 'The title must be at least 3 characters long',
            ],
            'cate_id' => [
                'greater_than' => 'Please choose Category',
            ],
            'quantity' => [
                'numeric' => 'The quantity is invalid value',
            ],
            'original_price' => [
                'required' => 'The original price is greater than equal to Zero',
                'numeric' => 'Invalid value',
                'greater_than_equal_to' => 'The original price is greater than equal to Zero',
            ],
            'discount_value' => [
                'required' => 'The field is required',
                'numeric' => 'Invalid value',
                'greater_than_equal_to' => 'Invalid format',
            ],
            'add_type' => [
                'in_list' => 'Invalid Mode value'
            ],
            'status' => [
                'in_list' => 'Invalid value'
            ],
            'is_tab_name' => [
                'in_list' => 'Invalid value'
            ],
            'tab_name_background' => [
                'required' => 'The field is required'
            ],
        ];

        if (get_post('is_tab_name')) {
            $items_language = db_fetch('code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
            if ($items_language) {
                foreach ($items_language as $key => $item_language) {
                    $message['tab_name.' . $item_language['code']] = [
                        'min_length' => 'The field must be at least 3 characters long (e.g., "Best Seller" or "Popular" or "Most Popular")',
                        'max_length' => 'The field must not exceed 15 characters (e.g., "Best Seller" or "Popular" or "Most Popular")',
                    ];
                }
            }
        }
        return $message; 
    }
}
