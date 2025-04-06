<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$nombreUsuario = $password = $correo = "";
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if ($txtID) {
    $sentencia = $conn->prepare("SELECT * FROM usuario WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if ($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $nombreUsuario = $registro["nombreUsuario"];
        $password = $registro["password"];
        $correo = $registro["correo"];
    }
}

if ($_POST) {
    $nombreUsuario = isset($_POST["nombreUsuario"]) ? $_POST["nombreUsuario"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    $sentencia = $conn->prepare("UPDATE usuario SET nombreUsuario=:nombreUsuario, password=:password, correo=:correo WHERE id=:id");
    $sentencia->bindParam(":nombreUsuario", $nombreUsuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    header("Location: /admin/seccion/usuarios/index.php");
    exit;
}
?>

<div class="card">
    <div class="card_header">Editar Usuario</div>
    <div class="card_body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" name="nombreUsuario" id="nombreUsuario" placeholder="Escriba el nombre de usuario" value="<?php echo htmlspecialchars($nombreUsuario); ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Escriba la contraseña" value="<?php echo htmlspecialchars($password); ?>">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="Escriba el correo" value="<?php echo htmlspecialchars($correo); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar Usuario</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>