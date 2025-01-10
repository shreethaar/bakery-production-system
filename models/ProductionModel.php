<?php
class ProductionModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSchedules() {
        $sql = "SELECT ps.*, r.name AS recipe_name 
                FROM production_schedules ps
                LEFT JOIN recipes r ON ps.recipe_id = r.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to create a new production schedule
    public function createSchedule($recipe_id, $order_id, $production_date, $start_time, $end_time, $quantity, $assigned_baker, $equipment_needed, $status, $created_by) {
        $sql = "INSERT INTO production_schedules (recipe_id, order_id, production_date, start_time, end_time, quantity, assigned_baker, equipment_needed, status, created_by) VALUES (:recipe_id, :order_id, :production_date, :start_time, :end_time, :quantity, :assigned_baker, :equipment_needed, :status, :created_by)";
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
}
?>
