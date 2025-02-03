<?php

// Conectar a la base de datos
require_once __DIR__ . '/../database/db.inc.php';

// Función para validar parámetros numéricos
function validate_int_param($param, $default = 0) {
    return (isset($param) && filter_var($param, FILTER_VALIDATE_INT) !== false) ? (int)$param : $default;
}

// Función para obtener el total de registros sin filtros
function get_total_records($pdo, $table, $user_id) {
    $query = "SELECT COUNT(*) FROM $table WHERE user_id = :user_id AND status != :status";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':status', 'eliminado', PDO::PARAM_STR); // Excluir 'eliminado'
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Función para obtener el total de registros con filtros
function get_filtered_records($pdo, $table, $search, $category, $user_id) {
    $query = "SELECT COUNT(*) FROM $table WHERE title LIKE :search AND user_id = :user_id AND status != :status";
    if ($category) {
        $query .= " AND category_id = :category";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':status', 'eliminado', PDO::PARAM_STR); // Excluir 'eliminado'
    if ($category) {
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Función para obtener los datos paginados con ordenamiento
function get_posts($pdo, $table, $start, $length, $search, $category, $order_by, $order_dir, $user_id) {
    $query = "SELECT post_id, title, DATE(created_at) AS created_at_formatted, preview, status FROM $table WHERE title LIKE :search AND user_id = :user_id AND status != :status";

    if ($category) {
        $query .= " AND category_id = :category";
    }

    $query .= " ORDER BY $order_by $order_dir";  // Agregar ordenamiento dinámico
    $query .= " LIMIT :start, :length";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':status', 'eliminado', PDO::PARAM_STR); // Excluir 'eliminado'
    if ($category) {
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    }
    $stmt->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt->bindValue(':length', $length, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    // Parámetros enviados por DataTables
    $draw = validate_int_param($_POST['draw'], 1);
    $start = validate_int_param($_POST['start'], 0);
    $length = validate_int_param($_POST['length'], 10);
    $search = trim($_POST['search']['value'] ?? '');
    $category = validate_int_param($_POST['category'] ?? null);
    $user_id = validate_int_param($_POST['user_id']);  // Usuario obligatorio

    // Validar que el parámetro user_id esté presente
    if (!$user_id) {
        echo json_encode(["error" => "El parámetro user_id es obligatorio."]);
        exit;
    }

    // Validar ordenamiento
    $order_column_index = isset($_POST['order'][0]['column']) ? (int) $_POST['order'][0]['column'] : 2;
    $order_dir = isset($_POST['order'][0]['dir']) && $_POST['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';

    // Mapeo de índices de columna a nombres de columnas en la base de datos
    $order_columns = ["post_id", "title", "created_at", "preview"];
    $order_by = $order_columns[$order_column_index] ?? "created_at_formatted"; // Orden por defecto si el índice no es válido

    $table = "posts";

    // Obtener el total de registros sin filtros
    $total_records = get_total_records($pdo, $table, $user_id);

    // Obtener el total de registros filtrados
    $filtered_records = get_filtered_records($pdo, $table, $search, $category, $user_id);

    // Obtener los posts con filtros, paginación y ordenamiento
    $data = get_posts($pdo, $table, $start, $length, $search, $category, $order_by, $order_dir, $user_id);

    // Enviar respuesta en formato JSON compatible con DataTables
    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $total_records,
        "recordsFiltered" => $filtered_records,
        "data" => $data
    ]);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(["error" => "An error occurred, please try again later."]);
}
?>