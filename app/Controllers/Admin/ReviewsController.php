<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\ReviewsModel as MainModel;
use App\Requests\Admin\ReviewsRequest as MainRequest;

class ReviewsController extends MyAdminController
{

    public function __construct()
    { 
        parent::__construct();
        $this->path_view_controller = 'admin/pages/reviews/';
        $this->controller_name     = 'reviews';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();
        $this->tb_columns = [
            "id"      => ['name' => 'ID', 'class' => 'text-center'],
            "name"      => ['name' => 'Name', 'class' => 'text-center'],
            "client_order_id"  => ['name' => 'Client Order ID', 'class' => 'text-center'],
            "content"   => ['name' => 'Content', 'class' => 'text-center'],
            "rating"   => ['name' => 'Rating', 'class' => 'text-center'],
            "ip"   => ['name' => 'IP Address', 'class' => 'text-center'],
            "status"    => ['name' => 'Status', 'class' => 'text-center'],
            "last_submit-date"   => ['name' => 'Last Submit', 'class' => 'text-center'],
            "last_changed"   => ['name' => 'Last Changed', 'class' => 'text-center'],
        ];
        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head'      => get_plugin_css_js_path(['jquery_ui']),
                'scripts'   => get_plugin_css_js_path([]),
            ],
        ];
        
        $this->page_title = [
            'title' => 'Manage Reviews',
            'right' => [],
        ];
    }
}
