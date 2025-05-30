<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class CouponsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_COUPONS;
        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['coupons']);
        $this->field_search_accepted = config('AppConfig')->config['search']['coupons'];
        $this->allowedFields       = [
            'ids', 'code', 'discount_value', 'start_date', 'end_date ', 'status', 'changed', 'created',
        ];
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

}   

