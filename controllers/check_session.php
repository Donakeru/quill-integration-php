<?php
session_start();
echo json_encode(['isLoggedIn' => isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true, 'username' => isset($_SESSION['username']) ? $_SESSION['username'] : null, 'id' => isset($_SESSION['id']) ? $_SESSION['id'] : null, 'email' => isset($_SESSION['email']) ? $_SESSION['email'] : null]);

?>