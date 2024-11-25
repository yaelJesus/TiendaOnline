<?php
include 'conexion.php';

$usuario_id = $_POST['usuario'];
$fecha_pedido = $_POST['fecha_pedido'];
$total = $_POST['total'];

$sql = "INSERT INTO pedidos (id_usuario, fecha_pedido, total) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isd", $usuario_id, $fecha_pedido, $total);

if ($stmt->execute()) {
    header("Location: 3pedidos.php"); // Redirigir a la página de usuarios
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
