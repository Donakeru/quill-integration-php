<?php

// funciones_comunes.php

function deleteMaliciousTags($html) {
    // Eliminar etiquetas <script> y su contenido
    $html = preg_replace('/<script.*?>(.*?)<\/script>/is', '', $html);
    // Eliminar bloques PHP y su contenido
    $html = preg_replace('/<\?php.*?\?>/is', '', $html);
    
    return $html;
}

function stripHtmlTags($html) {
    // Reemplaza <br>, <p>, </p> y otros saltos de línea con espacios o saltos de línea
    $html = preg_replace('/<br\s*\/?>/i', "\n", $html); // Reemplaza <br> con saltos de línea
    $html = preg_replace('/<\/p>/i', "\n", $html); // Reemplaza </p> con saltos de línea
    $html = preg_replace('/<p>/i', '', $html); // Elimina <p> sin reemplazar
    $html = preg_replace('/<[^>]+>/', ' ', $html); // Elimina el resto de las etiquetas HTML y reemplaza con espacios

    // Elimina espacios múltiples y saltos de línea consecutivos
    $html = preg_replace('/\s+/', ' ', $html);
    $html = preg_replace('/\n+/', "\n", $html);

    return trim($html); // Elimina espacios en blanco al inicio y al final
}

function truncateText($text, $maxLength) {
    if (strlen($text) > $maxLength) {
        return substr($text, 0, $maxLength) . '...'; // Recorta el texto y añade puntos suspensivos
    }
    return $text;
}

function getPreview($html, $maxLength) {
    $text = stripHtmlTags($html); // Elimina las etiquetas HTML y maneja los saltos de línea
    return truncateText($text, $maxLength); // Recorta el texto
}

?>