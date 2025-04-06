<?php
include("../../admin/bd.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreUsuario = $_POST['usuario'];
    $password = $_POST['password'];
    echo $nombreUsuario;
    echo $password;

    $query = ("SELECT * FROM usuario WHERE nombreUsuario = :nombreUsuario AND password = :password");
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nombreUsuario", $nombreUsuario);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($result) {
        $_SESSION['user'] = $result['nombreUsuario'];
        header('Location: ../seccion/index.php'); // Redirect to dashboard
        exit();
    } else {
        $error = "Correo o contraseña inválidos.";
    }
}


?>




<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-md-6">
                    <br>
                    <div class="card text-center">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3 row">
                                    <label for="inputName" class="col-sm-4 col-form-label">Usuario</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Contraseña</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password"  name="password" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button type="submit" class="btn btn-primary">Ingresar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>