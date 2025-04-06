<?php
include("../../templates/header.php");
include("../../../admin/bd.php");

$nombre = $ingredientes = $precio = $foto = "";
$txtID = isset($_GET["txtID"]) ? $_GET["txtID"] : "";

if ($txtID) {
    $sentencia = $conn->prepare("SELECT * FROM menu WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    if ($registro = $sentencia->fetch(PDO::FETCH_LAZY)) {
        $nombre = $registro["nombre"];
        $ingredientes = $registro["ingredientes"];
        $precio = $registro["precio"];
        $foto = $registro["foto"];
    }
}

if ($_POST) {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $ingredientes = isset($_POST["ingredientes"]) ? $_POST["ingredientes"] : "";
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
    $foto = isset($_POST["foto"]) ? $_POST["foto"] : "";
    $txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";

    $sentencia = $conn->prepare("UPDATE menu SET nombre=:nombre, ingredientes=:ingredientes, precio=:precio, foto=:foto WHERE id=:id");
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":ingredientes", $ingredientes);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":foto", $foto);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    header("Location: /admin/seccion/menu/index.php");
    exit;
}
?>

<div class="card">
    <div class="card_header">Editar Menú</div>
    <div class="card_body">
        <form method="post">
            <input type="hidden" name="txtID" value="<?php echo htmlspecialchars($txtID); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre del menú" value="<?php echo htmlspecialchars($nombre); ?>">
            </div>
            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes</label>
                <input type="text" class="form-control" name="ingredientes" id="ingredientes" placeholder="Escriba los ingredientes del menú" value="<?php echo htmlspecialchars($ingredientes); ?>">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" name="precio" id="precio" placeholder="Escriba el precio del menú" value="<?php echo htmlspecialchars($precio); ?>">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="text" class="form-control" name="foto" id="foto" placeholder="Escriba el enlace de la foto del menú" value="<?php echo htmlspecialchars($foto); ?>">
            </div>
            <button type="submit" class="btn btn-success">Editar Menú</button>
            <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>