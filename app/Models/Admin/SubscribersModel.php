<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class SubscribersModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_SUBSCRIBERS;
        $this->main_builder    = $this->db->table($this->table);

        $this->select_fields_index    = 'id, ids, first_name, last_name, email, history_ip, country, options, created, changed';
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['subscribers'];
        
        $this->allowedFields         = ['ids', 'first_name', 'last_name', 'email', 'country', 'history_ip', 'created', 'changed', 'options'];
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
