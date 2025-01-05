<?php
// Include the database configuration and get the connection object
require_once __DIR__ . '/../config/database.php';

// Assign the returned database connection to $db
$db = require __DIR__ . '/../config/database.php';

// Fetch all users with plaintext passwords
$sql = "SELECT id, password FROM users";
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    // Check if the password is already hashed
    if (!password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        continue;
    }

    // Hash the plaintext password
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

    // Update the user's password in the database
    $updateSql = "UPDATE users SET password = ? WHERE id = ?";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->execute([$hashedPassword, $user['id']]);

    echo "Updated password for user ID: " . $user['id'] . "<br>";
}

echo "Password migration complete!";
?>
