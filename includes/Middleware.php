<?php
class Middleware {
    // Method to check if the user is logged in
    public static function requireLogin() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
?>
