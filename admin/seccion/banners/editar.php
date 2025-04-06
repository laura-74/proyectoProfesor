<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$titulo = $descripcion = $link = "";
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if($txtID) {
    $sentencia = $conn->prepare("SELECT * FROM banner WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $titulo = $registro["titulo"];
        $descripcion = $registro["descripcion"];
        $link = $registro["link"];
    }
}

if($_POST) {
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
    $descripcion = isset($_POST["Descripcion"]) ? $_POST["Descripcion"] : "";
    $link = isset($_POST["link"]) ? $_POST["link"] : "";
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    $sentencia = $conn->prepare("UPDATE banner SET titulo=:titulo, descripcion=:descripcion, link=:link WHERE id=:id");
    $sentencia->bindParam(":titulo", $titulo);
    $sentencia->bindParam(":descripcion", $descripcion);
    $sentencia->bindParam(":link", $link); // Fixed variable name
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    
    header("Location: /admin/seccion/banners/index.php");
    exit;
}
?>

<div class="card">
    <div class="card_header">Banners</div>
    <div class="card_body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Esciba el titulo del banner" value="<?php echo htmlspecialchars($titulo); ?>">
            </div>
            <div class="mb-3">
                <label for="Descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" name="Descripcion" id="Descripcion" placeholder="Esciba el descripción del banner" value="<?php echo htmlspecialchars($descripcion); ?>">
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Enlace</label>
                <input type="text" class="form-control" name="link" id="link" placeholder="Esciba el enlace del banner" value="<?php echo htmlspecialchars($link); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar banner</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>
