<?php
// actualizar_articulo.php

require_once "../database/db.inc.php";
require_once "utils.inc.php";


// Leer los datos de la solicitud PUT
parse_str(file_get_contents("php://input"), $putData);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // Validación de ID para actualización
    if (isset($putData['article_id']) && !empty($putData['article_id'])) {
        $articuloId = $putData['article_id'];
    } else {
        echo "ID del artículo no proporcionado.";
        exit;
    }

    print_r($putData); // Print the $_POST array

    $titulo = deleteMaliciousTags($putData['title']);
    $categoría = $putData['category_id'];
    $contenido = deleteMaliciousTags($putData['content']);
    $video_url = deleteMaliciousTags($putData['video']);

    // Validar y sanitizar los datos (esto es importante para seguridad)
    $tituloSanitizado = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    $contenidoSanitizado = htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8');
    $preview = getPreview($contenido, 150);

    // Actualizar el artículo en la base de datos
    $statement = $pdo->prepare('UPDATE posts SET title = :title, content = :content, category_id = :category_id, preview = :preview, url = :video WHERE post_id = :post_id');

    $statement->execute([
        'title' => $tituloSanitizado,
        'content' => $contenidoSanitizado,
        'category_id' => $categoría,
        'preview' => $preview,
        'post_id' => $articuloId,
        'video' => $video_url
    ]);

    // Respuesta
    echo "OK";  // Si todo salió bien, se envía OK
}
?>
