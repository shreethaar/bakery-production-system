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

        <h1>Create Recipe</h1>
        <form action="/recipes/create" method="POST">
            <div class="form-group">
                <label for="name">Recipe Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" required></textarea>
            </div>

            <div class="form-group">
                <label for="steps">Preparation Steps:</label>
                <textarea id="steps" name="steps" required></textarea>
            </div>

            <div class="form-group">
                <label for="equipment">Equipment Needed:</label>
                <input type="text" id="equipment" name="equipment" required>
            </div>

            <div class="form-group">
                <label for="prep_time">Preparation Time (minutes):</label>
                <input type="number" id="prep_time" name="prep_time" required>
            </div>

            <div class="form-group">
                <label for="yield">Yield:</label>
                <input type="number" id="yield" name="yield" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Create Recipe</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
