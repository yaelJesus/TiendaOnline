<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agregar Detalle de Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 20px;
      background-color: #f8f9fa;
    }
    .container {
      max-width: 600px;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center">Agregar Detalle de Pedido</h2>
    <?php
    if (isset($_GET['id_pedido'])) {
      $id_pedido = intval($_GET['id_pedido']);
    ?>
    <form action="4AgregarDetallesPedidosPHP.php" method="POST">
      <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
      <div class="mb-3">
        <label for="id_producto" class="form-label">Producto</label>
        <select name="id_producto" id="id_producto" class="form-select" required>
          <option value="" selected disabled>Seleccionar Producto</option>
          <?php
          include 'conexion.php';
          $sql = "SELECT id, nombre FROM productos WHERE estatus = 1";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
          }
          $conn->close();
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="precio_unitario" class="form-label">Precio Unitario</label>
        <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control" required>
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Agregar</button>
        <a href="detalles_pedido.php?id=<?php echo $id_pedido; ?>" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
    <?php
    } else {
      echo "<p class='text-center'>No se proporcionó un ID de pedido válido.</p>";
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
