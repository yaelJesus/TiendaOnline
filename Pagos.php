<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e; /* Fondo oscuro */
            color: #ffffff;
            display: flex;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #C12847; /* Rosa intenso */
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            max-width: 1000px;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #2c2c2c; /* Fondo de la tabla */
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #C12847; /* Rosa intenso */
        }

        thead th {
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        tbody tr:nth-child(odd) {
            background-color: #333; /* Fila impar */
        }

        tbody tr:nth-child(even) {
            background-color: #2c2c2c; /* Fila par */
        }

        tbody tr:hover {
            background-color: #ababab; /* Rosa al pasar el mouse */
            color: #1e1e1e;
        }

        tbody td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444;
        }

        tbody td:last-child {
            text-align: center;
        }

        .message {
            color: #ff69b4;
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Pagos del Usuario</h1>
    <?php
    include 'conexion.php';

    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);

        // Buscar el pedido asociado al usuario
        $sql_pedido = "SELECT id FROM pedidos WHERE id_usuario = $user_id AND estatus = 1 LIMIT 1";
        $result_pedido = $conn->query($sql_pedido);

        if ($result_pedido->num_rows > 0) {
            $pedido = $result_pedido->fetch_assoc();
            $id_pedido = $pedido['id'];

            // Buscar los pagos relacionados con el pedido
            $sql_pagos = "SELECT id_pago, monto, fecha_pago, fecha_vencimiento, estado 
                          FROM pagos 
                          WHERE id_pedido = $id_pedido";
            $result_pagos = $conn->query($sql_pagos);

            if ($result_pagos->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID Pago</th>";
                echo "<th>Monto</th>";
                echo "<th>Fecha de Pago</th>";
                echo "<th>Fecha de Vencimiento</th>";
                echo "<th>Estado</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = $result_pagos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_pago'] . "</td>";
                    echo "<td>$" . number_format($row['monto'], 2) . "</td>";
                    echo "<td>" . $row['fecha_pago'] . "</td>";
                    echo "<td>" . $row['fecha_vencimiento'] . "</td>";
                    echo "<td>" . $row['estado'] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='message'>No hay pagos registrados para este pedido.</p>";
            }
        } else {
            echo "<p class='message'>No se encontró ningún pedido activo para este usuario.</p>";
        }
    } else {
        echo "<p class='message'>No se proporcionó un ID de usuario.</p>";
    }

    $conn->close();
    ?>
</body>
</html>


