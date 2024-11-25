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
    background-color: #1e1e1e;
    color: #ffffff;
    font-family: 'Arial', sans-serif;
  }
  .detalles-container {
    margin-top: 20px;
  }
  .detalles-card {
    background-color: #2a2a2a; 
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .card-title {
    color: #ff6f61; /* Rosa más vibrante */
    font-size: 1.25rem;
    font-weight: bold;
  }
  .card-text, h2, h3 {
    color: #ffffff;
  }
  .card-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }
  table {
    background-color: #333333;
    color: #ffffff;
    border-collapse: collapse;
    width: 100%;
  }
  table th, table td {
    border: 1px solid #444444;
    padding: 10px;
    text-align: left;
  }
  table th {
    background-color: #444444;
    color: #ff6f61;
  }
  .btn-primary, .btn-warning, .btn-danger, .btn-success {
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 0.9rem;
    text-transform: uppercase;
  }
  .btn-primary {
    background-color: #ff6f61;
    border-color: #ff6f61;
  }
  .btn-warning {
    background-color: #fbc02d;
    border-color: #fbc02d;
  }
  .btn-danger {
    background-color: #e53935;
    border-color: #e53935;
  }
  .btn-success {
    background-color: #43a047;
    border-color: #43a047;
  }
  .btn-primary:hover, .btn-warning:hover, .btn-danger:hover, .btn-success:hover {
    opacity: 0.9;
  }
  @media (max-width: 576px) {
    .detalles-card {
      padding: 15px;
    }
    .btn-primary, .btn-warning, .btn-danger, .btn-success {
      width: 100%;
      text-align: center;
    }
  }
</style>

</head>
<body>
  <div class="container">
    <div class="detalles-container">
      <div class="detalles-card">
        <?php
        // Verificar si no hay user_id en la URL
        if (!isset($_GET['user_id'])) {
            echo "<h1 class='text-center'>El carrito de compras está vacío</h1>";
            echo "<p class='text-center' style='font-size: 200px;'><i class='bi bi-cart4'></i></p>";
        } else {
            $user_id = intval($_GET['user_id']);
    
            include 'conexion.php';
    
            $sql_usuario = "SELECT nombre FROM usuarios WHERE id = $user_id LIMIT 1";
            $result_usuario = $conn->query($sql_usuario);
        
            if ($result_usuario->num_rows > 0) {
                $usuario = $result_usuario->fetch_assoc();
                $nombre_usuario = $usuario['nombre'];
    
                $sql_pedido = "SELECT id FROM pedidos WHERE id_usuario = $user_id AND estatus = 1 LIMIT 1";
                $result_pedido = $conn->query($sql_pedido);
    
                if ($result_pedido->num_rows > 0) {
                    $pedido = $result_pedido->fetch_assoc();
                    $id_pedido = $pedido['id'];
    
                    $sql_detalles = "SELECT d.idDetalles, p.nombre AS producto, d.cantidad, d.precio_unitario, p.imagen
                                     FROM detallepedido d 
                                     INNER JOIN productos p ON d.id_producto = p.id 
                                     WHERE d.id_pedido = $id_pedido AND d.estatus = 1";
                    $result_detalles = $conn->query($sql_detalles);
    
                    if ($result_detalles->num_rows > 0) {
                        echo "<h2 class='text-center'>Carrito de Compras de $nombre_usuario</h2>";
                        echo "<div class='d-flex justify-content-end mb-3'>";
                        echo "<a href='4AgregarDetallesPedidos.php?id_pedido=$id_pedido' class='btn btn-primary'>Agregar</a>";
                        echo "</div>";
                        echo "<div class='row'>";
    
                        $total = 0;
                        while ($row = $result_detalles->fetch_assoc()) {
                          echo "<div class='col-12 mb-3'>";
                          echo "<div class='detalles-card'>";
                          
                          echo "<table class='table table-borderless' style='background-color: #464646;'>";  // Añadido el fondo gris a la tabla
                          echo "<tr>";
                          
                          echo "<td style='width: 15%; background-color: #464646;'>";  // Fondo gris en la celda de la imagen
                          echo "<img src='" . $row['imagen'] . "' alt='" . $row['producto'] . "' class='img-fluid' style='max-height: 200px;'>";
                          echo "</td>";
                          
                          echo "<td style='width: 65%; background-color: #464646;'>";  // Fondo gris en la celda de los textos
                          echo "<h5 class='card-title'>" . $row['producto'] . "</h5>";
                          echo "<p class='card-text'>Cantidad: " . $row['cantidad'] . "</p>";
                          echo "<p class='card-text'>Precio Unitario: $" . number_format($row['precio_unitario'], 2) . "</p>";
                          echo "</td>";
                          
                          echo "<td style='width: 20%; text-align: right; background-color: #464646;'>";  // Fondo gris en la celda de los botones
                          echo "<div class='card-footer'>";
                          echo "<a href='4ModificarDetallesPedidos.php?id_detalle=" . $row['idDetalles'] . "&id_pedido=" . $id_pedido . "' class='btn btn-warning btn-sm'>";
                          echo "<i class='bi bi-pencil'></i>";
                          echo "</a> ";
                          echo "<button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' data-id='" . $row['idDetalles'] . "'>";
                          echo "<i class='bi bi-trash'></i>";
                          echo "</button>";
                          echo "</div>";
                          echo "</td>";
                          
                          echo "</tr>";
                          echo "</table>";
                      
                          $total += $row['cantidad'] * $row['precio_unitario'];
                      
                          echo "</div>";
                          echo "</div>";
                      }
                      
                      echo "<div class='text-end mb-3'>";
                      echo "<h3>Total: $" . number_format($total, 2) . "</h3>";
                      echo "</div>";
    
                      echo "<div class='d-flex justify-content-center mb-3'>";
                      echo "<button class='btn btn-success btn-lg' style='width: 50%; padding: 15px;' data-bs-toggle='modal' data-bs-target='#formaPagoModal'>Pagar</button>";
                      echo "</div>";
    
                    } else {
                      echo "<h1 class='text-center'>El carrito de compras está vacío</h1>";
                      echo "<p class='text-center' style='font-size: 200px;'><i class='bi bi-cart4'></i></p>";
                    }
                } else {
                    echo "<p class='text-center'>No se encontró ningún pedido activo para este usuario.</p>";
                }
    
                $conn->close();
            } else {
                echo "<p class='text-center'>No se pudo encontrar el usuario.</p>";
            }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Modal de Selección de Forma de Pago -->
  <div class="modal fade" id="formaPagoModal" tabindex="-1" aria-labelledby="formaPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formaPagoModalLabel">Selecciona la Forma de Pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="datostarjeta.php" method="GET">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="forma_pago" value="tarjeta" id="tarjeta" required>
              <label class="form-check-label" for="tarjeta">Pago con tarjeta</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="forma_pago" value="credito" id="credito" required>
              <label class="form-check-label" for="credito">Pago a crédito</label>
            </div>
            <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Confirmar Pago</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal de confirmación de eliminación -->
  <div class="modal" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de que deseas eliminar este producto del carrito?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="confirmDeleteButton" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script>
    // Script para el modal de confirmación de eliminación
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
