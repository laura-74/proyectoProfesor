<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/reservas.php"); // Importar la clase PilaMensajes
// Ruta del archivo donde se guardarán las reservas
$archivoReservas = $_SERVER['DOCUMENT_ROOT'] . "/reservas.json";

// Leer las reservas existentes del archivo
$reservasGuardadas = [];
if (file_exists($archivoReservas)) {
    $contenidoArchivo = file_get_contents($archivoReservas);
    $reservasGuardadas = json_decode($contenidoArchivo, true) ?? [];
}

// Procesar los datos enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"], $_POST["mesa"], $_POST["fecha"])) {
    $nuevaReserva = [
        "nombre" => $_POST["nombre"],
        "mesa" => $_POST["mesa"],
        "fecha" => $_POST["fecha"]
    ];

    // Agregar la nueva reserva al arreglo de reservas
    $reservasGuardadas[] = $nuevaReserva;

    // Guardar las reservas en el archivo
    file_put_contents($archivoReservas, json_encode($reservasGuardadas, JSON_PRETTY_PRINT));

    header("Location: /index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="/styles/reservas.css">
</head>

<body>
    <header class="header">
        <div class="headerDiv">
            <h1 class="header_h1">Reservas pendientes</h1>
            <div class="div_a">
                <a class="header_a" href="/admin/seccion/index.php">Inicio</a>
            </div>
        </div>
    </header>
    <?php if (!empty($reservasGuardadas)): ?>
        <div class="contenido">
            <?php foreach ($reservasGuardadas as $reserva): ?>
                <div class="reserva">
                    <p class="parrafo"><strong>Nombre:</strong> <?= htmlspecialchars($reserva["nombre"]) ?></p>
                    <p class="parrafo"><strong>Mesa:</strong> <?= htmlspecialchars($reserva["mesa"]) ?></p>
                    <p class="parrafo"><strong>Fecha:</strong> <?= htmlspecialchars($reserva["fecha"]) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-reservas">No hay reservas para mostrar.</p>
    <?php endif; ?>
</body>

</html>