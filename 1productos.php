<?php
session_start(); // Inicia la sesión para acceder a la variable de sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      padding: 20px;
      background-color: #1e1e1e; /* Fondo negro */
      color: #f06292; /* Texto rosa */
    }
    .barra-productos {
      background-color: #424242; /* Fondo gris oscuro */
      color: #f06292; /* Texto rosa */
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .card {
      background-color: #818181; /* Fondo gris oscuro */
      color: #000000; /* Texto rosa */
      border: 1px solid #f06292; /* Borde rosa */
      border-radius: 10px;
    }
    .card .btn {
      font-size: 0.9rem;
    }
    .card .btn-warning {
      color: #fff;
    }
    .card:hover {
      transform: scale(1.05); /* Pequeño efecto de zoom */
      transition: 0.3s ease-in-out;
    }
    /* Define una clase personalizada para las imágenes */
  .custom-img {
    width: 100%;          /* Ocupa el ancho completo del contenedor */
    height: 200px;        /* Fija una altura estándar */
    object-fit: cover;    /* Recorta la imagen si es necesario, manteniendo proporciones */
  }

  /* Para adaptar dinámicamente el tamaño al alto de la pantalla */
  @media (min-width: 768px) {
    .custom-img {
      height: 250px;      /* Altura mayor en pantallas más grandes */
    }
  }
  </style>
</head>
<body>
  
    <div class="barra-productos">
      <h1 class="text-center">Productos</h1>
      <!-- Mostrar nombre y ID del usuario si está autenticado -->
      <div class="text-center">
        <?php if (isset($_SESSION['id'])): ?>
          <p><strong>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']); ?>!</strong></p>
          <p>ID de Usuario: <?= htmlspecialchars($_SESSION['id']); ?></p>
        <?php else: ?>
          <p>No has iniciado sesión.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <?php
      include 'conexion.php';

      // Consulta para obtener los productos disponibles
      $sql = "SELECT id, nombre, descripcion, precio, stock, imagen FROM productos WHERE estatus = 1";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        // Mostrar los productos
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">';
          echo '<div class="card p-3">';

          // Verificar si existe una imagen y si no es vacía
          $imagen = !empty($row['imagen']) ? $row['imagen'] : 'imagenes/imagen_estandar.jpg'; // Ruta de la imagen estándar

          // Sección de imagen
          echo '<div class="card-img-container mb-3">';
          echo '<img src="' . $imagen . '" class="custom-img" alt="' . $row['nombre'] . '">';
          echo '</div>';
          
          // Sección de información del producto (nombre, descripción, precio)
          echo '<div class="card-body">';
          echo '<h5 class="card-title" style="color: #fca3ca">' . $row['nombre'] . '</h5>';
          echo '<p class="card-text">' . $row['descripcion'] . '</p>';
          echo '<h4 class="card-text"><strong>$' . $row['precio'] . '</strong></h4>';
          echo '</div>';

          // Sección del botón "Comprar"
          echo '<div class="d-flex justify-content-between mt-auto">';

          // Enlace de compra que envía el id del producto (id) y el id del usuario (user_id)
          echo '<a href="GenerarPedido.php?id_producto=' . $row['id'] . '&user_id=' . $_SESSION['id'] . '" class="btn btn-success w-100">
                <i class="fas fa-cart-plus"></i> Comprar</a>';

          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p class="text-center">No se encontraron productos</p>';
      }
      $conn->close();
      ?>
    </div>

  <!-- Modal de confirmación (si es necesario para eliminar productos) -->
  <div class="modal" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que quieres eliminar este producto?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a id="deleteProductLink" href="#" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openConfirmModal(idProducto) {
      var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
      var url = '1EliminarProductoPHP.php?id=' + idProducto;
      document.getElementById('deleteProductLink').setAttribute('href', url);
      confirmModal.show();
    }
  </script>
</body>
</html>
