<!-- Link to the CSS file -->
<link rel="stylesheet" href="/../../assets/register/styles.css">

<div class="register-form-container">
    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form id="registerForm" action="/register" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="baker" selected>Baker</option>
                <option value="supervisor">Supervisor</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-submit">Register</button>
        </div>
    </form>
</div>

<script src="/../../assets/register/scripts.js"></script>
