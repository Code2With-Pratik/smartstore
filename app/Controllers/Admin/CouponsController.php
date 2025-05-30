<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\CouponsModel as MainModel;
use App\Requests\Admin\CouponsRequest as MainRequest;

class CouponsController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/coupons/';
        $this->controller_name     = 'coupons';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "id"        => ['name' => 'ID', 'class' => 'text-center'],
            "name"      => ['name' => 'Name', 'class' => ''],
            "code"      => ['name' => 'Code', 'class' => ''],
            "discount_value"    => ['name' => 'Discount value', 'class' => 'text-center'],
            "start_date"    => ['name' => 'Start Date', 'class' => 'text-center'],
            "end_date"    => ['name' => 'End Date', 'class' => 'text-center'],
            "status"  => ['name' => 'Status', 'class' => 'text-center'],
            "created" => ['name' => 'created', 'class' => 'text-center'],
        ];

        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path([ 'datepicker']),
            ],
        ];
        
        $this->page_title = [
            'title' => 'Manage Coupons',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
    }
}
