<?php include __DIR__ . '/../../includes/header.php'; ?>

<!-- Link to the CSS file -->
<link rel="stylesheet" href="/assets/recipe/styles.css">

<div class="container">
    <!-- Display success message if set -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Display error message if set -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <h1>Recipe List</h1>

    <!-- Add the "Create Recipe" button -->
    <div class="create-recipe-button">
        <a href="/recipes/create" class="btn-create-recipe">Create Recipe</a>
    </div>

    <table class="recipe-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Ingredients</th>
                <th>Steps</th>
                <th>Equipment</th>
                <th>Preparation Time</th>
                <th>Yield</th>
                <th>Actions</th> <!-- New column for Edit and Delete buttons -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?= htmlspecialchars($recipe['name']) ?></td>
                    <td><?= htmlspecialchars($recipe['description']) ?></td>
                    <td>
                        <?php
                        // Ensure ingredients is an array before imploding
                        $ingredients = is_array($recipe['ingredients']) ? $recipe['ingredients'] : [];
                        echo htmlspecialchars(implode(', ', $ingredients));
                        ?>
                    </td>
                    <td>
                        <?php
                        // Ensure steps is an array before imploding
                        $steps = is_array($recipe['steps']) ? $recipe['steps'] : [];
                        echo htmlspecialchars(implode(', ', $steps));
                        ?>
                    </td>
                    <td>
                        <?php
                        // Ensure equipment is an array before imploding
                        $equipment = is_array($recipe['equipment']) ? $recipe['equipment'] : [];
                        echo htmlspecialchars(implode(', ', $equipment));
                        ?>
                    </td>
                    <td><?= htmlspecialchars($recipe['prep_time']) ?> minutes</td>
                    <td><?= htmlspecialchars($recipe['yield']) ?></td>
                    <td>
                        <!-- Edit Button (Link) -->
                        <a href="/recipes/update/<?= $recipe['id'] ?>" class="btn-edit">Edit</a>

                        <!-- Delete Button (Form with CSRF Token) -->
                        <form action="/recipes/delete/<?= $recipe['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');" style="display: inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="/recipes?page=<?= $page - 1 ?>" class="pagination-link">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/recipes?page=<?= $i ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="/recipes?page=<?= $page + 1 ?>" class="pagination-link">Next</a>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
