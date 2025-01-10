<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- Link to the Production CSS file -->
<link rel="stylesheet" href="/assets/production/styles.css">

<div class="container">
    <h1>View Production Schedule</h1>

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

    <!-- Schedule Details -->
    <div class="schedule-details">
        <p><strong>ID:</strong> <?php echo $schedule['id']; ?></p>
        <p><strong>Recipe:</strong> <?php echo $schedule['recipe_name']; ?></p>
        <p><strong>Order ID:</strong> <?php echo $schedule['order_id']; ?></p>
        <p><strong>Production Date:</strong> <?php echo $schedule['production_date']; ?></p>
        <p><strong>Start Time:</strong> <?php echo $schedule['start_time']; ?></p>
        <p><strong>End Time:</strong> <?php echo $schedule['end_time']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $schedule['quantity']; ?></p>
        <p><strong>Assigned Baker:</strong> <?php echo $schedule['assigned_baker']; ?></p>
        <p><strong>Equipment Needed:</strong> <?php echo implode(', ', json_decode($schedule['equipment_needed'], true)); ?></p>
        <p><strong>Status:</strong> <?php echo $schedule['status']; ?></p>
    </div>

    <!-- Back Button -->
    <a href="/production" class="btn-back">Back to List</a>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
