<?php
namespace App\Models\Admin;
use App\Models\Admin\MyAdminModel;

class BlackListIPModel extends MyAdminModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_BLACKLIST_IP;
        $this->main_builder    = $this->db->table($this->table);
        $this->select_fields_index    = 'id, ids, ip, description, status, created';

        $this->filter_accepted = array_keys(config('AppConfig')->config['status']['default']);

        $this->field_search_accepted = config('AppConfig')->config['search']['blacklist_ip'];
        $this->allowedFields         = ['ids', 'ip', 'description', 'status'];

        $this->crud_restricted_fields = ['id', 'token', 'editor', 'action_type'];
    }
}
