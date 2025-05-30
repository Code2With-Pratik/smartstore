<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class StaffsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->main_table = $this->table  = TB_STAFFS;
        $this->filter_accepted       = [];
        $this->field_search_accepted  = [];
        $this->allowedFields        = ['ids', 'role_id', 'admin', 'login_type', 'first_name', 'last_name', 'email', 'password', 'timezone', 'settings', 'history_ip', 'status', 'changed', 'created'];
    }

    // Get all items
    public function list_items($params = null, $option = null)
    {
        $result = null;
        return $result;
    }

    // Get all items
    public function count_items($params = null, $option = null)
    {
        $result = null;
        return $result;
    }

    // get Item
    public function get_item($params = null, $option = null)
    {
        $result = null;

        if ($option['task'] == 'get-item') {
            $result = $this->get_record('*', $this->table, ['id' => $params['id']]);
        }

        if ($option['task'] == 'get-item-by-email') {
            $result = $this->get_record('*', $this->table, ['email' => $params['email']]);
        }

        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        // edit-item
        if ($option['task'] == 'update-profile') {
            $input_posts = $params['input_posts'];
            $data_item = [
                'changed' => NOW
            ];
            if ($params['action_type'] === 'account_info') {
                $data_item['first_name'] = sanitize_input($input_posts['first_name']);
                $data_item['last_name'] = sanitize_input($input_posts['last_name']);
                $data_item['email'] = sanitize_input($input_posts['email']);
                $data_item['timezone'] = sanitize_input($input_posts['timezone']);
            } 
            if ($params['action_type'] === 'change_password') {
                $data_item['password'] = $input_posts['new_password'];
            } 
            $result = db_update($this->table, $data_item, ['id' => get_logged_in_user_info('sid')]);
            if ($result ) {
                return ["status" => "success", "message" => 'Updated Successfully!'];
            } else {
                return ["status" => "error", "message" => 'Update failed. Please try again later or contact support if the issue persists.'];
            }    
        }
        
    }
}
