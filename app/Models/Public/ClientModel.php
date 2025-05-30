<?php
namespace App\Models\Public;
use App\Models\Public\MyPublicModel;

class ClientModel extends MyPublicModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_BLOG_CATEGORIES;
        $this->main_builder    = $this->db->table($this->table);
        $this->allowedFields         = ['ids', 'name', 'status', 'sort', 'url_slug', 'lang_name']; 
    }
    // Home Page Index
    public function get_item_home_page($params = [], $options = []) {
        $builder = $this->db->table($this->tb_pages . ' pg')
                    ->select('pg.id, pg.ids, pg.page_type, pg.name')
                    ->select('pl.page_seo, pl.sections_layout, pl.options')
                    ->join($this->tb_pages_lang . ' pl', 'pl.page_id = pg.id');
        // Where
        $builder->where('pg.page_type', 'home_page');
        $builder->where('pl.lang_code', $params['language_info']['current_language']);
        $builder->where('pg.status', 1);
        $result = $builder->get()->getRowArray();
        return $result;
    }
    
    // Basic Page Index
    public function get_item_basic_page($params = [], $options = []) {
        $language_info = $params['language_info'];
        if ($language_info['previous_language'] != $language_info['current_language']) {
            $item_lang_old = db_get('page_id, url_slug', $this->tb_pages_lang, ['url_slug' => $params['url_slug'], 'lang_code' => $language_info['previous_language']]);
            if ($item_lang_old) {
                $item_lang_new = db_get('page_id, lang_code, url_slug', $this->tb_pages_lang, ['page_id' => $item_lang_old['page_id'], 'lang_code' => $language_info['current_language']]); 
                if (!empty($item_lang_new)) {
                    $slug = $language_info['current_language'] . '/' . $item_lang_new['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                } else {
                    $slug = $language_info['current_language'] . '/' . $item_lang_old['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                }
            }
            return null;
        } else {
            $builder = $this->db->table($this->tb_pages . ' pg')
                        ->select('pg.id, pg.ids, pg.page_type, pg.name')
                        ->select('pl.page_seo, pl.sections_layout, pl.options')
                        ->join($this->tb_pages_lang . ' pl', 'pl.page_id = pg.id');
            // Where
            $builder->where('pl.url_slug', $params['url_slug']);
            $builder->where('pl.lang_code', $language_info['current_language']);
            $builder->where('pg.status', 1);
            $result = $builder->get()->getRowArray();
            return [
                'redirect'      => false,
                'data'          => $result,
            ];
        }
    }

    // Category Index
    public function get_item_category_page($params = [], $options = []) {
        $language_info = $params['language_info'];
        if ($language_info['previous_language'] != $language_info['current_language']) {
            $item_lang_old = db_get('cate_id, url_slug', $this->tb_categories_lang, ['url_slug' => $params['url_slug'], 'lang_code' => $language_info['previous_language']]);
            if ($item_lang_old) {
                $item_lang_new = db_get('cate_id, lang_code, url_slug', $this->tb_categories_lang, ['cate_id' => $item_lang_old['cate_id'], 'lang_code' => $language_info['current_language']]); 
                if (!empty($item_lang_new)) {
                    $slug = $language_info['current_language'] . '/' . $item_lang_new['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                } else {
                    $slug = $language_info['current_language'] . '/' . $item_lang_old['url_slug'];
                    return [
                        'redirect'      => true,
                        'redirect_url'  => client_url($slug),
                    ];
                }
            }
            return null;
        } else {
            $builder = $this->db->table($this->tb_categories . ' cg')
                        ->select('cg.id, cg.ids, cg.name, cg.icon_class')
                        ->select('cl.page_seo, cl.unit_name, cl.sections_layout, cl.options')
                        ->join($this->tb_categories_lang . ' cl', 'cl.cate_id = cg.id');
            // Where
            $builder->where('cl.url_slug', $params['url_slug']);
            $builder->where('cg.status', 1);
            $builder->where('cl.lang_code', $language_info['current_language']);
            $result = $builder->get()->getRowArray();
            return [
                'redirect'      => false,
                'data'          => $result,
            ];
        }
        
    }
    
    public function get_social_networks_with_categories()
    {
        $current_locale = current_locale();
        // Build the query
        $builder = $this->db->table($this->tb_social_network . ' snc')
                    ->select('snc.id AS snc_id, snc.ids AS snc_ids, snc.name AS snc_name, snc.image AS snc_image, snc.sort AS snc_sort, snc.status AS snc_status')
                    ->select('c.id, c.ids, c.status, c.sort, c.icon_class')
                    ->select('cl.url_slug, cl.name')
                    ->join($this->tb_categories . ' c', 'snc.id = c.sncate_id')
                    ->join($this->tb_categories_lang . ' cl', 'c.id = cl.cate_id AND cl.lang_code = "' . $this->db->escapeString($current_locale) . '"', 'left');
        
        $builder->where('snc.status', 1);
        $builder->where('c.status', 1);
        $builder->orderBy('snc.sort, c.sort');
        $query = $builder->get();
        $results = $query->getResultArray();
        
        // Organize the data using array_reduce
        $social_networks = array_reduce($results, function($carry, $row) {
            $snc_id = $row['snc_id'];
            // Initialize social network if not already
            if (!isset($carry[$snc_id])) {
                $carry[$snc_id] = [
                    'id' => $snc_id,
                    'ids' => $row['snc_ids'],
                    'name' => $row['snc_name'],
                    'image' => $row['snc_image'],
                    'status' => $row['snc_status'],
                    'sort' => $row['snc_sort'],
                    'categories' => []
                ];
            }
            // Add category to the social network
            $carry[$snc_id]['categories'][] = $row;

            return $carry;
        }, []);

        return array_values($social_networks); 
    }


    public function get_total_reviews_count_by_rating() {
        $builder = $this->db->table($this->tb_reviews);
        $results = $builder->select('rating, COUNT(*) as total_reviews')
                           ->where('status', 1)  
                           ->groupBy('rating')  
                           ->orderBy('rating', 'ASC') 
                           ->get()
                           ->getResultArray();
        return $results;
    }


    public function get_language_by_code($lang_code) {
        $result = db_get('*', $this->tb_language_list, ['code' => sanitize_input($lang_code), 'status' => 1]);
        return $result;
    }
}