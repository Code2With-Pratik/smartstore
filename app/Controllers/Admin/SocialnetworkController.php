<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\SocialNetworkModel as MainModel;
use App\Requests\Admin\SocialNetworkRequest as MainRequest;

class SocialnetworkController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        
        clear_client_menu_cache();

        $this->path_view_controller = 'admin/pages/socialnetwork/';
        $this->controller_name     = 'socialnetwork';
        $this->model              = new MainModel();
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
            'title' => 'Social Network',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
    }
}
