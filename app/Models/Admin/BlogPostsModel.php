<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;
use CodeIgniter\HTTP\IncomingRequest;

class BlogPostsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table            = TB_BLOG_POSTS;
        $this->table_lang       = TB_BLOG_POSTS_LANG;

        $this->main_builder                     = $this->db->table($this->table);
        $this->foreign_key_for_table_lang       = $this->get_foreign_key_for_table_lang();

        $this->select_fields_index    = 'id, ids, name, sort, status, created, released, changed';
        $this->filter_accepted        = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted  = config('AppConfig')->config['search']['blogposts'];
        
        $this->allowedFields        = ['ids', 'cate_id', 'name', 'image', 'sort', 'status', 'released'];
    }


    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;

        if ($option['task'] == 'get-item') {
            $result = db_get('*', $this->table, ['id' => $params['id']]);
        }

        if ($option['task'] == 'admin-get-item-post-lang') {
            $result = db_get('*', $this->tb_blog_posts_lang, $params);
        }

        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        $response = [];
        if (in_array($option['task'], ['add-item', 'edit-item'])) {
            $response = $this->save_item_edit_add($params, $option['task']);
        }        
        return $response;
    }

    public function save_item_edit_add($params, $task = '')
    {
        $default_language_code = get_default_lang_code();

        $name               = get_post('name');
        $url_slug           = (get_post('url_slug')) ?? strtolower(url_title($name, '-')); 
        $status             = (int) get_post('status');
        $cate_id            = get_post('cate_id');
        $page_seo           = json_encode(sanitize_input($params['post_input']['page_seo']));
        $lang_code          = (get_post('language_code')) ?? $default_language_code;
        $content            = $params['post_input']['content']; 
        // Check if the URL slug is unique
        if ($this->item_lang_url_slug_exists($url_slug, $task, $lang_code)) {
            return ["status" => "error", "message" => 'URL Slug already exists'];  
        }
        // data item
        $data_item = [
            'cate_id'       => $cate_id,
            'url_slug'      => $url_slug,
            'image'         => get_post('image'),
            "released"      => date("Y-m-d H:i:s", strtotime(str_replace('/', '-', get_post('released')))),
            'status'        => $status,
            'changed'       => NOW, 
        ];

        if ($lang_code == $default_language_code) {
            $data_item['name'] = $name;
            $data_item['url_slug'] = $url_slug;
        }
        // data item lang
        $data_item_by_lang = [
            'name'      => $name,
            'url_slug'  =>  $url_slug,  
            'lang_code' =>  $lang_code,  
            'page_seo'  => $page_seo,
            'content'   => $content,
        ];
        return $this->save_item_with_lang($data_item, $data_item_by_lang, $task);
    }
}
