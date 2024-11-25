<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Encriptar la contraseña antes de insertarla
    $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $contraseñaHash);

    if ($stmt->execute()) {
        header("Location: Login.html"); // Redirigir a la página de usuarios
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


