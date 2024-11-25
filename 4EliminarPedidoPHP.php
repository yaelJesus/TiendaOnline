<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $idPedido = intval($_GET['id']);

    // Preparar la consulta SQL para actualizar el estatus del pedido a 0
    $sql = "UPDATE pedidos SET estatus = 0 WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $idPedido);
        if ($stmt->execute()) {
            // Redireccionar a la página de listado de pedidos después de eliminar
            header("Location: 3Pedidos.php");
            exit();
        } else {
            echo "Error al eliminar el pedido: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de pedido no proporcionado.";
}
?>
