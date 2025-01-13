<?php
class BatchController {
    private $batchModel;

    public function __construct($batchModel) {
        $this->batchModel = $batchModel;
    }

    // Display all batches
    public function index() {
        Middleware::requireLogin();

        // Fetch all batches with optional filters and sorting
        $filters = [
            'recipe_id' => $_GET['recipe'] ?? '',
            'status' => $_GET['status'] ?? '',
            'date' => $_GET['date'] ?? ''
        ];
        $sortBy = $_GET['sort'] ?? 'start_time';
        $sortOrder = $_GET['order'] ?? 'DESC';

        $batches = $this->batchModel->getAllBatches($filters, $sortBy, $sortOrder);
        $recipes = $this->batchModel->getAllRecipes();

        include __DIR__ . '/../views/batch/index.php';
    }

    // Show the form for creating a new batch
    public function create() {
        Middleware::requireLogin();

        // Fetch data for the form
        $recipes = $this->batchModel->getAllRecipes();
        $schedules = $this->batchModel->getAllSchedules();
        $bakers = $this->batchModel->getAllBakers();

        include __DIR__ . '/../views/batch/create.php';
    }

    // Handle the creation of a new batch
    public function store() {
        Middleware::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipeId = $_POST['recipe_id'];
            $scheduleId = $_POST['schedule_id'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $remarks = $_POST['remarks'];
            $assignments = $_POST['assignments'] ?? [];

            try {
                $batchId = $this->batchModel->createBatch($recipeId, $scheduleId, $startTime, $endTime, $remarks, $assignments);
                $_SESSION['success_message'] = "Batch created successfully!";
                header("Location: /batch");
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location: /batch/create");
                exit();
            }
        }
    }

    // Show the form for editing a batch
    public function edit($batchId) {
        Middleware::requireLogin();

        $batch = $this->batchModel->getBatchById($batchId);
        if (!$batch) {
            $_SESSION['error_message'] = "Batch not found.";
            header("Location: /batch");
            exit();
        }

        $recipes = $this->batchModel->getAllRecipes();
        $schedules = $this->batchModel->getAllSchedules();
        $bakers = $this->batchModel->getAllBakers();
        $assignments = $this->batchModel->getBatchAssignments($batchId);

        include __DIR__ . '/../views/batch/edit.php';
    }

    // Handle the update of a batch
    public function update($batchId) {
        Middleware::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $recipeId = $_POST['recipe_id'];
            $scheduleId = $_POST['schedule_id'];
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];
            $status = $_POST['status'];
            $remarks = $_POST['remarks'];
            $assignments = $_POST['assignments'] ?? [];

            try {
                $this->batchModel->updateBatch($batchId, $recipeId, $scheduleId, $startTime, $endTime, $status, $remarks, $assignments);
                $_SESSION['success_message'] = "Batch updated successfully!";
                header("Location: /batch");
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = $e->getMessage();
                header("Location: /batch/edit/$batchId");
                exit();
            }
        }
    }

    // Handle the deletion of a batch
    public function delete($batchId) {
        Middleware::requireLogin();

        try {
            $this->batchModel->deleteBatch($batchId);
            $_SESSION['success_message'] = "Batch deleted successfully!";
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }

        header("Location: /batch");
        exit();
    }
}
?>
