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
        $this->requireLogin(); // Ensure the user is logged in

        // Fetch all recipes from the model
        $recipes = $this->recipeModel->getAllRecipes();

        // Debug: Print the fetched recipes
        echo "<pre>";
        print_r($recipes);
        echo "</pre>";

        // Include the view to display the recipes
        include __DIR__ . '/../views/recipe/list.php';
    }

    // Method to display the "Create Recipe" form
    public function createRecipe() {
        $this->requireLogin(); // Ensure the user is logged in
        include __DIR__ . '/../views/recipe/create.php'; // Render the form
    }

    // Method to handle recipe creation form submission
    public function storeRecipe() {
        $this->requireLogin(); // Ensure the user is logged in

        // Handle form submission and save the recipe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $equipment = filter_input(INPUT_POST, 'equipment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prep_time = filter_input(INPUT_POST, 'prep_time', FILTER_SANITIZE_NUMBER_INT);
            $yield = filter_input(INPUT_POST, 'yield', FILTER_SANITIZE_NUMBER_INT);
            $created_by = $_SESSION['user_id']; // Use the logged-in user's ID

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
                    json_decode($ingredients, true), // Convert JSON string to array
                    json_decode($steps, true),       // Convert JSON string to array
                    json_decode($equipment, true),   // Convert JSON string to array
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
        $this->requireLogin(); // Ensure the user is logged in

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
        $this->requireLogin(); // Ensure the user is logged in

        // Handle form submission and update the recipe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $ingredients = json_decode($_POST['ingredients'], true);
            $steps = json_decode($_POST['steps'], true);
            $equipment = json_decode($_POST['equipment'], true);
            $prep_time = $_POST['prep_time'];
            $yield = $_POST['yield'];

            // Update the recipe
            $this->recipeModel->updateRecipe($id, $name, $description, $ingredients, $steps, $equipment, $prep_time, $yield);

            // Redirect to the recipe list with a success message
            $_SESSION['success_message'] = "Recipe updated successfully!";
            header("Location: /recipes");
            exit;
        }
    }

    // Method to delete a recipe
    public function deleteRecipe($id) {
        $this->requireLogin(); // Ensure the user is logged in

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
?>
