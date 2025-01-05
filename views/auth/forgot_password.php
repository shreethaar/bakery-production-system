<?php include __DIR__ . '/../../includes/login_header.php'; ?>

<div class="forgot-password-form">
    <h2>Forgot Password</h2>
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="/forgot-password" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Submit</button>
    </form>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
