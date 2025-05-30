<?php

namespace App\Config\Routes;

use CodeIgniter\Config\BaseConfig;

class AdminRoutes extends BaseConfig
{
    public static function init($routes)
    {
        /*Admin are*/
        $prefixAdmin = config('AppConfig')->prefixAdmin;

        // Special cases outside of the admin group
        $routes->group($prefixAdmin, function ($routes) {
            // Route cho login, logout, profile
            $routes->post('login', 'Admin\StaffsController::login');
            $routes->get('login', 'Admin\StaffsController::login');
            $routes->post('logout', 'Admin\StaffsController::logout');
            $routes->get('logout', 'Admin\StaffsController::logout');
            $routes->get('profile', 'Admin\StaffsController::profile');
            $routes->post('profile', 'Admin\StaffsController::profile');

            // cronjobs
            $routes->get('cronjobs', 'Admin\SettingsController::cronjobs');
        });

        $routes->group($prefixAdmin, ['filter' => 'admin'], function ($routes) {
            
            $nameSpace = ["namespace" => "App\Controllers\Admin"];

            // Manage Pages
            $controller_name = 'statistics';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
            });

            // Manage Pages
            $controller_name = 'pages';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Plugins
            $controller_name = 'plugins';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
            });

            // Settings
            $controller_name = 'settings';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->match(['get', 'post'], "send_test_mail", $controller . "send_test_mail");
                $routes->get("/", $controller . "index");
                $routes->post("store", $controller . "store");
                $routes->get("/?(:any)?", $controller . "index");
            });

            // FileManager
            $controller_name = 'filemanager';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("elfinder_init", $controller . "elfinder_init");
                $routes->match(['get', 'post'], "elfinder_connector", $controller . "elfinder_connector");
            });

            // Language
            $controller_name = 'languages';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Coupon
            $controller_name = 'coupons';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // SocialNetwork
            $controller_name = 'socialnetwork';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // MENU
            $controller_name = 'menu';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
            });

            // Blacklist
            $controller_name = 'blacklist';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Blog Category
            $controller_name = 'blogcategory';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Blog Posts
            $controller_name = 'blogposts';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Provider
            $controller_name = 'providers';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("balance/?(:num)?", $controller . "balance/$1");
                $routes->match(['get', 'post'], "sync_services/?(:num)?", $controller . "sync_services/$1");
                $routes->post("store", $controller . "store");
                $routes->post("services/(:num)", $controller . "services/$1");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Client users
            $controller_name = 'users';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->match(['get', 'post'], "add_note/?(:num)?", $controller . "add_note/$1");
                $routes->match(['get', 'post'], "send_mail/?(:num)?", $controller . "send_mail/$1");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Client users
            $controller_name = 'subscribers';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // transactions
            $controller_name = 'transactions';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // ticket
            $controller_name = 'tickets';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->match(['get', 'post'], "send_mail/?(:num)?", $controller . "send_mail/$1");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // payments
            $controller_name = 'payments';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Orders
            $controller_name = 'orders';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // category
            $controller_name = 'category';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // Reviews
            $controller_name = 'reviews';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

            // services
            $controller_name = 'services';
            $routes->group($controller_name, $nameSpace, function ($routes) use ($controller_name) {
                $controller = ucfirst($controller_name) . 'Controller::';
                $routes->get("/", $controller . "index");
                $routes->get("update/?(:num)?", $controller . "update/$1");
                $routes->post("store", $controller . "store");
                $routes->post("sort_table", $controller . "sort_table");
                $routes->post("change_status", $controller . "change_status");
                $routes->post("delete/(:num)", $controller . "delete/$1");
                $routes->post("duplicate/(:num)", $controller . "duplicate/$1");
                $routes->post("bulk_action", $controller . "bulk_action");
            });

        });

    }
}
