<?php
class RecipeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch all recipes
    public function getAllRecipes() {
        $sql = "SELECT * FROM recipes";
        $stmt = $this->pdo->query($sql);
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Decode JSON fields
        foreach ($recipes as &$recipe) {
            $recipe['ingredients'] = json_decode($recipe['ingredients'], true) ?? [];
            $recipe['steps'] = json_decode($recipe['steps'], true) ?? [];
            $recipe['equipment'] = json_decode($recipe['equipment'], true) ?? [];
        }

        return $recipes;
    }

    // Method to fetch paginated recipes
    public function getRecipesPaginated($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM recipes LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['limit' => $perPage, 'offset' => $offset]);
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Decode JSON fields
        foreach ($recipes as &$recipe) {
            $recipe['ingredients'] = json_decode($recipe['ingredients'], true) ?? [];
            $recipe['steps'] = json_decode($recipe['steps'], true) ?? [];
            $recipe['equipment'] = json_decode($recipe['equipment'], true) ?? [];
        }

        return $recipes;
    }

    // Method to get the total number of recipes
    public function getTotalRecipes() {
        $sql = "SELECT COUNT(*) as total FROM recipes";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Method to fetch a recipe by ID
    public function getRecipeById($id) {
        $sql = "SELECT * FROM recipes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($recipe) {
            // Decode JSON fields
            $recipe['ingredients'] = json_decode($recipe['ingredients'], true) ?? [];
            $recipe['steps'] = json_decode($recipe['steps'], true) ?? [];
            $recipe['equipment'] = json_decode($recipe['equipment'], true) ?? [];
        }

        return $recipe;
    }

    // Method to create a new recipe
    public function createRecipe($name, $description, $ingredients, $steps, $equipment, $prep_time, $yield, $created_by) {
        $sql = "INSERT INTO recipes (name, description, ingredients, steps, equipment, prep_time, yield, created_by) 
                VALUES (:name, :description, :ingredients, :steps, :equipment, :prep_time, :yield, :created_by)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'ingredients' => json_encode($ingredients), // Convert array to JSON string
            'steps' => json_encode($steps),             // Convert array to JSON string
            'equipment' => json_encode($equipment),     // Convert array to JSON string
            'prep_time' => $prep_time,
            'yield' => $yield,
            'created_by' => $created_by
        ]);
        return $this->pdo->lastInsertId();
    }

    // Method to update a recipe
    public function updateRecipe($id, $name, $description, $ingredients, $steps, $equipment, $prep_time, $yield) {
        $sql = "UPDATE recipes SET name = :name, description = :description, ingredients = :ingredients, steps = :steps, equipment = :equipment, prep_time = :prep_time, yield = :yield WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'ingredients' => json_encode($ingredients),
            'steps' => json_encode($steps),
            'equipment' => json_encode($equipment),
            'prep_time' => $prep_time,
            'yield' => $yield
        ]);

    // Debug: Check if the query executed successfully
        if ($stmt->rowCount() > 0) {
            echo "Recipe updated successfully!";
        } else {
            echo "No rows affected. Recipe may not exist or data is unchanged.";
        }
    }
    // Method to delete a recipe
    public function deleteRecipe($id) {
        $sql = "DELETE FROM recipes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
?>
