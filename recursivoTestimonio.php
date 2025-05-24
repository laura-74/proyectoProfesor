<?php
function obtenerTestimonios(PDO $conn): array {
    $stmt = $conn->query("SELECT * FROM testimonios ORDER BY fecha ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function mostrarTestimonios(array $testimonios, $padre_id = null, $nivel = 0): void {
    foreach ($testimonios as $t) {
        if ($t['padre_id'] == $padre_id) {
            echo str_repeat('&nbsp;', $nivel * 4);
            echo "<div style='margin-left: " . ($nivel * 1.5) . "em; border-left: 1px solid #ccc; padding-left: 10px; margin-bottom: 10px;'>
                    <strong>" . htmlspecialchars($t['nombre']) . ":</strong> " . htmlspecialchars($t['mensaje']) . "<br>
                    <small>" . htmlspecialchars($t['fecha']) . "</small>
                  </div>";
            mostrarTestimonios($testimonios, $t['id'], $nivel + 1);
        }
    }
}
