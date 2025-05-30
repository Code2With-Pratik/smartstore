<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class PluginsModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table           = TB_PURCHASE;
        $this->main_builder    = $this->db->table($this->table);

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);
        $this->field_search_accepted = config('AppConfig')->config['search']['category'];
        $this->allowedFields       = [
            'ids', 'pid', 'purchase_code', 'version'
        ];
    }

    public function save_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'install-upgrade-item'){
            $item_data = $params['item_data'];
            db_execute_command();
            $item = db_get("*", $this->table, ['pid' => $item_data[0]]);
            $item_crud_data = array(
                "ids"           => ids(),
                "pid"           => $item_data[0],
                "purchase_code" => $params['purchase_code'],
                "version"       => $item_data[3]
            );
            if(empty($item)){
                db_insert($this->table, $item_crud_data);
            }else{
                db_update($this->table, $item_crud_data, ['id' => $item['id']]);
            }
            $result = ["status" 	=> "success", "message"   => "Installation successfully"];
        }
        return $result;
    }
}   

