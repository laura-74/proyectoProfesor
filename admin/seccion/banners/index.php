<?php
include("../../bd.php");
if (isset($_GET["txtID"])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";


    $sentencia = $conn->prepare("DELETE FROM banner WHERE id= :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
}


$sentencia = $conn->prepare("SELECT * FROM banner");
$sentencia->execute();
$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
include("../../templates/header.php");
?>

<section class="container">
    <div class="card">
        <div class="card-header">
            <a name="" id="" class="btn btn-primary" href="crear.php" role="button"> agregar registro</a>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Enlace</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado as $key => $value) { ?>
                                <tr class="">
                                    <td scope="row"><?php echo $value["id"]; ?></td>
                                    <td><?php echo $value["titulo"]; ?></td>
                                    <td><?php echo $value["descripcion"]; ?></td>
                                    <td><?php echo $value["link"]; ?></td>
                                    <td>
                                        <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $value['id']; ?>" role="button">Editar </a>
                                        <a name="" id="" class="btn btn-danger" href="indexBanner.php?txtID=<?php echo $value['id']; ?>" role="button">Borrar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer text-muted">Footer</div>
        </div>
</section>
</div>