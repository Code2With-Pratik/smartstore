<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class UsersModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_USERS;
        $this->main_builder    = $this->db->table($this->table);

        $this->select_fields_index    = 'id, ids, first_name, last_name, email, total_orders, total_spent, timezone, history_ip, description, status, changed, last_order, options, created';
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['users'];
        
        $this->allowedFields         = ['ids', 'first_name', 'last_name', 'email', 'total_orders', 'total_spent', 'timezone', 'history_ip', 'description', 'status'];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = db_get($this->select_fields_index, $this->table, ['id' => $params['id']]);
        }
        return $result;
    }
}
