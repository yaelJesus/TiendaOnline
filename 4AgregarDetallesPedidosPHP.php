<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_pedido']) && isset($_POST['id_producto']) && isset($_POST['cantidad']) && isset($_POST['precio_unitario'])) {
    $id_pedido = intval($_POST['id_pedido']);
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);
    $precio_unitario = floatval($_POST['precio_unitario']);

    // Incluir el archivo de conexión
    include 'conexion.php';

    // Consulta SQL para insertar el nuevo detalle de pedido
    $sql = "INSERT INTO detallepedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio_unitario);

    if ($stmt->execute()) {
      // Redirigir a la página de detalles del pedido después de agregar el detalle
      header("Location: 4DetallesPedido.php?id=$id_pedido");
    } else {
      echo "Error al agregar el detalle del pedido: " . $conn->error;
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
