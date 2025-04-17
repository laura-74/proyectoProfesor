<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

if ($_POST) {
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";
    $foto = (isset($_POST["foto"])) ? $_POST["foto"] : "";
    $ingredientesSeleccionados = (isset($_POST["ingredientesSeleccionados"])) ? $_POST["ingredientesSeleccionados"] : "";

    // Insertar el plato en la tabla `plato`
    $sentencia = $conn->prepare("INSERT INTO plato(nombre, precio, foto) VALUES (:nombre, :precio, :foto)");
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":foto", $foto);
    $sentencia->execute();

    // Obtener el ID del plato recién insertado
    $idPlato = $conn->lastInsertId();

    // Insertar los ingredientes seleccionados en la tabla intermedia `plato_ingrediente`
    if (!empty($ingredientesSeleccionados)) {
        $ingredientesArray = explode(',', $ingredientesSeleccionados); // Convertir la cadena en un array
        $sentenciaIngrediente = $conn->prepare("INSERT INTO plato_ingrediente(plato_id, ingrediente_id) VALUES (:plato_id, :ingrediente_id)");

        foreach ($ingredientesArray as $idIngrediente) {
            $sentenciaIngrediente->bindParam(":plato_id", $idPlato);
            $sentenciaIngrediente->bindParam(":ingrediente_id", $idIngrediente);
            $sentenciaIngrediente->execute();
        }
    }

    header("Location: /admin/seccion/menu/index.php");
    exit;
}

// Obtener los ingredientes disponibles desde la base de datos
$sentencia = $conn->prepare("SELECT id, nombre FROM ingrediente");
$sentencia->execute();
$ingredientes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<br>

<div class="card">
    <div class="card-header">Menú</div>
    <div class="card-body">

        <form action="" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombre"
                    id="nombre"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre del platillo" />
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
                    <div id="ingredientesSeleccionados" class="form-control" style="height: auto; min-height: 38px;"></div>
                </div>

                <input type="hidden" name="ingredientesSeleccionados" id="ingredientesSeleccionadosInput">

                <script>
                    const ingredienteSelect = document.getElementById('ingrediente');
                    const ingredientesSeleccionadosDiv = document.getElementById('ingredientesSeleccionados');
                    const ingredientesSeleccionadosInput = document.getElementById('ingredientesSeleccionadosInput');
                    const selectedIngredients = new Set();

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
                <input
                    type="text"
                    class="form-control"
                    name="precio"
                    id="precio"
                    aria-describedby="helpId"
                    placeholder="Escriba el precio del platillo" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input
                    type="text"
                    class="form-control"
                    name="foto"
                    id="foto"
                    aria-describedby="helpId"
                    placeholder="Escriba la URL de la foto del platillo" />
            </div>

            <button type="submit" class="btn btn-success">Crear platillo</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="/admin/seccion/menu/index.php"
                role="button">Cancelar</a>
        </form>
    </div>
</div>

<div class="card-footer text-muted"></div>
</div>