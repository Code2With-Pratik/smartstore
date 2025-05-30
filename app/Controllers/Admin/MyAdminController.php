<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class MyAdminController extends BaseController
{
    protected $path_view_controller; // Define pathViewController
    protected $controller_name;
    protected $model;
    protected $main_request;
    protected $params = [];
    protected $tb_columns = [];
    protected $load_files = [];
    protected $page_title;
    protected $default_limit_per_page;
    
    public function __construct()
    {
        $this->default_limit_per_page = get_app_setting('admin_max_items_per_page');
        $this->helpers = ['app', 'admin', 'template', 'form', 'form_template' , 'date', 'language' , 'currency', 'cookie'];
    }
    
    public function index()
    {
        $this->params       = $this->build_params();
        $response           = $this->model->list_items_for_index($this->params, ['has_pagination' => true]);
        $items_status_count = $this->model->count_items_by_status($this->params);
        $view_data = [
            'controller_name'        => $this->controller_name,
            'params'                 => $this->params,
            'tb_columns'             => $this->tb_columns,
            'items'                  => $response['items'],
            'items_status_count'     => $items_status_count,
            'pagination'             => $response['paginate'],
            'page_title'             => $this->page_title,
            'load_files'             => $this->load_files,
            'path_view_controller'   => $this->path_view_controller,
        ];
        return view($this->path_view_controller . 'index', $view_data);
    }

    public function update($id = null)
    {   
        $item = null;
        if ($id !== null && $this->controller_name !== 'plugins') {
            $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
        }
        $view_data = [
            'controller_name' => $this->controller_name,
            'item' => $item,
            'js_validation_config' => $this->main_request->js_validation_config('update'),
        ];
        return view($this->path_view_controller . 'update', $view_data);
    }
    
    public function store()
    {
        if (is_ajax_post_request()) { 
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];
            $validations = $this->main_request->validateData($this->request);
            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'errors' => $validations,
                ]);
            }
            $task = 'add-item';
            if (get_post('id')) {
                $task = 'edit-item';
            }
            $result = $this->model->save_item($this->params, ['task' => $task, 'controller_name' => $this->controller_name]);

            // Update table tr no need to refresh page use ajax
            $allow_controllers = ['socialnetwork', 'services', 'blogcategory', 'reviews', 'faqs', 'coupons'];
            if (in_array($this->controller_name, $allow_controllers) && $task == 'edit-item' && $result['status'] == 'success') {
                $item = $this->model->get_item_for_ajax_update(get_post('id'));
                $view_data = [
                    'controller_name' => $this->controller_name,
                    'item' => $item,
                    'params' => ['search' => ''],
                ];
                $html_content = view($this->path_view_controller . 'child/item_row', $view_data);
                $result['html_update'] = [
                    'action_type' => 'replaceWith',
                    'html_content' => $html_content,
                    'target_selector' => 'tr.tr_' . $item['ids'],
                ];
            } 
            json_response($result);
        }
    }

    // Sort Table by drap
    public function sort_table()
    {
        if (is_ajax_post_request()) { 
            $items = get_post('items');
            if ($items && get_post('action') == 'sort_table') {
                $result = $this->model->sort_table_items(['items' => $items], ['task' => 'sort-table']);
                json_response($result);
            }
        }
    }

    // Change status
    public function change_status()
    {
        if (is_ajax_post_request()) { 
            $params = [
                'id'        => (int)get_post('id'),
                'status'    => (int)get_post('status'),
            ];
            $response = $this->model->change_item_status($params);
            json_response($response);
        }
    }

    // Delete Item
    public function delete($id = null)
    {
        if (is_ajax_post_request()) { 
            if ($id) {
                $result = $this->model->delete_item(['id' => sanitize_input($id)], ['task' => 'delete-item']);
                json_response($result);
            }
        }
    }

    // Duplicate Item
    public function duplicate($id = null)
    {
        if (is_ajax_post_request()) { 
            if ($id) {
                $result = $this->model->duplicate_item(sanitize_input($id));
                $result['redirect_url'] = $result['redirect_url'] ?? admin_url($this->controller_name);
                json_response($result);
            }
        }
    }

    //Bulk action
    public function bulk_action()
    {
        if (is_ajax_post_request()) { 
            $params = [
                'ids'       => get_post('ids'),
                'type'      => get_post('type'),
            ];
            $result = $this->model->save_items($params, ['task' => 'bulk-action']);
            json_response($result);
        }
    }

    /**
     * Build parameters for the query.
     *
     * @param int $start The starting index for pagination.
     * @return array
     */
    protected function build_params()
    {
        // Get current page and calculate start index for pagination
        $page = max((int)get('page') - 1, 0);
        $start = $page * $this->default_limit_per_page;

        return [
            'pagination' => [
                'limit' => $this->default_limit_per_page,
                'start' => $start,
            ],
            'filter' => [
                'status' => get('status', 'all'),
            ],
            'search' => [
                'query' => get('query'),
                'field' => get('field'),
            ],
        ];
    }
}
