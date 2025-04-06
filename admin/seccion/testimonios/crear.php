<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

if ($_POST) {
    $opinion = (isset($_POST["opinion"])) ? $_POST["opinion"] : "";
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";

    $sentencia = $conn->prepare("INSERT INTO testimonios(opinion, nombre) VALUES (:opinion, :nombre)");

    $sentencia->bindParam(":opinion", $opinion);
    $sentencia->bindParam(":nombre", $nombre);

    $sentencia->execute();
    header("Location: /admin/seccion/testimonios/index.php");
}
?>

<br>

<div class="card">
    <div class="card-header">Testimonios</div>
    <div class="card-body">

        <form action="" method="post">

            <div class="mb-3">
                <label for="opinion" class="form-label">Opinión</label>
                <input
                    type="text"
                    class="form-control"
                    name="opinion"
                    id="opinion"
                    aria-describedby="helpId"
                    placeholder="Escriba la opinión del testimonio" />
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombre"
                    id="nombre"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre del autor del testimonio" />
            </div>

            <button type="submit" class="btn btn-success">Crear testimonio</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="/admin/seccion/testimonios/index.php"
                role="button">Cancelar</a>
        </form>
    </div>
</div>

<div class="card-footer text-muted"></div>
</div>