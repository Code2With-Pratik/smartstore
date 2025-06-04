<?php
if (!function_exists('generate_auth_token')) {
    function generate_auth_token($user_id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Check if a token exists and its generation time
        $token_generated_at = $_SESSION['token_generated_at'] ?? 0;
        $current_time = time();
        $token_validity_period = 600; // 10 minutes in seconds

        // Generate a new token if none exists or if the existing one has expired
        if (!isset($_SESSION['auth_token']) || ($current_time - $token_generated_at >= $token_validity_period)) {
            // Create a unique token using random bytes, timestamp, and user ID
            $token = bin2hex(random_bytes(16)) . '_' . $current_time . '_' . $user_id;
            $_SESSION['auth_token'] = $token;
            $_SESSION['token_generated_at'] = $current_time;
        }

        return $_SESSION['auth_token'];
    }
}

if (!function_exists('is_token_valid')) {
    function is_token_valid() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $token = $_SESSION['auth_token'] ?? null;
        $token_generated_at = $_SESSION['token_generated_at'] ?? 0;
        $current_time = time();
        $token_validity_period = 600; // 10 minutes

        // Return true if token exists and is within the validity period
        return $token && ($current_time - $token_generated_at < $token_validity_period);
    }
}
?>