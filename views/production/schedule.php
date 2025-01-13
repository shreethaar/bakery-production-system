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

    <h1>Schedule Production</h1>

    <!-- Production Schedule Form -->
    <form action="/production/schedule" method="POST" class="production-form">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="form-group">
            <label for="recipe_id">Recipe:</label>
            <select id="recipe_id" name="recipe_id" required>
                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?php echo $recipe['id']; ?>"><?php echo $recipe['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="order_id">Order ID:</label>
            <input type="text" id="order_id" name="order_id" required>
        </div>

        <div class="form-group">
            <label for="production_date">Production Date:</label>
            <input type="date" id="production_date" name="production_date" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time:</label>
            <input type="time" id="start_time" name="start_time" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time:</label>
            <input type="time" id="end_time" name="end_time" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>

        <!-- Recipe Dropdown -->
        <div class="form-group">
            <label for="recipe_id">Recipe:</label>
            <select id="recipe_id" name="recipe_id" required>
                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?= $recipe['id'] ?>"><?= htmlspecialchars($recipe['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Assigned Baker Dropdown -->
        <div class="form-group">
            <label for="assigned_baker">Assigned Baker:</label>
            <select id="assigned_baker" name="assigned_baker" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="equipment_needed">Equipment Needed (JSON format):</label>
            <textarea id="equipment_needed" name="equipment_needed" required placeholder='Example: ["Oven", "Mixer", "Baking Tray"]'></textarea>
        </div>

        <button type="submit" class="btn-submit">Schedule Production</button>
        <a href="/production" class="btn-back">Back to List</a>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
