<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Inicia la conexión y prepara la consulta
    $sql = "INSERT INTO Productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Redirige a 1Productos.php si la inserción fue exitosa
        header("Location: 1Productos.php");
        exit();
    } else {
        // Muestra un mensaje de error si la inserción falló
        echo "Error: " . $stmt->error;
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
