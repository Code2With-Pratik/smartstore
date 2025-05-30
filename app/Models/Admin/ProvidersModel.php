<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;
use App\Libraries\SmmApi;

class ProvidersModel extends MyAdminModel
{
    private $smmApi;

    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_API_PROVIDERS;
        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = config('AppConfig')->config['search']['category'];
        $this->allowedFields       = [
            'ids', 'name', 'url', 'key', 'type', 'balance', 'currency_code', 'description',
             'status', 'created', 'changed'
        ];

        // Load SMM API
        $this->smmApi = new SmmApi();

    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        // Get items list by params (condition)  on services, etc
        if ($option['task'] == 'admin-items-by-params') {
            $wheres = [];
            if (isset($params['status'])) {
                $wheres = $params;
            } 
            $result = db_fetch('id, name', $this->table, $wheres,'name', 'ASC');
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
        $response = null;
        // Add Item
        if ($option['task'] == 'add-item') {
            $data_item        = $this->prepare_crud_data($params['post_input'], 'add');
            $data_item['ids'] = ids();
            $result = db_insert($this->table, $data_item);
            $response = handle_db_operation_result($result, 'added', 'error'); 
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $data_item = sanitize_input($this->prepare_crud_data($params['post_input'], 'edit'));
            $result = db_update($this->table, $data_item, ['id' => $params['post_input']['id']]);
            $response = handle_db_operation_result($result, 'updated', 'error'); 
        }

        // Update Balance
        if ($option['task'] == 'item-balance') {
            $result = db_update($this->table, $params, ['id' => sanitize_input($params['id'])]);
            $response = handle_db_operation_result($result, 'updated', 'error'); 
        }
        return $response;
    }
}

