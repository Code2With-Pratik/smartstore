<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class UsersRequest extends MyAdminRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_USERS;
    }

    protected function get_rules($task = '')
    {
        $rules = [];
        // add note
        if ($task == 'add_note') {
            $rules = [
                'description' => 'required',
            ];
        }

        // Send Mail
        if ($task == 'send_mail') {
            $rules = [
                'mail_to' => 'required|valid_email',
                'subject' => 'trim|required|min_length[10]',
                'message' => 'trim|required|min_length[10]',
            ];
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [];
        return $message; 
    }

}
