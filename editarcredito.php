<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Validar si el parámetro 'user_id' existe
    if (isset($_GET['user_id'])) {
        $id = $_GET['user_id'];

        // Obtener el crédito actual del usuario
        $sqlSelect = "SELECT credito FROM Usuarios WHERE id = ?";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bind_param("i", $id);
        $stmtSelect->execute();
        $stmtSelect->bind_result($creditoActual);
        $stmtSelect->fetch();
        $stmtSelect->close();

        // Verificar el crédito y calcular el nuevo crédito
        if ($creditoActual === null) {
            die("El usuario no existe o no tiene crédito asignado.");
        }

        if ($creditoActual == 0) {
            $nuevoCredito = 3000;
        } elseif ($creditoActual >= 3000) {
            $nuevoCredito = $creditoActual + ($creditoActual * 0.30);
        } else {
            die("Condición no válida para el crédito actual.");
        }

        // Actualizar el crédito en la base de datos
        $sqlUpdate = "UPDATE Usuarios SET credito = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("di", $nuevoCredito, $id);

        if ($stmtUpdate->execute()) {
            // Mostrar el mensaje de éxito y redirigir a 1productos.php
            echo "<script>
                    alert('¡Felicidades! Tu crédito ha sido aprobado. Ahora cuentas con $$nuevoCredito.');
                    window.location.href = '1productos.php'; // Redirigir después del mensaje
                  </script>";
        } else {
            echo "Error al actualizar el crédito: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        // Manejar el caso donde 'user_id' no está definido
        die("No se proporcionó el parámetro 'user_id'.");
    }

    $conn->close();
}
?>
