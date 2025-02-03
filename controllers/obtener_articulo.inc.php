<?php
require_once __DIR__ . '/../database/db.inc.php';

header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["error" => "ID inválido"]);
    exit;
}

$post_id = $_GET['id'];
$query = "SELECT * FROM posts WHERE post_id = :post_id";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if ($article) {
    echo json_encode($article);
} else {
    echo json_encode(["error" => "Artículo no encontrado"]);
}
exit;
?>
