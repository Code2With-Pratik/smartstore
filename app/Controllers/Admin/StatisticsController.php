<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\StatisticsModel as MainModel;

class StatisticsController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/statistics/';
        $this->controller_name     = 'statistics';
        $this->model              = new MainModel();
        $this->tb_columns = [];
        $this->load_files = [
            "cssFiles"   => get_plugin_css_js_path(['jquery_ui', 'charts_c3'], 'css'),
            "jsFiles" => [
                'scripts' => get_plugin_css_js_path(['charts_d3_c3', 'charts_c3', 'chart_int']), 
            ],
        ];
        $this->page_title = [];
    }

    public function index()
    {

        $header_statistics          = view($this->path_view_controller . '/header_statistics',[ 
            "header_area" => $this->model->header_statistics()
        ]);

        // Recent client
        $order_chart_spline  = view($this->path_view_controller . '/order_chart_spline',[ 
            "title"                 => 'Recent Orders',
            "order_chart_spline"    => $this->model->order_chart_spline()
        ]);

        // Top clients by orders
        $top_clients_orders = view($this->path_view_controller . '/top_clients_orders', [
            "title" => 'Top Clients by Orders', 
            "top_clients_orders" => $this->model->get_top_clients_by_orders(['limit' => 10]),
        ]);

        // Recent Clients
        $recent_clients = view($this->path_view_controller . '/recent_clients', [
            "title" => 'Recent Clients', 
            "recent_clients" => $this->model->get_recent_clients(['limit' => 10]),
        ]);

        $data_view = [
            "controller_name"               => $this->controller_name,
            'load_files'                    => $this->load_files,
            "header_statistics_area"        => $header_statistics,
            "order_chart_spline_area"       => $order_chart_spline,
            "top_clients_orders_area"       => $top_clients_orders,
            "recent_clients_area"           => $recent_clients,
        ];

        return view($this->path_view_controller . "/index", $data_view);
    }
}
