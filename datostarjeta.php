<?php
// Obtener los valores de los parámetros enviados por GET.
$forma_pago = isset($_GET['forma_pago']) ? $_GET['forma_pago'] : ''; 
$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e; /* Fondo oscuro */
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .modal {
            display: block;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2c2c2c; /* Fondo del modal */
            color: #fff;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow: hidden;
        }

        .modal-header {
            background-color: #ff69b4; /* Rosa intenso */
            padding: 15px;
            text-align: center;
        }

        .modal-header h5 {
            margin: 0;
            font-size: 18px;
        }

        .modal-header .btn-close {
            background: none;
            border: none;
            font-size: 18px;
            color: #fff;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .modal-body {
            padding: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            color: #ff69b4; /* Rosa para los labels */
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #1e1e1e; /* Fondo oscuro */
            color: #fff;
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group-inline {
            display: flex;
            gap: 15px;
        }

        .form-group-inline .form-group {
            flex: 1;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #ff69b4; /* Botón rosa */
            color: #1e1e1e; /* Texto oscuro */
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #ff85c1; /* Rosa más claro */
        }

        .btn-close:hover {
            color: #ff85c1;
        }
    </style>
</head>
<body>
    <div class="modal" id="formaPagoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingrese los datos de su tarjeta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="procesar_pago.php" method="POST">
                        <div class="form-group">
                            <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
                            <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="1234 5678 9012 3456" required>
                        </div>

                        <div class="form-group-inline">
                            <div class="form-group">
                                <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento</label>
                                <input type="month" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                            </div>
                            <div class="form-group">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required maxlength="3">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" value="<?php echo $total; ?>" readonly>
                        </div>
                        
                        <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
                        <input type="hidden" name="forma_pago" value="<?php echo $forma_pago; ?>"> <!-- Incluimos el valor de forma_pago -->
                        
                        <button type="submit" class="btn">Realizar pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


