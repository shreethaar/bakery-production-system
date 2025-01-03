<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Create Recipe</h1>
<form action="/recipes/create" method="POST">
    <label for="name">Recipe Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="ingredients">Ingredients:</label>
    <textarea id="ingredients" name="ingredients" required></textarea>

    <label for="steps">Preparation Steps:</label>
    <textarea id="steps" name="steps" required></textarea>

    <label for="equipment">Equipment Needed:</label>
    <input type="text" id="equipment" name="equipment" required>

    <label for="prep_time">Preparation Time (minutes):</label>
    <input type="number" id="prep_time" name="prep_time" required>

    <label for="yield">Yield:</label>
    <input type="number" id="yield" name="yield" required>

    <button type="submit">Create Recipe</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
