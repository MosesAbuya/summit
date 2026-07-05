<?php
$host = 'localhost';
$dbname = 'salonone_summit_africa';
$username = 'root'; // Adjust to environment
$password = ''; // Adjust to environment

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database Connection failed. Please ensure database.sql is imported: " . $e->getMessage());
}
?>
