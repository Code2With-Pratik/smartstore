<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\OrdersModel as MainModel;
use App\Requests\Admin\OrdersRequest as MainRequest;

class OrdersController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/orders/';
        $this->controller_name     = 'orders';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();
        
        $this->tb_columns     =  array(
            "id"                => ['name' => 'ID',    'class' => 'text-center'],
            "client_order_id"   => ['name' => 'Client Order ID', 'class' => 'text-center'],
            "user"              => ['name' => 'user', 'class' => 'text-center'],
            "order_details"     => ['name' => 'Order Details', 'class' => 'text-center'],
            "created"           => ['name' => 'Created', 'class' => 'text-center'],
            "response"          => ['name' => 'API Response', 'class' => 'text-center'],
            "status"            => ['name' => 'Status',  'class' => 'text-center'],
        );
        
        $this->page_title = [
            'title' => 'Orders',
            'right' => ['type' => '', 'action' => ''],
        ];
    }
}
