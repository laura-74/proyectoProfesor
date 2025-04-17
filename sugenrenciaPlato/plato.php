<?php
include(__DIR__ . "/../admin/bd.php");

// Verificar si la conexión a la base de datos es válida
if (!$conn) {
    die("Error de conexión a la base de datos.");
}

// Obtener los platos y sus ingredientes desde la base de datos
$sql = "
    SELECT p.nombre AS plato, i.nombre AS ingrediente
    FROM plato p
    INNER JOIN plato_ingrediente pi ON p.id = pi.plato_id
    INNER JOIN ingrediente i ON pi.ingrediente_id = i.id
";

try {
    $resultado = $conn->query($sql);
} catch (PDOException $e) {
    die("Error al ejecutar la consulta: " . $e->getMessage());
}

// Organizar los datos en un array de platos con sus ingredientes
$platos = [];
while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $plato = $fila['plato'];
    $ingrediente = $fila['ingrediente'];

    if (!isset($platos[$plato])) {
        $platos[$plato] = [];
    }
    $platos[$plato][] = $ingrediente;
}

// Construir el grafo
$grafo = [];

foreach ($platos as $platoA => $ingredientesA) {
    $grafo[$platoA] = [];
    foreach ($platos as $platoB => $ingredientesB) {
        if ($platoA !== $platoB) {
            $comunes = array_intersect($ingredientesA, $ingredientesB);
            if (count($comunes) > 0) {
                $grafo[$platoA][] = $platoB;
            }
        }
    }
}

// Devolver el grafo en formato JSON
header('Content-Type: application/json');
echo json_encode($grafo, JSON_PRETTY_PRINT);

// Cerrar la conexión a la base de datos
$conn = null;
?>
