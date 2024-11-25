<?php
// Configuración de la conexión a la base de datos MySQL
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "tiendaonline"; 
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


?>