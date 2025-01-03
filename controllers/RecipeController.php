<?php
class RecipeController {
    private $recipeModel;

    public function __construct($recipeModel) {
        $this->recipeModel = $recipeModel;
    }

    // Method to list all recipes
    public function listRecipes() {
        // Fetch all recipes from the model
        $recipes = $this->recipeModel->getAllRecipes();

        // Include the view to display the recipes
        include __DIR__ . '/../views/recipe/list.php';
    }

    // Method to show the recipe creation form
    public function createRecipe() {
        include __DIR__ . '/../views/recipe/create.php';
    }

    // Method to handle recipe creation
    public function storeRecipe() {
        // Handle form submission and save the recipe
        // ...
    }

    // Method to show the recipe update form
    public function updateRecipe($id) {
        // Fetch the recipe by ID
        $recipe = $this->recipeModel->getRecipeById($id);

        // Include the view to display the update form
        include __DIR__ . '/../views/recipe/update.php';
    }

    // Method to handle recipe updates
    public function saveRecipe($id) {
        // Handle form submission and update the recipe
        // ...
    }
}
?>
