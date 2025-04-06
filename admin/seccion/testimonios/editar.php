<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$opinion = $nombre = "";
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if ($txtID) {
    $sentencia = $conn->prepare("SELECT * FROM testimonios WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if ($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $opinion = $registro["opinion"];
        $nombre = $registro["nombre"];
    }
}

if ($_POST) {
    $opinion = isset($_POST["opinion"]) ? $_POST["opinion"] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    $sentencia = $conn->prepare("UPDATE testimonios SET opinion=:opinion, nombre=:nombre WHERE id=:id");
    $sentencia->bindParam(":opinion", $opinion);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    header("Location: /admin/seccion/testimonios/index.php");
    exit;
}
?>

<div class="card">
    <div class="card_header">Testimonios</div>
    <div class="card_body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="opinion" class="form-label">Opinión</label>
                <input type="text" class="form-control" name="opinion" id="opinion" placeholder="Escriba la opinión" value="<?php echo htmlspecialchars($opinion); ?>">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar Testimonio</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>