<?php
namespace App\Models\Public;
use App\Models\Public\MyPublicModel;

class CronModel extends MyPublicModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_ORDERS;
        $this->main_builder    = $this->db->table($this->table);
        $this->allowedFields   = ['ids', 'name', 'status', 'sort', 'url_slug', 'lang_name']; 

    }
    
    public function list_items($params = null, $option = null) 
    {
        $result = null;

        // Send Order
        if ($option['task'] == 'list-items-new-order') {
            $statuses = ['active', 'pending', 'inprogress'];
            $builder = $this->db->table($this->table); 
            $builder->select("*");
            $builder->whereIn('status', $statuses);
            $builder->where("api_provider_id >", 0);
            $builder->where("api_order_id =", -1);
            $builder->orderBy("id", 'ASC');
            $builder->limit(5, 0);
            $query = $builder->get();
            $result = $query->getResultArray(); 
        }

        // Status
        if ($option['task'] == 'list-items-status') {
            $builder = $this->db->table($this->table .' o');
            $builder->select('o.id, o.client_order_id, o.status, o.service_id, o.service_type, o.api_provider_id, o.api_service_id, o.api_order_id, o.start_counter, o.remains');
            $builder->select('o.charge, o.formal_charge, o.profit, o.api_charge, o.quantity');
            $builder->select('api.url as api_url, api.key as api_key, api.type as api_type');
            $builder->join($this->tb_providers . ' api', 'o.api_provider_id = api.id', 'left');
            $builder->whereIn('o.status', ['active', 'processing', 'inprogress', 'pending']);
            $builder->where('o.api_order_id >', 0);
            $builder->where("o.api_provider_id >", 0);
            $builder->where('o.changed <', NOW);
            //$builder->orderBy('o.id', 'ASC');
            $builder->limit($params['limit'], $params['start']);
            $query = $builder->get();
            $result = $query->getResultArray();
        }

        // Statuses
        if ($option['task'] == 'list-items-statuses') {
            $builder = $this->db->table($this->table);
            $builder->select('id, client_order_id, status, service_id, service_type, api_provider_id');
            $builder->select('api_service_id, api_service_id, api_order_id, charge, formal_charge, profit, api_charge, quantity, start_counter, remains');
            $builder->whereIn('status', ['active', 'processing', 'inprogress', 'pending']);
            $builder->where('api_order_id >', 0);
            $builder->where("api_provider_id >", 0);
            $builder->where('changed <', NOW);
            $builder->orderBy('id', 'ASC');
            $builder->limit($params['limit'], $params['start']);
            $query = $builder->get();
            $result = $query->getResultArray();
        }

        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        // New Order
        if ($option['task'] == 'item-new-update') {
            $order_log = "Order ID - ". $params['order_id'];
            $data_item = [
                "last_check" => NOW,
                "changed"    => NOW
            ];
            if (!$params['response']) {
                $data_item['status'] = 'error';
                $data_item['note'] = 'Troubleshooting API requests';
                db_update($this->table, $data_item, ["id" => $params['order_id']]);
            }
            if (isset($params['response']['error'])) {
                $order_log .= " : ". $params['response']['error'];
                $data_item['status'] = 'error';
                $data_item['note'] = $params['response']['error'];
                $data_item['order_details'] = json_encode($params['response']);
                db_update($this->table, $data_item, ["id" => $params['order_id']]);
            }
            if (isset($params['response']['order'])) {
                $data_item['api_order_id'] = $params['response']['order'];
                $data_item['order_details'] = json_encode($params['response']);
                $data_item['note'] = '';
                db_update($this->table, $data_item, ["id" => $params['order_id']]);
            }
            //Write Log
            log_message('info', $order_log); 
            echo $order_log . '<br>'; 
        }

        // Order Status
        if ($option['task'] == 'item-update-status') {
            $item = $params['item'];
            $response   = $params['response'];
            $order_log =  "Order ID - ". $item['id'];
            $data_item = $this->prepare_item_update_status($item, $response);
            if (!empty($data_item)) {
                db_update($this->table, $data_item, ["id" => $item['id']]);
            }
            echo $order_log . '<br>';
        }
    }

    public function save_items($params = null, $option = null)
    {
        // Batch update statuses
        if ($option['task'] == 'items-batch-update-statuses') {
            $items      = $params['items'];
            $response   = $params['response'];
            $exist_items = [];
            $data_items_batch_update = [];
            foreach ($items as $key => $item) {
                if (isset($response[$item['api_order_id']]) && !in_array($item['api_order_id'], $exist_items)) {
                    $exist_items[] = $item['api_order_id'];
                    $data_items_batch_update[] = $this->prepare_item_update_status($item, $response[$item['api_order_id']]);
                }
            }
            if (!empty($data_items_batch_update)) {
                $this->db->transStart();
                try {
                    $builder = $this->db->table($this->table);
                    $builder->updateBatch($data_items_batch_update, 'id');
                    $this->db->transCommit();
                    $result = [
                        'status'  => 'success',
                        'message' => 'Batch update completed successfully.'
                    ];
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $result = [
                        'status'  => 'error',
                        'message' => $e->getMessage(),
                    ]; 
                }
                return $result;
            }
        }

        // Order Statuses by ids
        if ($option['task'] == 'items-update-statuses-by-ids') {
            $response = $params['response'];
            $order_log = "";
            $rand_time = get_random_time();
            $data_item = [
                'last_check'  => NOW,
                "changed"     => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
            ];

            // For API not found: not_found
            if (isset($response['error_type']) && $response['error_type'] == 'not_found' && isset($params['response']['error'])) {
                $order_log = "ID: " . implode(", ", $params['order_ids']) . " - ". $response['error'];
                $data_item['status'] = 'error';
                $data_item['note'] = $response['error'];
            }

            $builder = $this->db->table($this->table);
            $builder->whereIn('id', $params['order_ids']);
            $builder->update($data_item);

            log_message('error', $order_log);
            echo $order_log . '<br>';
        }

    }
    
    private function prepare_item_update_status($item_old = [], $response_item = [])
    {
        $rand_time      = get_random_time();
        $data_item = [
            'id'            => $item_old['id'],
            'status'        => $item_old['status'],
            'start_counter' => $item_old['start_counter'],
            'remains'       => $item_old['remains'],
            'order_details' => json_encode($response_item),
            'api_charge'    => $item_old['api_charge'],
            'charge'        => $item_old['charge'],
            'formal_charge' => $item_old['formal_charge'],
            'profit'        => $item_old['profit'],
            'note'          => '',
            'last_check'    => NOW,
            'changed'       => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
        ];

        if (isset($response_item['status'])) {
            $data_item['status']        = order_status_format($response_item['status']);
            $data_item['formal_charge'] = $response_item['charge'] ?? 0;
            $data_item['api_charge']    = $response_item['charge'] ?? 0;
            $data_item['start_counter'] = $response_item['start_count'] ?? 0;
            $data_item['remains']       = order_remains_format($response_item['remains']);

            if (isset($response_item['charge'])) {
                $data_item['profit']   = $item_old['charge'] - (double)$response_item['charge'];
            }

            // Cancelled, partial
            if (in_array($data_item['status'], ['partial', 'canceled', 'refunded'])) {
                if ($response_item['remains'] > $item_old['quantity']) { 
                    $data_item['remains'] = $item_old['quantity']; 
                }
                $new_order_attr = calculate_order_by_status($item_old, ['status' => $data_item['status'], 'remains' => $response_item['remains'], 'api_charge' => $response_item['charge']]);
                $data_item['charge']        = $new_order_attr['real_charge'];
                $data_item['profit']        = $new_order_attr['profit'];
            }
        } else {
            $data_item['status']        = 'error';
            $data_item['note']          = $response_item['error'] ?? 'Unable to connect to the provider';
        }
        return $data_item;
    }
}