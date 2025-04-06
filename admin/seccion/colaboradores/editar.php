<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$nombre = $descripcion = $facebook = $instagram = $youtube = $foto = "";
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if ($txtID) {
    $sentencia = $conn->prepare("SELECT * FROM colaboradores WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if ($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $nombre = $registro["nombre"];
        $descripcion = $registro["descripcion"];
        $facebook = $registro["facebook"];
        $instagram = $registro["instagram"];
        $youtube = $registro["youtube"];
        $foto = $registro["foto"];
    }
}

if ($_POST) {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
    $facebook = isset($_POST["facebook"]) ? $_POST["facebook"] : "";
    $instagram = isset($_POST["instagram"]) ? $_POST["instagram"] : "";
    $youtube = isset($_POST["youtube"]) ? $_POST["youtube"] : "";
    $foto = isset($_POST["foto"]) ? $_POST["foto"] : "";
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    $sentencia = $conn->prepare("UPDATE colaboradores SET nombre=:nombre, descripcion=:descripcion, facebook=:facebook, instagram=:instagram, youtube=:youtube, foto=:foto WHERE id=:id");
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":facebook", $facebook);
    $sentencia->bindParam(":instagram", $instagram);
    $sentencia->bindParam(":youtube", $youtube);
    $sentencia->bindParam(":foto", $foto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    header("Location: /admin/seccion/colaboradores/index.php");
    exit;
}
?>

<div class="card">
    <div class="card_header">Editar Colaborador</div>
    <div class="card_body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre del colaborador" value="<?php echo htmlspecialchars($nombre); ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Escriba la descripción del colaborador" value="<?php echo htmlspecialchars($descripcion); ?>">
            </div>
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook</label>
                <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Escriba el enlace de Facebook" value="<?php echo htmlspecialchars($facebook); ?>">
            </div>
            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram</label>
                <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Escriba el enlace de Instagram" value="<?php echo htmlspecialchars($instagram); ?>">
            </div>
            <div class="mb-3">
                <label for="youtube" class="form-label">YouTube</label>
                <input type="text" class="form-control" name="youtube" id="youtube" placeholder="Escriba el enlace de YouTube" value="<?php echo htmlspecialchars($youtube); ?>">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="text" class="form-control" name="foto" id="foto" placeholder="Escriba el nombre del archivo de la foto" value="<?php echo htmlspecialchars($foto); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar Colaborador</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>