<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Product deleted successfully!';
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error deleting product: ' . $e->getMessage();
}

header('Location: index.php');
exit;
?>