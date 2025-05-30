<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;
use App\Models\Admin\SocialNetworkModel;

class CategoryModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_CATEGORIES;
        $this->table_lang      = TB_CATEGORIES_LANG;

        $this->main_builder                     = $this->db->table($this->table);
        $this->foreign_key_for_table_lang       = $this->get_foreign_key_for_table_lang();

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['category'];
        $this->allowedFields       = [
            'ids', 'name', 'sncate_id', 'url_slug', 'manage_sections', 'sort', 'status', 'created', 'changed',
        ];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        $builder = $this->db->table($this->table .' c');

        if ($option['task'] == 'list-items') {
            $builder->select('c.id, c.name, c.ids, c.url_slug, c.sort, c.status, c.created, c.changed')
                    ->select('sn.name as social_network_name, sn.id as main_sn_id')
                    ->join($this->tb_social_network . ' sn', 'sn.id = c.sncate_id', 'left');
            // Ajax Sort By Social Network
            if (!empty($params['sort_by'])) {
                $builder->where('c.sncate_id', (int)$params['sort_by']);
            }
            // Apply search conditions
            $search_field = $params['search']['field'] ?? 'all';
            $search_query = $params['search']['query'] ?? '';
            if ($search_query) {
                if ($search_field === 'all') {
                    $index = 1;
                    foreach ($this->field_search_accepted as $index => $column) {
                        if ($column !== 'all') {
                            $method = ($index === 1) ? 'like' : 'orLike';
                            $builder->$method('c.' . $column, $search_query);
                        }
                        $index++;
                    }
                } elseif (in_array($search_field, $this->field_search_accepted)) {
                    $builder->like('c.' . $search_field, $search_query);
                }
            }
            $result = $builder->orderBy('sn.status', 'DESC')->orderBy('sn.sort', 'ASC')
                            ->orderBy('c.status', 'DESC')
                            ->orderBy('c.sort', 'ASC')
                            ->get()->getResultArray();
            if ($result) {
                $result = group_by_criteria($result, 'social_network_name');
            }
        }

        if ($option['task'] == 'admin-list-items-on-services') {
            $builder->select('c.id, c.name')
                    ->select('sn.name as social_network_name, sn.id as main_sn_id')
                    ->join($this->tb_social_network . ' sn', 'sn.id = c.sncate_id', 'left');
                    // ->where('c.status', 1);
            
            $result = $builder->orderBy('sn.sort', 'ASC')->orderBy('c.sort', 'ASC')->get()->getResultArray();
            if ($result) {
                $result = group_by_criteria($result, 'social_network_name');
            }
        }

        if ($option['task'] == 'items-category-sort-by') {
            $sql = "SELECT DISTINCT sn.id, sn.name
                FROM $this->tb_social_network sn
                JOIN $this->table c ON sn.id = c.sncate_id ORDER BY sn.name ASC";
            $query = $this->db->query($sql);
            $result = $query->getResultArray();
        }

        // Get items list by params (condition)  on services, etc
        if ($option['task'] == 'admin-items-by-params') {
            $query = $this->select('id, name');
            if (isset($params['status'])) {
                $query->where($params);
            }
            $result =  $query->orderBy('name', 'ASC')->get()->getResultArray();
        }
        // Get items on Manage Menu
        if ($option['task'] == 'admin-items-on-menu') {
            $sql = "SELECT DISTINCT snc.name, snc.id, snc.ids
                    FROM $this->tb_social_network snc
                    JOIN $this->table c ON snc.id = c.sncate_id
                    WHERE c.status = 1";
            $query = $this->db->query($sql);
            $result = $query->getResultArray();
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

    // save item
    public function save_item($params = null, $option = null)
    {
        $result = [];
        $redirect_url = '';
        if (in_array($option['task'], ['add-item', 'edit-item'])) {
            $response = $this->save_item_edit_add($params, $option['task']);
        }
        
        return $response;
    }

    public function save_item_edit_add($params, $task = '')
    {
        $default_language_code = get_default_lang_code();
        $name               = get_post('name');
        $url_slug           = (get_post('url_slug')) ?? strtolower(url_title($name, '-')); 
        $status             = (int) get_post('status');
        $sncate_id          = get_post('sncate_id');
        $required_field     = get_post('required_field');
        $page_seo           = json_encode(sanitize_input($params['post_input']['page_seo']));
        $lang_code          = (get_post('language_code')) ?? $default_language_code;
        $optional_content   = $params['post_input']['optional_content']; 
        // Check if the URL slug is unique
        if ($this->item_lang_url_slug_exists($url_slug, $task, $lang_code)) {
            return ["status" => "error", "message" => 'URL Slug already exists'];  
        }
        // Get Section Layout
        $sections_layout = $this->prepare_sections_layout($params['post_input']);

        // Prepare data for the categories table
        $data_item = [
            'sncate_id'     => $sncate_id,
            'status'        => $status,
            'icon_class'    => get_post('icon_class') ?? 'bi bi-person-plus',
            'changed'       => NOW, 
        ];
        if ($lang_code == $default_language_code) {
            $data_item['name'] = $name;
            $data_item['url_slug'] = $url_slug;
        }
        $data_item_by_lang = [
            'name' => $name,
            'unit_name' => get_post('unit_name'),
            'url_slug' =>  $url_slug,  
            'lang_code' =>  $lang_code,  
            'required_field' => $required_field,
            'page_seo' => $page_seo,
            'sections_layout' => json_encode($sections_layout),
        ];
        return $this->save_item_with_lang($data_item, $data_item_by_lang, $task);
    }

}   

