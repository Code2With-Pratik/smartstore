<?php
namespace App\Models;
use CodeIgniter\Model;

use Exception;
use CodeIgniter\I18n\Time;

class MyModel extends Model
{
    // Default
    protected $table;
    protected $table_lang; //relate to main table
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'created';
    protected $updatedField     = 'changed';
    protected $allowedFields    = [];
    
    
    // option
    protected $crud_restricted_fields = ['id', 'token', 'editor'];
    protected $filter_accepted;
    protected $main_builder;


    protected $tb_users             =  TB_USERS;
    protected $tb_subscribers       =  TB_SUBSCRIBERS;
    protected $tb_tickets           =  TB_TICKETS;
    protected $tb_orders            =  TB_ORDERS;
    protected $tb_transactions      =  TB_TRANSACTION_LOGS;
    protected $tb_payments          =  TB_PAYMENTS_METHOD;
    protected $tb_services          =  TB_SERVICES;
    protected $tb_categories        =  TB_CATEGORIES;
    protected $tb_categories_lang   =  TB_CATEGORIES_LANG;
    
    protected $tb_pages             =  TB_PAGES;
    protected $tb_pages_lang        =  TB_PAGES_LANG;
    
    protected $tb_providers         =  TB_API_PROVIDERS;
    protected $tb_social_network    =  TB_SOCIAL_NETWORK_CATEGORIES;
    
    protected $tb_language_list     =  TB_LANGUAGE_LIST;
    protected $tb_blog_categories   =  TB_BLOG_CATEGORIES;
    protected $tb_blog_posts        =  TB_BLOG_POSTS;
    protected $tb_blog_posts_lang   =  TB_BLOG_POSTS_LANG;
    
    protected $tb_menu              =  TB_MENU;
    protected $tb_email_templates   =  TB_EMAIL_TEMPLATES;
    protected $tb_reviews           =  TB_REVIEWS;
    protected $tb_coupons           =  TB_COUPONS;


    // Blacklist
    protected $tb_blacklist_ip      =  TB_BLACKLIST_IP;
    protected $tb_blacklist_link    =  TB_BLACKLIST_LINK;
    protected $tb_blacklist_email   =  TB_BLACKLIST_EMAIL;



    /**
     * Fetch data from the specified table with optional filters and pagination.
     *
     * @param string $select Columns to select. Defaults to '*'.
     * @param string $table Table name from which to fetch data.
     * @param string $where Optional WHERE clause for filtering results.
     * @param string $order Column to order by.
     * @param string $by Order direction, 'ASC' or 'DESC'. Defaults to 'DESC'.
     * @param int $start Offset for pagination. Defaults to -1 (no offset).
     * @param int $limit Number of records to fetch. Defaults to 0 (no limit).
     * @param bool $return_array Whether to return results as an array. Defaults to false.
     * @return array|object Returns results as an array or object based on $return_array.
     */
    protected function fetch_records($select = '*', $table = '', $where = [], $order = '', $by = 'DESC', $start = -1, $limit = 0, $return_array = true)
    {
        try {
            $builder = $this->db->table($table);
            $builder->select($select);

            if (!empty($where)) {
                $builder->where($where);
            }

            if ($order && in_array(strtoupper($by), ['DESC', 'ASC'])) {
                $builder->orderBy($order, strtoupper($by));
            }

            if ((int)$start >= 0 && (int)$limit > 0) {
                $builder->limit($limit, $start);
            }
            $query = $builder->get();
            if ($return_array) {
                return $query->getResultArray();
            } else {
                return $query->getResult();
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieve a single row of data from the specified table with optional filters and sorting.
     *
     * @param string $select Columns to select. Defaults to '*'.
     * @param string $table Table name from which to fetch data.
     * @param string $where Optional WHERE clause for filtering results.
     * @param string $order Column to order by.
     * @param string $by Order direction, 'ASC' or 'DESC'. Defaults to 'DESC'.
     * @param bool $return_array Whether to return result as an array. Defaults to false.
     * @return array|object Returns a single row as an array or object based on $return_array.
     */
    protected function get_record($select = '*', $table = '', $where = [], $return_array = true)
    {
        try {
            if (!$table) {
                $table = $this->mainTable;
            }
            $builder = $this->db->table($table);
            $builder->select($select);

            if (!empty($where)) {
                $builder->where($where);
            }
            $query = $builder->get();
            if ($return_array) {
                return $query->getRowArray();
            } else {
                return $query->getRow();
            }
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * Insert a new record.
     *
     * @param array $data
     * @return bool
     */
    protected function insert_record($data = [])
    {
        try {
            if (!$table) {
                $table = $this->mainTable;
            }
            $builder = $this->db->table($table);
            $builder->insert($data);
            
            if ($this->db->affectedRows() > 0) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * Update existing records.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    protected function update_record_by_id($table = '', $id = '', $data = [])
    {
        try {
            if (!$table) {
                $table = $this->mainTable;
            }
            $builder = $this->db->table($table);
            $builder->where($this->primaryKey, $id);
            return $builder->update($data);
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());
            return false;
        }
    }

     /**
     * Update records with complex conditions.
     *
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    protected function update_record($data, $conditions = [])
    {
        try {
            if (!$table) {
                $table = $this->mainTable;
            }
            $builder = $this->db->table($table);
            foreach ($conditions as $field => $condition) {
                if (is_array($condition)) {
                    foreach ($condition as $operator => $value) {
                        $builder->where("$field $operator", $value);
                    }
                } else {
                    $builder->where($field, $condition);
                }
            }
            return $builder->update($data);
        } catch (Exception $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());
            return false;
        }
    }

    
    public function pr_sql($type = 0)
    {
        pr($this->getLastQuery()->getQuery(), $type);
    }

    /**
     * @param string $select_sum
     * @param string $table
     * @param string|null $where
     * @return int
     */
    public function sum_results($select_sum, $table, $where = null)
    {
        $builder = $this->db->table($table);

        if ($where !== null) {
            $builder->where($where);
        }

        $builder->selectSum($select_sum);
        $query = $builder->get();
        $result = $query->getRow();

        if ($result && $result->$select_sum > 0) {
            return $result->$select_sum;
        } else {
            return 0;
        }
    }

    /**
     * @param string $select_field
     * @param string $table
     * @param string|null $where
     * @return int
     */
    public function count_results($select_field, $table, $where = null)
    {
        $builder = $this->db->table($table);

        if ($where !== null) {
            $builder->where($where);
        }

        $builder->select($select_field);
        $query = $builder->get();

        return $query->getNumRows();
    }
}