<?php
// Obtener los valores de los parámetros enviados por GET.
$forma_pago = isset($_GET['forma_pago']) ? $_GET['forma_pago'] : ''; 
$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';

// Conectar a la base de datos
include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Obtener los datos del formulario
$monto = $_POST['monto'];
$id_pedido = $_POST['id_pedido'];

// Obtener la fecha actual (para el pago)
$fecha_pago = date('Y-m-d');  // Esto devuelve la fecha en formato 'YYYY-MM-DD'
$fecha_vencida = date('Y-m-d');

// Registrar el pago en la tabla 'pagos'
$sql = "INSERT INTO pagos (id_pedido, monto, fecha_pago, fecha_vencimiento, estado) 
        VALUES ('$id_pedido', '$monto', '$fecha_pago', '$fecha_vencida', 'pagado')";

if ($conn->query($sql) === TRUE) {
    // Actualizar los detalles de los pedidos para cambiar el estatus a 0 (vacío)
    $update_sql = "UPDATE Detallepedido SET estatus = 0 WHERE id_pedido = '$id_pedido'";

    if ($conn->query($update_sql) === TRUE) {
        // Mostrar mensaje de éxito y redirigir al carrito
        echo "<script>alert('Pago realizado exitosamente'); window.location.href='VerCarrito.php';</script>";
    } else {
        echo "Error al actualizar el estatus de los detalles de pedido: " . $conn->error;
    }
} else {
    echo "Error al registrar el pago: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

