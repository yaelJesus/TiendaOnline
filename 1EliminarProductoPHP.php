<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $idProducto = intval($_GET['id']);

    // Preparar la consulta SQL para actualizar el estatus del producto a 0
    $sql = "UPDATE productos SET estatus = 0 WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idProducto);
        if ($stmt->execute()) {
            // Redireccionar a la página de listado de productos después de eliminar
            header("Location: 1productos.php");
            exit();
        } else {
            echo "Error al eliminar el producto: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de producto no proporcionado.";
}
?>
