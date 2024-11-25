<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    // Preparar la consulta SQL para actualizar el estatus del usuario a 0
    $sql = "UPDATE Usuarios SET estatus = 0 WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            // Redireccionar a la página de listado de usuarios después de eliminar
            header("Location: 2usuarios.php");
            exit();
        } else {
            echo "Error al eliminar el usuario: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de usuario no proporcionado.";
}
?>
