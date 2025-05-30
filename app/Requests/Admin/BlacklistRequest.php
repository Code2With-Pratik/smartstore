<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class BlacklistRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table_BlackList_IP = TB_BLACKLIST_IP;
        $this->table_BlackList_Email = TB_BLACKLIST_EMAIL;
        $this->table_BlackList_Link = TB_BLACKLIST_LINK;
    }

    protected function get_rules($task = '')
    {
        $rules = [];
        switch ($task) {
            case 'ip':
                $cond_ip = 'is_unique['.$this->table_BlackList_IP. '.ip]';
                if (get_post('id')) {
                    $cond_ip = 'is_unique['.$this->table_BlackList_IP. '.ip,id,'. get_post('id') . ']';
                }
                $rules = [
                    'ip' => 'required|valid_ip|' . $cond_ip,
                ];
                break;
            case 'email':
                $cond_email = 'is_unique['.$this->table_BlackList_Email. '.email]';
                if (get_post('id')) {
                    $cond_email = 'is_unique['.$this->table_BlackList_Email. '.email,id,'. get_post('id') . ']';
                }
                $rules = [
                    'email' => 'required|valid_email|' . $cond_email,
                ];
                break;
            case 'link':
                $cond_link = 'is_unique['.$this->table_BlackList_Link. '.link]';
                if (get_post('id')) {
                    $cond_link = 'is_unique['.$this->table_BlackList_Link. '.link,id,'. get_post('id') . ']';
                }
                $rules = [
                    'link' => 'required|' . $cond_link,
                ];
                break;
        }
        return $rules;
    }

    protected function get_messages($task = '')
    {
        switch ($task) {
            case 'ip':
                $message = [
                    'ip' => [
                        'is_unique' => 'The IP Address field already exists!'
                    ],
                ];
                break;
            case 'email':
                $message = [
                    'email' => [
                        'is_unique' => 'The email field already exists!'
                    ],
                ];
                break;
            case 'link':
                $message = [
                    'link' => [
                        'is_unique' => 'The order link field already exists!'
                    ],
                ];
                break;
        }
        return $message; 
    }
}
