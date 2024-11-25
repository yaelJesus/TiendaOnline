<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Prepara la consulta SQL para actualizar el producto
    $sql = "UPDATE Productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Redirige a 1Productos.php si la actualización fue exitosa
        header("Location: 1Productos.php");
        exit();
    } else {
        // Muestra un mensaje de error si la actualización falló
        echo "Error: " . $stmt->error;
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
