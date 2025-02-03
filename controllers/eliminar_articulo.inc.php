<?php
// eliminar_articulo.inc.php

require_once "../database/db.inc.php";

// Leer los datos enviados en la solicitud DELETE
parse_str(file_get_contents("php://input"), $deleteData);

header('Content-Type: application/json');  // Asegurarse de que la respuesta esté en formato JSON

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Validar que se envíen los datos necesarios
    if (!isset($deleteData['post_id']) || empty($deleteData['post_id'])) {
        // Respuesta con código de error
        http_response_code(400);  // Bad Request
        echo json_encode([
            'success' => false,
            'message' => 'ID del artículo no proporcionado.'
        ]);
        exit;
    }

    $postId = $deleteData['post_id'];

    // Preparar la consulta para eliminar el artículo (eliminado lógico)
    $statement = $pdo->prepare('UPDATE posts SET status = :status WHERE post_id = :post_id');

    try {
        $statement->execute([
            'post_id' => $postId,
            'status' => 'eliminado'
        ]);
        
        // Respuesta de éxito
        if ($statement->rowCount() > 0) {
            http_response_code(200);  // OK
            echo json_encode([
                'success' => true,
                'message' => 'Artículo eliminado exitosamente.'
            ]);
        } else {
            // Si no se encontró el artículo para eliminar
            http_response_code(404);  // Not Found
            echo json_encode([
                'success' => false,
                'message' => 'Artículo no encontrado.'
            ]);
        }
    } catch (PDOException $e) {
        // Respuesta de error
        http_response_code(500);  // Internal Server Error
        echo json_encode([
            'success' => false,
            'message' => 'Error al eliminar el artículo: ' . $e->getMessage()
        ]);
    }
}
?>
