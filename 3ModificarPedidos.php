<<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Modificar Pedido</title>
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
    <h1 class="text-center">Modificar Pedido</h1>
    <?php
    include 'conexion.php';

    // Verificar si se proporcionó un ID de pedido válido
    if(isset($_GET['id']) && !empty($_GET['id'])) {
      $id_pedido = $_GET['id'];

      // Consulta SQL para obtener la información del pedido
      $sql = "SELECT p.id, p.fecha_pedido, p.total, p.id_usuario 
              FROM pedidos p
              WHERE p.id = $id_pedido"; 

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $pedido = $result->fetch_assoc(); // Obtener los datos del pedido

        // Convertir la fecha del formato Y-m-d al formato correcto
        $fecha_pedido_formato = date('Y-m-d', strtotime($pedido['fecha_pedido']));
        ?>
        <form action="3ModificarPedidosPHP.php" method="post">
          <input type="hidden" name="id_pedido" value="<?= $pedido['id'] ?>">
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <select class="form-select" id="usuario" name="usuario" required>
              <option value="" selected disabled>Seleccionar Usuario</option>
              <?php
              $sql_usuarios = "SELECT id, nombre FROM usuarios WHERE estatus = 1";
              $result_usuarios = $conn->query($sql_usuarios);
              if ($result_usuarios->num_rows > 0) {
                while ($row_usuario = $result_usuarios->fetch_assoc()) {
                  $selected = ($row_usuario['id'] == $pedido['id_usuario']) ? 'selected' : '';
                  ?>
                  <option value="<?= $row_usuario['id'] ?>" <?= $selected ?>><?= $row_usuario['nombre'] ?></option>
                  <?php
                }
              } else {
                ?>
                <option>No hay usuarios disponibles</option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha_pedido" class="form-label">Fecha de Pedido</label>
            <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" value="<?= $fecha_pedido_formato ?>" required>
          </div>
          <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" class="form-control" id="total" name="total" step="0.01" value="<?= $pedido['total'] ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <?php
      } else {
        echo "<p>No se encontró el pedido.</p>";
      }
    } else {
      echo "<p>ID de pedido no válido.</p>";
    }
    $conn->close();
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
