<?php
namespace App\Requests\Public;

use App\Requests\Public\MyPublicRequest;

class OrderRequest extends MyPublicRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_CATEGORIES;
    }

    /**
     * Get the validation rules for the request.
     * @return array The validation rules.
     */
    protected function get_rules($task = '')
    {
        $rules = [];
        //order_collect
        if ($task == 'order_collect') {
            $rules = [
                'link' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'service_ids' => 'required|validate_item_ids',
            ];
        }
        if ($task == 'checkout_process') {
            $rules = [
                'email' => 'required|valid_email',
                'payment_method' => 'required|min_length[3]',
            ];

            if (get_post('first_name') !== '') {
                $rules['first_name'] = 'min_length[1]|regex_match[/^\p{L}[\p{L}\s]+$/u]';
            }
            
            if (get_post('last_name') !== '') {
                $rules['last_name'] = 'min_length[1]|regex_match[/^\p{L}[\p{L}\s]+$/u]';
            }

            if (get_post('full_phone') !== '') {
                $rules['full_phone'] = 'min_length[6]|regex_match[/^\+[\d\s\-]{7,20}$/]';
            }
            
        }
        if ($task == 'track_order') {
            $rules = [
                'order_id' => 'required|min_length[10]',
                'email' => 'required|valid_email',
            ];
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [];
        // order_collect
        if ($task == 'order_collect') {
            $message = [
                'link' => [
                    'required'    => __l("The_field_is_required"), 
                    'min_length'  => __l("The_field_must_be_at_least_3_characters_long"), 
                ],
                'email' => [
                    'required'    => __l("Please_enter_your_email_address"), 
                    'valid_email' => __l("Please_enter_a_valid_email_address") 
                ],
                'service_ids' => [
                    'required'              => __l("The_service_package_is_required"), 
                    'validate_item_ids'     => __l("Invalid_service_package_Please_check_again") 
                ],
            ];
        }
        if ($task == 'checkout_process') {
            $message = [
                'email' => [
                    'required'    => __l("Please_enter_your_email_address"), 
                    'valid_email' => __l("Please_enter_a_valid_email_address")
                ],
                'first_name' => [
                    'min_length'    => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format"), 
                    'regex_match'   => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format") 
                ],
                'last_name' => [
                    'min_length'    => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format"), 
                    'regex_match'   => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format") 
                ],
                'full_phone' => [
                    'min_length'   => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format"), 
                    'regex_match'  => __l("This_field_is_optional_but_if_filled_please_use_the_correct_format") 
                ],
                'payment_method' => [
                    'required'     => __l("Please_select_a_payment_method"), 
                    'min_length'   => __l("Invalid_Payment_Method")
                ],
            ];
        }
        if ($task == 'track_order') {
            $message = [
                'order_id' => [
                    'required'              => __l("Please_enter_the_order_ID"), 
                    'min_length'            => __l("Invalid_order_ID")  
                ],
                'email' => [
                    'required'    => __l("Please_enter_your_email_address"), 
                    'valid_email' => __l("Please_enter_a_valid_email_address") 
                ],
            ];
        }
        return $message; 
    }

}
