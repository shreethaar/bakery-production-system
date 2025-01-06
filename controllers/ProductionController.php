<?php
class ProductionController {
    private $productionModel;

    public function __construct($productionModel) {
        $this->productionModel = $productionModel;
    }

    // Helper method to check if the user is logged in
    private function requireLogin() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    // Method to list all production schedules
    public function listSchedules() {
        $this->requireLogin(); // Ensure the user is logged in

        // Fetch all production schedules from the model
        $schedules = $this->productionModel->getAllSchedules();

        // Include the view to display the schedules
        include __DIR__ . '/../views/production/list.php';
    }

    // Method to show the production scheduling form
    public function scheduleProduction() {
        $this->requireLogin(); // Ensure the user is logged in

        // Include the view to display the schedule production form
        include __DIR__ . '/../views/production/schedule.php';
    }

    // Method to handle production scheduling
    public function storeSchedule() {
        $this->requireLogin(); // Ensure the user is logged in

        // Handle form submission and save the schedule
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipe_id = $_POST['recipe_id'];
            $order_id = $_POST['order_id'];
            $production_date = $_POST['production_date'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $quantity = $_POST['quantity'];
            $assigned_baker = $_POST['assigned_baker'];
            $equipment_needed = json_decode($_POST['equipment_needed'], true);
            $status = 'scheduled'; // Default status
            $created_by = $_SESSION['user_id']; // Use the logged-in user's ID

            // Create the production schedule
            $scheduleId = $this->productionModel->createSchedule($recipe_id, $order_id, $production_date, $start_time, $end_time, $quantity, $assigned_baker, $equipment_needed, $status, $created_by);

            // Redirect to the production schedules list with a success message
            $_SESSION['success_message'] = "Production schedule created successfully!";
            header("Location: /production");
            exit;
        }
    }
}
?>
