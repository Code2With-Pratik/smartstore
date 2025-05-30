<?php
namespace App\Models\Public;
use App\Models\Public\MyPublicModel;

class OrderModel extends MyPublicModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table  = TB_SERVICES;
        $this->main_builder    = $this->db->table($this->table);
        $this->allowedFields   = ['ids', 'name', 'status', 'sort', 'url_slug', 'lang_name']; 
    }

    public function created_order_and_transaction($data_order = [], $data_tnx = []) {

        $response = [];
        // Get Client ID
        $client_id = $this->get_client_id($data_tnx);
        if (empty($client_id)) {
            return $response = [
                'status' => 'error',
                'message' => 'There was an issue creating your order. Please try again',
            ];
        }
        // Insert Order
        $order_id = $this->create_order($data_order, $data_tnx, $client_id);
        if (empty($order_id)) {
            return $response = [
                'status' => 'error',
                'message' => 'There was an issue creating your order. Please try again',
            ];
        }
        // insert transaction
        $transaction_id = $this->create_transaction($data_tnx, $order_id, $client_id);
        if (empty($transaction_id)) {
            return $response = [
                'status' => 'error',
                'message' => 'There was an issue creating your order. Please try again',
            ];
        }
        return $response = [
            'status' => 'success',
            'result' => [
                'order_id' => $order_id,
                'transaction_id' => $transaction_id,
            ],
        ];
    }

    public function update_transaction_and_order($item_transaction = [], $verify_tnx_data = []) {
        $verify_tnx_status = $verify_tnx_data['status'];
        $result = [
            'tnx_status' => 'pending',
            'is_thank_you' => false,
        ];
        $item_tnx_status = 0;
        if (in_array($verify_tnx_status, [TNX_STATUS_PAID, TNX_STATUS_CANCELLED, TNX_STATUS_PENDING])) {
            if ($verify_tnx_status == TNX_STATUS_PAID) {
                $item_tnx_status = 1;
                db_update($this->tb_orders, ['status' => 'pending', 'note' => ''], ['id' => $item_transaction['order_id']]);
                // send email;
                $result['is_thank_you_page'] = true;
                $result['tnx_status'] = TNX_STATUS_PAID;
            } else if ($verify_tnx_status == TNX_STATUS_CANCELLED) {
                $item_tnx_status = -1;
                $result['is_thank_you_page'] = false;
                $result['tnx_status'] = TNX_STATUS_CANCELLED;
            } else {
                $item_tnx_status = 0;
                $result['is_thank_you_page'] = false;
                $result['tnx_status'] = TNX_STATUS_PENDING;
            }
            $item_tnx_new_data = [
                'status' => $item_tnx_status, 
                'changed' => NOW, 
            ];
            // Update new transaction id 
            if (!empty($verify_tnx_data['update_new_tnx_id']) && !empty($verify_tnx_data['new_tnx_id'])) { 
                $item_tnx_new_data['transaction_id'] = $verify_tnx_data['new_tnx_id']; 
            } 
            // update data detail for transaction
            if (!empty($verify_tnx_data['data_details'])) { 
                $item_tnx_new_data['data'] = add_transaction_details($item_transaction['data'], $verify_tnx_data['data_details']);
            }
            db_update($this->tb_transactions, $item_tnx_new_data, ['id' => $item_transaction['id']]);
        } else {
            $result['is_thank_you_page'] = false;
        }
        return $result;
    }

    private function get_client_id($data_tnx = []) {
        $result = null;
        $item_user_id = null;
        $email = get_post('email');
        $first_name = get_post('first_name');
        $last_name = get_post('last_name');
        $ip_address         = service('request')->getIPAddress();
        $get_location_info  = json_encode(get_location_info_by_ip());

        // Subscriber
        $subscribe_to_newsletter = get_post('subscribe_to_newsletter');
        if ($subscribe_to_newsletter) {
            $data_item_subcriber = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'ip_address' => $ip_address,
                'get_location_info' => $get_location_info,
            ];
            $this->save_subscriber($data_item_subcriber);
        }
        // check user
        $item_exits_user = db_get('id, total_orders, total_spent, history_ip, email', $this->tb_users, ['email' => $email]);
        if (empty($item_exits_user)) {
            $item_db_user = [
                "ids"           => ids(),
                'email'         => $email,
                'total_orders'  => 1,
                'total_spent'   => $data_tnx['amount'],
                'history_ip'    => $ip_address,
                'options'       => $get_location_info,
                'last_order'    => NOW,
                'changed'       => NOW,
                'created'       => NOW,
            ];

            if (!empty($first_name)) $item_db_user['first_name'] = $first_name;
            if (!empty($last_name)) $item_db_user['last_name'] = $last_name;
            
            $result = db_insert($this->tb_users, $item_db_user);
            $item_user_id = $result;
        } else {
            $item_db_user = [
                'total_orders'  => $item_exits_user['total_orders'] + 1,
                'total_spent'   => $item_exits_user['total_spent'] + $data_tnx['amount'],
                'history_ip'    => $ip_address,
                'options'       => $get_location_info,
                'last_order'    => NOW,
                'changed'       => NOW,
            ];
            if (!empty($first_name)) $item_db_user['first_name'] = $first_name;
            if (!empty($last_name)) $item_db_user['last_name'] = $last_name;
            db_update($this->tb_users, $item_db_user, ['id' => $item_exits_user['id']]);
            $item_user_id = $item_exits_user['id'];
        }
        $result = $item_user_id;
        return $result;
    }

    private function save_subscriber($data_item_subcriber = [])
    {
        $email          = get_post('email');
        $item_exists    = db_get('id', $this->tb_subscribers, ['email' => $email]);
        if (empty($item_exists)) {
            $get_location_info = json_decode($data_item_subcriber['get_location_info'], true);
            $data_item = [
                "ids"           => ids(),
                'email'         => $email,
                'history_ip'    => $data_item_subcriber['ip_address'],
                'country'       => $get_location_info['data']['country'] ?? 'Unknow',
                'options'       => $data_item_subcriber['get_location_info'],
                'changed'       => NOW,
                'created'       => NOW,
            ];
            if (!empty($data_item_subcriber['first_name'])) $data_item['first_name'] = $data_item_subcriber['first_name'];
            if (!empty($data_item_subcriber['last_name'])) $data_item['last_name'] = $data_item_subcriber['last_name'];
            db_insert($this->tb_subscribers, $data_item);
            return true;
        }
        return false;
    }

    private function create_transaction($data_tnx = [], $order_id = '', $client_id = '') {
        // insert transaction
        $item_transaction = [
            'ids' => ids(),
            'uid' => $client_id,
            'order_id' => $order_id,
            'type' => $data_tnx['type'],
            'amount' => $data_tnx['amount'],
            'original_amount' => $data_tnx['original_amount'],
            'discount_value' => $data_tnx['discount_value'],
            'coupon_code' => $data_tnx['coupon_code'],
            'transaction_fee' => $data_tnx['tnx_fee'],
            'transaction_id' => $data_tnx['transaction_id'],
            'data' => (isset($data_tnx['data_details'])) ? add_transaction_details([], $data_tnx['data_details']) : '',
            'status' => $data_tnx['status'],
            'changed' => NOW,
            'created' => NOW,
        ];
        $transaction_id = db_insert($this->tb_transactions, $item_transaction);
        if (empty($transaction_id)) {
            return $response = [
                'status' => 'error',
                'message' => 'There was an issue creating your order. Please try again',
            ];
        } 
        return $transaction_id;
    }

    private function create_order($data_order = [], $data_tnx = [], $client_id = '') {
        $item_service = $data_order['item_service'];
        $formal_charge = $item_service['original_price'] * $item_service['quantity'] / 1000;
        $profit = $item_service['price'] - $formal_charge;
        $status = 'awaiting';
        $note = 'Awaiting payment confirmation';
        if ($data_tnx['status'] == 1) {
            $status = 'pending';
            $note = '';
        }
        $item_order = [
            'ids'               => ids(),
            'uid'               => $client_id,
            'client_order_id'   => generate_client_order_id(),
            'service_id'        => $item_service['id'],
            'type'              => 'direct',
            'service_type'      => 'default',
            'api_provider_id'   => $item_service['api_provider_id'],
            'api_service_id'    => $item_service['api_service_id'],
            'api_order_id'      => -1,
            'status'            => $status,
            'charge'            => $item_service['price'],
            'formal_charge'     => $formal_charge,
            'profit'            => $profit,
            'link'              => $item_service['link'],
            'quantity'          => $item_service['quantity'],
            'note'              => $note,
            'ip_address'        => service('request')->getIPAddress(),
            'changed'           => NOW,
            'created'           => NOW,
        ];
        $order_id = db_insert($this->tb_orders, $item_order);
        return $order_id;
    }

     /**
     * Track order and transaction by email and order ID
     *
     * @param string $email
     * @param string $order_id
     * @return object|null
     */
    public function track_order_by_email_and_orderid($email, $order_id)
    {
        $result = null;
        $builder = $this->db->table($this->tb_orders . ' o');
        $builder->select('s.name AS service_name');
        $builder->select('o.created AS order_created, o.ids AS order_ids, , o.client_order_id, o.quantity AS order_quantity, o.status AS order_status, o.link AS order_link, o.service_id AS order_service_id');
        $builder->select('t.id AS transaction_id,
            t.transaction_id AS transaction_reference,
            t.amount AS transaction_amount,
            t.status AS transaction_status
        ');
        $builder->join($this->tb_users . ' u', 'u.id = o.uid');
        $builder->join($this->tb_transactions . ' t', 't.order_id = o.id', 'left');
        $builder->join($this->tb_services . ' s', 'o.service_id = s.id', 'left');
        $builder->where('u.email', $email);
        $builder->where('o.client_order_id', $order_id);
        $query = $builder->get();
        $result  = $query->getRowArray();
        return $result;
    }

    // Get Item order detail for send notifications
    public function get_item_order_details($order_id = '')
    {
        $builder = $this->db->table($this->tb_orders . " o");
        $builder->select('o.id, o.ids, o.link, o.client_order_id, o.quantity, o.charge');
        $builder->select('u.email as customer_email, s.name as service_name');
        $builder->select('tl.amount, tl.original_amount');
        $builder->join($this->tb_services . " s", "s.id = o.service_id", 'left');
        $builder->join($this->tb_users . " u", "u.id = o.uid", 'left');
        $builder->join($this->tb_transactions . " tl", "o.id = tl.order_id", 'left');
        $builder->where('o.id', $order_id);
        $query = $builder->get();
        $result = $query->getRowArray();
        return $result;
    }

    public function check_blacklist()
    {
        // blacklist
        $blacklisted = false;
        $type = '';

        // blacklist_ip
        if ($this->db->tableExists($this->tb_blacklist_ip)) {
            $ip = service('request')->getIPAddress();
            $item_exists = $this->db->table($this->tb_blacklist_ip)
                                    ->where('ip', $ip)
                                    ->where('status', 1)
                                    ->get()
                                    ->getRowArray();
            if ($item_exists) {
                $blacklisted = true;
                $type = 'Blacklisted IP';
            }
        }

        // blacklist email
        if ($this->db->tableExists($this->tb_blacklist_email)) {
            $email = get_post('email');
            $item_exists = $this->db->table($this->tb_blacklist_email)
                                    ->where('email', $email)
                                    ->where('status', 1)
                                    ->get()
                                    ->getRowArray();
            if ($item_exists) {
                $blacklisted = true;
                $type = 'Blacklisted email';
            }
        }
        // blacklist_link
        if ($this->db->tableExists($this->tb_blacklist_link) && !$blacklisted) {
            $link = service('request')->getPost('link');
            $link = sanitize_input($link);
            if ($link) {
                $query = $this->db->table($this->tb_blacklist_link)
                                ->like('link', $link)
                                ->where('status', 1)
                                ->get();

                if ($query->getNumRows() > 0) {
                    $blacklisted = true;
                    $type = 'Blacklisted link';
                }
            }
        }

        if ($blacklisted) {
            return [
                'status' => true,
                'type' => $type,
            ];
        }
        return [
            'status' => false,
        ];;
    }

    public function get_required_field_name($params = [])
    {
        $result = __l('Link');
        $current_lang_code = current_locale();
        if (!empty($params['cate_id'])) {
            $item_lang = db_get('required_field', $this->tb_categories_lang, ['cate_id' => $params['cate_id'], 'lang_code' => current_locale()]);
            if ($item_lang) {
                $result = $item_lang['required_field'];
            }
        }
        return  $result;
    }

}
