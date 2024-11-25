<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se proporcionaron los IDs del Detalle de Pedido y del Pedido
if(isset($_GET['id_detalles']) && isset($_GET['id_pedido'])) {
    // Obtener los IDs del Detalle de Pedido y del Pedido de la URL
    $idDetalle = intval($_GET['id_detalles']);
    $idPedido = intval($_GET['id_pedido']);

    // Preparar la consulta SQL para cambiar el estado del Detalle de Pedido a inactivo
    $sql = "UPDATE detallepedido SET estatus = 0 WHERE idDetalles = $idDetalle";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql) === TRUE) {
        // Redireccionar a la página de detalles del pedido
        header("Location: 4DetallesPedido.php?id=$idPedido");
        exit();
    } else {
        // Mostrar mensaje de error si la consulta falla
        echo "Error al intentar eliminar el Detalle de Pedido: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Mostrar mensaje de error si no se proporcionaron los IDs necesarios
    echo "ID de Detalle de Pedido o ID de Pedido no proporcionado.";
}
?>