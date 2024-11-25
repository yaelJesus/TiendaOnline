<?php
session_start(); // Inicia la sesión para acceder a la variable de sesión
include 'conexion.php';
// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Consulta para obtener el crédito del usuario
    $sql = "SELECT credito FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId); // Vincula el parámetro de la consulta
    $stmt->execute();
    $stmt->bind_result($credito); // Obtiene el valor de la columna 'credito'
    $stmt->fetch();
    $stmt->close();
} else {
    $credito = 0; // Si no está autenticado, asigna un crédito de 0
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Menú Tienda Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      display: flex;
      background-color: #1e1e1e;
      color: #C12847;
    }
    .navbar-custom {
      background-color: #424242;
      width: 200px;
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding-top: 20px;
    }
    .navbar-custom .navbar-brand {
      color: #C12847;
      font-size: 1.5rem;
      margin-bottom: 30px;
      padding-left: 20px;
    }
    .navbar-custom .nav-link {
      color: #C12847;
      width: 100%;
      padding: 10px 20px;
      font-size: 1.5rem;
    }
    .navbar-custom .nav-link:hover {
      background-color: #C12847;
      color: #1e1e1e;
    }
    .menu-container {
      margin-left: 700px;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .menu-image {
      width: 500px;
      height: 200px;
      border-radius: 10px;
    }
    .navbar-custom .credit-container {
      margin-top: auto;
      color: #C12847;
      font-size: 1.2rem;
      padding: 10px;
      text-align: center;
      width: 100%;
      background-color: #424242;
    }
  </style>
</head>
<body>

<nav class="navbar-custom">
  <a class="navbar-brand" href="#">Zephyr</a>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="1productos.php">Productos</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="2usuarios.php">Usuarios</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="VerCarrito.php?user_id=<?= $_SESSION['id']; ?>">Pedidos</a>
    </li>
    
    <!-- Mostrar "Solicitar Crédito" si el crédito es 0 -->
    <?php if ($credito == 0): ?>
      <li class="nav-item">
        <a class="nav-link" href="solicitarcredito.php?user_id=<?= $_SESSION['id']; ?>">Solicitar Crédito</a>
      </li>
    <?php endif; ?>
    
    <!-- Mostrar "Aumentar Crédito" si el crédito es mayor o igual a 1 -->
    <?php if ($credito >= 1): ?>
      <li class="nav-item">
        <a class="nav-link" href="AumentarCredito.php?user_id=<?= $_SESSION['id']; ?>">Aumentar Crédito</a>
      </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="Pagos.php?user_id=<?= $_SESSION['id']; ?>">Pagos</a>
      </li>
  </ul>

  <div class="credit-container">
    <?php if (isset($_SESSION['id'])): ?>
      <strong>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']); ?>!</strong>
      <br>
      <label for="usuario-id">ID de Usuario: <?= htmlspecialchars($_SESSION['id']); ?></label>
    <?php else: ?>
      <strong>No has iniciado sesión.</strong>
    <?php endif; ?>
    <br>
    
    <strong>Crédito Inicial:</strong> $<?= number_format($credito, 2); ?> <!-- Muestra el crédito del usuario -->
  </div>
</nav>

<div class="menu-container">
    <img src="Logo Zephyr Original.png" alt="Imagen Representativa" class="menu-image" style="width: 450px; height: 225px;">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

