<?php
include 'conexion.php';

$usuario_id = intval($_GET['user_id']); // ID del usuario enviado por GET
$id_producto = intval($_GET['id_producto']); // ID del producto enviado por GET
$fecha_pedido = date('Y-m-d'); // Fecha actual
$total = 0; // Inicializamos el total en 0

// Verificar si el producto existe y tiene stock disponible
$sql_producto = "SELECT nombre, precio, stock FROM productos WHERE id = ? AND estatus = 1 LIMIT 1";
$stmt_producto = $conn->prepare($sql_producto);
$stmt_producto->bind_param("i", $id_producto);
$stmt_producto->execute();
$result_producto = $stmt_producto->get_result();

if ($result_producto->num_rows > 0) {
    $producto = $result_producto->fetch_assoc();

    if ($producto['stock'] > 0) {
        // Verificar si el usuario ya tiene un pedido activo (estatus = 1)
        $sql_check = "SELECT id FROM pedidos WHERE id_usuario = ? AND estatus = 1 LIMIT 1";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $usuario_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Si el usuario ya tiene un pedido activo, obtenemos su ID
            $pedido = $result_check->fetch_assoc();
            $pedido_id = $pedido['id'];
        } else {
            // Si no tiene un pedido activo, creamos uno nuevo con estatus 1 (activo)
            $sql_insert_pedido = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, estatus) VALUES (?, ?, ?, 1)";
            $stmt_insert_pedido = $conn->prepare($sql_insert_pedido);
            $stmt_insert_pedido->bind_param("isd", $usuario_id, $fecha_pedido, $total);

            if ($stmt_insert_pedido->execute()) {
                $pedido_id = $stmt_insert_pedido->insert_id; // ID del nuevo pedido
            } else {
                echo "Error al crear el pedido: " . $stmt_insert_pedido->error;
                exit;
            }
            $stmt_insert_pedido->close();
        }

        // Añadir el producto al pedido (tabla detallepedido)
        $sql_insert_detalle = "INSERT INTO detallepedido (id_pedido, id_producto, cantidad, precio_unitario) 
                               VALUES (?, ?, 1, ?)";
        $stmt_insert_detalle = $conn->prepare($sql_insert_detalle);
        $stmt_insert_detalle->bind_param("iid", $pedido_id, $id_producto, $producto['precio']);

        if ($stmt_insert_detalle->execute()) {
            // Redirigir directamente a la página de detalles del pedido, sin mensaje de éxito
            header("Location: 4DetallesPedido.php?id_pedido=" . $pedido_id);
            exit;
        } else {
            echo "Error al añadir el producto al pedido: " . $stmt_insert_detalle->error;
        }
        $stmt_insert_detalle->close();
    } else {
        // Si no hay stock
        header("Location: productos.php");
        exit;
    }
} else {
    // Si el producto no existe
    header("Location: productos.php");
    exit;
}

$stmt_producto->close();
$conn->close();
?>



