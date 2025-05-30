<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\BlogCategoryModel as MainModel;
use App\Models\Admin\LanguagesModel;
use App\Requests\Admin\BlogCategoryRequest as MainRequest;

class BlogcategoryController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/blog_category/';
        $this->controller_name     = 'blogcategory';
        $this->model              = new MainModel();
        $this->languagesModel     = new LanguagesModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "name"    => ['name' => 'Name', 'class' => ''],
            "status"  => ['name' => 'Status', 'class' => 'text-center'],
            "created" => ['name' => 'created', 'class' => 'text-center'],
        ];

        $this->load_files = [
            "cssFiles"   => get_plugin_css_js_path(['jquery_ui'], 'css'),
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path([ 'notify', 'tinymce']), 
            ],
        ];
        
        $this->page_title = [
            'title' => 'Blog Category',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
    }

    public function update($id = null)
    {   
        $item = null;
        if ($id !== null) {
            $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
        }
        $items_lang = $this->languagesModel->list_items(['status' => 1], ['task' => 'admin-list-items-by-params']);
        return view($this->path_view_controller . 'update', [
            'controller_name' => $this->controller_name,
            'item' => $item,
            'items_lang' => $items_lang,
            'js_validation_config' => $this->main_request->js_validation_config('update'),
        ]);
    }
}
