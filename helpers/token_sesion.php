<?php
// helpers/token_sesion.php

// Inicia sesión segura si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict'
    ]);
}

// Validación mínima de sesión iniciada
if (!isset($_SESSION['usuario'], $_SESSION['id_usuario'], $_SESSION['token_sesion'])) {
    session_unset();
    session_destroy();
    header('Location: ../logout.php');
    exit;
}

// Verifica inactividad (timeout de sesión)
$timeout = 900; // 15 minutos
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: ../logout.php?timeout=true');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

require_once  'api/conexion.php'; // Ajusta ruta si es necesario

// Verifica el token contra la BD
$stmt = $pdo->prepare("SELECT token_sesion FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['id_usuario']]);
$dbToken = $stmt->fetchColumn();

if (!$dbToken || !hash_equals($_SESSION['token_sesion'], $dbToken)) {
    session_unset();
    session_destroy();
    header('Location: ../logout.php?sesion_multiple=true');
    exit;
}
?>
