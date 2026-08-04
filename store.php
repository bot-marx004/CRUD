<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO products (name, brand, model, price, stock, description, ram, storage, color) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['brand'],
            $_POST['model'],
            $_POST['price'],
            $_POST['stock'],
            $_POST['description'],
            $_POST['ram'],
            $_POST['storage'],
            $_POST['color']
        ]);
        
        $_SESSION['success'] = 'Product added successfully!';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error adding product: ' . $e->getMessage();
    }
    
    header('Location: index.php');
    exit;
}

header('Location: index.php');
exit;
?>