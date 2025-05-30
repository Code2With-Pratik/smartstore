<?php
namespace App\Requests\Public;

use App\Requests\Public\MyPublicRequest;

class ClientRequest extends MyPublicRequest
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
        //Submit Reviews
        if ($task == 'submit_review') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'client_order_id' => 'required',
                'rating' => 'required|integer|greater_than[0]|less_than[6]',
                'review_text' => 'required|min_length[10]|max_length[1000]',
            ];
        }
        //Submit Reviews
        if ($task == 'contact_us') {
            $rules = [
                'name'              => 'required|min_length[3]|max_length[100]',
                'email'             => 'required|valid_email',
                // 'phone'             => 'required|min_length[16]',
                'subject'           => 'required|in_list[order_id,payment,other]',
                'message'           => 'required|min_length[50]|max_length[1000]',
            ];
            if (get_post('subject') == 'order_id') {
                $rules['order_id'] = 'required|min_length[16]';
            }
            if (get_post('subject') == 'payment') {
                $rules['transaction_id'] = 'required|min_length[8]';
            }
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [];
        // Submit Reviews
        if ($task == 'submit_review') {
            $message = [
                'name' => [
                    'required'    => __l("Please_enter_your_name"), 
                    'min_length'  => __l("The_field_must_be_at_least_3_characters_long"), 
                    'max_length'  => __l("The_name_cannot_be_longer_than_100_characters")
                ],
                'email' => [
                    'required'    => __l("Please_enter_your_email_address"), 
                    'valid_email' => __l("Please_enter_a_valid_email_address") 
                ],
                'client_order_id' => [
                    'required'          => __l("Please_enter_the_order_ID"), 
                    'min_length'        => __l("Invalid_order_ID") 
                ],
                'rating' => [
                    'required'    => __l("Please_select_a_rating"), 
                    'integer'     => __l("The_rating_must_be_an_integer"), 
                    'greater_than'=> __l("Invalid_Rating"), 
                    'less_than'   => __l("Invalid_Rating")
                ],
                'review_text' => [
                    'required'    => __l("Please_enter_a_review"), 
                    'min_length'  => __l("The_review_must_be_at_least_10_characters_long"), 
                    'max_length'  => __l("The_review_cannot_be_longer_than_1000_characters") 
                ],
            ];
        }

         // Contact us form
         if ($task == 'contact_us') {
            $message = [
                'name' => [
                    'required'    => __l("Please_enter_your_name"), 
                    'min_length'  => __l("The_field_must_be_at_least_3_characters_long"), 
                    'max_length'  => __l("The_name_cannot_be_longer_than_100_characters")
                ],
                'email' => [
                    'required'    => __l("Please_enter_your_email_address"),  
                    'valid_email' => __l("Please_enter_a_valid_email_address") 
                ],
                'order_id' => [
                    'required'    => __l("Please_enter_the_order_ID"), 
                    'min_length'  => __l("Invalid_order_ID")  
                ],
                'transaction_id' => [
                    'required'    => __l("Please_enter_the_transaction_ID"), 
                    'min_length'  => __l("Invalid_transaction_ID")
                ],
                'subject' => [
                    'required'    => __l("The_field_is_required"), 
                    'in_list'     => 'Invalid Subject format',
                ],
                'message' => [
                    'required'    => __l("The_field_is_required"), 
                    'min_length'  => __l("The_message_must_be_at_least_50_characters_long"), 
                    'max_length'  => __l("The_review_cannot_be_longer_than_1000_characters") 
                ],
            ];
        }


        return $message; 
    }

}
