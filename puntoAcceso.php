<?php
header('Content-Type: application/json');
require 'api/conexion.php'; // tu conexión PDO

$modo = $_GET['modo'] ?? 'verificar';

try {
    if ($modo === 'verificar') {
        // MODO VERIFICACIÓN: ¿Ya hay usuarios?
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        $count = $stmt->fetchColumn();

        echo json_encode([
            'success' => true,
            'existe' => $count > 0,
            'message' => $count > 0 ? 'Ya existen usuarios' : 'No hay usuarios registrados'
        ]);
        exit;
    }

    if ($modo === 'crear') {
        // MODO CREACIÓN: Crear usuario administrador si no existe

        $nombre_usuario = 'salvador';
        $contrasena = '123456';
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $rol = 'administrador';

        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);
        if ($stmt->fetch()) {
            echo json_encode([
                'success' => false,
                'message' => 'El usuario ya existe'
            ]);
            exit;
        }

        // Insertar en 'personal'
        $stmt = $pdo->prepare("INSERT INTO personal (nombre, apellidos, fecha_nacimiento, direccion, correo, telefono, especialidad, codigo) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            'salvador', 'Mete', '1985-05-12', 'Bar-Estadio, Malabo', 'salvadorMete@example.com',
            '222414141', 'informatico', 'PSHS-001'
        ]);
        $id_personal = $pdo->lastInsertId();

        // Obtener o crear rol
        $stmt = $pdo->prepare("SELECT id FROM roles WHERE nombre = ?");
        $stmt->execute([$rol]);
        $id_rol = $stmt->fetchColumn();

        if (!$id_rol) {
            $pdo->prepare("INSERT INTO roles (nombre) VALUES (?)")->execute([$rol]);
            $id_rol = $pdo->lastInsertId();
        }

        // Insertar en usuarios
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, password, id_personal, id_rol)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre_usuario, $hash, $id_personal, $id_rol]);

        echo json_encode([
            'success' => true,
            'message' => 'Usuario administrador creado correctamente. usuario: '.$nombre_usuario.' contraseña: 123456'
        ]);
        exit;
    }

    // Modo inválido
    echo json_encode([
        'success' => false,
        'message' => 'Modo inválido'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
