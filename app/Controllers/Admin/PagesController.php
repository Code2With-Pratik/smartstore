<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\PagesModel as MainModel;
use App\Requests\Admin\PagesRequest as MainRequest;

class PagesController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/manage_pages/';
        $this->controller_name     = 'pages';
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
            'title' => 'Manage pages',
            'right' => ['type' => 'addButton', 'action' => ''],
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
            "name"                      => ['name' => 'Name', 'class' => ''],
            "template"                  => ['name' => 'Template', 'class' => ''],
            "languages_icon"            => ['name' => render_th_html_with_language_icon($items_language), 'class' => 'text-center'],
            "status"                    => ['name' => 'Status', 'class' => 'text-center'],
            "created"                   => ['name' => 'created', 'class' => 'text-center'],
        ];

        $items = $this->model->list_items($this->params, ['task' => 'list-items']);
        $view_data = [
            'controller_name'     => $this->controller_name,
            "params"             => $this->params,
            'tb_columns'         => $this->tb_columns,
            'items'              => $items,
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
        $language_code = 'en';
        $page_title = [
            'title' => 'Manage Pages',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
        $items_language = db_fetch('*', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        $ui_components_list = config('AppConfig')->client_template['default_ui_components_lists'];
        if ($items_language) {
            $item_default_language = current(array_filter($items_language, fn($item) => $item['is_default'] == 1)) ?: null;
        }
        $language_code = $item_default_language['code'];
        if ($id !== null) {
            $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
            if ($item) {
                $language_code = get('ref_lang') ?? $item_default_language['code'];
                $language_code = validate_language_code($language_code) ?? 'en';
                $item_lang = db_get('*', TB_PAGES_LANG, ['page_id' => $item['id'], 'lang_code' => $language_code]);
                if (!$item_lang) {
                    $item_lang = db_get('*', TB_PAGES_LANG, ['page_id' => $item['id'], 'lang_code' => $item_default_language['code']]);
                }
            }
        }
        $page_type = (isset($item['page_type']) && in_array($item['page_type'], ['default', 'blog', 'home_page'])) ? $item['page_type'] : 'default';
        $ui_components_list = [
            'left'  => get_ui_components_list($page_type, 'left'),
            'right'  => get_ui_components_list($page_type, 'right'),
        ];
        $view_data = [
            'controller_name'           => $this->controller_name,
            'path_view_controller'      => $this->path_view_controller,
            'page_title'                => $this->page_title,
            'load_files'                => $this->load_files,
            'task'                      => $item ? 'edit_item' : 'add_item',
            'item'                      => $item,
            'item_lang'                 => $item_lang,
            'items_language'            => $items_language,
            'language_code'             => $language_code,
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
                    'message' => generate_section_layout_errors($validations)['final_message'],
                    'errors' => generate_section_layout_errors($validations)['errors'],
                ]);
            }
            $result = $this->model->save_item($this->params, ['task' => $task, 'controller_name' => $this->controller_name]);
            json_response($result);
        }
    }
}
