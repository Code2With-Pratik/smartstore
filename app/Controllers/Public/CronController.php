<?php
namespace App\Controllers\Public;

use App\Models\Public\CronModel as MainModel;

use App\Libraries\SmmApi;

class CronController extends MyPublicController
{
    private $provider;

    public function __construct()
    {
        parent::__construct();
        $this->controller_name      = 'cron';
        $this->model                = new MainModel();
        $this->cron_token();
        // Load provider
        $this->provider = new SmmApi();
    }
   
    public function order()
    {
        $lock = fopen('_lock_file_multiple_order.lock', 'w');
        if (!($lock && flock($lock, LOCK_EX | LOCK_NB)))
            die('Order already running');
        $items = $this->model->list_items('', ['task' => 'list-items-new-order']);
        if (!$items) {
            echo "There is no order at the present.<br>";
            exit();
        }
        foreach ($items as $key => $row) {
            $api = db_get('url, key, type, id', TB_API_PROVIDERS, ['id' => $row['api_provider_id']]);
            if (!$api) {
                $response = ['error' => "API Provider does not exists"];
                $this->model->save_item(['order_id' => $row['id'], 'response' => $response], ['task' => 'item-new-update']);
                continue;
            }
            $data_post = [
                'action' => 'add',
                'service' => $row['api_service_id'],
            ];
            switch ($row['service_type']) {
                case 'subscriptions':
                    $data_post["username"] = $row['username'];
                    $data_post["min"] = $row['sub_min'];
                    $data_post["max"] = $row['sub_max'];
                    $data_post["posts"] = ($row['sub_posts'] == -1) ? 0 : $row['sub_posts'];
                    $data_post["delay"] = $row['sub_delay'];
                    $data_post["expiry"] = (!empty($row['sub_expiry'])) ? date("d/m/Y", strtotime($row['sub_expiry'])) : ""; //change date format dd/mm/YYYY
                    break;

                case 'custom_comments':
                    $data_post["link"] = $row['link'];
                    $data_post["comments"] = json_decode($row['comments']);
                    break;

                case 'mentions_with_hashtags':
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    $data_post["usernames"] = $row['usernames'];
                    $data_post["hashtags"] = $row['hashtags'];
                    break;

                case 'mentions_custom_list':
                    $data_post["link"] = $row['link'];
                    $data_post["usernames"] = json_decode($row['usernames']);
                    break;

                case 'mentions_hashtag':
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    $data_post["hashtag"] = $row['hashtag'];
                    break;

                case 'mentions_user_followers':
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    $data_post["username"] = $row['username'];
                    break;

                case 'mentions_media_likers':
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    $data_post["media"] = $row['media'];
                    break;

                case 'package':
                    $data_post["link"] = $row['link'];
                    break;

                case 'custom_comments_package':
                    $data_post["link"] = $row['link'];
                    $data_post["comments"] = json_decode($row['comments']);
                    break;

                case 'comment_likes':
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    $data_post["username"] = $row['username'];
                    break;

                default:
                    $data_post["link"] = $row['link'];
                    $data_post["quantity"] = $row['quantity'];
                    if (isset($row['is_drip_feed']) && $row['is_drip_feed'] == 1) {
                        $data_post["runs"] = $row['runs'];
                        $data_post["interval"] = $row['interval'];
                        $data_post["quantity"] = $row['dripfeed_quantity'];
                    } else {
                        $data_post["quantity"] = $row['quantity'];
                    }
                    break;
            }
            $response = $this->provider->order($api, $data_post);
            $this->model->save_item(['order_id' => $row['id'], 'response' => $response], ['task' => 'item-new-update']);
        }
        echo "Successfully";
    }


    public function status()
    {
        $lock = fopen('_lock_file_status.lock', 'w');
        if (!($lock && flock($lock, LOCK_EX | LOCK_NB)))
            die('Order already running');
        $params = [
            'limit' => 15,
            'start' => 0,
        ];
        $items = $this->model->list_items($params, ['task' => 'list-items-status']);
        if (!$items) {
            echo "There is no order at the present.<br>";
            exit();
        }
        foreach ($items as $key => $item) {
            $api = [
                'id' => $item['api_provider_id'],
                'url' => $item['api_url'],
                'key' => $item['api_key'],
                'type' => $item['api_type'],
            ];
            $response = $this->provider->status($api, $item['api_order_id']);
            $this->model->save_item(['item' => $item, 'response' => $response], ['task' => 'item-update-status']);
        }
        echo "Successfully";
    }

    public function multiple_status()
    {
        $lock = fopen('_lock_file_multiple_status.lock', 'w');
        if (!($lock && flock($lock, LOCK_EX | LOCK_NB)))
            die('Orders already running');
        $params = [
            'limit' => 100,
            'start' => 0,
        ];
        $items = $this->model->list_items($params, ['task' => 'list-items-statuses']);
        if (!$items) {
            echo "There is no order at the present.<br>";
            exit();
        }
        $items_group_by_api = group_by_criteria($items, 'api_provider_id');
        foreach ($items_group_by_api as $api_id => $items_group) {
            $api = db_get('url, key, type, id', TB_API_PROVIDERS, ['id' => $api_id]);
            if (!$api) {
                $response = [
                    'error'         => "API Provider does not exists",
                    'error_type'    => 'not_found', //not_found, unconnected
                ];
                $params = [
                    'order_ids' => array_column($items_group, 'id'),
                    'response' => $response,
                ];
                $this->model->save_items($params, ['task' => 'items-update-statuses-by-ids']);
                continue;
            } else {
                $response = $this->provider->multiStatus($api, array_column($items_group, 'api_order_id'));
                if ($response) {
                    $params = [
                        'items' => $items_group, 
                        'response' => $response
                    ];
                    $batch_update = $this->model->save_items($params, ['task' => 'items-batch-update-statuses']);
                    continue;
                } else {
                    $response = [
                        'error'         => "API Request Error: Unable to connect to the external service!",
                        'error_type'    => 'unconnected',
                    ];
                    $params = [
                        'order_ids' => array_column($items_group, 'id'),
                        'response' => $response,
                    ];
                    $this->model->save_items($params, ['task' => 'item-update-statuses-by-ids']);
                    continue;
                }
            }
        }
        echo "Successfully";
    }

    protected function cron_token() 
    {
        if (get_cron_key() != get('key')) {
            exit('Invalid token');
        }
        return true;
    }
}
