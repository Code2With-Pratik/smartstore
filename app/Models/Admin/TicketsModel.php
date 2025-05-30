<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class TicketsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_TICKETS;

        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['tickets']);
        $this->select_fields_index    = 'id, ids, from, name, subject, message, reply_message, ip, status, read, changed, created';

        $this->field_search_accepted = config('AppConfig')->config['search']['tickets'];
        $this->allowedFields         = ['ids', 'from', 'name', 'subject', 'message', 'ip', 'reply_message', 'status', 'read'];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        
        return $result;
    }

    // Get all items
    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] = 'admin-count-items-group-by-status') {
            $query = $this->groupBy('status')->select('count(id) as count, status');
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if ($i == 1) {
                            $query->like($column, $params['search']['query']);
                        } elseif ($i > 1) {
                            $query->orLike($column, $params['search']['query']);
                        }
                        $i++;
                    }
                }
            } elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $query->like($params['search']['field'], $params['search']['query']);
            }
            $result = $query->orderBy('status', 'DESC')->get()->getResultArray();
        }
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            $result = db_get('id, ids, from, name, subject, message, reply_message, ip, status, read, changed, created', $this->table, ['id' => $params['id']]);
        }
        return $result;
    }
}