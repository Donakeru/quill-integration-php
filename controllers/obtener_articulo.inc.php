<?php
require_once __DIR__ . '/../database/db.inc.php';

header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["error" => "ID inválido"]);
    exit;
}

$post_id = $_GET['id'];
$status = 'eliminado'; // El valor que se debe excluir
$query = "SELECT * FROM posts WHERE post_id = :post_id AND status != :status";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if ($article) {
    echo json_encode($article);
} else {
    echo json_encode(["error" => "Artículo no encontrado o eliminado"]);
}
exit;
?>