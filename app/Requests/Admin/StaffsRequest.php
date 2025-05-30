<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class StaffsRequest extends MyAdminRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_STAFFS;
    }

    protected function get_rules($task = '')
    {
        switch ($task) {
            case 'login':
                $rules = [
                    'email'    => 'required|valid_email',
                    'password' => 'required|min_length[6]'
                ];
                break;
            case 'account_info':
                $rules = [
                    'email' => 'required|is_unique['.$this->table. '.email,id,'. get_logged_in_user_info('sid') . ']',
                    'last_name' => 'required|min_length[3]|max_length[255]',
                    'first_name' => 'required|min_length[3]|max_length[255]'
                ];
                break;
            case 'change_password':
                $rules = [
                    'password' => 'min_length[6]',
                    're_password' => 'required_with[password]|matches[password]',
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'email' => [
                'required'    => 'Email is required.',
                'valid_email' => 'Please provide a valid email address.',
                'is_unique' => 'The email address you entered is already associated with another account. Please use a different address.'
            ],
            'password' => [
                'required'    => 'Password is required.',
                'min_length'  => 'Password must be at least 6 characters long.',
                'matches'  => 'Your password and confirmation do not match. Please correct them and try again.'
            ]
        ];
        return $message; 
    }

}
