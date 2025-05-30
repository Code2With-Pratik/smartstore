<?php
namespace App\Models\Admin;

use App\Models\MyModel;

class MyAdminModel extends MyModel
{
    protected $select_fields_index = '*';
    protected $bulk_actions_copy_clipboard_accepted;
    protected $foreign_key_for_table_lang;

    public function __construct()
    {
        parent::__construct();
        $this->blog_posts_lang_builder = $this->db->table(TB_BLOG_POSTS_LANG);
        $this->lang_list_builder = $this->db->table(TB_LANGUAGE_LIST);
    }

    /**
     * Retrieves a list of items for display on an index page.
     */
    public function list_items_for_index($params = null, $option = null)
    {
        $result = null;
        $this->main_builder->select($this->select_fields_index);

        // For Payment method
        if ($this->table === TB_PAYMENTS_METHOD) {
            $this->main_builder->where('type !=', 'free');
        }
        // Apply filter and search conditions
        $this->apply_filter_and_search($this->main_builder, $params);

        // Create a clone of the builder for counting results
        $builder_for_count = clone $this->main_builder;
        $builder_for_count->select('id'); // Choose one column to count the rows
        $total_items = $builder_for_count->countAllResults(true);

        // orderBy
        if (in_array($this->table, [$this->tb_tickets])) {
            $this->main_builder->orderBy('read', 'DESC');
            $this->main_builder->orderBy("FIELD (status, 'new', 'answered', 'closed')");
            $this->main_builder->orderBy('created', 'DESC');
        } else if (in_array($this->table, [$this->tb_reviews])) {
            $this->main_builder->orderBy('id', 'DESC');
            $this->main_builder->orderBy('status', 'ASC');
        } else if (in_array($this->table, [$this->tb_subscribers]) ) {
            $this->main_builder->orderBy('id', 'DESC');
        } else {
            $this->main_builder->orderBy('status', 'DESC');
        }

        if (in_array($this->table, [$this->tb_categories, $this->tb_payments, $this->tb_social_network, $this->tb_services, $this->tb_menu])) {
            $this->main_builder->orderBy('sort', 'ASC');
        }

        $this->main_builder->limit($params['pagination']['limit'], $params['pagination']['start']);
        $items = $this->main_builder->get()->getResultArray();
        // $this->pr_sql(1);
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
     * Counts the number of items grouped by their status.
     */
    public function count_items_by_status($params = [])
    {
        if ($this->table == TB_ORDERS) {
            return null;
        } else {
            $this->main_builder->select('status, COUNT(id) as count');
            $this->main_builder->groupBy('status');
            // Apply filter and search conditions
            $this->apply_filter_and_search($this->main_builder, $params);
            if (in_array($this->table, [$this->tb_reviews])) {
                $this->main_builder->orderBy('status', 'ASC');
            } else {
                $this->main_builder->orderBy('status', 'DESC');
            }
            $query = $this->main_builder->get();
            return $query->getResultArray();
        }
    }

    /**
     * Retrieves an item for an AJAX update based on the provided item ID.
     */
    public function get_item_for_ajax_update($item_id = "")
    {
        $result = null;
        if ($item_id) {
            $result = db_get('*', $this->table, ['id' => $item_id]);
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
            $builder->where('status', $status_filter);
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
                        $builder->$method($column, $search_query);
                    }
                    $index++;
                }
            } elseif (in_array($search_field, $this->field_search_accepted)) {
                $builder->like($search_field, $search_query);
            }
        }
    }

    /**
     * Saves an item based on the provided parameters and options.
     */
    public function save_item($params = null, $option = null)
    {
        $response = [];
        // Add Item
        if ($option['task'] == 'add-item') {
            $data_item = $this->prepare_crud_data($params['post_input'], 'add');
            $data_item['ids'] = ids();
            // For coupons
            if (isset($option['controller_name']) && $option['controller_name'] == 'coupons') {
                $data_item['start_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', get_post('start_date'))));
                $data_item['end_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', get_post('end_date'))));
            }
            $result = db_insert($this->table, $data_item);
            $response = handle_db_operation_result($result, 'added', 'error');
        }

        // Edit item
        if ($option['task'] == 'edit-item') {
            $data_item = sanitize_input($this->prepare_crud_data($params['post_input'], 'edit'));
            // From Payments controllers
            if (isset($option['controller_name']) && $option['controller_name'] == 'payments') {
                $payment_params = sanitize_input($params['post_input']['payment_params']);
                $data_item['params'] = json_encode($payment_params);
            }
            // For coupons
            if (isset($option['controller_name']) && $option['controller_name'] == 'coupons') {
                $data_item['start_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', get_post('start_date'))));
                $data_item['end_date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', get_post('end_date'))));
            }

            $result = db_update($this->table, $data_item, ['id' => sanitize_input($params['post_input']['id'])]);
            $response = handle_db_operation_result($result, 'updated', 'error');
        }
        return $response;
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
                    $this->main_builder->whereIn('id', $array_idss);
                    $this->main_builder->update(['status' => $params['type']]);
                    $response = get_message('updated');
                    break;
            }

        }

        return $response;
    }

    /**
     * Creates a duplicate of an item based on the provided ID.
     */
    public function duplicate_item($id)
    {
        $response = [];
        $item = $this->get_item(['id' => $id], ['task' => 'get-item']);
        if ($item) {
            $default_lang_code = get_default_lang_code();
            unset($item['id']);
            $data_item = $item;
            $data_item['ids'] = ids();
            if (isset($data_item['name'])) {
                $data_item['name'] = '[Duplicated]-' . $data_item['name'];
            }
            if (isset($data_item['url_slug'])) {
                $data_item['url_slug'] = 'duplicated-' . $data_item['url_slug'];
            }
            if (isset($data_item['sort'])) {
                $data_item['sort'] += 1;
            }
            $result = db_insert($this->table, $data_item);
            $new_item_id = $result;
            if ($this->table_lang_exists($this->table_lang)) {
                $foreign_key_column = $this->foreign_key_for_table_lang;
                if ($foreign_key_column) {
                    $items_lang = db_fetch('*', $this->table_lang, [$foreign_key_column => $id]);
                    if (!empty($items_lang)) {
                        foreach ($items_lang as $key => $item_lang) {
                            unset($item_lang['id']);
                            $item_lang['ids'] = ids();
                            $item_lang[$foreign_key_column] = $new_item_id;
                            if ($item_lang['lang_code'] == $default_lang_code ) {
                                $item_lang['name'] = $data_item['name'];
                            }
                            $result_lang = db_insert($this->table_lang, $item_lang);
                        }
                    }
                }
            }
            $response = handle_db_operation_result($result, 'duplicated', 'error');
        }
        return $response;
    }

    protected function table_lang_exists($table_lang = '') {
        $tables_lang = [
            TB_PAGES_LANG,
            TB_BLOG_POSTS_LANG,
            TB_CATEGORIES_LANG
        ];
        return in_array($table_lang, $tables_lang);
    }

    protected function get_foreign_key_for_table_lang()
    {
        
        if ($this->table_lang == TB_PAGES_LANG) {
            return 'page_id';
        } elseif ($this->table_lang == TB_BLOG_POSTS_LANG) {
            return 'post_id';
        } elseif ($this->table_lang == TB_CATEGORIES_LANG) {
            return 'cate_id';
        }
        return ''; 
    }

    /**
     * Changes the status of a specific item.
     */
    public function change_item_status($params)
    {
        $response = [];
        $result = db_update($this->table, ['status' => $params['status']], ['id' => sanitize_input($params['id'])]);

        if (!$params['status']) {
            // Update all service relate to this category
            if ($this->table_lang_exists($this->table_lang)) {
                db_update($this->table_lang, ['status' => $params['status']], [$this->foreign_key_for_table_lang => sanitize_input($params['id'])]);
            }
        }

        $response = handle_db_operation_result($result, 'updated', 'error');
        return $response;
    }

    /**
     * Sorts the rows of items in a table based on the given parameters.
     */
    public function sort_table_items($params = null, $option = null)
    {
        $response = [];
        if ($option['task'] == 'sort-table') {
            $result = db_update_batch($this->table, sanitize_input($params['items']), 'id');
            $response = $this->handle_db_result($result, 'updated');
        }
        return $response;
    }

    /**
     * Deletes an item based on the provided parameters.
     */
    public function delete_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'delete-item') {

            $item = $this->get_item(['id' => $params['id']], ['task' => 'get-item']);
            if ($item) {
                if (isset($item['is_core_page']) && $item['is_core_page']) {
                    return [
                        'status'    => 'error',
                        'message'   => 'Deleting core pages is not allowed'
                    ];
                }
                // For Language
                if (isset($item['is_default']) && $item['is_default']) {
                    return [
                        'status'    => 'error',
                        'message'   => 'Deleting default language is not allowed'
                    ];
                }
                $this->delete(['id' => $params['id']]);
                // Delete all items related main item
                if ($this->table_lang_exists($this->table_lang)) {
                    db_update($this->table_lang, ['status' => $params['status']], [$this->foreign_key_for_table_lang => sanitize_input($params['id'])]);
                }
                $result = get_message('deleted');
                $result['ids'] = $item['ids'];
            } else {
                $result = get_message('error');
            }
        }
        return $result;
    }

    public function prepare_crud_data($params, $task = 'edit')
    {
        $params = array_diff_key($params, array_flip($this->crud_restricted_fields));
        if ($this->useTimestamps) {
            if ($this->updatedField == 'changed') {
                $params['changed'] = NOW;
            }
            if ($task == 'add' && $this->createdField == 'created') {
                $params['created'] = NOW;
            }
        }
        return $params;
    }

    // Save Item include Item Lang
    protected function save_item_with_lang($data_item = [], $data_item_by_lang = [], $task = 'add-item') 
    {
        $response = null;
        if ($task == 'add-item') {
            $response = $this->add_item_with_lang($data_item, $data_item_by_lang);
        } else if ($task == 'edit-item') {
            $response = $this->edit_item_with_lang($data_item, $data_item_by_lang);
        }
        return $response;
    }

    // Add Item include Item Lang
    protected function add_item_with_lang($data_item = [], $data_item_by_lang = []) 
    {
        // Prepare data for inserting into categories table
        $data_item['ids'] = ids(); 
        $data_item['created'] = NOW;  

        // Insert into categories table
        $last_id = db_insert($this->table, $data_item);
        if (!$last_id) {
            return ["status" => "error", "message" => 'Error while inserting item']; 
        }
        // Prepare data for inserting into item lang table
        $data_item_by_lang['ids'] = ids();

        $data_item_by_lang[$this->foreign_key_for_table_lang] = $last_id; 

        // Insert into item lang table
        $result_lang = db_insert($this->table_lang, $data_item_by_lang);
        if (!$result_lang) {
            return ["status" => "error", "message" => 'Error while inserting item language']; 
        }
        return handle_db_operation_result($result_lang, 'added', 'error');
    }

    // Add Item include Item Lang
    protected function edit_item_with_lang($data_item = [], $data_item_by_lang = []) 
    {
        // Update data in the categories table
        $result = db_update($this->table, $data_item, ['id' => get_post('id')]);
        if (!$result) {
            return ["status" => "error", "message" => 'Error while updating item']; 
        }
        // Update or insert data in the item lang table
        $where_item_exist = ['lang_code' => $data_item_by_lang['lang_code'], $this->foreign_key_for_table_lang => get_post('id')];
        $exist_item_by_lang = db_get('id', $this->table_lang, $where_item_exist);
        if (empty($exist_item_by_lang)) {
            // If no existing language record, insert a new one
            $data_item_by_lang['ids'] = ids();

            // Table Lang
            $data_item_by_lang[$this->foreign_key_for_table_lang] = get_post('id');  

            $result_lang = db_insert($this->table_lang, $data_item_by_lang);
        } else {
            // If language record exists, update it
            $result_lang = db_update($this->table_lang, $data_item_by_lang, ['id' => $exist_item_by_lang['id']]);
        }
        return handle_db_operation_result($result_lang, 'updated', 'error');
    }
    
    // Prepare Sections Content layout for category & Basic page
    protected function prepare_sections_layout($post_input = []) {
        $sections_layout = null;

        $sections_content = $post_input['sections'] ?? null; 
        $optional_content = $post_input['optional_content'] ?? null; 
        if (!empty($sections_content)) {
            // sections_layout
            $sections_layout = sanitize_input($sections_content);
            if (isset($sections_layout['default_form'])) unset($sections_layout['default_form']);

            // Check optional content content section
            $filtered_option_content = array_filter($sections_layout, function($section) {
                return isset($section['section_type']) && $section['section_type'] === 'optional_content_section';
            });
            
            $filtered_option_content = array_values($filtered_option_content);
            if (count($filtered_option_content) > 1) {
                json_response([
                    'status' => 'error',
                    'message' => 'The "Optional Content Section" can only appear once in "Content Layout"',
                ]);
            };
            // add content fields for optional_content_section
            $sections_layout = array_map(function($item) use ($optional_content) {
                if (isset($item['section_type']) && $item['section_type'] === 'optional_content_section') {
                    if (isset($item['fields'])) {
                        $item['fields']['content'] = $optional_content;
                    } else {
                        $item['fields'] = ['content' => $optional_content];
                    }
                }
                return $item;
            }, $sections_layout);
        }
        return $sections_layout;
    }

    // Check if the URL slug is unique for either add or edit task
    protected function item_lang_url_slug_exists($url_slug, $task = 'add-item', $lang_code = 'en')
    {
        if ($task == 'add-item') {
            return db_get('id', $this->table_lang, ['url_slug' => $url_slug, 'lang_code' => $lang_code]);
        } else if ($task == 'edit-item') {
            $where = [];
            $foreign_key_column = $this->foreign_key_for_table_lang;
            $where = ['url_slug' => $url_slug, $foreign_key_column .' !=' => get_post('id'), 'lang_code !=' => $lang_code];
            if (!empty($where)) {
                return db_get('id', $this->table_lang, $where);
            }
        }
        return false; 
    }


    protected function handle_db_result($result, $action = 'added')
    {
        return handle_db_operation_result($result, $action, 'error');
    }
}
