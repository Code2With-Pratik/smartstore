<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class ReviewsRequest extends MyAdminRequest
{
    protected $class_name;
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_REVIEWS;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    public function get_rules($task = '')
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]', 
            'email' => 'required|valid_email', 
            'comment' => 'required|min_length[10]|max_length[5000]', 
            'status' => get_status_rule_by_request($this->request_name), 
            'rating' => 'required|in_list[1,2,3,4,5]', 
        ];
        return $rules;
    }

    public function get_messages($task = '')
    {
        $messages = [
            'name' => [
                'required' => 'The name field is required.',
                'min_length' => 'The name must be at least 3 characters long.',
                'max_length' => 'The name must not exceed 255 characters.'
            ],
            'email' => [
                'required' => 'The email field is required.',
                'valid_email' => 'The email address must be a valid email address.'
            ],
            'comment' => [
                'required' => 'The comment field is required.',
                'min_length' => 'The comment must be at least 10 characters long.',
                'max_length' => 'The comment must not exceed 200 characters.'
            ],
            'status' => [
                'required' => 'The status field is required.',
                'in_list' => 'The status must be one of the following: pending, approved, or rejected.'
            ],
            'rating' => [
                'required' => 'The rating field is required.',
                'in_list' => 'The rating must be a number between 1 and 5.'
            ]
        ];
        return $messages; 
    }
}
