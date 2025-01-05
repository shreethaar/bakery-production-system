<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Batch Status</h1>

<!-- Filters -->
<form method="GET" action="/batch" class="filters">
    <label for="recipe">Recipe:</label>
    <select name="recipe" id="recipe">
        <option value="">All Recipes</option>
        <?php foreach ($recipes as $recipe): ?>
            <option value="<?php echo $recipe['recipe_id']; ?>" <?php echo ($filters['recipe_id'] ?? '') == $recipe['recipe_id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($recipe['recipe_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">All Status</option>
        <option value="Pending" <?php echo ($filters['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="In Progress" <?php echo ($filters['status'] ?? '') === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
        <option value="Completed" <?php echo ($filters['status'] ?? '') === 'Completed' ? 'selected' : ''; ?>>Completed</option>
    </select>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" value="<?php echo $filters['date'] ?? ''; ?>">

    <button type="submit">Apply Filters</button>
</form>

<!-- Batch Table -->
<table>
    <thead>
        <tr>
            <th><a href="<?php echo getSortUrl('batch_id'); ?>">ID <?php echo getSortIndicator('batch_id'); ?></a></th>
            <th><a href="<?php echo getSortUrl('recipe_name'); ?>">Recipe <?php echo getSortIndicator('recipe_name'); ?></a></th>
            <th><a href="<?php echo getSortUrl('schedule_date'); ?>">Schedule Date <?php echo getSortIndicator('schedule_date'); ?></a></th>
            <th><a href="<?php echo getSortUrl('batch_startTime'); ?>">Start Time <?php echo getSortIndicator('batch_startTime'); ?></a></th>
            <th>End Time</th>
            <th>Assigned Users</th>
            <th><a href="<?php echo getSortUrl('batch_status'); ?>">Status <?php echo getSortIndicator('batch_status'); ?></a></th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($batches)): ?>
            <tr>
                <td colspan="9">No batches found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($batches as $batch): ?>
                <tr>
                    <td><?php echo $batch['batch_id']; ?></td>
                    <td><?php echo htmlspecialchars($batch['recipe_name']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($batch['schedule_date'])); ?></td>
                    <td><?php echo date('M d, Y H:i', strtotime($batch['batch_startTime'])); ?></td>
                    <td><?php echo date('M d, Y H:i', strtotime($batch['batch_endTime'])); ?></td>
                    <td><?php echo htmlspecialchars($batch['assigned_users'] ?? 'No assignments'); ?></td>
                    <td>
                        <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $batch['batch_status'])); ?>">
                            <?php echo $batch['batch_status']; ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($batch['batch_remarks'] ?? '-'); ?></td>
                    <td>
                        <a href="/batch/edit/<?php echo $batch['batch_id']; ?>" class="action-btn edit-btn">Edit</a>
                        <button class="action-btn delete-btn" onclick="deleteBatch(<?php echo $batch['batch_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Add Batch Button -->
<a href="/batch/create" class="add-btn">Add New Batch</a>

<!-- JavaScript for Delete Functionality -->
<script>
function deleteBatch(batchId) {
    if (confirm("Are you sure you want to delete this batch?")) {
        fetch(`/batch/delete/${batchId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
