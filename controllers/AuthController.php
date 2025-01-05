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

        // Debug: Print the sanitized username and password
        echo "Sanitized Username: " . $username . "<br>";
        echo "Sanitized Password: " . $password . "<br>";

        // Fetch the user by username
        $user = $this->userModel->getUserByUsername($username);

        // Debug: Print the fetched user data
        echo "Fetched User Data: ";
        print_r($user);
        echo "<br>";

        if ($user && isset($user['password'])) {
            // Debug: Print the hashed password from the database
            echo "Hashed Password from DB: " . $user['password'] . "<br>";

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Debug: Print success message
                echo "Password verification successful!<br>";

                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // Debug: Print session variables
                echo "Session User ID: " . $_SESSION['user_id'] . "<br>";
                echo "Session Role: " . $_SESSION['role'] . "<br>";

                // Redirect to dashboard
                header('Location: /dashboard');
                exit;
            } else {
                // Debug: Print failure message
                echo "Password verification failed!<br>";

                // Invalid password
                $error = "Invalid username or password.";
            }
        } else {
            // Debug: Print failure message
            echo "User not found or password not set!<br>";

            // Invalid username or password
            $error = "Invalid username or password.";
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

    // Handle user registration
    public function register() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize inputs
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate inputs
            if (empty($name) || empty($email) || empty($username) || empty($password) || empty($role)) {
                $error = "All fields are required.";
            } else {
                // Check if the username or email already exists
                $existingUser = $this->userModel->getUserByUsername($username);
                $existingEmail = $this->userModel->getUserByEmail($email);

                if ($existingUser) {
                    $error = "Username already exists.";
                } elseif ($existingEmail) {
                    $error = "Email already exists.";
                } else {
                    // Create the user
                    $data = [
                        'name' => $name,
                        'email' => $email,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role
                    ];

                    if ($this->userModel->createUser($data)) {
                        // Redirect to login page after successful registration
                        header('Location: /login');
                        exit;
                    } else {
                        $error = "Registration failed. Please try again.";
                    }
                }
            }
        }

        // Show registration form (with error message if applicable)
        include __DIR__ . '/../views/auth/register.php';
    }

    // Handle forgot password
    public function forgotPassword() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            // Validate input
            if (empty($email)) {
                $error = "Email is required.";
            } else {
                // Check if the email exists in the database
                $user = $this->userModel->getUserByEmail($email);

                if ($user) {
                    // Display a message indicating that a supervisor will handle the request
                    $message = "A supervisor will manually send you a new password.";
                } else {
                    // Email does not exist in the database
                    $error = "Email not found.";
                }
            }
        }

        // Show forgot password form (with message or error if applicable)
        include __DIR__ . '/../views/auth/forgot_password.php';
    }
}
?>
