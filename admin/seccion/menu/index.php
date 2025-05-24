<?php
include("../../bd.php");

// Eliminar un plato si se proporciona un ID
if (isset($_GET["txtID"])) {
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";

    // Verificar si el plato existe antes de eliminar
    $sentenciaVerificar = $conn->prepare("SELECT COUNT(*) FROM plato WHERE id = :id");
    $sentenciaVerificar->bindParam(":id", $txtID);
    $sentenciaVerificar->execute();
    $existePlato = $sentenciaVerificar->fetchColumn();

    if ($existePlato) {
        // Eliminar los ingredientes asociados al plato
        $sentenciaIngredientes = $conn->prepare("DELETE FROM plato_ingrediente WHERE plato_id = :plato_id");
        $sentenciaIngredientes->bindParam(":plato_id", $txtID);
        $sentenciaIngredientes->execute();

        // Eliminar el plato
        $sentencia = $conn->prepare("DELETE FROM plato WHERE id= :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
}

// Obtener todos los platos
$sentencia = $conn->prepare("SELECT * FROM plato");
$sentencia->execute();
$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php");
?>

<section class="container">
    <div class="card">
        <div class="card-header">
            <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Ingredientes</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $key => $value) { ?>
                            <tr class="">
                                <td scope="row"><?php echo $value["id"]; ?></td>
                                <td><?php echo $value["nombre"]; ?></td>
                                <td>
                                    <?php
                                    // Obtener los ingredientes asociados al plato
                                    $sentenciaIngredientes = $conn->prepare("
                                        SELECT ingrediente.nombre 
                                        FROM ingrediente 
                                        INNER JOIN plato_ingrediente 
                                        ON ingrediente.id = plato_ingrediente.ingrediente_id 
                                        WHERE plato_ingrediente.plato_id = :plato_id
                                    ");
                                    $sentenciaIngredientes->bindParam(":plato_id", $value["id"]);
                                    $sentenciaIngredientes->execute();
                                    $ingredientes = $sentenciaIngredientes->fetchAll(PDO::FETCH_COLUMN);

                                    echo implode(", ", $ingredientes);
                                    ?>
                                </td>
                                <td><?php echo $value["precio"]; ?></td>
                                <td><img src="<?php echo $value["foto"]; ?>" alt="Foto" width="50"></td>
                                <td>
                                    <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $value['id']; ?>" role="button">Editar</a>
                                    <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $value['id']; ?>" role="button">Borrar</a>
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