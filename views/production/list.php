<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Production Schedules</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Recipe</th>
            <th>Order ID</th>
            <th>Production Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Quantity</th>
            <th>Assigned Baker</th>
            <th>Equipment Needed</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedules as $schedule): ?>
            <tr>
                <td><?php echo $schedule['id']; ?></td>
                <td><?php echo $schedule['recipe_id']; ?></td>
                <td><?php echo $schedule['order_id']; ?></td>
                <td><?php echo $schedule['production_date']; ?></td>
                <td><?php echo $schedule['start_time']; ?></td>
                <td><?php echo $schedule['end_time']; ?></td>
                <td><?php echo $schedule['quantity']; ?></td>
                <td><?php echo $schedule['assigned_baker']; ?></td>
                <td><?php echo implode(', ', json_decode($schedule['equipment_needed'], true)); ?></td>
                <td><?php echo $schedule['status']; ?></td>
                <td>
                    <a href="/production/schedule/<?php echo $schedule['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
