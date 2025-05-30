<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\CategoryModel as MainModel;
use App\Requests\Admin\CategoryRequest as MainRequest;

class CategoryController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();

        clear_client_menu_cache();

        $this->path_view_controller = 'admin/pages/category/';
        $this->controller_name     = 'category';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->load_files = [
            "cssFiles"   => get_plugin_css_js_path(['flags_docs', 'flags', 'tagsinput'], 'css'),
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui', 'sortable']),
                'scripts' => get_plugin_css_js_path(['flags', 'tinymce', 'tagsinput', 'notify', 'manage_sections'])
            ],
        ];
        
        $this->page_title = [
            'title' => 'Category',
            'right' => ['type' => 'search', 'action' => ''],
            'secondRow' => [
                'left'  => [
                    'addNew' => ['name' => 'Add New',   'class' => '', 'icon' => 'fe fe-plus', 'route-name' => '/update/'],
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
        $items_language = db_fetch('*', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        $this->tb_columns = [
            "id"                        => ['name' => 'ID', 'class' => 'text-center'],
            "name"                      => ['name' => 'Name', 'class' => ''],
            "languages_icon"            => ['name' => render_th_html_with_language_icon($items_language), 'class' => 'text-center'],
            "status"                    => ['name' => 'Status', 'class' => 'text-center'],
            "changed"                   => ['name' => 'Last Changed', 'class' => 'text-center'],
            "created"                   => ['name' => 'created', 'class' => 'text-center'],
        ];

        $items = $this->model->list_items($this->params, ['task' => 'list-items']);
        $items_by_category = $this->model->list_items($this->params, ['task' => 'items-category-sort-by']);
        if (!in_array($this->params['sort_by'], array_column($items_by_category , 'id'))) {
            unset($this->params['sort_by']);
        }
        $view_data = [
            'controller_name'     => $this->controller_name,
            "params"             => $this->params,
            'tb_columns'         => $this->tb_columns,
            'items'              => $items,
            'items_by_category'  => $items_by_category ,
            'items_language'     => $items_language ,
            'pagination'         => $this->model->pager,
            'page_title'          => $this->page_title,
            'load_files'          => $this->load_files,
            'path_view_controller' => $this->path_view_controller,
        ];
        return view($this->path_view_controller . 'index', $view_data);
    }

    public function update($id = null)
    {   
        $item_lang = $item = null;
        $items_language = $item_default_language = null;
        $page_title = [
            'title' => 'Category',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
        $items_language = db_fetch('*', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        if ($items_language) {
            $item_default_language = current(array_filter($items_language, fn($item) => $item['is_default'] == 1)) ?: null;
        }
        $language_code = $item_default_language['code'];
        if ($id !== null) {
            $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
            if ($item) {
                $language_code = get('ref_lang') ?? $item_default_language['code'];
                $language_code = validate_language_code($language_code) ?? 'en';
                $item_lang = db_get('*', TB_CATEGORIES_LANG, ['cate_id' => $item['id'], 'lang_code' => $language_code]);
                if (!$item_lang) {
                    $item_lang = db_get('*', TB_CATEGORIES_LANG, ['cate_id' => $item['id'], 'lang_code' => $item_default_language['code']]);
                }
            }
        }
        // Socianetwork Type
        $items_social_network = db_fetch('id, name', TB_SOCIAL_NETWORK_CATEGORIES, ['status' => 1], 'SORT', 'ASC');

        $ui_components_list = [
            'left'  => get_ui_components_list('category_page', 'left'),
            'right'  => get_ui_components_list('category_page', 'right'),
        ];

        $view_data = [
            'controller_name'           => $this->controller_name,
            'path_view_controller'      => $this->path_view_controller,
            'load_files'                => $this->load_files,
            'task'                      => $item ? 'edit_item' : 'add_item',
            'item'                      => $item,
            'item_lang'                 => $item_lang,
            'items_language'            => $items_language,
            'language_code'             => $language_code,
            'items_social_network'      => $items_social_network,
            'item_default_language'     => $item_default_language,
            'ui_components_list'        => $ui_components_list,
            'js_validation_config'      => $this->main_request->js_validation_config('update'),
        ];
        return view($this->path_view_controller . 'update', $view_data);
    }
    
    public function store()
    {
        if (is_ajax_post_request()) { 
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];
            $task = 'add-item';
            if (get_post('id')) {
                $task = 'edit-item';
            }
            $validations = $this->main_request->validateData($this->request, $task);

            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => get_validation_message_for_alert($validations),
                    'errors' => $validations,
                ]);
            }
            $result = $this->model->save_item($this->params, ['task' => $task, 'controller_name' => $this->controller_name]);
            json_response($result);
        }
    }
}
