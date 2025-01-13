<?php
session_start();

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Include config and routing
require_once __DIR__ . '/../config/config.php';

// Include middleware
require_once __DIR__ . '/../includes/Middleware.php';

// Include models
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RecipeModel.php';
require_once __DIR__ . '/../models/ProductionModel.php';
require_once __DIR__ . '/../models/BatchModel.php';

// Include controllers
$authControllerPath = __DIR__ . '/../controllers/AuthController.php';
if (!file_exists($authControllerPath)) {
    die("File not found: $authControllerPath");
}
require_once $authControllerPath;

require_once __DIR__ . '/../controllers/RecipeController.php';
require_once __DIR__ . '/../controllers/ProductionController.php';
require_once __DIR__ . '/../controllers/BatchController.php';

// Initialize the database connection
$pdo = require __DIR__ . '/../config/database.php'; // Use the returned connection

// Initialize models
$userModel = new UserModel($pdo);
$recipeModel = new RecipeModel($pdo);
$productionModel = new ProductionModel($pdo);
$batchModel = new BatchModel($pdo);

// Initialize controllers
$authController = new AuthController($userModel);
$recipeController = new RecipeController($recipeModel);
$productionController = new ProductionController($productionModel, $pdo);
$batchController = new BatchController($batchModel);

// Routing logic
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($requestUri, '/'));

// Default route
if (empty($segments[0])) {
    $segments[0] = 'home';
}

// Handle routes
switch ($segments[0]) {
    case 'home':
        include __DIR__ . '/../views/home.php';
        break;

    case 'login':
        $authController->login();
        break;

    case 'dashboard':
        Middleware::requireLogin(); // Ensure the user is logged in
        include __DIR__ . '/../views/dashboard.php';
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'recipes':
        Middleware::requireLogin(); // Ensure the user is logged in
        if (isset($segments[1]) && $segments[1] == 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $recipeController->storeRecipe(); // Handle form submission
            } else {
                $recipeController->createRecipe(); // Display the form
            }
        } elseif (isset($segments[1]) && $segments[1] == 'update') {
            if ($_SERVER['REQUEST_METHOD']==='POST') {
                $recipeController->saveRecipe($segments[2]);
            } else {
                $recipeController->updateRecipe($segments[2]);
            }
        } elseif (isset($segments[1]) && $segments[1] == 'delete') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipeController->deleteRecipe($segments[2]); // Handle delete request
        } else {
            header('Location: /recipes'); // Redirect if not a POST request
            exit;
        }
        } else {
            $recipeController->listRecipes();
        }
        break;
     case 'production':
        Middleware::requireLogin(); // Ensure the user is logged in
        if (isset($segments[1])) {
            switch ($segments[1]) {
                case 'schedule':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $productionController->storeSchedule(); // Handle form submission
                    } else {
                        $productionController->scheduleProduction(); // Display the form
                    }
                    break;

                case 'view':
                    if (isset($segments[2])) {
                        $productionController->viewSchedule($segments[2]); // View a schedule
                    } else {
                        header('Location: /production');
                        exit;
                    }
                    break;

                case 'edit':
                    if (isset($segments[2])) {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $productionController->updateSchedule($segments[2]); // Handle form submission for updating
                        } else {
                            $productionController->editSchedule($segments[2]); // Display the edit form
                        }
                    } else {
                        header('Location: /production');
                        exit;
                    }
                    break;

                case 'delete':
                    if (isset($segments[2]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $productionController->deleteSchedule($segments[2]); // Handle deletion
                    } else {
                        header('Location: /production');
                        exit;
                 }
                    break;

                default:
                    $productionController->listSchedules(); // List all schedules
                    break;
            }
        } else {
            $productionController->listSchedules(); // List all schedules
        }
        break;

    case 'batch':
        Middleware::requireLogin(); // Ensure the user is logged in
        if (isset($segments[1])) {
            switch ($segments[1]) {
                case 'create':
                    $batchController->create();
                    break;

                case 'store':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $batchController->store();
                    } else {
                        header('Location: /batch');
                        exit;
                    }
                    break;

                case 'edit':
                    if (isset($segments[2])) {
                        $batchController->edit($segments[2]);
                    } else {
                        header('Location: /batch');
                        exit;
                    }
                    break;

                case 'update':
                    if (isset($segments[2]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $batchController->update($segments[2]);
                    } else {
                        header('Location: /batch');
                        exit;
                    }
                    break;

                case 'delete':
                    if (isset($segments[2])) {
                        $batchController->delete($segments[2]);
                    } else {
                        header('Location: /batch');
                        exit;
                    }
                    break;

                case 'track':
                    $batchController->trackBatch();
                    break;

                default:
                    // Show a 404 page or redirect to batch list
                    header('Location: /batch');
                    exit;
            }
        } else {
            // Default batch route (list batches)
            $batchController->index();
        }
        break;

    case 'register':
        $authController->register();
        break;

    case 'forgot-password':
        $authController->forgotPassword();
        break;

    default:
        // Show a 404 page or redirect to home
        echo "404 - Not Found";
        break;
}
?>
