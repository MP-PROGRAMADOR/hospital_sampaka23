<?php
// Seguridad básica en cabeceras
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

ini_set('display_errors', 0); // Nunca mostrar errores en producción
error_reporting(0);

// Inicia sesión segura
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Strict'
    ]);
}

// Timeout de sesión (15 min)
$timeout = 900;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

include_once 'conexion.php';

// Sanitización de entrada
$usuario = htmlspecialchars(trim($_POST['usuario'] ?? ''), ENT_QUOTES, 'UTF-8');
$clave = trim($_POST['contrasena'] ?? '');

if (empty($usuario) || empty($clave)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

// Consulta segura
$sql = "SELECT u.id, u.nombre_usuario, u.password, r.nombre AS rol, u.id_rol
        FROM usuarios u
        JOIN roles r ON u.id_rol = r.id
        WHERE u.nombre_usuario = :usuario
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario' => $usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificación de credenciales
if ($user && password_verify($clave, $user['password'])) {
    session_regenerate_id(true); // Previene fijación de sesión

    // 🔐 Generar token único para esta sesión
    $tokenSesion = bin2hex(random_bytes(32));
    $_SESSION['token_sesion'] = $tokenSesion;

    // Guardar token en BD
    $stmt = $pdo->prepare("UPDATE usuarios SET token_sesion = :token, ultimo_inicio_sesion = NOW() WHERE id = :id");
    $stmt->execute([
        'token' => $tokenSesion,
        'id' => $user['id']
    ]);

    // Guardar datos de sesión
    $_SESSION['usuario'] = $user['nombre_usuario'];
    $_SESSION['id_usuario'] = $user['id'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['id_rol'] = $user['id_rol'];

    // Rutas por rol
    $rol = strtolower($user['rol']);
    $rutas = [
        'administrador' => 'views/admin',
        'triaje' => 'views/triaje',
        'doctor' => 'views/doctor',
        'medicina_interna' => 'views/medicina_interna',
        'laboratorio' => 'views/laboratorio'
    ];

    if (isset($rutas[$rol])) {
        echo json_encode(['success' => true, 'ruta' => $rutas[$rol]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Rol no reconocido']);
    }

} else {
    // Retraso para mitigar ataques de fuerza bruta
    usleep(500000);
    echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
}
?>
