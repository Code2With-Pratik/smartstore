<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class LanguagesModel extends MyAdminModel
{
    protected $language_path;

    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_LANGUAGE_LIST;
        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = config('AppConfig')->config['search']['socialnetwork'];
        $this->allowedFields         = ['ids', 'code', 'country_code', 'is_default', 'status', 'created'];
        $this->select_fields_index    = '*';

        $this->language_path = APPPATH . 'Language/data/';

        $this->crud_restricted_fields = ['id', 'token', 'editor', 'langs'];
    }
    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        // list-items-by-params on blog post, etc
        if ($option['task'] == 'admin-list-items-by-params') {
            $query = $this->select('id, code, country_code, is_default, status, created');
            if (isset($params['status'])) {
                $query->where($params);
            }
            $result =  $query->orderBy('id', 'ASC')->get()->getResultArray();
        }
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = $this->select('id, ids, code, country_code, is_default, status, created')->where('id', $params['id'])->first();
        }
        return $result;
    }

    /**
     * Saves an item based on the provided parameters and options.
     */
    public function save_item($params = null, $option = null)
    {
        $response = [];
        // Add Item
        if ($option['task'] == 'add-item') {
            $data_item = $this->prepare_crud_data($params['post_input'], 'add');
            $data_item['ids'] = ids();
            $langs = $params['post_input']['langs'];
            if ($data_item['is_default']) {
                db_update($this->table, ['is_default' => 0]);
            }
            create_lang_file($data_item['code'], $langs);

            $result = db_insert($this->table, $data_item);
            $response = handle_db_operation_result($result, 'added', 'error');
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $data_item = sanitize_input($this->prepare_crud_data($params['post_input'], 'edit'));
            $langs = $params['post_input']['langs'];
            if ($data_item['is_default']) {
                db_update($this->table, ['is_default' => 0]);
            }
            create_lang_file($data_item['code'], $langs);

            $result = db_update($this->table, $data_item, ['id' => sanitize_input($params['post_input']['id'])]);
            $response = handle_db_operation_result($result, 'updated', 'error');
        }
        return $response;
    }
    
}