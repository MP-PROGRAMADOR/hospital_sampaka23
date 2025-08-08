<?php
if(session_status() == PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    echo json_encode(['authenticated' => true, 'usuario' => $_SESSION['usuario']]);
} else {
    echo json_encode(['authenticated' => false]);
}
