<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\ProvidersModel as MainModel;
use App\Requests\Admin\ProvidersRequest as MainRequest;

use App\Libraries\SmmApi;

class ProvidersController extends MyAdminController
{
    private $smmApi;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/providers/';
        $this->controller_name     = 'providers';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();
        $this->tb_columns = [
            "name"    => ['name' => 'Name', 'class' => ''],
            "balance" => ['name' => 'Balance', 'class' => 'text-center'],
            "status"  => ['name' => 'Status', 'class' => 'text-center'],
            "created" => ['name' => 'created', 'class' => 'text-center'],
            "note"    => ['name' => 'Note', 'class' => 'text-center'],
        ];
        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path(['notify'])
            ],
        ];
        $this->page_title = [
            'title' => 'Providers',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];

        // Load SMM API
        $this->smmApi = new SmmApi();
    }

    
    public function store()
    {

        if (is_ajax_request() && is_request_method('POST')) {
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
            $result = $this->smmApi->balance(['url' => get_post('url'), 'key' => get_post('key')]);
            if ($result && isset($result['balance'])) {
                $this->params["balance"] = $result['balance'];
            } else {
                return json_response([
                    'status' => 'error', 
                    'message' => 'There seems to be an issue connecting to API provider. Please check API URL and Key again!'
                ]);
            }
            $task = 'add-item';
            if (get_post('id')) {
                $task = 'edit-item';
            }
            $result = $this->model->save_item($this->params, ['task' => $task, 'controller_name' => $this->controller_name]);
            // Update table tr no need to refresh page use ajax
            if ($task == 'edit-item' && $result['status'] == 'success') {
                $item = $this->model->get_item_for_ajax_update(get_post('id'));
                $view_data = [
                    'controller_name' => $this->controller_name,
                    'item' => $item,
                    'params' => ['search' => ''],
                ];
                $html_content = view($this->path_view_controller . 'child/item_row', $view_data);
                $result['html_content'] = $html_content;
            } 
            json_response($result);
        }
    }

    public function balance($id = null)
    {   
        // Get form
        if ($this->request->isAJAX() && $this->request->getMethod(true) == 'POST' && $id !== null) {
            $params = [];
            $item = $this->model->get_item(['id' => $id], ['task' => 'get-item']);
            if (!$item) return json_response([
                'status' => 'error', 
                'message' => 'The provider does not exists'
            ]);
            $result = $this->smmApi->balance($item);
            if ($result && isset($result['balance'])) {
                $params["balance"] = $result['balance'];
                $params["id"]      = $id;
            } else {
                return json_response([
                    'status' => 'error', 
                    'message' => 'There seems to be an issue connecting to API provider. Please check API URL and Key again!'
                ]);
            }
            $response = $this->model->save_item($params, ['task' => 'item-balance']);
            json_response($response);
        }
    }

    public function sync_services($id = null)
    {   
        // Get form
        $item = null;
        if ($this->request->isAJAX() && $this->request->getMethod(true) == 'GET') {
            if ($id !== null) {
                $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
            }
            return view($this->path_view_controller . 'sync_services', [
                'controller_name' => $this->controller_name,
                'item' => $item,
            ]);
        }
        // Action
        if ($this->request->isAJAX() && $this->request->getMethod(true) == 'POST') {
            pr( 1, 1);
        }
    }

    public function services($id)
    {   
        // Get form
        $item = null;
        if ($this->request->isAJAX() && $id != null) {
            $itemApi = $this->model->get_item(['id' => (int)$id], ['task' => 'get-item']);
            $xhtml_option = null;
            if (!empty($itemApi)) {
                $items = $this->smmApi->services($itemApi);
                if (!isset($items['error']) && $items) {
                    if(!in_array($itemApi['type'], ['realfans'] )){
                        usort($items, function($a, $b) {return $a['service'] - $b['service'];});
                    }
                    $xhtml_option = '<option value="0">Choose Service</option>';
                    foreach ($items as $key => $item) {
                        $data_attr = null;
                        foreach ($item as $attr => $value) {
                            if (in_array($attr, ['min', 'max', 'dripfeed', 'refill'])) {
                                $value = (int)$value;
                            }
                            // if ($attr == 'type') {
                            //     $value = service_type_format($value);
                            // }
                            $data_attr .= ' data-'. $attr .'="' . $value . '"';
                        }
                        $class_selected = (get_post('api_service_id') == $item['service']) ? 'selected' : '';
                        $xhtml_option .= sprintf(
                            '<option %s value="%s" %s>ID%s - (%s) - %s</option>', 
                            $class_selected, $item['service'], $data_attr, $item['service'], (double)$item['rate'], truncate_string($item['name'], 60)
                        );
                    }
                } else {
                    $xhtml_option = '<option value="0">'. $items['error'] .'</option>';
                }
                echo $xhtml_option;
            }
        }
    }
}
