<?php
namespace App\Controllers\Admin;
use App\Controllers\Admin\MyAdminController;

use App\Models\Admin\BlackListIPModel;
use App\Models\Admin\BlackListEmailModel;
use App\Models\Admin\BlackListLinkModel;
use App\Requests\Admin\BlacklistRequest as MainRequest;

class BlacklistController extends MyAdminController
{
    protected $sub_controller;
    protected $page_title_name;
    protected $table_column_name;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/blacklist/';
        $this->controller_name     = 'blacklist';

        $this->sub_controller = get_post('action_type') ?? get('action_type');
        if (!$this->sub_controller || !in_array($this->sub_controller, ['ip', 'link', 'email'])) {
            $this->sub_controller = 'ip';
        }
        $this->params['sub_controller'] = $this->sub_controller;
        
        if ($this->sub_controller == 'ip') {
            $this->page_title_name = 'Blacklist IP';
            $this->table_column_name = 'IP Address';
            $this->model              = new BlackListIPModel();
        } else if ($this->sub_controller == 'email') {
            $this->page_title_name = 'Blacklist Email';
            $this->table_column_name = 'Link';
            $this->model              = new BlackListEmailModel();
        } else if ($this->sub_controller == 'link') {
            $this->page_title_name = 'Blacklist Order Link';
            $this->table_column_name = 'Order Link';
            $this->model              = new BlackListLinkModel();
        }
        $this->main_request        = new MainRequest();
        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [],
        ];
    }

    public function index()
    {

        $this->params = array_merge($this->build_params(), $this->params);
        $this->params['path_link'] = admin_url($this->controller_name .'/'. $this->sub_controller);
        $tb_columns = [
            "name"         => ['name' => $this->table_column_name, 'class' => ''],
            "description"  => ['name' => 'Note',    'class'   =>      'text-center'],
            "status"       => ['name' => 'status',    'class'   =>      'text-center'],
            "created"      => ['name' => 'created', 'class'   =>      'text-center'],
        ];
        $page_title = [
            'title' => $this->page_title_name,
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal', 'route-name' => '/update?action_type=' . $this->sub_controller],
        ];

        $response = $this->model->list_items_for_index($this->params, ['has_pagination' => true]);
        $items_status_count = $this->model->count_items_by_status($this->params);
        return view($this->path_view_controller . 'index', [
            'controller_name'     => $this->controller_name,
            "params"             => $this->params,
            'tb_columns'         => $tb_columns,
            'items'              => $response['items'],
            'items_status_count'   => $items_status_count,
            'pagination'         => $response['paginate'],
            'page_title'          => $page_title,
            'load_files'          => $this->load_files,
            'path_view_controller' => $this->path_view_controller,
        ]);
    }

    public function update($id = null)
    {   
        $item = null;
        if ($id !== null) {
            $item = $this->model->get_item_for_ajax_update(['id' => sanitize_input($id)], ['task' => 'get-item']);
        }
        return view($this->path_view_controller . 'update', [
            'controller_name' => $this->controller_name,
            'item' => $item,
            'sub_controller' => $this->sub_controller,
            // 'js_validation_config' => $this->main_request->js_validation_config('update'),
        ]);
    }

    public function store()
    {
        if ($this->request->isAJAX() && $this->request->getMethod(true) == 'POST') {
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];

            $validations = $this->main_request->validateData($this->request, $this->sub_controller);
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
            json_response($result);
        }
    }
}
