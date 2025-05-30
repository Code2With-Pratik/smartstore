<?php
namespace App\Controllers\Public;

use App\Models\Public\ClientModel as MainModel;
use App\Models\Public\BlogModel;
use App\Requests\Public\ClientRequest as MainRequest;

class PageController extends MyPublicController
{
    protected $page_type;
    protected $path_view_sections;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'themes/regular/';
        $this->path_view_sections   = 'themes/regular/sections/';
        $this->controller_name      = 'home';
        $this->model                = new MainModel();
        $this->main_request         = new MainRequest();
        $this->load_files           = [];
        $this->page_title           = [
            'right' => ['type' => '', 'action' => ''],
        ];
        $this->page_type    = 'default';
    }

    public function index()
    {   
        $this->page_type = 'home_page';
        $item_page = $this->model->get_item_home_page(['language_info' => $this->language_info], ['task' => $this->page_type]);
        $sections_html = null;
        if (empty($item_page)) {
            return 'HOme page index';
        } else {
            return $this->render_page($item_page, 'home_page');
        }

    }

    public function display_page($url_slug = null)
    {
        if ($url_slug === null) { 
            return redirect()->to('/'); 
        };
        $sections_html = null;

        // For Basic Page
        $item_basic_page = $this->model->get_item_basic_page(['language_info' => $this->language_info, 'url_slug' => sanitize_input($url_slug)], ['task' => '']);
        if (!empty($item_basic_page)) {
            if (isset($item_basic_page['redirect']) && $item_basic_page['redirect'] && isset($item_basic_page['redirect_url'])) {
                return redirect()->to($item_basic_page['redirect_url']);
            }
            if (!empty($item_basic_page['data'])) {
                return $this->render_page($item_basic_page['data'], '');
            }
        }
        // For category Page
        $item_category_page = $this->model->get_item_category_page(['language_info' => $this->language_info, 'url_slug' => sanitize_input($url_slug)], ['task' => '']);
        if (!empty($item_category_page)) {
            if (isset($item_category_page['redirect']) && $item_category_page['redirect'] && isset($item_category_page['redirect_url'])) {
                return redirect()->to($item_category_page['redirect_url']);
            }
            if (!empty($item_category_page['data'])) {
                return $this->render_page($item_category_page['data'], 'category_page');
            }
        }
        show_404_page();
    }

    private function render_page($item_page, $task = 'default')
    {
        $sections_html = null;
        if (!empty($item_page)) {
            $sections_layout = (!empty($item_page['sections_layout'])) ? json_decode($item_page['sections_layout'], true) : '';
            if (empty($sections_layout)) {
                echo "";
            } else {
                foreach ($sections_layout as $key => $section) {
                    $section_data_view = [
                        'section_fields' => $section['fields'] ?? [], 
                        'section_type' => $section['section_type'] ?? '',
                    ];
                    // Reviews section
                    if ($section['section_type'] == 'reviews_section') {
                        $total_reviews = db_fetch('id', TB_REVIEWS, ['status' => 1]);
                        $section_data_view['items_reviews'] = db_fetch('ids, name, email, rating, status, comment', TB_REVIEWS, ['status' => 1], 'id', 'DESC', 0, $this->reviews_limit_per_page);
                        $section_data_view['total_reviews_count_by_rating'] = $this->model->get_total_reviews_count_by_rating();
                        $section_data_view['has_more_reviews'] = (count($total_reviews) > $this->reviews_limit_per_page) ? true : false;
                    }
    
                    // Packages section
                    if ($section['section_type'] == 'packages_section') {
                        $section_data_view['items_social_network_with_category'] = [];
                        $section_data_view['items_service_by_category'] = [];
                        if ($task == 'home_page') {
                            $section_data_view['items_social_network_with_category'] = $this->model->get_social_networks_with_categories();
                        }
                        if ($task == 'category_page') {
                            $section_data_view['items_service_by_category'] = db_fetch('id, ids, name, quantity, discount_value, tab_name, is_tab_name, tab_name_background, original_price, price', TB_SERVICES, ['status' => 1, 'cate_id' => $item_page['id']], 'SORT', 'ASC');
                        }
                        $section_data_view['display_on_page'] = $task;
                        $section_data_view['item_page'] = $item_page;
                    }
                    $sections_html .= view($this->path_view_sections . $section['section_type'], $section_data_view);
                }
            }
            $page_seo = (!empty($item_page['page_seo'])) ? json_decode($item_page['page_seo'], true) : [];

            if (isset($item_page['page_type']) && $item_page['page_type'] === 'blog') {
                $blog_data = $this->get_blog_content('blog-index');
                $sections_html .= $blog_data['content'];
            }
            
            $view_data = [
                'page_seo'              => $page_seo,
                'sections_html'         => $sections_html,
                'controller_name'       => $this->controller_name,
                'path_view_controller'  => $this->path_view_controller,
            ];
            return view($this->path_view_controller . 'landing_page', $view_data);
        }
    }
    
}
