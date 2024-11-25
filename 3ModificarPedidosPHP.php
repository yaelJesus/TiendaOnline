<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_pedido = $_POST['id_pedido'];
  $fecha_pedido = $_POST['fecha_pedido'];
  $total = $_POST['total'];

  $sql = "UPDATE pedidos SET fecha_pedido=?, total=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sdi", $fecha_pedido, $total, $id_pedido);

  if ($stmt->execute()) {
    header("Location: 3pedidos.php"); // Redirigir a la página de usuarios
    exit();
} else {
    echo "Error: " . $stmt->error;
}

  $stmt->close();
  $conn->close(); // Cerrar la conexión a la base de datos
}
?>

