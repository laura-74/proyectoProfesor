<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

if ($_POST) {
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $ingredientes = (isset($_POST["ingredientes"])) ? $_POST["ingredientes"] : "";
    $precio = (isset($_POST["precio"])) ? $_POST["precio"] : "";
    $foto = (isset($_POST["foto"])) ? $_POST["foto"] : "";

    $sentencia = $conn->prepare("INSERT INTO menu(nombre, ingredientes, precio, foto) VALUES (:nombre, :ingredientes, :precio, :foto)");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ingredientes", $ingredientes);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":foto", $foto);

    $sentencia->execute();
    header("Location: /admin/seccion/menu/index.php");
}
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

            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes</label>
                <input
                    type="text"
                    class="form-control"
                    name="ingredientes"
                    id="ingredientes"
                    aria-describedby="helpId"
                    placeholder="Escriba los ingredientes del platillo" />
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