<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\AppConfig;

class AdminFilter implements FilterInterface
{

    protected $config;

    public function __construct()
    {
        $this->config = new AppConfig();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $prefixAdmin = $this->config->prefixAdmin;
        // Check if the user is not logged in
        if (!is_user_logged_in()) {
             // If the user is not logged in and trying to access an admin page (except login)
            if (strpos($request->getUri()->getPath(), $prefixAdmin . '/login') === false) {
                // Redirect to the login page if the user is not logged in
                return redirect()->to($prefixAdmin . '/login');
            }
        } else {
            // If the user is logged in, continue checking if they are an admin and the demo mode status
            // Check if it's in demo mode and if the request is an AJAX POST request
            if (APP_IS_DEMO === TRUE && is_ajax_post_request()) {
                json_response([
                    'status'    => 'error',
                    'message'   => 'Demo mode does not allow changes to data. Please try again later.',
                ]);
            }
             // Check if the logged-in user is not an admin
            if (!check_admin_status()) {
                if (strpos($request->getUri()->getPath(), $prefixAdmin) !== false) {
                    return redirect()->to('/');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // After processing the request, no additional actions are needed
    }
}
