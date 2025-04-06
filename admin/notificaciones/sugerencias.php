<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/pilaMensaje.php"); // Importar la clase PilaMensajes

// Ruta del archivo donde se guardarán los mensajes
$archivoMensajes = $_SERVER['DOCUMENT_ROOT'] . "/mensajes.json";

// Leer los mensajes existentes del archivo
$mensajesGuardados = [];
if (file_exists($archivoMensajes)) {
    $contenidoArchivo = file_get_contents($archivoMensajes);
    $mensajesGuardados = json_decode($contenidoArchivo, true) ?? [];
}

// Procesar los datos enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"], $_POST["email"], $_POST["telefono"], $_POST["mensaje"])) {
    $nuevoMensaje = [
        "nombre" => $_POST["nombre"],
        "email" => $_POST["email"],
        "telefono" => $_POST["telefono"],
        "mensaje" => $_POST["mensaje"],
        "fecha" => date("Y-m-d H:i:s")
    ];

    // Agregar el nuevo mensaje al arreglo de mensajes
    $mensajesGuardados[] = $nuevoMensaje;

    // Guardar los mensajes en el archivo
    file_put_contents($archivoMensajes, json_encode($mensajesGuardados, JSON_PRETTY_PRINT));

    header("Location: /index.php");
    exit;
}

// Mostrar los mensajes guardados
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerencias</title>
    <link rel="stylesheet" href="/styles/sugerencias.css">
</head>

<body>
    <header class="header">
        <div class="headerDiv">
            <h1 class="header_h1">Sugerencias del cliente</h1>
            <div class="div_a">
                <a class="header_a" href="/admin/seccion/index.php">Inicio</a>
            </div>
        </div>
    </header>   

    <?php if (!empty($mensajesGuardados)): ?>
        <div style="font-family: Arial, sans-serif; line-height: 1.6;">
            <?php foreach (array_reverse($mensajesGuardados) as $mensaje): ?>
                <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px; background-color: #f9f9f9;">
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($mensaje["nombre"]) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($mensaje["email"]) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($mensaje["telefono"]) ?></p>
                    <p><strong>Mensaje:</strong> <?= htmlspecialchars($mensaje["mensaje"]) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($mensaje["fecha"]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="font-family: Arial, sans-serif; color: #666;">No hay mensajes para mostrar.</p>
    <?php endif; ?>

</body>

</html>