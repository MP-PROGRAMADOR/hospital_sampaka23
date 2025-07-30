<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Conexión PDO (ajusta tus datos)
header('conexion.php');

// Detectar método real vía _method para simular PUT y DELETE en POST
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}


// Leer input para POST y PUT
$input = [];

// Si Content-Type es JSON
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

if (strpos($contentType, 'application/json') !== false) {
    $input = json_decode(file_get_contents('php://input'), true);
} elseif (strpos($contentType, 'multipart/form-data') !== false) {
    // Para form-data viene en $_POST
    $input = $_POST;
} else {
    // Por si llega vacío o diferente tipo, usar $_POST por defecto
    $input = $_POST;
}

// Leer datos de entrada
$input = $_POST;

// Para PUT/DELETE enviados con JSON raw (opcional, si usas JSON)
// if (in_array($method, ['PUT', 'DELETE'])) {
//     $input = json_decode(file_get_contents('php://input'), true);
// }

switch ($method) {
    case 'GET':
        // Opcional: si quieres permitir GET (requiere ajustes en fetch)
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;

    case 'POST':  // Crear rol
        if (empty(trim($input['nombre'] ?? ''))) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre es obligatorio']);
            break;
        }
        $nombre = trim($input['nombre']);
        $stmt = $pdo->prepare("INSERT INTO roles (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
        $idNuevo = $pdo->lastInsertId();
        http_response_code(201);
        echo json_encode(['id' => $idNuevo, 'nombre' => $nombre]);
        break;

    case 'PUT':   // Editar rol
        if (empty(trim($input['id'] ?? '')) || empty(trim($input['nombre'] ?? ''))) {
            http_response_code(400);
            echo json_encode(['error' => 'ID y nombre son obligatorios']);
            break;
        }
        $id = intval($input['id']);
        $nombre = trim($input['nombre']);
        $stmt = $pdo->prepare("SELECT id FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Rol no encontrado']);
            break;
        }
        $stmt = $pdo->prepare("UPDATE roles SET nombre = ? WHERE id = ?");
        $stmt->execute([$nombre, $id]);
        echo json_encode(['id' => $id, 'nombre' => $nombre]);
        break;

    case 'DELETE': // Eliminar rol
        if (empty(trim($input['id'] ?? ''))) {
            http_response_code(400);
            echo json_encode(['error' => 'ID es obligatorio']);
            break;
        }
        $id = intval($input['id']);
        $stmt = $pdo->prepare("SELECT id FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(['error' => 'Rol no encontrado']);
            break;
        }
        $stmt = $pdo->prepare("DELETE FROM roles WHERE id = ?");
        $stmt->execute([$id]);
        http_response_code(204); // Sin contenido
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
