<?php
include("admin/bd.php");

$sugeridos = [];
$total = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $presupuesto = floatval($_POST["presupuesto"]);

    // Obtener los platos ordenados de mayor a menor precio
    $stmt = $conn->query("SELECT nombre, precio, foto FROM plato");
    $platos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir precio a número (por si es VARCHAR)
    foreach ($platos as &$plato) {
        $plato['precio'] = floatval($plato['precio']);
    }

    // Ordenar de mayor a menor
    usort($platos, function($a, $b) {
        return $b['precio'] <=> $a['precio'];
    });

    // Aplicar lógica voraz
    foreach ($platos as $plato) {
        if ($total + $plato['precio'] <= $presupuesto) {
            $sugeridos[] = $plato;
            $total += $plato['precio'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Platos según presupuesto</title>
    <link rel="stylesheet" href="styles/presupuesto.css">
</head>

<body>
<header class="header">
    <div class="div_a">
      <a class="header_a" href="/index.php">Volver a la pagina principal</a>
    </div>
  </header>

<h2>¿De cuánto es tu presupuesto?</h2>
<form method="POST">
    <input type="number" name="presupuesto" required placeholder="Ej: 2.000">
    <button type="submit">Ver platos</button>
</form>

<?php if (!empty($sugeridos)): ?>
    <h3>Platos sugeridos:</h3>
    <?php foreach ($sugeridos as $p): ?>
        <div class="plato">
            <img src="imagenes/<?php echo htmlspecialchars($p['foto']); ?>" alt="Foto">
            <div>
                <strong><?php echo htmlspecialchars($p['nombre']); ?></strong><br>
                Precio: $<?php echo number_format($p['precio'], 2); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
<?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <p>No hay platos disponibles para ese presupuesto.</p>
<?php endif; ?>

</body>
</html>