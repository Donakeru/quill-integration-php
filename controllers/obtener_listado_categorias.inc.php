<?php
require_once __DIR__ . '/../database/db.inc.php';

header('Content-Type: application/json');

try {
    $table = 'categories';
    $query = "SELECT * FROM $table";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver las categorías como JSON
    echo json_encode($categories);
} catch (\Throwable $th) {
    // Si hay un error, devolver un array vacío
    echo json_encode([]);
}
?>
