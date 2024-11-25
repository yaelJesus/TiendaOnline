<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Modificar Producto</title>
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
    <h1 class="text-center">Modificar Producto</h1>
    <?php
    include 'conexion.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM Productos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        
        if ($producto) {
            ?>
            <form action="1ModificarProductosPHP.php" method="post">
              <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del Producto</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $producto['descripcion']; ?></textarea>
              </div>
              <div class="mb-3">
                <label for="precio" class="form-label">Precio del Producto</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="stock" class="form-label">Cantidad en Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
              </div>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
            <?php
        } else {
            echo "<p class='text-danger'>Producto no encontrado.</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='text-danger'>ID de producto no especificado.</p>";
    }

    $conn->close();
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
