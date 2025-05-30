<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class BlogCategoryModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_BLOG_CATEGORIES;

        $this->main_builder                     = $this->db->table($this->table);
        $this->foreign_key_for_table_lang       = $this->get_foreign_key_for_table_lang();

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['socialnetwork'];

        $this->allowedFields         = ['ids', 'name', 'status', 'sort', 'url_slug', 'lang_name']; 
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        // Get items list by params (condition) on category, etc
        if ($option['task'] == 'admin-list-items-by-params') {
            $wheres = [];
            if (isset($params['status'])) {
                $wheres = $params;
            } 
            $result = db_fetch('id, ids, name, sort, status', $this->table, $wheres,'name', 'ASC');
        }
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = db_get('*', $this->table, ['id' =>  $params['id']]);
        }
        return $result;
    }

    // save item
    public function save_item($params = null, $option = null)
    {
        $response = [];
        // Add Item
        if ($option['task'] == 'add-item') {
            // insert to post
            $url_slug = strtolower(url_title(get_post("name"), '-'));
            $exist_item = db_get('id', $this->table, ['url_slug' =>  $url_slug]);
            if (!empty($exist_item)) {
                $url_slug += random(1, 10);
            }
            $data_item = [
                "ids"             => ids(),
                "name"            => get_post("name"),
                "status"          => (int)get_post("status"),
                "sort"            => (int)get_post("sort"),
                "url_slug"        => $url_slug,
                "lang_name"       => json_encode(get_post("lang_name")),
                "created"         => NOW,
                "changed"         => NOW,
            ];
            $result = db_insert($this->table, $data_item);
            $response = handle_db_operation_result($result, 'added', 'error'); 
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $url_slug = strtolower(url_title(get_post("name"), '-'));

            $exist_item = db_get('id', $this->table, ['url_slug' =>  $url_slug, 'id !=' => get_post('id')]);
            if (!empty($exist_item)) {
                return ["status" => "error", "message" => 'A url slug with this title does already exist! Please choose another URL slug'];
            }
            $data_item = [
                "name"            => get_post("name"),
                "status"          => (int)get_post("status"),
                "url_slug"        => $url_slug,
                "lang_name"       => json_encode(get_post("lang_name")),
                "changed"         => NOW,
            ];

            $result = db_update($this->table, $data_item, ['id' => get_post('id')]);
            $response = handle_db_operation_result($result, 'updated', 'error'); 
        }
        return $response;
    }
}
