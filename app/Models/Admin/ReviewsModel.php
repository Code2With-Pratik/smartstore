<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class ReviewsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_REVIEWS;
        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['reviews']);
        $this->field_search_accepted = config('AppConfig')->config['search']['reviews'];
        $this->allowedFields       = [
            'ids', 'name', 'email', 'customer_id', 'cate_id ', 'client_order_id', 'rating', 'comment', 'status','options', 'ip_address', 'last_submission_time', 'changed', 'created',
        ];
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = $this->select('*')->where('id', $params['id'])->first();
        }
        return $result;
    }

}   

