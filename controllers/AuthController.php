<?php
class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Handle user login
    public function login() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user = $this->userModel->getUserByUsername($username);

            if ($user && isset($password,$user['password'])) {
                if(password_verify($password, $user['password'])) {
                    $_SESSION['user_id']=$user['id'];
                    $_SESSION['role']=$user['role'];

                    header('Location: /dashboard');
                    exit;
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }
        }

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
