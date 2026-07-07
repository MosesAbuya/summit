<?php
require 'includes/db.php';
$sql = file_get_contents('database.sql');
try {
    $pdo->exec($sql);
    echo "Database tables imported successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
