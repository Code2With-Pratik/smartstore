<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Start the native PHP session to align with app/auth/index.php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Debug: Log session data
        file_put_contents('C:\xampp\htdocs\smartstore\home_controller_debug.txt', "Home Controller - Session ID: " . session_id() . "\nSession Data: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

        // Render the view
        return view('welcome_message');
    }
}