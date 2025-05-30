<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// cronjob
$routes->group('cron', ['namespace' => 'App\Controllers\Public'], function($routes) {
    $routes->get('order', 'CronController::order');
    $routes->get('status', 'CronController::status');
    $routes->get('statuses', 'CronController::multiple_status');
});

// Payment IPN
$routes->post('(:alpha)_ipn', 'Public\OrderController::handle_payment_ipn/$1');


\App\Config\Routes\AdminRoutes::init($routes);
\App\Config\Routes\UserRoutes::init($routes);