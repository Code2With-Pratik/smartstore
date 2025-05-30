<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;
use App\Models\Admin\CategoryModel;

class ServicesModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table     = TB_SERVICES;
        $this->filter_accepted  = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['services'];
        $this->allowedFields       = [
            'ids', 'name', 'cate_id', 'quantity', 'sort', 'desc', 'price', 'original_price', 'min', 'max', 'add_type',
            'is_free', 'type', 'api_service_id', 'api_provider_id', 'status', 'created', 'changed', 'tab_name', 'is_tab_name', 
        ];

        $this->crud_restricted_fields = ['id', 'token', 'editor', 'api_service_type'];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' s');
        if ($option['task'] == 'admin-list-items') {
            $builder->select('s.*')
                    ->select('c.name as category_name, c.status as category_status')
                    ->select('api.name as api_name')
                    ->join($this->tb_categories . ' c', 'c.id = s.cate_id', 'left')
                    ->join($this->tb_providers . ' api', 'api.id = s.api_provider_id', 'left');
                    
            // Ajax Sort By Social Network
            if (!empty($params['sort_by'])) {
                $builder->where('s.cate_id', $params['sort_by']);
            }
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if ($i == 1) {
                            $builder->like($column, $params['search']['query']);
                        } elseif ($i > 1) {
                            $builder->orLike($column, $params['search']['query']);
                        }
                        $i++;
                    }
                }
            } elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $builder->like('s.' . $params['search']['field'], $params['search']['query']);
            }
            $result = $builder->orderBy('c.name', 'ASC')
                            ->orderBy('s.status', 'DESC')
                            ->orderBy('s.sort', 'ASC')
                            ->orderBy('s.price', 'ASC')->get()->getResultArray();
            if ($result) {
                $result = group_by_criteria($result, 'category_name');
            }
        }

        if ($option['task'] == 'items-category-sort-by') {
            $sql = "SELECT DISTINCT c.id, c.name
                FROM $this->tb_categories c
                JOIN $this->table s ON c.id = s.cate_id ORDER BY c.name ASC";
            $query = $this->db->query($sql);
            $result = $query->getResultArray();
        }
        return $result;
    }

    // Get all items
    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] = 'admin-count-items-group-by-status') {
            
        }
        return $result;
    }

    // get item for ajax update with no refesh page
    public function get_item_for_ajax_update($item_id = '')
    {
        $result = null;
        if ($item_id) {
            $builder = $this->db->table($this->table .' s');
            $builder->select('s.*')
                    ->select('c.name as category_name')
                    ->select('api.name as api_name')
                    ->join($this->tb_categories . ' c', 'c.id = s.cate_id', 'left')
                    ->join($this->tb_providers . ' api', 'api.id = s.api_provider_id', 'left')
                    ->where('s.id', $item_id);  
            $query = $builder->get();     
            $result = $query->getRowArray();     
        }
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item') {
            return db_get('*', $this->table, ['id' => $params['id']]);
        }
        if ($option['task'] == 'get-item-for-ajax-update') {
            $builder = $this->db->table($this->table .' s');
            $builder->select('s.*')
                    ->select('c.name as category_name')
                    ->select('api.name as api_name')
                    ->join($this->tb_categories . ' c', 'c.id = s.cate_id', 'left')
                    ->join($this->tb_providers . ' api', 'api.id = s.api_provider_id', 'left')
                    ->where('s.id', $params['id']);  
            $query = $builder->get();     
            $result = $query->getRowArray();     
        }
        return $result;
    }


    /**
     * Saves an item based on the provided parameters and options.
     */
    public function save_item($params = null, $option = null)
    {
        $response = [];
        // Add Item
        if ($option['task'] == 'add-item') {
            $data_item = $this->prepare_item_data($params['post_input'], 'add', $option);
            $data_item['ids'] = ids();
            $result = db_insert($this->table, $data_item);
            $response = $this->handle_db_result($result, 'added');
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $data_item = $this->prepare_item_data($params['post_input'], 'edit', $option);
            $result = db_update($this->table, $data_item, ['id' => sanitize_input($params['post_input']['id'])]);
            $response = $this->handle_db_result($result, 'updated');
        }
        return $response;
    }
    
    private function prepare_item_data($post_input, $action = 'add', $option = [])
    {
        $data_item = $this->prepare_crud_data($post_input, $action);
        $data_item['is_tab_name'] = $post_input['is_tab_name'] ?? 0;
        $data_item['tab_name'] = json_encode(sanitize_input($post_input['tab_name']));
        if (isset($data_item['discount_value']) && $data_item['discount_value'] > 0) {
            $data_item['price'] = $data_item['original_price'] * (1 - $data_item['discount_value'] / 100);
            $data_item['price'] = round($data_item['price'], 2);
        } else {
            $data_item['price'] = $data_item['original_price'];
        }
        return sanitize_input($data_item);
    }
}

