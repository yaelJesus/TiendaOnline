<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agregar Usuario</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #1e1e1e;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      text-align: center;
      background-color: #2b2b2b;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
      width: 300px;
    }

    .login-container img {
      width: 100px;
      margin-bottom: 20px;
    }

    .login-container h1 {
      color: #fff;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .form-group {
      position: relative;
      margin-bottom: 30px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      background: transparent;
      border: none;
      border-bottom: 2px solid #555;
      outline: none;
      color: #fff;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-bottom: 2px solid #C12847;
    }

    .form-group label {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #888;
      font-size: 14px;
      pointer-events: none;
      transition: 0.3s;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -15px;
      font-size: 12px;
      color: #C12847;
    }

    .login-container button {
      padding: 10px 20px;
      background-color: #C12847;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    .login-container button:hover {
      background-color: #C12847;
    }

    .login-container a {
      color: #C12847;
      text-decoration: none;
      font-size: 14px;
    }

    .login-container a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <div class="login-container">
    <img src="Logo Zephyr Original.png" alt="Logo" style="width: 300px; height: 150px;">
    <br/>
        <h1>Crear Cuenta</h1>
        <form action="CrearCuentaPHP.php" method="post">
            <div class="form-group">
                <input type="text" id="nombre" name="nombre" placeholder=" " required>
                <label for="nombre">Nombre</label>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>
            <div class="form-group">
                <input type="password" id="contraseña" name="contraseña" placeholder=" " required>
                <label for="contraseña">Contraseña</label>
            </div>
            <p>
                <a href="Login.html">¿Ya tienes una cuenta? Inicia Sesión</a>
            </p>
            <br/>
            <button type="submit">Registrarme</button>
        </form>
    </div>
</body>
</html>
