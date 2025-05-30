<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\BlogCategoryModel;
use App\Models\Admin\BlogPostsModel as MainModel;
use App\Models\Admin\LanguagesModel;
use App\Requests\Admin\BlogPostsRequest as MainRequest;

class BlogpostsController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/blog_posts/';
        $this->controller_name = 'blogposts';
        $this->model = new MainModel();
        $this->blog_category_model = new BlogCategoryModel();
        $this->languages_model = new LanguagesModel();
        $this->main_request = new MainRequest();

        $this->load_files = [
            "cssFiles" => get_plugin_css_js_path(['flags_docs', 'flags', 'tagsinput'], 'css'),
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path(['flags', 'tinymce', 'datepicker', 'tagsinput', 'notify']),
            ],
        ];

        $this->page_title = [
            'title' => 'Blog Posts',
            'right' => ['type' => 'addButton', 'action' => ''],
        ];
    }

    public function index()
    {
        $this->params = $this->build_params();
        $list_items = $this->model->list_items_for_index($this->params, ['has_pagination' => true]);
        $items_status_count = $this->model->count_items_by_status($this->params);

        $items_category = $this->blog_category_model->list_items(['status' => 1], ['task' => 'admin-list-items-by-params']);
        $items_language = $items_language = db_fetch('*', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
        $this->tb_columns = array(
            "name" => ['name' => 'Name', 'class' => ''],
            "status" => ['name' => 'Status', 'class' => 'text-center'],
            "language" => ['name' => render_th_html_with_language_icon($items_language), 'class' => 'text-center'],
            "released" => ['name' => 'Released', 'class' => 'text-center'],
            "changed" => ['name' => 'Last Changed', 'class' => 'text-center'],
            "created" => ['name' => 'Created', 'class' => 'text-center'],
        );

        $view_data = [
            'controller_name' => $this->controller_name,
            "params" => $this->params,
            'tb_columns' => $this->tb_columns,
            'items' => $list_items['items'],
            'items_category' => $items_category,
            'items_language' => $items_language,
            'items_status_count' => $items_status_count,
            'pagination' => $list_items['paginate'],
            'page_title' => $this->page_title,
            'load_files' => $this->load_files,
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
                $item_lang = db_get('*', TB_BLOG_POSTS_LANG, ['post_id' => $item['id'], 'lang_code' => $language_code]);
                if (!$item_lang) {
                    $item_lang = db_get('*', TB_BLOG_POSTS_LANG, ['post_id' => $item['id'], 'lang_code' => $item_default_language['code']]);
                }
            }
        }
        // Socianetwork Type
        $items_category = db_fetch('id, name', TB_BLOG_CATEGORIES, ['status' => 1], 'SORT', 'ASC');
        $view_data = [
            'controller_name'           => $this->controller_name,
            'path_view_controller'      => $this->path_view_controller,
            'load_files'                => $this->load_files,
            'task'                      => $item ? 'edit_item' : 'add_item',
            'item'                      => $item,
            'item_lang'                 => $item_lang,
            'items_language'            => $items_language,
            'language_code'             => $language_code,
            'items_category'            => $items_category,
            'item_default_language'     => $item_default_language,
            'js_validation_config'      => $this->main_request->js_validation_config('update'),
        ];
        return view($this->path_view_controller . 'update', $view_data);
    }

}
