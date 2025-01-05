<?php include __DIR__ . '/../../includes/login_header.php'; ?>

<div class="register-form">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="/register" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="baker" selected>Baker</option>
            <option value="supervisor">Supervisor</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
