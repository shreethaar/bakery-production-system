<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- Link to the Production CSS file -->
<link rel="stylesheet" href="/assets/production/styles.css">

<div class="container">
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

    <h1>Production Schedules</h1>

    <!-- Add the "Create Production Schedule" button -->
    <div class="create-schedule-button">
        <a href="/production/schedule" class="btn-create-schedule">Create Production Schedule</a>
    </div>

    <!-- Production Schedules Table -->
    <table class="production-table">
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
                    <td><?php echo $schedule['recipe_name']; ?></td>
                    <td><?php echo $schedule['order_id']; ?></td>
                    <td><?php echo $schedule['production_date']; ?></td>
                    <td><?php echo $schedule['start_time']; ?></td>
                    <td><?php echo $schedule['end_time']; ?></td>
                    <td><?php echo $schedule['quantity']; ?></td>
                    <td><?php echo $schedule['assigned_baker']; ?></td>
                    <td><?php echo implode(', ', json_decode($schedule['equipment_needed'], true)); ?></td>
                    <td><?php echo $schedule['status']; ?></td>
                    <td>
                        <!-- View Button -->
                        <a href="/production/view/<?php echo $schedule['id']; ?>" class="btn-view">View</a>

                        <!-- Edit Button -->
                        <a href="/production/edit/<?php echo $schedule['id']; ?>" class="btn-edit">Edit</a>

                        <!-- Delete Button -->
                        <form action="/production/delete/<?php echo $schedule['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="/production?page=<?= $page - 1 ?>" class="pagination-link">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="/production?page=<?= $i ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="/production?page=<?= $page + 1 ?>" class="pagination-link">Next</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
