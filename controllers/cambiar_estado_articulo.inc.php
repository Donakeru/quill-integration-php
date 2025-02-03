<?php
// cambiar_estado_articulo.inc.php

require_once "../database/db.inc.php";

// Leer los datos enviados en la solicitud PUT
parse_str(file_get_contents("php://input"), $putData);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Validar que se envíen los datos necesarios
    if (!isset($putData['post_id']) || empty($putData['post_id'])) {
        echo "ID del artículo no proporcionado.";
        exit;
    }

    if (!isset($putData['new_status']) || empty($putData['new_status'])) {
        echo "Nuevo estado no proporcionado.";
        exit;
    }

    $postId = $putData['post_id'];
    $newStatus = $putData['new_status'];

    // Preparar la consulta para actualizar el estado
    $statement = $pdo->prepare('UPDATE posts SET status = :status WHERE post_id = :post_id');

    try {
        $statement->execute([
            'status' => $newStatus,
            'post_id' => $postId
        ]);
        echo "OK";  // Respuesta de éxito
    } catch (PDOException $e) {
        echo "Error al actualizar el estado: " . $e->getMessage();
    }
}
?>
