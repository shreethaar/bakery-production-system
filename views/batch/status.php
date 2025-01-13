<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Batch Status</h1>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
<?php endif; ?>

<!-- Batch Status Table -->
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Recipe</th>
            <th>Production Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($batches as $batch): ?>
            <tr>
                <td><?= htmlspecialchars($batch['id']) ?></td>
                <td><?= htmlspecialchars($batch['recipe_name']) ?></td>
                <td><?= htmlspecialchars($batch['production_date']) ?></td>
                <td><?= htmlspecialchars($batch['start_time']) ?></td>
                <td><?= htmlspecialchars($batch['end_time']) ?></td>
                <td><?= htmlspecialchars($batch['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="/batch" class="btn btn-secondary">Back to Batches</a>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
