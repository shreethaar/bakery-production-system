<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Update Recipe</h1>
<form action="/recipes/update/<?php echo $recipe['id']; ?>" method="POST">
    <label for="name">Recipe Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $recipe['name']; ?>" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?php echo $recipe['description']; ?></textarea>

    <label for="ingredients">Ingredients:</label>
    <textarea id="ingredients" name="ingredients" required><?php echo $recipe['ingredients']; ?></textarea>

    <label for="steps">Preparation Steps:</label>
    <textarea id="steps" name="steps" required><?php echo $recipe['steps']; ?></textarea>

    <label for="equipment">Equipment Needed:</label>
    <input type="text" id="equipment" name="equipment" value="<?php echo $recipe['equipment']; ?>" required>

    <label for="prep_time">Preparation Time (minutes):</label>
    <input type="number" id="prep_time" name="prep_time" value="<?php echo $recipe['prep_time']; ?>" required>

    <label for="yield">Yield:</label>
    <input type="number" id="yield" name="yield" value="<?php echo $recipe['yield']; ?>" required>

    <button type="submit">Update Recipe</button>
</form>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
