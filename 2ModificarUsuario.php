<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Modificar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 20px;
      background-color: #f0f8ff; /* Fondo azul claro */
    }
    .container {
      max-width: 600px; /* Ancho máximo del contenido para dispositivos móviles */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center">Modificar Usuario</h1>
    <?php
    include 'conexion.php';
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM Usuarios WHERE id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <form action="2ModificarUsuarioPHP.php" method="post">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" value="<?php echo $row['contraseña']; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Modificar Usuario</button>
    </form>
    <?php
      } else {
        echo "<div class='alert alert-danger' role='alert'>Usuario no encontrado.</div>";
      }
      $stmt->close();
      $conn->close();
    } else {
      echo "<div class='alert alert-danger' role='alert'>ID de usuario no proporcionado.</div>";
    }
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
