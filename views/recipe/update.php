<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- Link to the CSS file -->
<link rel="stylesheet" href="/assets/recipe/styles.css">

<div class="container">
    <div class="form-container">
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

        <h1>Update Recipe</h1>
        <form action="/recipes/update/<?php echo $recipe['id']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Recipe Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $recipe['name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo $recipe['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" required><?php echo $recipe['ingredients']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="steps">Preparation Steps:</label>
                <textarea id="steps" name="steps" required><?php echo $recipe['steps']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="equipment">Equipment Needed:</label>
                <input type="text" id="equipment" name="equipment" value="<?php echo $recipe['equipment']; ?>" required>
            </div>

            <div class="form-group">
                <label for="prep_time">Preparation Time (minutes):</label>
                <input type="number" id="prep_time" name="prep_time" value="<?php echo $recipe['prep_time']; ?>" required>
            </div>

            <div class="form-group">
                <label for="yield">Yield:</label>
                <input type="number" id="yield" name="yield" value="<?php echo $recipe['yield']; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Update Recipe</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
