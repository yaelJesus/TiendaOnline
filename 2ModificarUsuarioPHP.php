<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    $sql = "UPDATE Usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $email, $contraseña, $id);

    if ($stmt->execute()) {
        header("Location: 2usuarios.php"); // Redirigir a la página de usuarios
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
