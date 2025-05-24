<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$nombre = $precio = $foto = "";
$ingredientesSeleccionados = [];
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if ($txtID) {
    
    // Obtener los datos del plato
    $sentencia = $conn->prepare("SELECT * FROM plato WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if ($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $nombre = $registro["nombre"];
        $precio = $registro["precio"];
        $foto = $registro["foto"];
    }

    // Obtener los ingredientes asociados al plato
    $sentenciaIngredientes = $conn->prepare("SELECT ingrediente_id FROM plato_ingrediente WHERE plato_id = :plato_id");
    $sentenciaIngredientes->bindParam(":plato_id", $txtID);
    $sentenciaIngredientes->execute();
    $ingredientesSeleccionados = $sentenciaIngredientes->fetchAll(PDO::FETCH_COLUMN);
}

// Procesar el formulario de edición
if ($_POST) {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
    $foto = isset($_POST["foto"]) ? $_POST["foto"] : "";
    $ingredientesSeleccionados = isset($_POST["ingredientesSeleccionados"]) ? explode(',', $_POST["ingredientesSeleccionados"]) : [];
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    // Actualizar los datos del plato
    $sentencia = $conn->prepare("UPDATE plato SET nombre=:nombre, precio=:precio, foto=:foto WHERE id=:id");
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":foto", $foto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Actualizar los ingredientes asociados al plato
    // Eliminar los ingredientes actuales
    $sentenciaEliminar = $conn->prepare("DELETE FROM plato_ingrediente WHERE plato_id = :plato_id");
    $sentenciaEliminar->bindParam(":plato_id", $txtID);
    $sentenciaEliminar->execute();

    // Insertar los nuevos ingredientes seleccionados
    if (!empty($ingredientesSeleccionados)) {
        $sentenciaInsertar = $conn->prepare("INSERT INTO plato_ingrediente(plato_id, ingrediente_id) VALUES (:plato_id, :ingrediente_id)");
        foreach ($ingredientesSeleccionados as $idIngrediente) {
            $sentenciaInsertar->bindParam(":plato_id", $txtID);
            $sentenciaInsertar->bindParam(":ingrediente_id", $idIngrediente);
            $sentenciaInsertar->execute();
        }
    }

    header("Location: /admin/seccion/menu/index.php");
    exit;
}

// Obtener todos los ingredientes disponibles
$sentencia = $conn->prepare("SELECT id, nombre FROM ingrediente");
$sentencia->execute();
$ingredientes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card">
    <div class="card-header">Editar Menú</div>
    <div class="card-body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre del menú" value="<?php echo htmlspecialchars($nombre); ?>">
            </div>

            <div>
                <div class="mb-3">
                    <label for="ingrediente" class="form-label">Ingredientes</label>
                    <select class="form-select" id="ingrediente">
                        <option value="" selected>Seleccione un ingrediente</option>
                        <?php foreach ($ingredientes as $ingrediente): ?>
                            <option value="<?= htmlspecialchars($ingrediente['id']) ?>">
                                <?= htmlspecialchars($ingrediente['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ingredientesSeleccionados" class="form-label">Ingredientes seleccionados</label>
                    <div id="ingredientesSeleccionados" class="form-control" style="height: auto; min-height: 38px;">
                        <?php foreach ($ingredientes as $ingrediente): ?>
                            <?php if (in_array($ingrediente['id'], $ingredientesSeleccionados)): ?>
                                <div class="badge bg-primary me-1 mb-1" style="cursor: pointer;" data-id="<?= $ingrediente['id'] ?>">
                                    <?= htmlspecialchars($ingrediente['nombre']) ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <input type="hidden" name="ingredientesSeleccionados" id="ingredientesSeleccionadosInput" value="<?php echo implode(',', $ingredientesSeleccionados); ?>">

                <script>
                    const ingredienteSelect = document.getElementById('ingrediente');
                    const ingredientesSeleccionadosDiv = document.getElementById('ingredientesSeleccionados');
                    const ingredientesSeleccionadosInput = document.getElementById('ingredientesSeleccionadosInput');
                    const selectedIngredients = new Set(ingredientesSeleccionadosInput.value.split(',').filter(Boolean));

                    function updateHiddenInput() {
                        ingredientesSeleccionadosInput.value = Array.from(selectedIngredients).join(',');
                    }

                    ingredienteSelect.addEventListener('change', function () {
                        const selectedValue = ingredienteSelect.value;
                        const selectedText = ingredienteSelect.options[ingredienteSelect.selectedIndex].text;

                        if (selectedValue && !selectedIngredients.has(selectedValue)) {
                            selectedIngredients.add(selectedValue);

                            const ingredientDiv = document.createElement('div');
                            ingredientDiv.textContent = selectedText;
                            ingredientDiv.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                            ingredientDiv.style.cursor = 'pointer';

                            ingredientDiv.addEventListener('click', function () {
                                selectedIngredients.delete(selectedValue);
                                ingredientesSeleccionadosDiv.removeChild(ingredientDiv);
                                updateHiddenInput();
                            });

                            ingredientesSeleccionadosDiv.appendChild(ingredientDiv);
                            updateHiddenInput();
                        }

                        ingredienteSelect.value = ""; // Reset the select
                    });
                </script>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" name="precio" id="precio" placeholder="Escriba el precio del menú" value="<?php echo htmlspecialchars($precio); ?>">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="text" class="form-control" name="foto" id="foto" placeholder="Escriba el enlace de la foto del menú" value="<?php echo htmlspecialchars($foto); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar Menú</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>