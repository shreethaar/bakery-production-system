<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Track Batch</h1>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
<?php endif; ?>

<!-- Batch Tracking Form -->
<form method="POST" action="/batch/track">
    <div class="form-group">
        <label for="batch_id">Batch ID</label>
        <input type="text" id="batch_id" name="batch_id" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="submit-btn">Track Batch</button>
        <a href="/batch" class="cancel-btn">Cancel</a>
    </div>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
