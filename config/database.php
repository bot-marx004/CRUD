<?php
// Database configuration
$host = 'localhost';
$port = '3306'; // Change to 3307 if needed
$dbname = 'cell_ject2_db';
$username = 'root';
$password = '';

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, $pdoOptions);
} catch (PDOException $e) {
    if ($e->getCode() == '1049') {
        $setupPdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password, $pdoOptions);
        $setupPdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password, $pdoOptions);
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        brand VARCHAR(255) NOT NULL,
        model VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        description TEXT,
        ram VARCHAR(50),
        storage VARCHAR(50),
        color VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}

// Start session for messages
session_start();
?>