<?php include __DIR__ . '/../../includes/header.php'; ?>

<h1>Edit Batch</h1>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
<?php endif; ?>

<!-- Batch Edit Form -->
<form method="POST" action="/batch/update/<?= $batch['id'] ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <div class="form-section">
        <h2>Batch Details</h2>
        
        <div class="form-group">
            <label for="recipe_id">Recipe</label>
            <select id="recipe_id" name="recipe_id" required>
                <option value="">Select Recipe</option>
                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?php echo $recipe['id']; ?>" <?= $recipe['id'] == $batch['recipe_id'] ? 'selected' : '' ?>>
                        <?php echo htmlspecialchars($recipe['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="schedule_id">Production Schedule</label>
            <select id="schedule_id" name="schedule_id" required>
                <option value="">Select Schedule</option>
                <?php foreach ($schedules as $schedule): ?>
                    <option value="<?php echo $schedule['id']; ?>" <?= $schedule['id'] == $batch['production_schedule_id'] ? 'selected' : '' ?>>
                        <?php echo htmlspecialchars($schedule['recipe_name'] . ' - ' . date('M d, Y', strtotime($schedule['production_date']))); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" id="start_time" name="start_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($batch['start_time']))) ?>" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" id="end_time" name="end_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($batch['end_time']))) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="scheduled" <?= $batch['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                <option value="in_progress" <?= $batch['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="completed" <?= $batch['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="cancelled" <?= $batch['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea id="remarks" name="remarks" rows="3"><?= htmlspecialchars($batch['notes']) ?></textarea>
        </div>
    </div>

    <div class="form-section">
        <h2>Task Assignments</h2>
        <div id="task-assignments">
            <?php foreach ($assignments as $index => $assignment): ?>
                <div class="task-assignment">
                    <div class="form-group">
                        <label>Baker</label>
                        <select name="assignments[<?= $index ?>][user_id]" required>
                            <option value="">Select Baker</option>
                            <?php foreach ($bakers as $baker): ?>
                                <option value="<?php echo $baker['id']; ?>" <?= $baker['id'] == $assignment['user_id'] ? 'selected' : '' ?>>
                                    <?php echo htmlspecialchars($baker['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Task</label>
                        <select name="assignments[<?= $index ?>][task]" required>
                            <option value="">Select Task</option>
                            <option value="Mixing" <?= $assignment['task'] == 'Mixing' ? 'selected' : '' ?>>Mixing</option>
                            <option value="Baking" <?= $assignment['task'] == 'Baking' ? 'selected' : '' ?>>Baking</option>
                            <option value="Decorating" <?= $assignment['task'] == 'Decorating' ? 'selected' : '' ?>>Decorating</option>
                        </select>
                    </div>
                    <button type="button" class="remove-task" onclick="removeTask(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="add-task-btn" onclick="addTask()">
            <i class="fas fa-plus"></i> Add Another Task
        </button>
    </div>

    <div class="form-actions">
        <button type="submit" class="submit-btn">Update Batch</button>
        <a href="/batch" class="cancel-btn">Cancel</a>
    </div>
</form>

<!-- JavaScript for Dynamic Task Assignment -->
<script>
function addTask() {
    const taskAssignments = document.getElementById('task-assignments');
    const newTask = taskAssignments.children[0].cloneNode(true);
    const index = taskAssignments.children.length;

    // Update input names
    newTask.querySelectorAll('select').forEach(select => {
        select.name = select.name.replace('[0]', `[${index}]`);
    });

    // Clear selected values
    newTask.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    // Show remove button
    newTask.querySelector('.remove-task').style.display = 'block';

    taskAssignments.appendChild(newTask);
}

function removeTask(button) {
    const taskAssignment = button.closest('.task-assignment');
    taskAssignment.remove();
}
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
