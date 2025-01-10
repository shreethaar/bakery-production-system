<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- Link to the Production CSS file -->
<link rel="stylesheet" href="/assets/production/styles.css">

<div class="container">
    <h1>Delete Production Schedule</h1>

    <!-- Confirmation Message -->
    <p>Are you sure you want to delete this production schedule?</p>

    <!-- Schedule Details -->
    <div class="schedule-details">
        <p><strong>ID:</strong> <?php echo $schedule['id']; ?></p>
        <p><strong>Recipe:</strong> <?php echo $schedule['recipe_name']; ?></p>
        <p><strong>Order ID:</strong> <?php echo $schedule['order_id']; ?></p>
        <p><strong>Production Date:</strong> <?php echo $schedule['production_date']; ?></p>
    </div>

    <!-- Delete Form -->
    <form action="/production/delete/<?php echo $schedule['id']; ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <button type="submit" class="btn-delete">Yes, Delete</button>
        <a href="/production" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
