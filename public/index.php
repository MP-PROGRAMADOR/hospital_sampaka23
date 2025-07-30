<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Definir páginas públicas y permisos por rol
$publicas = ['login', 'registro'];
$roles_permisos = [
    'admin' => ['home','usuarios','pacientes'],
    'doctor' => ['home','pacientes'],
    'recepcion' => ['home']
];

//  Obtener URL y segmento de la página
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segmentos = explode('/', $uri);
$pagina = $segmentos[2] ?? 'home'; // porque la estructura es /hospital_sampaka23/public/{pagina}

//  Bloquear acceso si alguien intenta forzar entrada a /views/ u otras carpetas internas
if (strpos($uri, 'views') !== false || strpos($uri, 'includes') !== false) {
    include __DIR__ . '/views/404.php';
    exit;
}

//  Verificar si el usuario está logueado para páginas privadas
if (!isset($_SESSION['usuario']) && !in_array($pagina, $publicas)) {
    header("Location: /hospital_sampaka23/public/login");
    exit;
}

//  Verificar permisos por rol
if (isset($_SESSION['rol']) && isset($roles_permisos[$_SESSION['rol']])) {
    if (!in_array($pagina, $roles_permisos[$_SESSION['rol']])) {
        $pagina = '403';
    }
}

//  Cargar la vista correspondiente
$ruta = __DIR__ . "/views/{$pagina}.php";
if (file_exists($ruta)) {
    include $ruta;
} else {
    include __DIR__ . "/views/404.php";
}






 