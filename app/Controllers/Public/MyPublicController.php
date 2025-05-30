<?php
namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\Public\BlogModel;

class MyPublicController extends BaseController
{
    protected $path_view_controller; // Define pathViewController
    protected $controller_name;
    protected $model;
    protected $main_request;
    protected $language_info;
    protected $item_limit_per_page;
    protected $reviews_limit_per_page; 
    
    public function __construct()
    {
        $this->language_info = $this->get_language_info();
        $this->item_limit_per_page = get_app_setting('blog_limit_posts_per_page');
        $this->reviews_limit_per_page = get_app_setting('reviews_limit_per_page');
    }

    private function get_language_info() {
        $locale_by_url = segment(1);
        $supported_languages = array_keys(language_codes());
        $language_info = [
            'previous_language' => current_locale(),
            'current_language' => session_get('current_language') ?? current_locale(),
        ];
        if (!empty($locale_by_url) && in_array($locale_by_url, $supported_languages) && $locale_by_url !== $language_info['current_language']) {
            $items_lang_active = db_fetch('id, code', TB_LANGUAGE_LIST, ['status' => 1]);
            if (!empty($items_lang_active)) {
                $locales_db = array_column($items_lang_active, 'code');
                session_set('supported_languages', $locales_db);
                if (in_array($locale_by_url, $locales_db)) {
                    session_set('current_language', $locale_by_url);
                    $language_info['previous_language'] = $language_info['current_language'];
                    $language_info['current_language'] = $locale_by_url;
                    return $language_info;
                }
            }
        }
        // For get default language
        if (empty($language_info['current_language'])) {
            $item_default_lang = db_get('id, code', TB_LANGUAGE_LIST, ['status' => 1, 'is_default' => 1]);
            if (!empty($item_default_lang)) {
                $default_language = $item_default_lang['code'];
                session_set('current_language', $default_language);
                $language_info['previous_language'] = '';
                $language_info['current_language'] = $default_language;
    
                return $language_info;
            }
        }
        return $language_info;
    }

    // Render blog content
    protected function get_blog_content($task = 'blog-index', $url_slug = '')
    {
        $params = [
            'language_info' => $this->language_info, 
            'url_slug' => sanitize_input($url_slug),
            'limit' => $this->item_limit_per_page, 
            'offset' => 0,
        ];
        $blog_model = new BlogModel();
        if ($task == 'blog-index') {
            $items_post                 = $blog_model->get_blog_items($params);
            $total_items_post = db_fetch('id', TB_BLOG_POSTS, ['status' => 1]);
        } else {
            $items_post  = $blog_model->get_items_post_by_category($params, ['task' => '']);
            $total_items_post = $blog_model->total_items_post_by_category($params, ['task' => '']);
        }
        $posts_content = view($this->path_view_controller . 'pages/blog/item_list', [
            'items_post'            => $items_post,
        ]);
        $post_categories_content    = view($this->path_view_controller . 'pages/blog/post_categories', [
            'post_categories'  => $blog_model->get_post_count_by_category(['language_info' => $this->language_info]),
        ]);
        $content = view($this->path_view_controller . 'pages/blog', [
            'has_more_items'                => (count($total_items_post) > $this->item_limit_per_page) ? true : false,
            'items_post'                    => $items_post,
            'posts_content'                 => $posts_content,
            'post_categories_content'       => $post_categories_content,
            'post_category_slug'            => sanitize_input($url_slug),
        ]);
        return [
            'items_post' => $items_post,
            'content'    => $content,
        ];
    }
}
