<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Schedule Production</h1>
<form action="/production/schedule" method="POST">
    <label for="recipe_id">Recipe:</label>
    <select id="recipe_id" name="recipe_id" required>
        <?php foreach ($recipes as $recipe): ?>
            <option value="<?php echo $recipe['id']; ?>"><?php echo $recipe['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="order_id">Order ID:</label>
    <input type="text" id="order_id" name="order_id" required>

    <label for="production_date">Production Date:</label>
    <input type="date" id="production_date" name="production_date" required>

    <label for="start_time">Start Time:</label>
    <input type="time" id="start_time" name="start_time" required>

    <label for="end_time">End Time:</label>
    <input type="time" id="end_time" name="end_time" required>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required>

    <label for="assigned_baker">Assigned Baker:</label>
    <select id="assigned_baker" name="assigned_baker" required>
        <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="equipment_needed">Equipment Needed:</label>
    <textarea id="equipment_needed" name="equipment_needed" required></textarea>

    <button type="submit">Schedule Production</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
