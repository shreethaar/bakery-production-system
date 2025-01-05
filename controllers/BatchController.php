<?php
class BatchController {
    private $batchModel;

    public function __construct($batchModel) {
        $this->batchModel = $batchModel;
    }

    // Method to display all batches with optional filters and sorting
    public function index() {
        // Get filters and sorting parameters from the request
        $filters = [
            'recipe_id' => $_GET['recipe'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date' => $_GET['date'] ?? ''
        ];
        $sortBy = $_GET['sort'] ?? 'batch_startTime';
        $sortOrder = $_GET['order'] ?? 'DESC';

        // Fetch all batches from the model
        $batches = $this->batchModel->getAllBatches($filters, $sortBy, $sortOrder);

        // Fetch related data for filters
        $recipes = $this->batchModel->getAllRecipes();

        // Include the view to display the batches
        include __DIR__ . '/../views/batch/index.php';
    }

    // Method to show the form for creating a new batch
    public function create() {
        // Fetch related data for the form
        $recipes = $this->batchModel->getAllRecipes();
        $schedules = $this->batchModel->getAllSchedules();
        $bakers = $this->batchModel->getAllBakers();

        // Include the view to display the create batch form
        include __DIR__ . '/../views/batch/create.php';
    }

    // Method to handle the creation of a new batch
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $recipeId = $_POST['recipe_id'];
            $scheduleId = $_POST['schedule_id'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $remarks = $_POST['remarks'];
            $assignments = $_POST['assignments'] ?? [];

            try {
                // Create the batch
                $batchId = $this->batchModel->createBatch($recipeId, $scheduleId, $startTime, $endTime, $remarks, $assignments);

                // Redirect to the batch list with a success message
                $_SESSION['success_message'] = "Batch created successfully!";
                header("Location: /batch");
                exit();
            } catch (Exception $e) {
                // Handle errors
                $_SESSION['error_message'] = $e->getMessage();
                header("Location: /batch/create");
                exit();
            }
        }
    }

    // Method to show the form for editing a batch
    public function edit($batchId) {
        // Fetch the batch by ID
        $batch = $this->batchModel->getBatchById($batchId);

        if (!$batch) {
            $_SESSION['error_message'] = "Batch not found.";
            header("Location: /batch");
            exit();
        }

        // Fetch related data for the form
        $recipes = $this->batchModel->getAllRecipes();
        $schedules = $this->batchModel->getAllSchedules();
        $bakers = $this->batchModel->getAllBakers();
        $assignments = $this->batchModel->getBatchAssignments($batchId);

        // Include the view to display the edit batch form
        include __DIR__ . '/../views/batch/edit.php';
    }

    // Method to handle the update of a batch
    public function update($batchId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $recipeId = $_POST['recipe_id'];
            $scheduleId = $_POST['schedule_id'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];
            $assignments = $_POST['assignments'] ?? [];

            try {
                // Update the batch
                $this->batchModel->updateBatch($batchId, $recipeId, $scheduleId, $startTime, $endTime, $status, $remarks, $assignments);

                // Redirect to the batch list with a success message
                $_SESSION['success_message'] = "Batch updated successfully!";
                header("Location: /batch");
                exit();
            } catch (Exception $e) {
                // Handle errors
                $_SESSION['error_message'] = $e->getMessage();
                header("Location: /batch/edit/$batchId");
                exit();
            }
        }
    }

    // Method to handle the deletion of a batch
    public function delete($batchId) {
        try {
            // Delete the batch
            $this->batchModel->deleteBatch($batchId);

            // Return a JSON response for AJAX requests
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => true, 'message' => 'Batch deleted successfully']);
                exit();
            }

            // Redirect to the batch list with a success message
            $_SESSION['success_message'] = "Batch deleted successfully!";
            header("Location: /batch");
            exit();
        } catch (Exception $e) {
            // Handle errors
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit();
            }

            $_SESSION['error_message'] = $e->getMessage();
            header("Location: /batch");
            exit();
        }
    }

    // Method to display batch status (legacy method, can be removed or updated)
    public function batchStatus() {
        // Fetch all batches from the model
        $batches = $this->batchModel->getAllBatches();

        // Include the view to display the batch status
        include __DIR__ . '/../views/batch/status.php';
    }

    // Method to show the batch tracking form (legacy method, can be removed or updated)
    public function trackBatch() {
        include __DIR__ . '/../views/batch/track.php';
    }

    // Method to handle batch tracking (legacy method, can be removed or updated)
    public function storeBatch() {
        // Handle form submission and save the batch
        // ...
    }
}
