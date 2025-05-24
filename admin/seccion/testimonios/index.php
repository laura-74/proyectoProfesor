<?php
include("../../../admin/bd.php");
include("../../../recursivoTestimonio.php");

// Procesar el formulario de envío de testimonios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $mensaje = $_POST['mensaje'];
    $padre_id = $_POST['padre_id'] ?? null;

    // Validar que el padre_id sea válido o NULL
    if (!empty($padre_id)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM testimonios WHERE id = ?");
        $stmt->execute([$padre_id]);
        $exists = $stmt->fetchColumn();

        if (!$exists) {
            $padre_id = null; // Si el padre_id no existe, lo establecemos como NULL
        }
    } else {
        $padre_id = null; // Si no se selecciona un padre_id, lo establecemos como NULL
    }

    // Insertar el testimonio en la base de datos
    $stmt = $conn->prepare("INSERT INTO testimonios (nombre, mensaje, padre_id, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$nombre, $mensaje, $padre_id]);

    header("Location: index.php");
    exit;
}

// Obtener todos los testimonios
$testimonios = obtenerTestimonios($conn);
?>

<h2>Administrar Testimonios</h2>

<!-- Formulario para agregar un nuevo testimonio -->
<form method="post">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <textarea name="mensaje" placeholder="Mensaje" required></textarea><br>
    <label>Responder a:</label>
    <select name="padre_id">
        <option value="">Ninguno</option>
        <?php foreach ($testimonios as $t): ?>
            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?>: <?= htmlspecialchars(substr($t['mensaje'], 0, 30)) ?>...</option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Enviar</button>
</form>

<h3>Historial de Testimonios</h3>

<!-- Mostrar los testimonios de forma recursiva -->
<?php mostrarTestimonios($testimonios); ?>
