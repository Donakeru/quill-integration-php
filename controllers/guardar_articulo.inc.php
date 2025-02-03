<?php
// guardar_articulo.php

require_once __DIR__ . '/../database/db.inc.php';
require_once "utils.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = deleteMaliciousTags($_POST['title']);
    $categoria = $_POST['category_id'];
    $contenido = deleteMaliciousTags($_POST['content']);
    $video_url = deleteMaliciousTags($_POST['video']);
    $usuario_id = deleteMaliciousTags($_POST['usuario_id']);

    // Validar y sanitizar los datos (esto es importante para seguridad)
    $tituloSanitizado = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    $contenidoSanitizado = htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8');
    $videoUrlSanitizado = htmlspecialchars($video_url, ENT_QUOTES, 'UTF-8');
    $preview = getPreview($contenido, 125);

    $statement = $pdo->prepare('INSERT INTO posts (title, content, category_id, user_id, preview, url)
        VALUES (:title, :content, :category_id, :user_id, :preview, :video)');

    $statement->execute([
        'title' => $tituloSanitizado,
        'content' => $contenidoSanitizado,
        'category_id' => $categoria,
        'user_id' => $usuario_id,
        'preview' => $preview,
        'video' => $video_url
    ]);

    // Obtener el ID del post recién registrado
    $postId = $pdo->lastInsertId();

    echo $postId;
}
?>