<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\ServicesModel as MainModel;
use App\Models\Admin\SocialNetworkModel;
use App\Models\Admin\ProvidersModel;
use App\Models\Admin\CategoryModel;
use App\Requests\Admin\ServicesRequest as MainRequest;

class ServicesController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/services/';
        $this->controller_name     = 'services';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "id"             => ['name' => 'ID',     'class' => 'text-center'],
            "name"           => ['name' => 'Name',     'class' => ''],
            "original_price"     => ['name' => 'Original price',    'class' => 'text-center'],
            "discount_value"          => ['name' => 'Discount (%)',    'class' => 'text-center'],
            "price"          => ['name' => 'Price',    'class' => 'text-center'],
            "quantity"       => ['name' => 'Quantity', 'class' => 'text-center'],
            "type"           => ['name' => 'Type',     'class' =>  'text-center'],
            "provider"       => ['name' => 'Provider', 'class' =>  'text-center'],
            "api_provider_price"           => ['name' => 'API Rate (Per 1000)', 'class' => 'text-center'],
            "status"         => ['name' => 'Status',   'class' =>      'text-center'],
            "created"        => ['name' => 'created',  'class' =>      'text-center'],
        ];

        $this->load_files = [
            "cssFiles"   => [],
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui', 'sortable']),
                'scripts' =>  get_plugin_css_js_path(['notify'])
            ],
        ];
        
        $this->page_title = [
            'title' => 'Services',
            'right' => ['type' => 'search', 'action' => ''],
            'secondRow' => [
                'left'  => [
                    'addNew' => ['name' => 'Add New',   'class' => 'ajaxModal', 'icon' => 'fe fe-plus', 'route-name' => '/update/'], 
                    'hideAll' => ['name' => 'Hide All',   'class' => 'btn-services-collapse', 'icon' => 'fe fe-chevrons-up', 'route-name' => '#']
                ],
                'right' => [
                    'sortBy'     => ['name' => 'Add New',   'class' => 'ajaxSortBy', 'icon' => '', 'route-name' => '/sort_by/'], 
                    'bulkActions' => ['name' => 'Actions ',   'class' => ' ', 'icon' => '', 'route-name' => '']
                ],
            ],
        ];
    }

    public function index()
    {
        $this->params['filter'] = [
            'status' => (isset($_GET['status'])) ? get('status') : 'all',
        ];
        $this->params['sort_by'] = (isset($_GET['sort_by'])) ? (int)get('sort_by') : '';
        $this->params['search'] = [
            'query' => get('query'),
            'field' => get('field'),
        ];
        $items_by_category  = $this->model->list_items([], [ 'task' => 'items-category-sort-by']);
        if (!in_array($this->params['sort_by'], array_column($items_by_category , 'id'))) {
            unset($this->params['sort_by']);
        }
        $items = $this->model->list_items($this->params, ['task' => 'admin-list-items']);
        return view($this->path_view_controller . 'index', [
            'controller_name'     => $this->controller_name,
            "params"             => $this->params,
            'tb_columns'         => $this->tb_columns,
            'items'              => $items,
            'items_by_category'        => $items_by_category ,
            'pagination'         => $this->model->pager,
            'page_title'          => $this->page_title,
            'load_files'          => $this->load_files,
            'path_view_controller' => $this->path_view_controller,
        ]);
    }

    public function update($id = null)
    {   
        $item = null;
        if ($id !== null) {
            $item = $this->model->get_item(['id' => esc($id)], ['task' => 'get-item']);
        }
        $category_model = new CategoryModel();
        $items_category_tmp = $category_model->list_items($this->params, ['task' => 'admin-list-items-on-services']);
        $items_category = [];
        foreach ($items_category_tmp as $key => $value) {
            $items_category[$key] = array_column($value, 'name', 'id');
        }

        $providers_model = new ProvidersModel();
        $items_provider = $providers_model->list_items([], ['task' => 'admin-items-by-params']);
        $items_language = db_fetch('code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        return view($this->path_view_controller . 'update', [
            'controller_name'     => $this->controller_name,
            'item'               => $item,
            'items_category'      => $items_category,
            'items_provider'      => $items_provider,
            'items_language'      => $items_language,
            'path_view_controller' => $this->path_view_controller,
            'js_validation_config' => $this->main_request->js_validation_config('update'),
        ]);
    }
  
}
