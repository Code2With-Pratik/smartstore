<?php
namespace App\Models\Admin;

use App\Models\Admin\MyAdminModel;

class PaymentsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_PAYMENTS_METHOD;

        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = config('AppConfig')->config['search']['payments'];
        $this->allowedFields         = ['id', 'type', 'name', 'sort', 'status', 'params'];

        $this->crud_restricted_fields = ['id', 'token', 'editor', 'payment_params'];

    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = db_get('*', $this->table, ['id' => $params['id'], 'type !=' => 'free']);
        }
        return $result;
    }
    
}
