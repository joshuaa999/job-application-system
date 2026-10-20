
<?php
// Database configuration for the Job Application System
// PDO is used to connect PHP to the MySQL database.

$host = "localhost";
$dbname = "job_application_db";
$username = "root";
$password = "";

try {
    // Create a PDO database connection.
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Display errors when a database operation fails.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
