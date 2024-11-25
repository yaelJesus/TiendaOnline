<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Modificar Detalle de Pedido</title>
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
    <h2 class="text-center">Modificar Detalle de Pedido</h2>
    <?php
    if (isset($_GET['id_detalle']) && isset($_GET['id_pedido'])) {
      $id_detalle = intval($_GET['id_detalle']);
      $id_pedido = intval($_GET['id_pedido']);

      // Incluir el archivo de conexión
      include 'conexion.php';

      // Consulta SQL para obtener los datos del detalle
      $sql = "SELECT d.idDetalles, d.id_producto, d.cantidad, d.precio_unitario 
              FROM detallepedido d 
              WHERE d.idDetalles = $id_detalle";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_producto_seleccionado = $row['id_producto'];
    ?>
    <form action="4ModificarDetallesPedidosPHP.php" method="POST">
      <input type="hidden" name="id_detalle" value="<?php echo $id_detalle; ?>">
      <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
      <div class="mb-3">
        <label for="id_producto" class="form-label">Producto</label>
        <select name="id_producto" id="id_producto" class="form-select" required>
          <option value="" disabled>Seleccionar Producto</option>
          <?php
          // Consulta SQL para obtener los productos activos
          $sql_productos = "SELECT id, nombre FROM productos WHERE estatus = 1";
          $result_productos = $conn->query($sql_productos);
          while ($row_producto = $result_productos->fetch_assoc()) {
            $selected = ($row_producto['id'] == $id_producto_seleccionado) ? "selected" : "";
            echo "<option value='" . $row_producto['id'] . "' $selected>" . $row_producto['nombre'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?php echo $row['cantidad']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="precio_unitario" class="form-label">Precio Unitario</label>
        <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control" value="<?php echo $row['precio_unitario']; ?>" required>
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="detalles_pedido.php?id=<?php echo $id_pedido; ?>" class="btn btn-secondary ms-2">Cancelar</a>
      </div>
    </form>
    <?php
      } else {
        echo "<p class='text-center'>No se encontró el detalle de pedido.</p>";
      }

      // Cerrar la conexión a la base de datos
      $conn->close();
    } else {
      echo "<p class='text-center'>No se proporcionó un ID de detalle o un ID de pedido válido.</p>";
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
