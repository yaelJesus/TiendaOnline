<?php
session_start();
require_once "conexion.php"; // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $password = $_POST['contraseña'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($password)) {
        echo json_encode(['error' => 'Por favor, complete todos los campos.']);
        exit;
    }

    // Preparar consulta para buscar al usuario por su nombre
    $stmt = $conn->prepare("SELECT id, nombre, contraseña, estatus FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Asociar el resultado a variables
        $stmt->bind_result($id, $nombreDb, $hashedPassword, $estatus);
        $stmt->fetch();

        // Verificar si el usuario está activo
        if ($estatus != 1) { // Cambié 'activo' por 1 (activo)
            echo json_encode(['error' => 'Tu cuenta está inactiva. Contacta al administrador.']);
            exit;
        }

        // Verificar la contraseña
        if (password_verify($password, $hashedPassword)) {
            // Almacenar datos en la sesión
            $_SESSION['id'] = $id;
            $_SESSION['nombre'] = $nombreDb;
            echo json_encode(['success' => 'Inicio de sesión exitoso.']);
            exit;
        } else {
            echo json_encode(['error' => 'Contraseña incorrecta.']);
            exit;
        }
    } else {
        echo json_encode(['error' => 'El usuario no existe.']);
        exit;
    }

    $stmt->close();
}

$conn->close();
?>

