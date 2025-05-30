<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class PagesModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table                            = TB_PAGES;
        $this->table_lang                       = TB_PAGES_LANG;
        $this->foreign_key_for_table_lang       = $this->get_foreign_key_for_table_lang();

        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['pages'];
        $this->allowedFields       = [
            'ids', 'name', 'url_slug', 'manage_sections', 'sort', 'status', 'created', 'changed',
        ];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' pg');

        if ($option['task'] == 'list-items') {
            $builder->select('pg.id, pg.page_type, pg.name, pg.ids, pg.url_slug, pg.is_core_page, pg.status, pg.created');
            // Apply search conditions
            $search_field = $params['search']['field'] ?? 'all';
            $search_query = $params['search']['query'] ?? '';
            if ($search_query) {
                if ($search_field === 'all') {
                    $index = 1;
                    foreach ($this->field_search_accepted as $index => $column) {
                        if ($column !== 'all') {
                            $method = ($index === 1) ? 'like' : 'orLike';
                            $builder->$method('pg.' . $column, $search_query);
                        }
                        $index++;
                    }
                } elseif (in_array($search_field, $this->field_search_accepted)) {
                    $builder->like('pg.' . $search_field, $search_query);
                }
            }
            $result = $builder->orderBy('pg.id', 'DESC')->orderBy('pg.status', 'DESC')->get()->getResultArray();
        }

        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = db_get('*', $this->table, ['id' => $params['id']]);
        }
        return $result;
    }

    // save item
    public function save_item($params = null, $option = null)
    {
        $result = [];
        $redirect_url = '';
        if (in_array($option['task'], ['add-item', 'edit-item'])) {
            $response = $this->save_item_edit_add($params, $option['task']);
        }
        
        return $response;
    }

    public function save_item_edit_add($params, $task = '')
    {
        $response = [];
        // Retrieve data from the POST request
        $default_language_code  = get_default_lang_code();
        $name                   = sanitize_input($params['post_input']['name']);
        $url_slug               = (get_post('url_slug')) ?? strtolower(url_title($name, '-')); 
        $status                 = (int) get_post('status');
        $page_id                = get_post('id');
        $page_seo               = json_encode(sanitize_input($params['post_input']['page_seo']));
        $optional_content       = $params['post_input']['optional_content'];
        $lang_code              = (get_post('language_code')) ?? $default_language_code; 
        if ($this->item_lang_url_slug_exists($url_slug, $task, $lang_code)) {
            return ["status" => "error", "message" => 'URL Slug already exists'];  
        }
        // Get Section Layout
        $sections_layout = $this->prepare_sections_layout($params['post_input']);
        $data_item = [
            'status'        => $status,
            'changed'       => NOW, 
        ];
        if ($lang_code == $default_language_code) {
            $data_item['name'] = $name;
            $data_item['url_slug'] = $url_slug;
        }
        // Prepare data for the pages_lang table (default language 'en')
        $data_item_by_lang = [
            'name' => $name,
            'url_slug' =>  $url_slug,  
            'lang_code' =>  $lang_code,  
            'page_seo' => $page_seo,
            'sections_layout' => json_encode($sections_layout),
        ];
        if (in_array(get_post('page_type'), ['home_page', 'blog'])) {
            unset($data_item_by_lang['url_slug']);
        }
        return $this->save_item_with_lang($data_item, $data_item_by_lang, $task);
    }

}   

