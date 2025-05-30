<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class BlogCategoryRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_BLOG_CATEGORIES;
    }

    protected function get_rules($task = '')
    {
        $condName = 'is_unique['.$this->table. '.name]';
        if (get_post('id')) {
            $condName = 'is_unique['.$this->table. '.name,id,'. get_post('id') . ']';
        }
        $rules = [
            'name' => 'required|' . $condName,
            'status' => 'required|in_list[0,1]',
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'name' => [
                'is_unique' => 'The name field already exists!'
            ],
        ];
        return $message; 
    }
}
