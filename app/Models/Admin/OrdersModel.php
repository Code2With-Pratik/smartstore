<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;


class OrdersModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table   = TB_ORDERS;
        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = config('AppConfig')->config['status']['orders'];

        $this->field_search_accepted = config('AppConfig')->config['search']['orders'];
        $this->allowedFields         = ['id', 'ids', 'uid', 'type', 'cate_id', 'service_id', 'service_type', 'api_provider_id', 'api_service_id', 'api_order_id', 'status', 'charge', 'formal_charge', 'profit', 'link', 'quantity', 'start_counter', 'remains', 'note', 'ip_address'];

         //Copy to clipboard
        $this->bulk_actions_copy_clipboard_accepted = config('AppConfig')->config['bulk_action']['orders'];
        $this->bulk_actions_copy_clipboard_accepted = array_diff($this->bulk_actions_copy_clipboard_accepted, ['pending', 'inprogress', 'completed', 'resend', 'cancel']);
    }

    // Get all items
    public function list_items_for_index($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' o');

        $builder->select('o.id, o.ids, o.uid, o.type, o.client_order_id, o.cate_id, o.service_id,  o.api_provider_id, o.api_service_id, o.api_order_id, o.status');
        $builder->select('o.charge, o.formal_charge, o.profit, o.link, o.quantity, o.start_counter, o.remains,  o.note, o.ip_address, o.changed, o.created');
        $builder->select('u.email as email');
        $builder->select('s.name as service_name');
        $builder->select('api.name as api_name');
        $builder->join($this->tb_users . ' u', 'o.uid = u.id', 'left');
        $builder->join($this->tb_services . ' s', 'o.service_id = s.id', 'left');
        $builder->join($this->tb_providers . ' api', 'o.api_provider_id = api.id', 'left');

        // Apply filter and search conditions
        $this->apply_filter_and_search($builder, $params);
        
        // Create a clone of the builder for counting results
        $builder_for_count = clone $builder;
        $builder_for_count->select('o.id');
        $total_items = $builder_for_count->countAllResults(true);
        
        // order by
        $builder->orderBy('o.id', 'DESC');
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

    /**
     * Applies filtering and search criteria to a query builder for the index page.
     */
    private function apply_filter_and_search($builder, $params = [])
    {
        // Apply status filter
        $status_filter = $params['filter']['status'] ?? 'all';
        if ($status_filter !== null && $status_filter !== 'all' && $status_filter !== 3 && in_array($status_filter, $this->filter_accepted)) {
            $builder->where('o.status', $params['filter']['status']);
        }
        // Apply search conditions
        $search_field = $params['search']['field'] ?? 'all';
        $search_query = $params['search']['query'] ?? '';
        if ($search_query) {
            if ($search_field === 'all') {
                $index = 1;
                foreach ($this->field_search_accepted as $index => $column) {
                    $column = ($column == 'email') ? 'u.' . $column : 'o.' . $column;
                    if ($column !== 'all') {
                        $method = ($index === 1) ? 'like' : 'orLike';
                        $builder->$method($column, $search_query);
                    }
                    $index++;
                }
            } elseif (in_array($search_field, $this->field_search_accepted) && $search_query != "") {

                if (in_array($search_field, ['id', 'api_order_id'])) {
                    $builder->whereIn('`o`.' . $search_field, convert_str_to_array($search_query));
                } else {
                    $column = ($search_field == 'email') ? 'u.' . $search_field : 'o.' . $search_field;
                    $builder->like($column, $search_query); 
                }
                
            }
        }
    }


    // Get all items
    public function count_items($params = null, $option = null)
    {
        $result = null;
        
        if ($option['task'] = 'admin-count-items-group-by-status') {
            return null;
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

    // Count Items
    public function count_items_by_item_status($params = [])
    {
        $result = null;
        $result = db_fetch('id', $this->table, ['status' => $params['status']], 'id', 'desc');
        return count($result);
    }

    // save items
    public function save_items($params = null, $option = null)
    {
        $response = [];
        // bulk-actions
        if ($option['task'] == 'bulk-action') {
            if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                return get_message('no_selection');
            }
            $array_idss = convert_str_to_array($params['ids']);
            switch ($params['type']) {
                case 'active':
                case 'deactive':
                    $status = ($params['type'] === 'active') ? 1 : 0;
                    $this->main_builder->whereIn('id', $array_idss);
                    $this->main_builder->update(['status' => $status]);
                    $response = get_message('updated');
                    break;

                case 'delete':
                    $this->main_builder->whereIn('id', $array_idss);
                    $this->main_builder->delete();
                    $response = get_message('deleted');
                    break;
                default:
                    //copy to clipboard
                    if (in_array($params['type'], $this->bulk_actions_copy_clipboard_accepted)) {
                        $column_name = str_replace('copy_', '', $params['type']);

                        $this->main_builder->select($column_name);
                        $this->main_builder->whereIn('id', $array_idss);
                        $items_order_ids = $this->main_builder->get()->getResultArray();
                        if ($items_order_ids) {
                            $order_ids = array_column($items_order_ids, $column_name);
                            $order_ids = implode(',', $order_ids);
                            $order_ids = preg_replace('/-1,?/', '', $order_ids); //remove -1
                            $order_ids = rtrim($order_ids, ',');
                            return ["status"  => "success", "value" => $order_ids];
                        } else {
                            return ["status"  => "error", "value" => 'There was issue with your request'];
                        }
                    } else {
                        $this->main_builder->whereIn('id', $array_idss);
                        $this->main_builder->update(['status' => $params['type']]);
                        $response = get_message('updated');
                    }
                    break;
            }

        }

        return $response;
    }

}