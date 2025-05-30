<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\TransactionsModel as MainModel;

class TransactionsController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/transactions/';
        $this->controller_name     = 'transactions';
        $this->model              = new MainModel();
        $this->tb_columns = [
            "id"              => ['name' => '#',               'class' => 'text-center'],
            "order_id"        => ['name' => 'Order ID',        'class' => 'text-center'],
            "user"            => ['name' => 'Customer',        'class' => 'text-center'],
            "payment"         => ['name' => 'Method',          'class' => 'text-center'],
            "tnx_id"          => ['name' => 'Transaction ID',  'class' => 'text-center'],
            "amount"          => ['name' => 'Total Amount',    'class' => 'text-center'],
            "status"          => ['name' => 'Status',          'class' => 'text-center'],
            "created"         => ['name' => 'Created',         'class' => 'text-center'],
        ];
        $this->page_title = [
            'title' => 'Transactions',
            'right' => ['type' => '', 'action' => ''],
        ];
    }
}
