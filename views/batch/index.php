<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Batch List</h1>

<!-- Display success or error messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Batch List Table -->
<?php if (!empty($batches)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Batch Number</th>
                <th>Recipe</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($batches as $batch): ?>
                <tr>
                    <td><?= htmlspecialchars($batch['id']) ?></td>
                    <td><?= htmlspecialchars($batch['batch_number']) ?></td>
                    <td><?= htmlspecialchars($batch['recipe_name']) ?></td>
                    <td><?= htmlspecialchars($batch['start_time']) ?></td>
                    <td><?= htmlspecialchars($batch['end_time']) ?></td>
                    <td><?= htmlspecialchars($batch['status']) ?></td>
                    <td>
                        <a href="/batch/edit/<?= $batch['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="/batch/delete/<?= $batch['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No batches found.</p>
<?php endif; ?>

<!-- Create New Batch Button -->
<a href="/batch/create" class="btn btn-success">Create New Batch</a>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
