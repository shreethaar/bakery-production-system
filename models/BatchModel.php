<?php
class BatchModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch all batches with optional filters and sorting
    public function getAllBatches($filters = [], $sortBy = 'start_time', $sortOrder = 'DESC') {
        $query = "SELECT b.*, r.name as recipe_name, s.production_date,
                  STRING_AGG(DISTINCT CONCAT(u.name, ' (', ba.task, ')'), ', ') as assigned_users
                  FROM batches b
                  LEFT JOIN recipes r ON b.recipe_id = r.id
                  LEFT JOIN production_schedules s ON b.production_schedule_id = s.id
                  LEFT JOIN batch_assignments ba ON b.id = ba.batch_id
                  LEFT JOIN users u ON ba.user_id = u.id";

        $whereConditions = [];
        $params = [];

        // Apply filters
        if (!empty($filters['recipe_id'])) {
            $whereConditions[] = "b.recipe_id = :recipe_id";
            $params['recipe_id'] = $filters['recipe_id'];
        }
        if (!empty($filters['status'])) {
            $whereConditions[] = "b.status = :status";
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['date'])) {
            $whereConditions[] = "DATE(b.start_time) = :date";
            $params['date'] = $filters['date'];
        }

        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $query .= " GROUP BY b.id, r.name, s.production_date";

        // Add sorting
        $validSortColumns = ['id', 'recipe_name', 'production_date', 'start_time', 'status'];
        if (in_array($sortBy, $validSortColumns)) {
            $query .= " ORDER BY $sortBy $sortOrder";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch a single batch by ID
    public function getBatchById($batchId) {
        $sql = "SELECT b.*, r.name as recipe_name, s.production_date
                FROM batches b
                LEFT JOIN recipes r ON b.recipe_id = r.id
                LEFT JOIN production_schedules s ON b.production_schedule_id = s.id
                WHERE b.id = :batch_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['batch_id' => $batchId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to create a new batch with task assignments
    public function createBatch($recipeId, $scheduleId, $startTime, $endTime, $remarks, $assignments = []) {
        $this->pdo->beginTransaction();

        try {
            // Insert batch
            $sql = "INSERT INTO batches (recipe_id, production_schedule_id, start_time, end_time, notes)
                    VALUES (:recipe_id, :production_schedule_id, :start_time, :end_time, :notes)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'recipe_id' => $recipeId,
                'production_schedule_id' => $scheduleId,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'notes' => $remarks
            ]);
            $batchId = $this->pdo->lastInsertId();

            // Insert task assignments
            if (!empty($assignments)) {
                $sql = "INSERT INTO batch_assignments (batch_id, user_id, task, status)
                        VALUES (:batch_id, :user_id, :task, 'Pending')";
                $stmt = $this->pdo->prepare($sql);

                foreach ($assignments as $assignment) {
                    $stmt->execute([
                        'batch_id' => $batchId,
                        'user_id' => $assignment['user_id'],
                        'task' => $assignment['task']
                    ]);
                }
            }

            $this->pdo->commit();
            return $batchId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error creating batch: " . $e->getMessage());
        }
    }

    // Method to update a batch
    public function updateBatch($batchId, $recipeId, $scheduleId, $startTime, $endTime, $status, $remarks, $assignments = []) {
        $this->pdo->beginTransaction();

        try {
            // Update batch
            $sql = "UPDATE batches
                    SET recipe_id = :recipe_id,
                        production_schedule_id = :production_schedule_id,
                        start_time = :start_time,
                        end_time = :end_time,
                        status = :status,
                        notes = :notes
                    WHERE id = :batch_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'recipe_id' => $recipeId,
                'production_schedule_id' => $scheduleId,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $status,
                'notes' => $remarks,
                'batch_id' => $batchId
            ]);

            // Delete existing assignments
            $sql = "DELETE FROM batch_assignments WHERE batch_id = :batch_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['batch_id' => $batchId]);

            // Insert new assignments
            if (!empty($assignments)) {
                $sql = "INSERT INTO batch_assignments (batch_id, user_id, task, status)
                        VALUES (:batch_id, :user_id, :task, 'Pending')";
                $stmt = $this->pdo->prepare($sql);

                foreach ($assignments as $assignment) {
                    $stmt->execute([
                        'batch_id' => $batchId,
                        'user_id' => $assignment['user_id'],
                        'task' => $assignment['task']
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error updating batch: " . $e->getMessage());
        }
    }

    // Method to delete a batch
    public function deleteBatch($batchId) {
        $this->pdo->beginTransaction();

        try {
            // Delete assignments
            $sql = "DELETE FROM batch_assignments WHERE batch_id = :batch_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['batch_id' => $batchId]);

            // Delete batch
            $sql = "DELETE FROM batches WHERE id = :batch_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['batch_id' => $batchId]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error deleting batch: " . $e->getMessage());
        }
    }

    // Method to fetch all recipes
    public function getAllRecipes() {
        $sql = "SELECT id, name FROM recipes ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch all schedules
    public function getAllSchedules() {
        $sql = "SELECT s.id, r.name as recipe_name, s.production_date
                FROM production_schedules s
                JOIN recipes r ON s.recipe_id = r.id
                WHERE s.status != 'Completed'
                ORDER BY s.production_date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch all bakers
    public function getAllBakers() {
        $sql = "SELECT id, name FROM users WHERE role = 'Baker' ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch assignments for a batch
    public function getBatchAssignments($batchId) {
        $sql = "SELECT * FROM batch_assignments WHERE batch_id = :batch_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['batch_id' => $batchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
