<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agregar Usuario</title>
  <?php
// Iniciar sesión si es necesario
session_start();

// Capturar el ID enviado por GET
  if (isset($_GET['user_id'])) {
      $user_id = $_GET['user_id'];
  } else {
      // Redireccionar o manejar el caso donde no haya un ID
      die('No se proporcionó un ID de usuario.');
  }

  ?>
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
        width: 350px;
      }

      .login-container h1 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 20px;
      }

      .form-group {
        position: relative;
        margin-bottom: 20px;
      }

      .form-group input, .form-group select {
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

      .form-group input:focus, .form-group select:focus {
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
      .form-group input:not(:placeholder-shown) + label,
      .form-group select:focus + label {
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
        opacity: 0.5;
        pointer-events: none;
      }

      .login-container button.active {
        opacity: 1;
        pointer-events: all;
      }

      .login-container a {
        color: #C12847;
        text-decoration: none;
        font-size: 14px;
      }

      .login-container a:hover {
        text-decoration: underline;
      }

      .message {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        display: none;
        z-index: 1000;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <h1>Solicitar Crédito</h1>
      <label style="color: white; font-size: 18px; margin-bottom: 15px; display: block;">
      Usuario: <?= $_SESSION['nombre']; ?> (ID: <?= $_SESSION['id']; ?>)
    </label>
    <form action="editarcredito.php" method="get">
    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
    <div class="form-group">
      <input type="number" id="salario" placeholder=" " required>
      <label for="salario">Salario Mensual Neto</label>
    </div>
    <div class="form-group">
      <input type="file" id="ine" accept="image/png" required>
      <label for="ine">Imagen del INE</label>
    </div>
    <div class="form-group">
      <input type="file" id="comprobante" accept="application/pdf" onchange="displayPDFName()" required>
      <label for="comprobante">Comprobante de Domicilio (PDF)</label>
    </div>
      <button type="submit" class="active">Guardar</button>
    </form>
  </div>

  <script>
    // Función para mostrar el nombre del archivo PDF
    function displayPDFName() {
      const pdfInput = document.getElementById("comprobante");
      const pdfName = document.getElementById("comprobante-name");
      if (pdfInput.files.length > 0) {
        pdfName.textContent = pdfInput.files[0].name;
      }
    }

    // Habilitar el botón solo si todos los campos están completos
    const formElements = document.querySelectorAll("#user-form input");
    const submitButton = document.getElementById("submit-button");

    formElements.forEach(element => {
      element.addEventListener("input", validateForm);
    });

    function validateForm() {
      let allFieldsFilled = true;
      formElements.forEach(element => {
        if (!element.value) {
          allFieldsFilled = false;
        }
      });

      if (allFieldsFilled) {
        submitButton.classList.add("active");
      } else {
        submitButton.classList.remove("active");
      }
    }

    // Mostrar mensaje de crédito aprobado cuando se envíe el formulario
    document.getElementById("user-form").addEventListener("submit", function(event) {
      event.preventDefault();  // Prevenir el envío tradicional del formulario

      const messageElement = document.getElementById("message");
      messageElement.style.display = "block";

      // Ocultar el mensaje después de 3 segundos
      setTimeout(() => {
        messageElement.style.display = "none";
      }, 3000);

      // Aquí puedes agregar código para procesar el formulario, como enviar los datos a un servidor
    });
  </script>
</body>
</html>


