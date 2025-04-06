<?php 
include("../../templates/header.php");
include("../../../admin/bd.php");


if ($_POST) {
    $titulo = (isset($_POST["titulo"])) ? $_POST["titulo"] : "";
    $descripcion = (isset($_POST["Descripcion"])) ? $_POST["Descripcion"] : "";
    $enlace = (isset($_POST["Enlace"])) ? $_POST["Enlace"] : "";

    $sentencia = $conn->prepare("INSERT INTO banner(titulo, descripcion, link) VALUES (:titulo, :descripcion, :link)");

    $sentencia -> bindParam(":titulo", $titulo);
    $sentencia -> bindParam(":descripcion", $descripcion);
    $sentencia -> bindParam(":link", $enlace);

    $sentencia -> execute();
    header("Location: /admin/seccion/index.php");
}
    ?>


<br>

<div class="card">
    <div class="card-header">Banners</div>
    <div class="card-body">

        <form action="" method="post">

            <div class="mb-3">
                <label for="" class="form-label">Titulo</label>
                <input
                    type="text"
                    class="form-control"
                    name="titulo"
                    id="titulo"
                    aria-describedby="helpId"
                    placeholder="Esciba el titulo del banner" />

            </div>
            <div class="mb-3">
                <label for="" class="form-label">Descripción</label>
                <input
                    type="text"
                    class="form-control"
                    name="Descripcion"
                    id="Descripcion"
                    aria-describedby="helpId"
                    placeholder="Esciba el descripción del banner" />

            </div>
            <div class="mb-3">
                <label for="" class="form-label">Enlace</label>
                <input
                    type="text"
                    class="form-control"
                    name="Enlace"
                    id="Enlace"
                    aria-describedby="helpId"
                    placeholder="Esciba el enlace del banner" />
            </div>

            <button type="submit" class="btn btn-success">Crear banner</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="/admin/seccion/banners/index.php"
                role="button">Cancelar</a>
        </form>
    </div>

</div>

<div class="card-footer text-muted"></div>
</div>