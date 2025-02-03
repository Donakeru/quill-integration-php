<?php
session_start();

require_once "../database/db.inc.php"; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario y la contraseña hasheada
    $query = "SELECT user_id, name, email, password, role_id, status FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query); // Asumimos que $pdo es tu objeto de conexión a la base de datos
    $stmt->execute([$email]); // Ejecutar la consulta con el email como parámetro
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener los datos del usuario

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Si el usuario y la contraseña son correctos, iniciar sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['name']; // Puedes usar el nombre o el email
        $_SESSION['email'] = $user['email']; // Puedes usar el nombre o el email
        $_SESSION['id'] = $user['user_id'];
        //$_SESSION['role_id'] = $user['role_id'];
        //$_SESSION['status'] = $user['status'];

        echo json_encode(['status' => 'success', 'username' => $user['name'], 'id' => $user['user_id'], 'email' => $user['email']]);
    } else {
        // Si no se encuentra el usuario o la contraseña no es correcta
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
    }
} elseif (isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_unset();
    session_destroy();
    echo json_encode(['status' => 'success']);
}
?>
