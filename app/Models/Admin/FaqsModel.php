<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class FaqsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_FAQS;
        
        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = config('AppConfig')->config['search']['faqs'];
        $this->allowedFields         = ['ids', 'question', 'answer', 'sort', 'status'];
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = $this->select('id, ids, question, answer, sort, status, created')->where('id', $params['id'])->first();
        }
        return $result;
    }
}


/**
 * // $this->set(sanitize_input($data_item));
 * // $this->where('id', $params['post_input']['id']);
 * // $this->update();
 */