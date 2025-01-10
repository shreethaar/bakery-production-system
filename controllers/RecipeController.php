<?php
class RecipeController {
    private $recipeModel;

    public function __construct($recipeModel) {
        $this->recipeModel = $recipeModel;
    }

    // Helper method to check if the user is logged in
    private function requireLogin() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // Method to list all recipes
    public function listRecipes() {
        Middleware::requireLogin(); // use middleware to check login

    // Get the current page from the query string (default to 1 if not set)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 10; // Number of recipes per page

    // Fetch paginated recipes from the model
    $recipes = $this->recipeModel->getRecipesPaginated($page, $perPage);

    // Get the total number of recipes for pagination
    $totalRecipes = $this->recipeModel->getTotalRecipes();
    $totalPages = ceil($totalRecipes / $perPage);

    // Include the view to display the recipes
    include __DIR__ . '/../views/recipe/list.php';
}
    // Method to display the "Create Recipe" form
    public function createRecipe() {
        Middleware::requireLogin(); // Ensure the user is logged in
        include __DIR__ . '/../views/recipe/create.php'; // Render the form
    }

    // Method to handle recipe creation form submission
    public function storeRecipe() {
    Middleware::requireLogin(); // Ensure the user is logged in

    // Handle form submission and save the recipe
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Debug: Print all POST data
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = "Invalid CSRF token.";
            header("Location: /recipes/create");
            exit;
        }

        // Sanitize and validate input data
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prep_time = filter_input(INPUT_POST, 'prep_time', FILTER_SANITIZE_NUMBER_INT);
        $yield = filter_input(INPUT_POST, 'yield', FILTER_SANITIZE_NUMBER_INT);
        $created_by = $_SESSION['user_id']; // Use the logged-in user's ID

        // Sanitize array fields manually
        $ingredients = $_POST['ingredients'] ?? [];
        $steps = $_POST['steps'] ?? [];
        $equipment = $_POST['equipment'] ?? [];

        // Sanitize each item in the arrays
        $ingredients = array_map('htmlspecialchars', $ingredients);
        $steps = array_map('htmlspecialchars', $steps);
        $equipment = array_map('htmlspecialchars', $equipment);

        // Debug: Print sanitized values
        echo "<pre>";
        echo "Name: $name\n";
        echo "Description: $description\n";
        echo "Ingredients: " . print_r($ingredients, true) . "\n";
        echo "Steps: " . print_r($steps, true) . "\n";
        echo "Equipment: " . print_r($equipment, true) . "\n";
        echo "Prep Time: $prep_time\n";
        echo "Yield: $yield\n";
        echo "</pre>";

        // Validate required fields
        if (empty($name) || empty($description) || empty($ingredients) || empty($steps) || empty($equipment) || empty($prep_time) || empty($yield)) {
            $_SESSION['error_message'] = "All fields are required.";
            header("Location: /recipes/create");
            exit;
        }

        try {
            // Create the recipe
            $recipeId = $this->recipeModel->createRecipe(
                $name,
                $description,
                $ingredients, // Already an array
                $steps,       // Already an array
                $equipment,   // Already an array
                $prep_time,
                $yield,
                $created_by
            );

            // Redirect to the recipe list with a success message
            $_SESSION['success_message'] = "Recipe created successfully!";
            header("Location: /recipes");
            exit;
        } catch (Exception $e) {
            // Handle errors
            $_SESSION['error_message'] = "Error creating recipe: " . $e->getMessage();
            header("Location: /recipes/create");
            exit;
        }
    }
}

    // Method to show the recipe update form
    public function updateRecipe($id) {
        Middleware::requireLogin(); // Ensure the user is logged in

        // Fetch the recipe by ID
        $recipe = $this->recipeModel->getRecipeById($id);

        if (!$recipe) {
            $_SESSION['error_message'] = "Recipe not found.";
            header("Location: /recipes");
            exit;
        }

        // Include the view to display the update form
        include __DIR__ . '/../views/recipe/update.php';
    }

    // Method to handle recipe updates
    public function saveRecipe($id) {
      Middleware::requireLogin();
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          echo "<pre>";
          echo "CSRF Token from Form: " . $_POST['csrf_token'] . "\n";
          echo "CSRF Token from Session: " . $_SESSION['csrf_token'] . "\n"; // Debug: Print POST data
          echo "</pre>";

          // Validate CSRF token
          if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
              $_SESSION['error_message'] = "Invalid CSRF token.";
              header("Location: /recipes/update/$id");
              exit;
          }

          // Sanitize and validate input data
          $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $prep_time = filter_input(INPUT_POST, 'prep_time', FILTER_SANITIZE_NUMBER_INT);
          $yield = filter_input(INPUT_POST, 'yield', FILTER_SANITIZE_NUMBER_INT);

          // Sanitize array fields
          $ingredients = $_POST['ingredients'] ?? [];
          $steps = $_POST['steps'] ?? [];
          $equipment = $_POST['equipment'] ?? [];

          $ingredients = array_map('htmlspecialchars', $ingredients);
          $steps = array_map('htmlspecialchars', $steps);
          $equipment = array_map('htmlspecialchars', $equipment);

          // Debug: Print sanitized values
          echo "<pre>";
          echo "Name: $name\n";
          echo "Description: $description\n";
          echo "Ingredients: " . print_r($ingredients, true) . "\n";
          echo "Steps: " . print_r($steps, true) . "\n";
          echo "Equipment: " . print_r($equipment, true) . "\n";
          echo "Prep Time: $prep_time\n";
          echo "Yield: $yield\n";
          echo "</pre>";

          // Validate required fields
          if (empty($name) || empty($description) || empty($ingredients) || empty($steps) || empty($equipment) || empty($prep_time) || empty($yield)) {
              $_SESSION['error_message'] = "All fields are required.";
              header("Location: /recipes/update/$id");
              exit;
          }

          try {
              // Update the recipe
              $this->recipeModel->updateRecipe($id, $name, $description, $ingredients, $steps, $equipment, $prep_time, $yield);

              // Redirect to the recipe list with a success message
              $_SESSION['success_message'] = "Recipe updated successfully!";
              header("Location: /recipes");
              exit;
          } catch (Exception $e) {
              // Handle errors
              $_SESSION['error_message'] = "Error updating recipe: " . $e->getMessage();
              header("Location: /recipes/update/$id");
              exit;
          }
      }
}
    // Method to delete a recipe
    public function deleteRecipe($id) {
    Middleware::requireLogin(); // Ensure the user is logged in

    // Validate CSRF token
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Debug: Print all POST data
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = "Invalid CSRF token.";
            header("Location: /recipes");
            exit;
        }

        try {
            // Delete the recipe
            $this->recipeModel->deleteRecipe($id);

            // Redirect to the recipe list with a success message
            $_SESSION['success_message'] = "Recipe deleted successfully!";
        } catch (Exception $e) {
            // Handle errors
            $_SESSION['error_message'] = "Error deleting recipe: " . $e->getMessage();
        }

        header("Location: /recipes");
        exit;
    }
}
}
?>
