<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agregar Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 20px;
      background-color: #f0f8ff; /* Color de fondo azul claro */
    }
    .container {
      max-width: 600px; /* Ancho máximo del contenido para dispositivos móviles */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center">Agregar Pedido</h1>
    <form action="3AgregarPedidosPHP.php" method="post">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <select class="form-select" id="usuario" name="usuario" required>
          <option value="" selected disabled>Seleccionar Usuario</option>
          <?php
          include 'conexion.php';
          $sql = "SELECT id, nombre FROM usuarios WHERE estatus = 1";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
            }
          } else {
            echo "<option>No hay usuarios disponibles</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="fecha_pedido" class="form-label">Fecha de Pedido</label>
        <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" required>
      </div>
      <div class="mb-3">
        <label for="total" class="form-label">Total</label>
        <input type="number" class="form-control" id="total" name="total" step="0.01" required>
      </div>
      <button type="submit" class="btn btn-primary">Agregar Pedido</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
