<?php

require_once __DIR__ . '/../database/db.inc.php';
require_once "utils.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Verificar si el post_id está presente en la solicitud
        if (!isset($_POST['post_id'])) {
            throw new Exception("El campo 'post_id' es requerido.", 400);
        }

        $post_id = $_POST['post_id'];

        // Obtener el artículo
        $stmt = $pdo->prepare("SELECT title, content FROM posts WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            throw new Exception("El artículo no existe.", 404);
        }

        // Obtener todos los suscriptores activos
        $stmt = $pdo->query("SELECT email, suscriber_id FROM subscribers WHERE is_active = TRUE");
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($subscribers)) {
            throw new Exception("No hay suscriptores activos para notificar.", 404);
        }

        // Construir el mensaje
        $subject = "Nuevo artículo publicado: " . $post['title'];
        $message = "Hola,\n\nSe ha publicado un nuevo artículo en nuestro blog:\n\n";
        $message .= "Título: " . $post['title'] . "\n";
        $message .= "Contenido: " . $post['content'] . "\n\n";
        $message .= "¡Gracias por suscribirte!";

        // Enviar el correo a cada suscriptor
        foreach ($subscribers as $subscriber) {
            $email = $subscriber['email'];
            $subscriber_id = $subscriber['suscriber_id'];

            // Enviar el correo (usando la función mail de PHP)
            $headers = "From: no-reply@blog.com";
            if (mail($email, $subject, $message, $headers)) {
                // Registrar la notificación en la base de datos
                $stmt = $pdo->prepare("INSERT INTO notifications (subscriber_id, post_id) VALUES (:subscriber_id, :post_id)");
                $stmt->execute(['subscriber_id' => $subscriber_id, 'post_id' => $post_id]);
            } else {
                throw new Exception("Error al enviar el correo a $email.", 500);
            }
        }

        // Retornar éxito
        http_response_code(200);
        echo "Notificaciones enviadas a todos los suscriptores activos.";

    } catch (Exception $e) {
        // Capturar excepciones y retornar el código de error HTTP correspondiente
        $errorCode = $e->getCode() ?: 500;
        http_response_code($errorCode);
        echo "Error: " . $e->getMessage();
    }

}