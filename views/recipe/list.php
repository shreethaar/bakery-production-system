<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Recipe List</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Ingredients</th>
            <th>Steps</th>
            <th>Equipment</th>
            <th>Prep Time</th>
            <th>Yield</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recipes as $recipe): ?>
            <tr>
                <td><?php echo $recipe['id']; ?></td>
                <td><?php echo $recipe['name']; ?></td>
                <td><?php echo $recipe['description']; ?></td>
                <td><?php echo implode(', ', json_decode($recipe['ingredients'], true)); ?></td>
                <td><?php echo implode(', ', json_decode($recipe['steps'], true)); ?></td>
                <td><?php echo implode(', ', json_decode($recipe['equipment'], true)); ?></td>
                <td><?php echo $recipe['prep_time']; ?> minutes</td>
                <td><?php echo $recipe['yield']; ?></td>
                <td>
                    <a href="/recipes/update/<?php echo $recipe['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
