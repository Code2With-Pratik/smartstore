<?php
namespace App\Models\Public;
use App\Models\Public\MyPublicModel;

class BlogModel extends MyPublicModel
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table            = TB_BLOG_CATEGORIES;
        $this->main_builder     = $this->db->table($this->table);
        $this->allowedFields    = ['ids', 'name', 'status', 'sort', 'url_slug', 'lang_name']; 
    }

    // Blog Index
    public function get_blog_items($params = [], $options = []) {
        $language_info = $params['language_info'];
        $builder = $this->db->table($this->tb_blog_posts . ' bp')
                        ->select('bp.id, bp.ids, bp.image, bp.released')
                        ->select('bpl.page_seo, bpl.name, bpl.content, bpl.url_slug, bpl.options')
                        ->join($this->tb_blog_posts_lang . ' bpl', 'bpl.post_id = bp.id');
        // Where
        $builder->where('bp.released <=', NOW);
        $builder->where('bp.status', 1);
        $builder->where('bpl.lang_code', $language_info['current_language']);
        $builder->orderBy('bp.released', 'DESC');
        if (isset($params['limit']) && isset($params['offset']) && $params['limit'] > 0) {
            $builder->limit($params['limit'], $params['offset']);
        }
        $result = $builder->get()->getResultArray();
        return $result; 
    }
    
    // Blog Category
    public function get_items_post_by_category($params = [], $options = []) 
    {
        $language_info = $params['language_info'];
        $builder = $this->db->table($this->tb_blog_categories . ' bc')
                            ->select('bc.name as category_name, bp.id, bp.image, bp.cate_id as post_category_id, bp.released')
                            ->select('bpl.page_seo, bpl.name, bpl.content, bpl.url_slug, bpl.options')
                            ->join($this->tb_blog_posts .' bp', 'bc.id = bp.cate_id', 'left')
                            ->join($this->tb_blog_posts_lang . ' bpl', 'bpl.post_id = bp.id AND bpl.lang_code = "' . $language_info['current_language'] . '"', 'left');
        $builder->where('bc.status', 1); 
        $builder->where('bc.url_slug', $params['url_slug']); 
        $builder->where('bp.status', 1); 
        $builder->where('bp.released <=', NOW);
        $builder->orderBy('bp.released', 'DESC'); 
        if (isset($params['limit']) && isset($params['offset']) && $params['limit'] > 0) {
            $builder->limit($params['limit'], $params['offset']);
        }
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }
    // Total items for loadmore  Button
    public function total_items_post_by_category($params = [], $options = []) 
    {
        $language_info = $params['language_info'];
        $builder = $this->db->table($this->tb_blog_categories . ' bc')
                            ->select('bp.id')
                            ->join($this->tb_blog_posts .' bp', 'bc.id = bp.cate_id', 'left');
        $builder->where('bc.status', 1); 
        $builder->where('bc.url_slug', $params['url_slug']); 
        $builder->where('bp.status', 1); 
        $builder->where('bp.released <=', NOW);
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }
    
    // Post Single
    public function get_item_post_single($params = [], $options = []) 
    {
        $language_info = $params['language_info'];
        
        if ($language_info['previous_language'] != $language_info['current_language']) {
            $item_lang_old = db_get('post_id, url_slug', $this->tb_blog_posts_lang, ['url_slug' => $params['url_slug'], 'lang_code' => $language_info['previous_language']]);
            if ($item_lang_old) {
                $item_lang_new = db_get('post_id, lang_code, url_slug', $this->tb_blog_posts_lang, ['post_id' => $item_lang_old['post_id'], 'lang_code' => $language_info['current_language']]); 
                if (!empty($item_lang_new)) {
                    $slug = $language_info['current_language'] . '/blog/' . $item_lang_new['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                } else {
                    $slug = $language_info['current_language'] . '/blog/' . $item_lang_old['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                }
            }
            return null;
        } else {
            
            $builder = $this->db->table($this->tb_blog_posts . ' bp')
                            ->select('bc.name as blog_category_name, bc.url_slug as blog_category_url_slug')
                            ->select('bp.id, bp.cate_id, bp.image, bp.released')
                            ->select('bpl.page_seo, bpl.name, bpl.content, bpl.options')
                            ->join($this->tb_blog_posts_lang . ' bpl', 'bpl.post_id = bp.id')
                            ->join($this->tb_blog_categories . ' bc', 'bc.id = bp.cate_id');
            // Where
            $builder->where('bpl.url_slug', $params['url_slug']);
            $builder->where('bp.status', 1);
            $builder->where('bpl.lang_code', $language_info['current_language']);
            $result = $builder->get()->getRowArray();
            return [
                'redirect'      => false,
                'data'          => $result,
            ];
        }    
    }

    // Related item Post
    public function get_items_related_post($params = [], $options = []) 
    {
        $current_id = $params['current_id'];
        $language_info = $params['language_info'];
        $category_id = $params['cate_id'];
        $lang_code = $language_info['current_language'];
        
        $builder =  $this->db->table($this->tb_blog_posts . ' bp')
                            ->select('bp.image, bp.released, bpl.name, bpl.url_slug')
                            ->join($this->tb_blog_posts_lang . ' bpl', 'bpl.post_id = bp.id')
                            ->where('bp.id !=', $current_id)
                            ->where('bp.cate_id', $category_id)
                            ->where('bp.status', 1)
                            ->where('bpl.lang_code', $lang_code)
                            ->orderBy('bp.released', 'DESC')
                            ->limit(5)
                            ->get();
        $result = $builder->getResultArray();
        return $result;
    }

    // Items for pagination
    public function get_items_pagination($params = [], $options = []) 
    {
        $current_id = $params['current_id'];
        $language_info = $params['language_info'];
        $category_id = $params['cate_id'];
        $lang_code = $language_info['current_language'];
        $get_item = function($id_condition, $order_by) use ($category_id, $lang_code, $current_id) {
            return $this->db->table($this->tb_blog_posts . ' bp')
                            ->select('bp.image, bpl.name, bpl.url_slug')
                            ->join($this->tb_blog_posts_lang . ' bpl', 'bpl.post_id = bp.id')
                            ->where('bp.id ' . $id_condition, $current_id)
                            ->where('bp.cate_id', $category_id)
                            ->where('bp.status', 1)
                            ->where('bpl.lang_code', $lang_code)
                            ->orderBy('bp.id', $order_by)
                            ->limit(1)
                            ->get()
                            ->getRowArray();
        };
        $result = [
            'item_prev'  => $get_item('<', 'DESC'),
            'item_next'  => $get_item('>', 'ASC'),
        ];
        return $result;
    }

    // Post categories
    public function get_post_count_by_category($params = [], $options = []) {
        $language_info = $params['language_info'];
        $builder = $this->db->table($this->tb_blog_categories . ' bc');
        $builder->select('bc.name, bc.url_slug, COUNT(bp.id) as post_count');
        $builder->join($this->tb_blog_posts .' bp', 'bc.id = bp.cate_id', 'left');
        $builder->where('bp.status', 1); 
        $builder->where('bp.released <=', NOW); 
        $builder->groupBy('bc.id');
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }
}
