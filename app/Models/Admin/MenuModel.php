<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class MenuModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table   = TB_MENU;
        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['transactions']);

        $this->field_search_accepted = config('AppConfig')->config['search']['transactions'];
        $this->crud_restricted_fields = ['id', 'token', 'editor', 'menu_params'];
        $this->allowedFields         = ['ids', 'name', 'type', 'status', 'target', 'options', 'sort','created'];
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


    public function save_item($params = null, $option = null)
    {
        $response = [];
        // Add Item
        if ($option['task'] == 'add-item') {
            $data_item = $this->prepare_item_data($params['post_input'], 'add', $option);
            $data_item['ids'] = ids();
            $result = db_insert($this->table, $data_item);
            $response = $this->handle_db_result($result, 'added');
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $data_item = $this->prepare_item_data($params['post_input'], 'edit', $option);
            $result = db_update($this->table, $data_item, ['id' => sanitize_input($params['post_input']['id'])]);
            $response = $this->handle_db_result($result, 'updated');
        }
        return $response;
    }

    private function prepare_item_data($post_input, $action = 'add', $option = [])
    {
        $default_language_code  = get_default_lang_code();
        $data_item              = $this->prepare_crud_data($post_input, $action);
        $data_item['options']   = $this->prepare_menu_options($data_item['type'], sanitize_input($post_input['menu_params']));
        $data_item['name_lang'] = json_encode(sanitize_input($post_input['name_lang']));
        $data_item['name']      = sanitize_input($post_input['name_lang'][$default_language_code]);
        return sanitize_input($data_item);
    }

    private function prepare_menu_options($type = 'link', $menu_params = []) {
        $options = null;
        switch ($type) {
            case 'link':
                $options = json_encode(get_array_element_by_key($menu_params, 'url_slug'));
                break;
            case 'social_network_option':
                $options = json_encode(get_array_element_by_key($menu_params, 'sncate_id'));
                break;
            case 'track_order':
                $options = json_encode(['url_slug' => 'track-order']);
                break;
            case 'blog':
                $options = json_encode(['url_slug' => 'blog']);
                break;
        }
        return $options;
    }
}