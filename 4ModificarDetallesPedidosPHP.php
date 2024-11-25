<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_detalle']) && isset($_POST['id_pedido']) && isset($_POST['cantidad']) && isset($_POST['precio_unitario'])) {
    $id_detalle = intval($_POST['id_detalle']);
    $id_pedido = intval($_POST['id_pedido']);
    $cantidad = intval($_POST['cantidad']);
    $precio_unitario = floatval($_POST['precio_unitario']);

    // Incluir el archivo de conexión
    include 'conexion.php';

    // Consulta SQL para actualizar el detalle de pedido
    $sql = "UPDATE detallepedido SET cantidad = ?, precio_unitario = ? WHERE idDetalles = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $cantidad, $precio_unitario, $id_detalle);

    if ($stmt->execute()) {
      // Redirigir a la página de detalles del pedido después de modificar el detalle
      header("Location: 4DetallesPedido.php?id=$id_pedido");
      exit(); // Asegura que el script se detenga después de la redirección
    } else {
      echo "Error al modificar el detalle del pedido: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
  } else {
    echo "Datos incompletos. Por favor, vuelva a intentarlo.";
  }
} else {
  echo "Método no permitido.";
}
?>
