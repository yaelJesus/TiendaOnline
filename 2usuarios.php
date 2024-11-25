<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      padding: 20px;
      background-color: #f0f8ff; /* Fondo azul claro */
    }
    .table-container {
      margin-top: 20px;
    }
    .table-custom thead th {
      background-color: #007bff; /* Fondo azul para encabezados de tabla */
      color: white; /* Texto blanco */
    }
    .table-custom tbody td {
      background-color: #e7f3ff; /* Fondo azul claro para celdas de tabla */
      text-align: center; /* Centrar el texto */
    }
    .barra-tabla {
      background-color: #007bff; /* Fondo azul para la barra de tabla */
      color: white; /* Texto blanco */
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="barra-tabla">
      <h1 class="text-center">Usuarios</h1>
      <a href="2AgregarUsuario.php" class="btn btn-light">Agregar Usuario</a>
    </div>
    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-striped table-custom">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'conexion.php';

            $sql = "SELECT id, nombre, email FROM Usuarios WHERE estatus = 1";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>";
                echo "<a href='2ModificarUsuario.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'><i class='fas fa-pencil-alt'></i></a> ";
                echo "<button type='button' class='btn btn-danger btn-sm' onclick='openConfirmModal(" . $row['id'] . ")'><i class='fas fa-trash'></i></button>";
                echo "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='3'>No se encontraron usuarios</td></tr>";
            }
            $conn->close();
            ?>
          </tbody>
        </table>
      </div>
    </div>  
  </div>

  <!-- Modal de confirmación -->
  <div class="modal" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que quieres eliminar este usuario?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a id="deleteUserLink" href="#" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openConfirmModal(idUsuario) {
      var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
      var url = '2EliminarUsuarioPHP.php?id=' + idUsuario;
      document.getElementById('deleteUserLink').setAttribute('href', url);
      confirmModal.show();
    }
  </script>
</body>
</html>

