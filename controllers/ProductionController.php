<?php

class ProductionController {
    private $productionModel;
    private $pdo;

    // Update the constructor to accept $pdo
    public function __construct($productionModel, $pdo) {
        $this->productionModel = $productionModel;
        $this->pdo = $pdo; // Assign the passed $pdo to $this->pdo
    }

    // Method to list all production schedules
    public function listSchedules() {
        Middleware::requireLogin(); // Ensure the user is logged in

        // Fetch all production schedules from the model
        $schedules = $this->productionModel->getAllSchedules();

        // Include the view to display the schedules
        include __DIR__ . '/../views/production/list.php';
    }

    // Method to show the production scheduling form
    public function scheduleProduction() {
        Middleware::requireLogin(); // Ensure the user is logged in

        // Fetch all recipes from the RecipeModel
        $recipeModel = new RecipeModel($this->pdo); // Use $this->pdo
        $recipes = $recipeModel->getAllRecipes();

        // Fetch all bakers from the UserModel
        $userModel = new UserModel($this->pdo); // Use $this->pdo
        $users = $userModel->getAllUsers();

        // Include the view to display the schedule production form
        include __DIR__ . '/../views/production/schedule.php';
    }

    // Method to handle production scheduling
    public function storeSchedule() {
        Middleware::requireLogin(); // Ensure the user is logged in

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            $requiredFields = ['recipe_id', 'order_id', 'production_date', 'start_time', 'end_time', 'quantity', 'assigned_baker', 'equipment_needed'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['error_message'] = "Please fill in all required fields.";
                    header("Location: /production/schedule");
                    exit;
                }
            }

            // Proceed with creating the schedule
            try {
                $scheduleId = $this->productionModel->createSchedule(
                    $_POST['recipe_id'],
                    $_POST['order_id'],
                    $_POST['production_date'],
                    $_POST['start_time'],
                    $_POST['end_time'],
                    $_POST['quantity'],
                    $_POST['assigned_baker'],
                    json_decode($_POST['equipment_needed'], true),
                    'scheduled', // Default status
                    $_SESSION['user_id'] // Logged-in user ID
                );
                $_SESSION['success_message'] = "Production schedule created successfully!";
                header("Location: /production");
                exit;
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error creating production schedule: " . $e->getMessage();
                header("Location: /production/schedule");
                exit;
            }
        }
    }

    public function viewSchedule($scheduleId) {
        Middleware::requireLogin(); // Ensure the user is logged in

        // Fetch the schedule details from the model
        $schedule = $this->productionModel->getScheduleById($scheduleId);

        if (!$schedule) {
            $_SESSION['error_message'] = "Schedule not found.";
            header("Location: /production");
            exit;
        }

        // Include the view to display the schedule details
        include __DIR__ . '/../views/production/view.php';
    }

    public function editSchedule($scheduleId) {
        Middleware::requireLogin(); // Ensure the user is logged in

        // Fetch the schedule details from the model
        $schedule = $this->productionModel->getScheduleById($scheduleId);

        if (!$schedule) {
            $_SESSION['error_message'] = "Schedule not found.";
            header("Location: /production");
            exit;
        }

        // Fetch all recipes and users for the form
        $recipeModel = new RecipeModel($this->pdo);
        $recipes = $recipeModel->getAllRecipes();

        $userModel = new UserModel($this->pdo);
        $users = $userModel->getAllUsers();

        // Include the view to display the edit form
        include __DIR__ . '/../views/production/edit.php';
    }

    public function deleteSchedule($scheduleId) {
        Middleware::requireLogin(); // Ensure the user is logged in

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Delete the schedule from the model
                $this->productionModel->deleteSchedule($scheduleId);

                $_SESSION['success_message'] = "Schedule deleted successfully!";
                header("Location: /production");
                exit;
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Error deleting schedule: " . $e->getMessage();
                header("Location: /production");
                exit;
            }
        } else {
            // If not a POST request, redirect to the production list
            header("Location: /production");
            exit;
        }
    }
}

?>
