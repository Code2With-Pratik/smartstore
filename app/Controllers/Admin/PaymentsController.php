<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\PaymentsModel as MainModel;
use App\Requests\Admin\PaymentsRequest as MainRequest;

class PaymentsController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/payments/';
        $this->controller_name     = 'payments';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "method"           => ['name' => 'method',      'class'       =>          'text-center'],
            "name"             => ['name' => 'name',       'class'     =>      'text-center'],
            "status"           => ['name' => 'Status',          'class'       =>          'text-center'],
        ];

        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui', 'sortable']),
                'scripts' =>  get_plugin_css_js_path(['notify'])
            ],
        ];

        $this->page_title = [
            'title' => 'Payment Method',
            'right' => ['type' => '', 'action' => ''],
        ];
    }
}
