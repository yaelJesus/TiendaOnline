<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agregar Producto</title>
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
    <h1 class="text-center">Agregar Producto</h1>
    <form action="1AgregarProductosPHP.php" method="post">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción del Producto</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="precio" class="form-label">Precio del Producto</label>
        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="stock" class="form-label">Cantidad en Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" required>
      </div>
      <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
