<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\SubscribersModel as MainModel;

class SubscribersController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/subscribers/';
        $this->controller_name     = 'subscribers';
        $this->model              = new MainModel();

        $this->tb_columns = [
            "id"               => ['name' => '#',             'class'       => 'text-center'],
            "user"             => ['name' => 'Customer',      'class'       =>  'text-center'],
            "ip_address"       => ['name' => 'History IP',    'class' =>      'text-center'],
            "country"          => ['name' => 'Last Order',       'class' =>  'text-center'],
            "created"          => ['name' => 'created',       'class' =>  'text-center'],
        ];
        $this->load_files = [];
        $this->page_title = [
            'title' => 'Subscribers',
            'right' => ['type' => '', 'action' => ''],
        ];
    }
}
