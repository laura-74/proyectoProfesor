<?php
include("admin/bd.php");
// Lista ordenada para búsqueda binaria usando PDO
try {
    // Asume que $pdo es tu conexión PDO en bd.php
    $stmt = $conn->query("SELECT nombre FROM plato ORDER BY nombre ASC");
    $lista = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
} catch (PDOException $e) {
    $lista = [];
}



// Función de búsqueda binaria para autocompletar
function autocompletar($lista, $query) {
    $resultados = [];
    $inicio = 0;
    $fin = count($lista) - 1;
    $query = strtolower($query);

    // Buscar el primer índice que podría coincidir
    while ($inicio <= $fin) {
        $medio = intval(($inicio + $fin) / 2);
        if (strpos(strtolower($lista[$medio]), $query) === 0) {
            // Buscar hacia atrás para encontrar el primer match
            $i = $medio;
            while ($i >= 0 && strpos(strtolower($lista[$i]), $query) === 0) {
                $i--;
            }
            $i++;
            // Agregar todos los matches consecutivos
            while ($i < count($lista) && strpos(strtolower($lista[$i]), $query) === 0) {
                $resultados[] = $lista[$i];
                $i++;
            }
            break;
        } elseif (strtolower($lista[$medio]) < $query) {
            $inicio = $medio + 1;
        } else {
            $fin = $medio - 1;
        }
    }
    return $resultados;
}

// Si es una petición AJAX, responder con sugerencias
if (isset($_GET['q'])) {
    $sugerencias = autocompletar($lista, $_GET['q']);
    header('Content-Type: application/json');
    echo json_encode($sugerencias);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocompletado con Búsqueda Binaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #sugerencias {
            border: 1px solid #ccc;
            max-width: 100%;
            position: absolute;
            background: #fff;
            z-index: 100;
        }
        #sugerencias div {
            padding: 5px;
            cursor: pointer;
        }
        #sugerencias div:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center">Autocompletado de todos los platos del menu 🍽️  </h2>
                        <p class="text-center">Empieza a escribir y selecciona una de las opciones sugeridas:</p>
                        <div class="mb-3">
                            <input type="text" id="busqueda" class="form-control" placeholder="Ejemplo: Arroz..." autocomplete="on">
                        </div>
                        <div id="sugerencias" class="list-group"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('busqueda');
        const sugerencias = document.getElementById('sugerencias');

        input.addEventListener('input', function() {
            const query = this.value;
            if (query.length === 0) {
                sugerencias.innerHTML = '';
                return;
            }
            fetch('?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    sugerencias.innerHTML = '';
                    if (data.length === 0) {
                        sugerencias.innerHTML = '<div class="list-group-item">No hay sugerencias</div>';
                    } else {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.textContent = item;
                            div.className = 'list-group-item list-group-item-action';
                            div.onclick = () => {
                                input.value = item;
                                sugerencias.innerHTML = '';
                            };
                            sugerencias.appendChild(div);
                        });
                    }
                });
        });

        // Ocultar sugerencias al perder el foco
        input.addEventListener('blur', () => {
            setTimeout(() => sugerencias.innerHTML = '', 100);
        });
    </script>
</body>
</html>