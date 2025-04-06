<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

if ($_POST) {
    $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : "";
    $descripcion = (isset($_POST["descripcion"])) ? $_POST["descripcion"] : "";
    $facebook = (isset($_POST["facebook"])) ? $_POST["facebook"] : "";
    $instagram = (isset($_POST["instagram"])) ? $_POST["instagram"] : "";
    $youtube = (isset($_POST["youtube"])) ? $_POST["youtube"] : "";
    $foto = (isset($_POST["foto"])) ? $_POST["foto"] : "";

    $sentencia = $conn->prepare("INSERT INTO colaboradores (nombre, descripcion, facebook, instagram, youtube, foto) VALUES (:nombre, :descripcion, :facebook, :instagram, :youtube, :foto)");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":facebook", $facebook);
    $sentencia->bindParam(":instagram", $instagram);
    $sentencia->bindParam(":youtube", $youtube);
    $sentencia->bindParam(":foto", $foto);

    $sentencia->execute();
    header("Location: /admin/seccion/colaboradores/index.php");
}
?>

<br>

<div class="card">
    <div class="card-header">Colaboradores</div>
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
                    placeholder="Escriba el nombre del colaborador" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input
                    type="text"
                    class="form-control"
                    name="descripcion"
                    id="descripcion"
                    aria-describedby="helpId"
                    placeholder="Escriba la descripción del colaborador" />
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook</label>
                <input
                    type="text"
                    class="form-control"
                    name="facebook"
                    id="facebook"
                    aria-describedby="helpId"
                    placeholder="Escriba el enlace de Facebook" />
            </div>

            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram</label>
                <input
                    type="text"
                    class="form-control"
                    name="instagram"
                    id="instagram"
                    aria-describedby="helpId"
                    placeholder="Escriba el enlace de Instagram" />
            </div>

            <div class="mb-3">
                <label for="youtube" class="form-label">YouTube</label>
                <input
                    type="text"
                    class="form-control"
                    name="youtube"
                    id="youtube"
                    aria-describedby="helpId"
                    placeholder="Escriba el enlace de YouTube" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input
                    type="text"
                    class="form-control"
                    name="foto"
                    id="foto"
                    aria-describedby="helpId"
                    placeholder="Escriba el enlace de la foto" />
            </div>

            <button type="submit" class="btn btn-success">Crear colaborador</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="/admin/seccion/colaboradores/index.php"
                role="button">Cancelar</a>
        </form>
    </div>
</div>

<div class="card-footer text-muted"></div>
</div>