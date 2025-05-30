<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class SocialNetworkRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_SOCIAL_NETWORK_CATEGORIES;
    }

    protected function get_rules($task = '')
    {
        $condName = 'is_unique['.$this->table. '.name]';
        if (get_post('id')) {
            $condName = 'is_unique['.$this->table. '.name,id,'. get_post('id') . ']';
        }
        $rules = [
            'name' => 'required|min_length[3]|' . $condName,
            'status' => 'required|in_list[0,1]',
            'image' => 'required|valid_url|validate_image_url',
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'name' => [
                'required'      => 'The field is required',
                'min_length'    => 'The name must be at least 3 characters long',
                'is_unique'     => 'The name field already exists!'
            ],
            'status' => [
                'required'      => 'The field is required',
                'in_list'       => 'Invalid format'
            ],
            'image' => [
                'required'              => 'The field is required',
                'valid_url'             => 'The Image Icon URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'    => 'The Image Icon URL must point to a valid image file (e.g., .jpg, .png)',
            ],
        ];
        return $message; 
    }
}
