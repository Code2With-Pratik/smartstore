<?php

namespace App\Config\Routes;

use CodeIgniter\Config\BaseConfig;
use App\Models\LanguageModel;

class UserRoutes extends BaseConfig
{
    protected $name_space;

    public function __construct()
    {
        $this->name_space = ["namespace" => "App\Controllers\Public"];
    }

    public static function init($routes)
    {
        $name_space = ["namespace" => "App\Controllers\Public"];
        
        $routes->get('/([a-zA-Z]{2})', 'PageController::index', $name_space);
        
        self::defineRoutes($routes);

        $routes->group('{locale}', function ($routes) {
            self::defineRoutes($routes);
        });

    }

    private static function defineRoutes($routes)
    {
        $name_space = ["namespace" => "App\Controllers\Public"];
        $client_controller = 'ClientController::';
        $page_controller = 'PageController::';
        $order_controller = 'OrderController::';
        $blog_controller  = 'BlogController::';
        
        // Home Page
        $routes->get('/', $page_controller. 'index', $name_space);

        // Blog category
        $routes->get('load-more-blog-post/', $blog_controller. 'load_more_post', $name_space);
        $routes->get('load-more-blog-post/(:any)?', $blog_controller. 'load_more_post/$1', $name_space);
        $routes->get('blog/category/(:segment)', $blog_controller . 'category/$1', $name_space);
        $routes->get('blog/(:any)', $blog_controller . 'post_detail/$1', $name_space);

        // Client 
        $routes->match(['get', 'post'], 'submit_review', $client_controller. 'submit_review', $name_space);
        $routes->get('load-more-reviews', $client_controller. 'load_more_reviews', $name_space);
        $routes->post('submit-review', $client_controller. 'submit_review', $name_space);
        $routes->post('contact-us/message', $client_controller. 'submit_contact_us', $name_space);

        // Order
        $routes->get('checkout', $order_controller . 'checkout', $name_space);
        $routes->post('checkout/payment-process', $order_controller . 'checkout_process', $name_space);
        $routes->get('checkout/(:segment)/complete', $order_controller . 'checkout_complete/$1', $name_space);
        $routes->get('payment-failed', $order_controller . 'checkout_unsuccess', $name_space);
        $routes->get('payment-success/(:segment)', $order_controller . 'checkout_success/$1', $name_space);

        $routes->get('order', $order_controller . 'index', $name_space);
        $routes->post('order/collect', $order_controller . 'order_collect', $name_space);
        $routes->match(['get', 'post'], 'track-order', $order_controller . 'track_order', $name_space);
        $routes->post('apply-coupon', $order_controller . 'checkout_apply_coupon', $name_space);

        // Generic Route for URL Slugs (must be the last route)
        $routes->get('(:segment)', $page_controller . 'display_page/$1', $name_space);
    }
}
