<?php
// $host = 'localhost';
// $dbname = 'summit';
// $username = 'root'; // Adjust to environment
// $password = ''; // Adjust to environment

$host = 'localhost';
$dbname = 'faridagi_summit';
$username = 'faridagi_summit'; // Adjust to environment
$password = 'Summit@2026'; // Adjust to environment

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Auto-create new tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS partners (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            image_url VARCHAR(255),
            is_major TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS speakers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            title VARCHAR(255),
            bio TEXT,
            image_url VARCHAR(255),
            is_keynote TINYINT(1) DEFAULT 0,
            video_url VARCHAR(255),
            theme VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS accommodations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            hotel_name VARCHAR(255) NOT NULL,
            description TEXT,
            booking_link VARCHAR(255),
            image_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS resources (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            file_url VARCHAR(255),
            category VARCHAR(255),
            status VARCHAR(100) DEFAULT 'Locked',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
} catch (PDOException $e) {
    die("Database Connection failed. Please ensure database.sql is imported: " . $e->getMessage());
}
?>