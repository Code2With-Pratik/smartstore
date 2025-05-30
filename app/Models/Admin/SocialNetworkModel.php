<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class SocialNetworkModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_SOCIAL_NETWORK_CATEGORIES;
        $this->allowedFields         = ['ids', 'name', 'status', 'desc', 'image', 'sort'];
        
        // modified
        $this->main_builder             = $this->db->table($this->table);
        $this->filter_accepted          = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted    = config('AppConfig')->config['search']['socialnetwork'];
        $this->select_fields_index      = 'id, ids, name, status, desc, image, sort, created';
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        // Get items list by params (condition) on category, etc
        if ($option['task'] == 'admin-items-by-params') {
            $query = $this->select('id, name');
            if (isset($params['status'])) {
                $query->where($params);
            }
            $result =  $query->orderBy('sort', 'ASC')->get()->getResultArray();
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
}
