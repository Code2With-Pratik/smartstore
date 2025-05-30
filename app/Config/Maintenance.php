<?php

namespace App\Config;
use CodeIgniter\Config\BaseConfig;

class Maintenance extends BaseConfig
{
    public function checkMaintenanceStatus()
    {
        return get_app_setting('site_maintenance_mode');
    }
    
    public function admin_url()
    {
        return config('AppConfig')->prefixAdmin . '/login';
    }
}
