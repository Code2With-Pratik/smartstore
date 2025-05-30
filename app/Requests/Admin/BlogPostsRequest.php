<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class BlogPostsRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_BLOG_POSTS;
        $this->table_lang       = TB_BLOG_POSTS_LANG;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    protected function get_rules($task = '')
    {
        $lang_code = get_post('lang_code') ?? get_default_lang_code();
        $unique_name = "is_unique[{$this->table_lang}.name]";
        $unique_url = "is_unique[{$this->table_lang}.url_slug]";
        if (get_post('id')) {
            $id = get_post('id');
            $unique_name = "is_unique[{$this->table_lang}.name,post_id,{$id}]";
            $unique_url = "is_unique[{$this->table_lang}.url_slug,post_id,{$id}]";
        }
        $rules = [
            'name'               => 'required|min_length[6]|' . $unique_name,
            'url_slug'           => 'required|min_length[3]|regex_match[/^[a-z0-9-]+$/]|' . $unique_url,
            'image'              => 'required|valid_url|validate_image_url',
            'cate_id'            => 'required|greater_than[0]',
            'content'            => 'required|min_length[300]',
            'released'           => 'required|valid_date[d/m/Y]',
            'status'             => get_status_rule_by_request($this->request_name),
        ];

        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'name' => [
                'required' => 'The name is required',
                'min_length' => 'Name must be at least 6 characters long',
                'is_unique' => 'Name field already exists',
            ],
            'url_slug' => [
                'required' => 'The Url Slug is required. Eg: "how-to-buy-instagram-likes"',
                'min_length' => 'The Url Slug  must only contain lowercase letters, numbers, and hyphens. Eg: "how-to-buy-instagram-likes"',
                'regex_match' => 'The Url Slug  must only contain lowercase letters, numbers, and hyphens. Eg: "how-to-buy-instagram-likes"',
                'is_unique' => 'Url Slug already exists',
            ],
            'cate_id' => [
                'required' => 'Please choose Post Category',
                'greater_than' => 'Please choose Post Category'
            ],
            'image' => [
                'required'              => 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'             => 'Image URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => 'The image URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            'content' => [
                'required'      => 'Article Content is required',
                'min_length'    => 'Article Content must be at least 300 characters long',
            ],
            'released' => [
                'required'      => 'Publication date is required',
                'valid_date'    => 'Publication date invalid format',
            ],
            'status' => [
                'in_list' => 'The status field is invalid value'
            ],
        ];
        return $message; 
    }
}
