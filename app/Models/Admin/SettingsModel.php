<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class SettingsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->main_table   =  $this->table           = TB_OPTIONS;
        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = '';
        $this->allowedFields         = ['name', 'value'];
        $this->useTimestamps    = false;
    }

    // save item
    public function save_item($params = null, $option = null)
    {
        // Update
        $input_posts = $this->prepare_crud_data($params['post_input']);

        if (get_post('tab_key') == 'email_templates') return $this->save_email_template($input_posts, $option);

        $data_update_batch = [];
        foreach ($input_posts as $key => $value) {
            
            if (in_array($key, ['embed_js_code_header', 'embed_js_code_header'])) {
                $value = htmlspecialchars($value, ENT_QUOTES);
            } else {
                $value = (is_array($value)) ? json_encode($value) : $value;
            }
            $item = [
                'name' => $key,
                'value' => $value
            ];
            $data_update_batch[] = $item;
        }
        $result = db_update_batch($this->table, $data_update_batch, 'name');
        $result = ($result === false) ? false : 1;
        $response = handle_db_operation_result($result, 'updated', 'error');
        return $response;
    }
    
    private function save_email_template($params = [], $option) 
    {   
        $data_update_batch = [];    
        if (is_array($params['email_templates']) && !empty($params['email_templates'])) {
            foreach ($params['email_templates'] as $key => $item_tmpl) {
                $item_exist = db_get('name, id, ids', $this->tb_email_templates, ['name' => $key]);
                $data_item = [
                    'status' => (int)$item_tmpl['status'],
                    'subject' => $item_tmpl['subject'],
                    'content' => $item_tmpl['content'],
                ];
                if (!empty($item_exist)) {
                    $data_item['changed'] = NOW;
                    $result = db_update($this->tb_email_templates, $data_item, ['name' => $key]);
                } else {
                    $data_item['ids'] = ids();
                    $data_item['name'] = $key;
                    $result = db_insert($this->tb_email_templates, $data_item);
                }
            }
        }
        return ['status' => 'success', 'message' => 'Updated successfully'];
    }
}
