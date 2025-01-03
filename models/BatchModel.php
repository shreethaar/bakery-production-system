<?php
class BatchModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch all batches
    public function getAllBatches() {
        $sql = "SELECT * FROM batches";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to create a new batch
    public function createBatch($batch_number, $production_schedule_id, $start_time, $end_time, $status, $notes, $quality_checks) {
        $sql = "INSERT INTO batches (batch_number, production_schedule_id, start_time, end_time, status, notes, quality_checks) VALUES (:batch_number, :production_schedule_id, :start_time, :end_time, :status, :notes, :quality_checks)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'batch_number' => $batch_number,
            'production_schedule_id' => $production_schedule_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $status,
            'notes' => $notes,
            'quality_checks' => json_encode($quality_checks)
        ]);
        return $this->pdo->lastInsertId();
    }
}
?>
