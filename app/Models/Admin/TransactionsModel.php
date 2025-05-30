<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class TransactionsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table   = TB_TRANSACTION_LOGS;
        $this->main_builder    = $this->db->table($this->table);
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['transactions']);

        $this->field_search_accepted = config('AppConfig')->config['search']['transactions'];
        $this->allowedFields         = ['ids', 'name', 'status', 'desc', 'image', 'sort'];
    }

    // Get all items
    public function list_items_for_index($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' tnx');
        $builder->select('tnx.id, tnx.ids, tnx.uid, tnx.order_id, tnx.type, tnx.transaction_id, tnx.transaction_fee,  tnx.data, tnx.amount, tnx.status, tnx.created');
        $builder->select('tnx.discount_value, tnx.original_amount, tnx.coupon_code');
        $builder->select('u.email as email');
        $builder->join($this->tb_users . ' u', 'tnx.uid = u.id', 'left');
        if ($params['filter']['status'] != null && !in_array($params['filter']['status'], ['all', 3]) && in_array($params['filter']['status'], $this->filter_accepted)) {
            $builder->where('tnx.status', $params['filter']['status']);
        }
        //Search
        if ($params['search']['field'] === 'all') {
            $i = 1;
            foreach ($this->field_search_accepted as $column) {
                if ($column != 'all') {
                    $column = ($column == 'email') ? 'u.' . $column : 'tnx.' . $column;
                    if ($i == 1) {
                        $builder->like($column, $params['search']['query']);
                    } elseif ($i > 1) {
                        $builder->orLike($column, $params['search']['query']);
                    }
                    $i++;
                }
            }
        } elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
            // Search Email
            if ($params['search']['field'] == 'email') {
                $builder->like('u.' . $params['search']['field'], $params['search']['query']);
            } else {
                $builder->like('tnx.' . $params['search']['field'], $params['search']['query']);
            }
        }

        // Create a clone of the builder for counting results
        $builder_for_count = clone $builder;
        $builder_for_count->select('tnx.id');
        $total_items = $builder_for_count->countAllResults(true);

        // order by
        $builder->orderBy('tnx.id', 'DESC');
        $builder->limit($params['pagination']['limit'], $params['pagination']['start']);
        $items = $builder->get()->getResultArray();

        $result['paginate'] = '';
        if ($option['has_pagination']) {
            $data_pager = [
                'per_page' => $params['pagination']['limit'],
                'total_items' => $total_items,
                'only_epected_queries' => array_merge(array_keys($params['search']), array_keys($params['filter'])),
            ];
            $result = [
                'items' => $items,
                'paginate' => render_pagination($data_pager),
            ];
        } else {
            $result = $items;
        }

        return $result;
    }

    // Get all items
    public function count_items_by_status($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' tnx');
        $builder->groupBy('tnx.status')->select('count(tnx.id) as count, tnx.status');
        $builder->join($this->tb_users . ' u', 'tnx.uid = u.id', 'left');
        
        //Search
        if ($params['search']['field'] === 'all') {
            $i = 1;
            foreach ($this->field_search_accepted as $column) {
                if ($column != 'all') {
                    $column = ($column == 'email') ? 'u.' . $column : 'tnx.' . $column;
                    if ($i == 1) {
                        $builder->like($column, $params['search']['query']);
                    } elseif ($i > 1) {
                        $builder->orLike($column, $params['search']['query']);
                    }
                    $i++;
                }
            }
        } elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
            // Search Email
            if ($params['search']['field'] == 'email') {
                $builder->like('u.' . $params['search']['field'], $params['search']['query']);
            } else {
                $builder->like('tnx.' . $params['search']['field'], $params['search']['query']);
            }
        }

        $result = $builder->get()->getResultArray();
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;

        if ($option['task'] == 'get-item') {
            $result = db_get('id, ids, uid, order_id, type, transaction_id, transaction_fee,  data, amount, status, created', $this->table, ['id' => $params['id']]);
        }
        return $result;
    }
}