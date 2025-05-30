<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\MenuModel as MainModel;
use App\Models\Admin\CategoryModel;
use App\Requests\Admin\MenuRequest as MainRequest;

class MenuController extends MyAdminController
{

    public function __construct()
    {
        clear_client_menu_cache();
        parent::__construct();
        $this->path_view_controller = 'admin/pages/menu/';
        $this->controller_name     = 'menu';
        $this->model              = new MainModel();
        $this->main_request       = new MainRequest();
        $this->load_files = [
            "cssFiles"   => [
            ],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path(['tinymce', 'notify'])
            ],
        ];
        $this->page_title = [
            'title' => 'Header Menu',
            'right' => ['type' => 'addButton', 'action' => ''],
        ];
    }


    public function index()
    {
        
        $this->params = $this->build_params();
        $list_items = $this->model->list_items_for_index($this->params, ['has_pagination' => true]);
        $items_status_count = $this->model->count_items_by_status($this->params);
       
        $this->tb_columns = array(
            "name"     => ['name' => 'Name', 'class' => 'text-center'],
            "type"     => ['name' => 'Menu Type', 'class' => 'text-center'],
            "target"   => ['name' => 'Target', 'class' => 'text-center'],
            "status"   => ['name' => 'Status', 'class' => 'text-center'],
        );
        $view_data = [
            'controller_name'       => $this->controller_name,
            "params"                => $this->params,
            'tb_columns'            => $this->tb_columns,
            'items'                 => $list_items['items'],
            'items_status_count'    => $items_status_count,
            'pagination'            => $list_items['paginate'],
            'page_title'            => $this->page_title,
            'load_files'            => $this->load_files,
            'path_view_controller'  => $this->path_view_controller,
        ];
        return view($this->path_view_controller . 'index', $view_data);
    }

    public function update($id = null)
    {   
        $item = null;
        if ($id !== null) {
            $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
        }

        $categoryModel = new CategoryModel();
        $items_social_network = $categoryModel->list_items([],['task' => 'admin-items-on-menu']);
        $items_language = db_fetch('code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        $view_data = [
            'controller_name'       => $this->controller_name,
            "item"                  => $item,
            "items_social_network"  => $items_social_network,
            "items_language"        => $items_language,
            'page_title'            => $this->page_title,
            'load_files'            => $this->load_files,
            'path_view_controller'  => $this->path_view_controller,
            'js_validation_config' => $this->main_request->js_validation_config('update'),
        ];
        return view($this->path_view_controller . 'update', $view_data);
    }
}
