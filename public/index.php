<?php
// Include config and routing
require_once __DIR__ . '/../config/config.php';

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
$productionController = new ProductionController($productionModel);
$batchController = new BatchController($batchModel);

// Routing logic (Basic Example)
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
        // Check if the user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        include __DIR__ . '/../views/dashboard.php';
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'recipes':
        if (isset($segments[1]) && $segments[1] == 'create') {
            $recipeController->createRecipe();
        } elseif (isset($segments[1]) && $segments[1] == 'update') {
            $recipeController->updateRecipe($segments[2]);
        } else {
            $recipeController->listRecipes();
        }
        break;

    case 'production':
        if (isset($segments[1]) && $segments[1] == 'schedule') {
            $productionController->scheduleProduction();
        } else {
            $productionController->listSchedules();
        }
        break;

    case 'batch':
        if (isset($segments[1]) && $segments[1] == 'track') {
            $batchController->trackBatch();
        } else {
            $batchController->batchStatus();
        }
        break;

    default:
        // Show a 404 page or home page if the route is not found
        echo "404 - Not Found";
        break;
}
?>
