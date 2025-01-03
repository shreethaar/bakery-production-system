<?php
class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Handle user login
    public function login() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize inputs
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate credentials
            $user = $this->userModel->getUserByUsername($username);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect to dashboard
                    header('Location: /dashboard');
                    exit;
                } else {
                    // Invalid password
                    $error = "Invalid password.";
                }
            } else {
                // Invalid username
                $error = "Invalid username.";
            }
        }

        // Show login form (with error message if applicable)
        include __DIR__ . '/../views/auth/login.php';
    }

    // Handle user logout
    public function logout() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy the session
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>
