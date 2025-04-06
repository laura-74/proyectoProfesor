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

// Mostrar las reservas guardadas
if (!empty($reservasGuardadas)) {
    echo "<h3>Reservas pendientes:</h3>";
    foreach ($reservasGuardadas as $reserva) { // No se invierte el orden
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($reserva["nombre"]) . "</p>";
        echo "<p><strong>Mesa:</strong> " . htmlspecialchars($reserva["mesa"]) . "</p>";
        echo "<p><strong>Fecha:</strong> " . htmlspecialchars($reserva["fecha"]) . "</p>";
        echo "<hr>";
    }
} else {
    echo "<p>No hay reservas para mostrar.</p>";
}
?>