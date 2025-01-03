<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Batch Status</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Batch Number</th>
            <th>Production Schedule ID</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Quality Checks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($batches as $batch): ?>
            <tr>
                <td><?php echo $batch['id']; ?></td>
                <td><?php echo $batch['batch_number']; ?></td>
                <td><?php echo $batch['production_schedule_id']; ?></td>
                <td><?php echo $batch['start_time']; ?></td>
                <td><?php echo $batch['end_time']; ?></td>
                <td><?php echo $batch['status']; ?></td>
                <td><?php echo $batch['notes']; ?></td>
                <td><?php echo implode(', ', json_decode($batch['quality_checks'], true)); ?></td>
                <td>
                    <a href="/batch/track/<?php echo $batch['id']; ?>">Track</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
