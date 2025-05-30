<?php
namespace App\Controllers\Public;

use App\Models\Public\BlogModel as MainModel;

class BlogController extends MyPublicController
{
    protected $page_type;
    protected $path_view_sections;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'themes/regular/';
        $this->controller_name      = 'home';
        $this->model                = new MainModel();
        $this->load_files           = [];
        $this->page_title           = [
            'right' => ['type' => '', 'action' => ''],
        ];
        $this->page_type    = 'default';
    }


    public function post_detail($url_slug = null)
    {
        if ($url_slug === null) { 
            return redirect()->to('/'); 
        };
        $items_pagination = [
            'item_prev'  => [],
            'item_next' => [],
        ];
        $items_related_post  = [];
        $item_post  = $this->model->get_item_post_single(['language_info' => $this->language_info, 'url_slug' => sanitize_input($url_slug)], ['task' => '']);
        if (!empty($item_post)) {
            if (isset($item_post['redirect']) && $item_post['redirect'] && isset($item_post['redirect_url'])) {
                return redirect()->to($item_post['redirect_url']);
            }
            if (!empty($item_post['data'])) {
                $item_post = $item_post['data'];
                if (!empty($item_post)) {
                    $items_pagination = $this->model->get_items_pagination(['language_info' => $this->language_info, 'cate_id' => $item_post['cate_id'], 'current_id' => $item_post['id']], ['task' => '']);
                    $items_related_post = $this->model->get_items_related_post(['language_info' => $this->language_info, 'cate_id' => $item_post['cate_id'], 'current_id' => $item_post['id']], ['task' => '']);
                }
                $sections_html = view($this->path_view_controller . 'pages/blog_post_single', [
                    'item_post'             => $item_post,
                    'items_pagination'      => $items_pagination,
                    'items_related_post'    => $items_related_post,
                ]);
                $page_seo = (!empty($item_post['page_seo'])) ? json_decode($item_post['page_seo'], true) : [];
                $view_data = [
                    'page_seo'              => $page_seo,
                    'sections_html'         => $sections_html,
                    'controller_name'       => $this->controller_name,
                    'path_view_controller'  => $this->path_view_controller,
                ];
                return view($this->path_view_controller . 'landing_page', $view_data);
            }
        } 
        show_404_page();
    }

    public function category($url_slug = null)
    {
        $category_name = 'Category name';
        if ($url_slug === null) { 
            return redirect()->to('/'); 
        };
        $blog_data = $this->get_blog_content('category-index', $url_slug);
        if (!empty($blog_data['items_post'])) {
            $items_post = $blog_data['items_post'];
            $category_names = array_column($items_post, 'category_name');
            $unique_category_names = array_unique($category_names);
            $category_name = reset($unique_category_names);
            $view_data = [
                'page_seo'                  => [],
                'category_name'             => $category_name,
                'sections_html'             => $blog_data['content'],
                'controller_name'           => $this->controller_name,
                'path_view_controller'      => $this->path_view_controller,
            ];
            return view($this->path_view_controller . 'blog_category_page', $view_data);
        }

        show_404_page();
    }

    public function load_more_post($url_slug = '')
    {
        if (is_ajax_get_request()) {
            $limit = $this->item_limit_per_page; 
            $page = get('page') ?: 1; 
            $offset = ($page - 1) * $limit;
            $url_slug = sanitize_input($url_slug);
            $params = [
                'language_info' => $this->language_info, 
                'url_slug' => $url_slug,
                'limit' => $offset, 
                'offset' => $offset,
            ];
            if (!empty($url_slug)) {
                $items_post    = $this->model->get_items_post_by_category($params, []);
                $total_items_post = $this->model->total_items_post_by_category($params, []);
            } else {
                $items_post    =  $this->model->get_blog_items($params, []);
                $total_items_post  = db_fetch('id', TB_BLOG_POSTS, ['status' => 1]);
            }
            $total_pages = ceil(count($total_items_post) / $limit);
            if ($items_post) {
                $posts_content = view($this->path_view_controller . 'pages/blog/item_list', [
                    'items_post'            => $items_post,
                ]);
                return json_response([
                    'status'        => 'success',
                    'has_more'      => $page < $total_pages,  
                    'html_update'   => [
                            'action_type' => 'append',
                            'html_content' => $posts_content,
                            'target_selector' => '#posts-content',
                        ],  
                    ]);
            } else {
                return json_response([
                    'status' => 'error',
                    'message' => 'No reviews available.', 
                ]);
            }
        }
    }
    
}
