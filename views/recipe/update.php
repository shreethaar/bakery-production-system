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
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="name">Recipe Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $recipe['name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo $recipe['description']; ?></textarea>
            </div>

            <!-- Dynamic Ingredients Field -->
            <div class="form-group">
                <label for="ingredients">Ingredients:</label>
                <div id="ingredients-container">
                    <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                        <div class="ingredient-group">
                            <input type="text" name="ingredients[]" value="<?php echo $ingredient; ?>" required>
                            <button type="button" class="remove-ingredient">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="add-ingredient">Add Ingredient</button>
            </div>

            <!-- Dynamic Steps Field -->
            <div class="form-group">
                <label for="steps">Preparation Steps:</label>
                <div id="steps-container">
                    <?php foreach ($recipe['steps'] as $step): ?>
                        <div class="step-group">
                            <input type="text" name="steps[]" value="<?php echo $step; ?>" required>
                            <button type="button" class="remove-step">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="add-step">Add Step</button>
            </div>

            <!-- Dynamic Equipment Field -->
            <div class="form-group">
                <label for="equipment">Equipment Needed:</label>
                <div id="equipment-container">
                    <?php foreach ($recipe['equipment'] as $equipment): ?>
                        <div class="equipment-group">
                            <input type="text" name="equipment[]" value="<?php echo $equipment; ?>" required>
                            <button type="button" class="remove-equipment">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="add-equipment">Add Equipment</button>
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

<!-- JavaScript for Dynamic Fields -->
<script>
    // Add Ingredient
    document.getElementById('add-ingredient').addEventListener('click', function () {
        const container = document.getElementById('ingredients-container');
        const newIngredient = document.createElement('div');
        newIngredient.classList.add('ingredient-group');
        newIngredient.innerHTML = `
            <input type="text" name="ingredients[]" placeholder="Ingredient" required>
            <button type="button" class="remove-ingredient">Remove</button>
        `;
        container.appendChild(newIngredient);
    });

    // Add Step
    document.getElementById('add-step').addEventListener('click', function () {
        const container = document.getElementById('steps-container');
        const newStep = document.createElement('div');
        newStep.classList.add('step-group');
        newStep.innerHTML = `
            <input type="text" name="steps[]" placeholder="Step" required>
            <button type="button" class="remove-step">Remove</button>
        `;
        container.appendChild(newStep);
    });

    // Add Equipment
    document.getElementById('add-equipment').addEventListener('click', function () {
        const container = document.getElementById('equipment-container');
        const newEquipment = document.createElement('div');
        newEquipment.classList.add('equipment-group');
        newEquipment.innerHTML = `
            <input type="text" name="equipment[]" placeholder="Equipment" required>
            <button type="button" class="remove-equipment">Remove</button>
        `;
        container.appendChild(newEquipment);
    });

    // Remove Functionality
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-ingredient')) {
            e.target.parentElement.remove();
        }
        if (e.target.classList.contains('remove-step')) {
            e.target.parentElement.remove();
        }
        if (e.target.classList.contains('remove-equipment')) {
            e.target.parentElement.remove();
        }
    });
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
