<?php
// Incluir helper de sesión segura y token único
require_once '../../helpers/token_sesion.php';

// Validar que el usuario es administrador
if ($_SESSION['rol'] !== 'administrador') {
    session_unset();
    session_destroy();
    header('Location: ../logout.php');
    exit;
}

session_regenerate_id(true); // Previene fijación de sesión

$usuario = htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8');

// Seguridad en cabeceras HTML
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Seguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        .navbar-brand {
            font-weight: bold;
        }
        @media (max-width: 576px) {
            .navbar-text {
                display: block;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Administrador</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3 text-white navbar-text">
                    Usuario: <?= $usuario ?>
                </li>
                <li class="nav-item">
                    <a href="../../logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="display-6">124</p>
                    <p class="card-text">Registrados en el sistema</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Pacientes atendidos</h5>
                    <p class="display-6">342</p>
                    <p class="card-text">Total hasta la fecha</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Citas de hoy</h5>
                    <p class="display-6">56</p>
                    <p class="card-text">Programadas para hoy</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <section class="row">
        <div class="col-12">
            <h4>Resumen general</h4>
            <p>Bienvenido al panel de control del administrador. Desde aquí puedes supervisar usuarios, estadísticas, roles y más.</p>
        </div>
    </section>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

</body>
</html>
