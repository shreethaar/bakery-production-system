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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch a recipe by ID
    public function getRecipeById($id) {
        $sql = "SELECT * FROM recipes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to create a new recipe
    public function createRecipe($name, $description, $ingredients, $steps, $equipment, $prep_time, $yield, $created_by) {
        $sql = "INSERT INTO recipes (name, description, ingredients, steps, equipment, prep_time, yield, created_by) VALUES (:name, :description, :ingredients, :steps, :equipment, :prep_time, :yield, :created_by)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'ingredients' => json_encode($ingredients),
            'steps' => json_encode($steps),
            'equipment' => json_encode($equipment),
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
    }
}
?>
