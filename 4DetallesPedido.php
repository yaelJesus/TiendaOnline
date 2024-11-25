   <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Detalles de Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body {
      padding: 20px;
      background-color: #1e1e1e; /* Fondo oscuro */
      color: #ffffff; /* Texto blanco */
    }
    .detalles-container {
      margin-top: 20px;
    }
    .detalles-card {
      background-color: #2a2a2a; /* Gris más claro para las tarjetas */
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .table {
      background-color: #464646; /* Fondo gris para la tabla */
      color: #ffffff; /* Texto blanco */
    }
    .table th, .table td {
      border-color: #444444; /* Bordes gris oscuro */
    }
    h2, h3 {
      color: #C12847; /* Rosa para los títulos */
    }
    @media (max-width: 576px) {
      .detalles-card {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="detalles-container">
      <div class="detalles-card">
        <?php
        if (isset($_GET['id_pedido'])) {
          $id_pedido = intval($_GET['id_pedido']);
          include 'conexion.php';

          $sql = "SELECT d.idDetalles, p.nombre AS producto, d.cantidad, d.precio_unitario 
                  FROM detallepedido d 
                  INNER JOIN productos p ON d.id_producto = p.id 
                  WHERE d.id_pedido = $id_pedido AND d.estatus = 1";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            echo "<h2 class='text-center'>Detalles del Pedido #$id_pedido</h2>";
            echo "<div class='d-flex justify-content-end mb-3'>";
            echo "<a href='4AgregarDetallesPedidos.php?id_pedido=$id_pedido' class='btn btn-primary'>Agregar</a>";
            echo "</div>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-borderless'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID Detalle</th>";
            echo "<th>Producto</th>";
            echo "<th>Cantidad</th>";
            echo "<th>Precio Unitario</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['idDetalles'] . "</td>";
              echo "<td>" . $row['producto'] . "</td>";
              echo "<td>" . $row['cantidad'] . "</td>";
              echo "<td>$" . number_format($row['precio_unitario'], 2) . "</td>";
              echo "<td>";
              echo "<a href='4ModificarDetallesPedidos.php?id_detalle=" . $row['idDetalles'] . "&id_pedido=$id_pedido' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a> ";
              echo "<button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' data-id='" . $row['idDetalles'] . "'><i class='bi bi-trash'></i></button>";
              echo "</td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
          } else {
            echo "<h1 class='text-center'>No se encontraron detalles para este pedido</h1>";
            echo "<p class='text-center' style='font-size: 200px;'><i class='bi bi-cart4'></i></p>";
          }
          $conn->close();
        } else {
          echo "<p class='text-center'>No se proporcionó un ID de pedido</p>";
        }
        ?>
      </div>
    </div>
  </div>

  <div class="modal" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar este producto del pedido?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="confirmDeleteButton" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var deleteButtons = document.querySelectorAll('button[data-bs-toggle="modal"]');
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var detalleId = this.getAttribute('data-id');
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.setAttribute('href', 'eliminar_producto.php?id=' + detalleId);
      });
    });
  </script>
</body>
</html>
