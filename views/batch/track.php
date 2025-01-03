<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Track Batch</h1>
<form action="/batch/track" method="POST">
    <label for="batch_id">Batch ID:</label>
    <input type="text" id="batch_id" name="batch_id" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
        <option value="failed">Failed</option>
    </select>

    <label for="notes">Notes:</label>
    <textarea id="notes" name="notes"></textarea>

    <label for="quality_checks">Quality Checks:</label>
    <textarea id="quality_checks" name="quality_checks"></textarea>

    <button type="submit">Update Batch</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
