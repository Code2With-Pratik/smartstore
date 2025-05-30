<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class StatisticsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_ORDERS;

        $this->field_search_accepted = '';
        $this->allowedFields         = ['name', 'value'];
        $this->useTimestamps    = false;
    }

    public function header_statistics()
    {
        $total_users                = $this->count_results('id', $this->tb_users, ['status' => 1]);
        $total_transactions         = $this->sum_results('amount', $this->tb_transactions, ['status' => 1]);
        $total_orders               = $this->count_results('id', $this->tb_orders);
        $total_providers_balance    = $this->sum_results('balance', $this->tb_providers, ['status' => 1]);

        $result = [
            'users' => [
                'name'    =>  'Total Clients',
                'value'   =>  $total_users,
                'class'   =>  'bg-success-gradient',
                'icon'    =>  'fe  fe-users'],
            'transactions' => [
                'name'    => 'Total payment received', 
                'value'   => format_price_with_currency($total_transactions),
                'class'   => 'bg-info-gradient',
                'icon'    => 'fe fe-dollar-sign'],
            'orders' => [
                'name'    => 'Total  Orders',
                'value'   => $total_orders,
                'class'   => 'bg-warning-gradient',
                'icon'    => 'fe fe-shopping-cart'],
            'providers_balance' => [
                'name'    => "Total  Provider' Balance",
                'value'   => format_price_with_currency($total_providers_balance),
                'class'   =>  'bg-success-gradient',
                'icon'    => 'icon-fa fa fa-money'],
        ];
        return $result;
    }

    public function order_chart_spline()
    {
        $result = $this->replace_data_language($this->data_chart_spline());
        return $result;
    }

    /*----------  Get array data_chart_spline  ----------*/
    private function data_chart_spline($params = null, $option = null)
    {
        $this->chart_spline_limit_days = 7;
        $orders_status = array_keys($this->order_status_tmpl());
        $params = [
            'select'   		=> 'status, count(id) as total, DATE(changed) as datetime',
            'group_by' 		=> ['status', 'DATE(changed)'],
            'data_type'     => 'object',
            'where'         => ['changed >' => date('Y-m-d', strtotime('-' . $this->chart_spline_limit_days . ' days'))],
        ];
        $data_for_analytic = $this->data_for_analytic( $params, ['task' => 'chart-spline'] );
        $data_time = [];
        //Create data format
        for ($i = $this->chart_spline_limit_days; $i >= 1 ; $i--) { 
            $data_time[date('Y-m-d', strtotime(NOW) - 86400 * ($i - 1)) ] = 0;
        }
        $default_data_format = [];
        foreach ($orders_status as $value) {
            $default_data_format[$value] = $data_time;
        }
        if($data_for_analytic){
            foreach ($data_for_analytic  as $key => $row) {
                if( isset($default_data_format[ $row->status ]) && isset( $default_data_format[$row->status][$row->datetime] ) ){
                    $default_data_format[$row->status][$row->datetime] = $row->total;
                }
            }

        };
        $data_orders_chart_spline = [
            'time' => array_keys($data_time),
        ];
        foreach($default_data_format  as $key => $row){
            $data_orders_chart_spline[$key] = array_values($row);
        }
        return json_encode($data_orders_chart_spline);
    }

    private function data_for_analytic($params = null, $option = null)
    {
        // Get the table from the $this->table property if it's defined
        $builder = $this->db->table($this->table);

        // Select columns as defined in $params
        $builder->select($params['select']);

        // Handle the conditions based on the task in $option
        if (isset($option['task'])) {
            if ($option['task'] === 'chart-spline' || $option['task'] === 'chart-spline-total-orders') {
                if (!empty($params['where'])) {
                    $builder->where($params['where']);
                }
            }

            if ($option['task'] === 'profit-last-days') {
                if (!empty($params['where'])) {
                    $builder->where($params['where']);
                }
                $builder->whereIn('status', ['completed', 'partial']);
            }
        }

        // Apply group by
        if (!empty($params['group_by'])) {
            $builder->groupBy($params['group_by']);
        }

        // Execute the query
        $query = $builder->get();

        // Return the results as either an array or an object based on $params['data_type']
        if ($params['data_type'] === 'array') {
            return $query->getResultArray();
        } else {
            return $query->getResult();
        }
    }

    private function replace_data_language($string){
        $data_new_lang = $this->order_status_tmpl();
        foreach ($data_new_lang as $key => $value) {
            $string 	= str_replace($key, $value, $string);
        }
        return $string;
    }

    private function order_status_tmpl() {
        $result = [
            "completed" 	=> 'Completed',
            "awaiting" 		=> 'Awaiting',
            "partial" 		=> 'Partial',
            "inprogress" 	=> 'In progress',
            "pending" 		=> 'Pending',
            "processing" 	=> 'Processing',
            "canceled" 		=> 'Canceled',
        ];
        return $result;
    }

    public function get_top_clients_by_orders($params = [])
    {
        $builder = $this->db->table($this->tb_users);
        $builder->select('id, ids, first_name, last_name, email, total_orders, total_spent, timezone, history_ip, description, status, created');
        $builder->where('total_orders >', 0);
        $builder->orderBy('total_orders', 'DESC');
        $builder->limit($params['limit'], 0);
        $result = $builder->get()->getResultArray();
        return $result;
    }

    public function get_recent_clients($params = [])
    {
        $builder = $this->db->table($this->tb_users);
        $builder->select('id, ids, first_name, last_name, email, total_orders, total_spent, timezone, history_ip, description, status, created');
        $builder->where('total_orders >', 0);
        $builder->orderBy('created', 'DESC');
        $builder->limit($params['limit'], 0);
        $result = $builder->get()->getResultArray();
        return $result;
    }

}
