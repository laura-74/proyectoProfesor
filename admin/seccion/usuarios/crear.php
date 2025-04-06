<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

if ($_POST) {
    $nombreUsuario = (isset($_POST["nombreUsuario"])) ? $_POST["nombreUsuario"] : "";
    $password = (isset($_POST["password"])) ? $_POST["password"] : "";
    $correo = (isset($_POST["correo"])) ? $_POST["correo"] : "";

    $sentencia = $conn->prepare("INSERT INTO usuario(nombreUsuario, password, correo) VALUES (:nombreUsuario, :password, :correo)");

    $sentencia->bindParam(":nombreUsuario", $nombreUsuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);

    $sentencia->execute();
    header("Location: /admin/seccion/usuarios/index.php");
}
?>

<br>

<div class="card">
    <div class="card-header">Usuarios</div>
    <div class="card-body">

        <form action="" method="post">

            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Nombre de Usuario</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombreUsuario"
                    id="nombreUsuario"
                    aria-describedby="helpId"
                    placeholder="Escriba el nombre de usuario" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    aria-describedby="helpId"
                    placeholder="Escriba la contraseña" />
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id="correo"
                    aria-describedby="helpId"
                    placeholder="Escriba el correo electrónico" />
            </div>

            <button type="submit" class="btn btn-success">Crear usuario</button>
            <a
                name=""
                id=""
                class="btn btn-primary"
                href="/admin/seccion/usuarios/index.php"
                role="button">Cancelar</a>
        </form>
    </div>
</div>

<div class="card-footer text-muted"></div>
</div>