<?php
class ProductionModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fetch all production schedules
    public function getAllSchedules() {
        $sql = "SELECT ps.*, r.name AS recipe_name 
                FROM production_schedules ps
                LEFT JOIN recipes r ON ps.recipe_id = r.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single production schedule by ID
    public function getScheduleById($scheduleId) {
        $sql = "SELECT ps.*, r.name AS recipe_name, u.name AS baker_name
                FROM production_schedules ps
                LEFT JOIN recipes r ON ps.recipe_id = r.id
                LEFT JOIN users u ON ps.assigned_baker = u.id
                WHERE ps.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $scheduleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new production schedule
    public function createSchedule($recipe_id, $order_id, $production_date, $start_time, $end_time, $quantity, $assigned_baker, $equipment_needed, $status, $created_by) {
        $sql = "INSERT INTO production_schedules (recipe_id, order_id, production_date, start_time, end_time, quantity, assigned_baker, equipment_needed, status, created_by) 
                VALUES (:recipe_id, :order_id, :production_date, :start_time, :end_time, :quantity, :assigned_baker, :equipment_needed, :status, :created_by)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'recipe_id' => $recipe_id,
            'order_id' => $order_id,
            'production_date' => $production_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'quantity' => $quantity,
            'assigned_baker' => $assigned_baker,
            'equipment_needed' => json_encode($equipment_needed),
            'status' => $status,
            'created_by' => $created_by
        ]);
        return $this->pdo->lastInsertId();
    }

    // Update an existing production schedule
    public function updateSchedule($scheduleId, $recipe_id, $order_id, $production_date, $start_time, $end_time, $quantity, $assigned_baker, $equipment_needed, $status) {
        $sql = "UPDATE production_schedules 
                SET recipe_id = :recipe_id, 
                    order_id = :order_id, 
                    production_date = :production_date, 
                    start_time = :start_time, 
                    end_time = :end_time, 
                    quantity = :quantity, 
                    assigned_baker = :assigned_baker, 
                    equipment_needed = :equipment_needed, 
                    status = :status 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $scheduleId,
            'recipe_id' => $recipe_id,
            'order_id' => $order_id,
            'production_date' => $production_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'quantity' => $quantity,
            'assigned_baker' => $assigned_baker,
            'equipment_needed' => json_encode($equipment_needed),
            'status' => $status
        ]);
        return $stmt->rowCount() > 0; // Return true if the update was successful
    }

    // Delete a production schedule by ID
    public function deleteSchedule($scheduleId) {
        $sql = "DELETE FROM production_schedules WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $scheduleId]);
        return $stmt->rowCount() > 0; // Return true if the deletion was successful
    }
}
?>
