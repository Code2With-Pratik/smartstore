<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\PluginsModel as MainModel;
use App\Requests\Admin\PluginsRequest as MainRequest;

class PluginsController extends MyAdminController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/plugins/';
        $this->controller_name     = 'plugins';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();


        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path(['notify'])
            ],
        ];
        
        $this->page_title = [
            'title' => 'Modules',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
    }

    public function index()
    {
        $item_main = db_get('*', TB_PURCHASE, ['id' => 1]);
        
        if (empty($item_main)) {
           return redirect()->to(admin_url('users'));
        }
        $item_plugins = "";
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $item_main['purchase_code'])) {
            return redirect()->to(admin_url('users'));
        }
        $item_plugins = get_item_plugins($item_main['purchase_code']);
        if (empty($item_plugins)) {
            return redirect()->to(admin_url('users'));
        }
        $items_installed = db_fetch('*', TB_PURCHASE);
        $view_data = array(
            "controller_name"   => $this->controller_name,
            "path_view_controller"   => $this->path_view_controller,
            'page_title'          => $this->page_title,
            'load_files'          => $this->load_files,
            "item_plugins"      => $item_plugins,
            "items_installed"   => $items_installed,
        );
        return view($this->path_view_controller . 'index', $view_data);
    }

    public function store()
    {
        if (is_ajax_post_request()) {

            if (!extension_loaded('zip')) {
                json_response([
                    'status' => 'error',
                    'message' => 'Please enable the Zip extension in your PHP configuration to continue',
                ]);
            }

            if (!extension_loaded('curl')) {
                json_response([
                    'status' => 'error',
                    'message' => 'Please enable the PHP Curl extension in your PHP configuration to continue',
                ]);
            }

            if (ini_get("allow_url_fopen") !== '1') {
                json_response([
                    'status' => 'error',
                    'message' => 'Please enable set allow_url_fopen = on in your PHP configuration to continue',
                ]);
            }

            $type = get_post('type');
            $code = get_post("purchase_code");
            if ($type == 'install') {
                $validations = $this->main_request->validateData($this->request);
                if (!empty($validations)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'type' => 'validation',
                        'errors' => $validations,
                    ]);
                }
                $action = 3;
            } else {
                $item = db_get('id', TB_PURCHASE, ['purchase_code' => sanitize_output($code)]);
                if (empty($item)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'The item does not exists',
                    ]);
                }
                $action = 2;
            }
            $result = __ins($code, $action);
            if (isset($result['status']) && isset($result['response']) && $result['status'] == 'success') {
                $response = $this->model->save_item(['item_data' => $result['response'], 'purchase_code' => $code], ['task' => 'install-upgrade-item']);
                json_response($response);
            } else {
                json_response($result);
            }

        }
    }
    
}
