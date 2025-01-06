<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'bakery_production');
define('DB_USER', 'REDACTED');
define('DB_PASS', 'REDACTED');

// Establish database connection
try {
    $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $dbh = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    exit("Database connection failed. Please check the logs or contact support.");
}

// Return the connection
return $dbh;
?>
