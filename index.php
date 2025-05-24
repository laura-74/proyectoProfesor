<?php
include("admin/bd.php");
include("pilaMensaje.php"); // Importar la clase PilaMensajes
include 'recursivoTestimonio.php';
$sentencia = $conn->prepare("SELECT * FROM banner limit 1");
$sentencia->execute();
$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$listaBanner = $resultado;

$sentencia = $conn->prepare("SELECT * FROM testimonios limit 6");
$sentencia->execute();
$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$listaTestimonios = $resultado;


$sentencia = $conn->prepare("SELECT * FROM plato limit 2");
$sentencia->execute();
$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$listaplato = $resultado;

/*MATRIZ RESERVA DE MESAS */
$mesas = [
    ["Mesa 1", "Disponible"],
    ["Mesa 2", "Disponible"],
    ["Mesa 3", "Disponible"],
    ["Mesa 4", "Disponible"],
    ["Mesa 5", "Disponible"],
    ["Mesa 6", "Disponible"],
    ["Mesa 7", "Disponible"],
    ["Mesa 8", "Disponible"],
    ["Mesa 9", "Disponible"]
];

// Verificar si se ha realizado una reserva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mesa"])) {
    $mesaSeleccionada = $_POST["mesa"];
    $_SESSION["reserva"] = "Has reservado la " . $mesaSeleccionada;
}

/*PILA */


// Instanciar la pila
$pilaMensajes = new PilaMensajes();

// Guardar el mensaje si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $mensaje = $_POST["mensaje"];

    // Agregar el mensaje a la pila
    $pilaMensajes->agregarMensaje($nombre, $email, $telefono, $mensaje);
}


/*  COLA */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $mesa = $_POST["mesa"];
    $fecha = $_POST["fecha"];

    // Agregar la reserva a la cola
    $colaReservas->agregarReserva($nombre, $mesa, $fecha);
    echo "<p>Reserva agregada correctamente.</p>";
}


/*RECURSIVO TESTIMONIOS*/
$testimonios = obtenerTestimonios($conn);

/*iterarivos*/
$stmt = $conn->query("SELECT * FROM colaboradores");
$chefs = $stmt->fetchAll(PDO::FETCH_ASSOC); 
?>


<!doctype html>
<html lang="en">

<head>
    <title>Restaurante</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container">
            <ul class="nav navbar-nav">
                <a href="#" class="navbar-brand">Restaurante</a>
                <li class="nav-item">
                    <a class="nav-link active" href="#" aria-current="page">Inicio <span
                            class="visually-hidden">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#platos">Platos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#chefs">Chef</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#reservas">Reservaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sugenrenciaPlato/plato.html">Sugerencia de platos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonios">Testimonios</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/arbolMenu.php">Menú completo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/presupuesto.php">Presupuesto</a>
                </li>               
                <li class="nav-item">
                    <a class="nav-link" href="/binario.php">Buscar 🔎</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/authentication/login.php">Iniciar Sesión</a>
                </li>



            </ul>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

        </div>
    </nav>


    <section class="container-fluid p=0">
        <div class="banner-img"
            style="position:relative; background: url('/admin/images/banner.jpg') center/cover no-repeat; height:400px">
            <div class="banner-text"
                style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); text-align:center; color:white">
                <?php foreach ($listaBanner as $banner) { ?>

                    <h1><?php echo $banner['titulo']; ?></h1>
                    <p><?php echo $banner['descripcion']; ?></p>
                    <a href="<?php echo $banner['link'] ?>" class="btn btn-primary">Ver mas</a>
                <?php } ?>
            </div>
        </div>
    </section>

    <section id="chefs" class="py-5">
        <h2 class="text-center">Nuestros Chefs</h2>
        <div class="d-flex flex-wrap justify-content-center">
            <?php foreach ($chefs as $chef): ?>
                <div class="card m-3" style="width: 18rem;">
                    <img src="<?= htmlspecialchars($chef['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($chef['nombre']) ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($chef['nombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($chef['descripcion']) ?></p>
                        <div class="d-flex justify-content-around">
                            <a href="<?= htmlspecialchars($chef['facebook']) ?>" target="_blank" class="btn btn-primary btn-sm">Facebook</a>
                            <a href="<?= htmlspecialchars($chef['instagram']) ?>" target="_blank" class="btn btn-danger btn-sm">Instagram</a>
                            <a href="<?= htmlspecialchars($chef['youtube']) ?>" target="_blank" class="btn btn-dark btn-sm">YouTube</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="platos">
        <h2 class="text-center">Mejores platos</h2>
        <br>

        <div class="col d-flex p-5" style="justify-content: space-around; width: 100%; display: flex;">
            <?php foreach ($listaplato as $plato) { ?>
                <div class="card h-100">
                    <img src="<?php echo $plato['foto']; ?>" alt="Bandeja paisa">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $plato['nombre']; ?></h5>
                        <p class="card-text"><?php echo $plato['precio']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section id="reservas">
        <style>
            .reserva {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin: 1.5rem;

            }

            table {
                width: 50%;
                border-collapse: collapse;
            }

            td {
                width: 33%;
                height: 50px;
                text-align: center;
                border: 1px solid black;
            }

            button {
                padding: 10px;
                cursor: pointer;
            }

            /* Estilos del modal */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: white;
                margin: 15% auto;
                padding: 20px;
                width: 50%;
                text-align: center;
            }

            .close {
                cursor: pointer;
                font-size: 20px;
            }
        </style>
        </head>

        <body>
            <div class="reserva">
                <h2>Selecciona una mesa para reservar</h2>

                <form id="reservaForm" action="/admin/notificaciones/reservas.php" method="POST">
                    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
                        <label for="nombre">Tu nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
                        <label for="fecha">Fecha y hora de reserva:</label>
                        <input type="datetime-local" id="fecha" name="fecha" required>
                    </div>
                    <div>
                        <table>
                            <?php
                            $contador = 0;
                            for ($fila = 0; $fila < 3; $fila++) {
                                echo "<tr>";
                                for ($columna = 0; $columna < 3; $columna++) {
                                    echo "<td>";
                                    echo "<button type='submit' name='mesa' value='{$mesas[$contador][0]}' onclick='mostrarModal(event, \"{$mesas[$contador][0]}\")'>{$mesas[$contador][0]}</button>";
                                    echo "</td>";
                                    $contador++;
                                }
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </form>

                <!-- Modal -->
                <div id="modalReserva" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="cerrarModal()">&times;</span>
                        <h3 id="mensajeReserva"></h3>
                    </div>
                </div>
            </div>
            <script>
                // Array global para almacenar reservas
                let reservas = [];

                function mostrarModal(event, mesa) {
                    event.preventDefault(); // Evita que el formulario se envíe automáticamente

                    let nombre = document.getElementById("nombre").value;
                    let fecha = document.getElementById("fecha").value;

                    if (nombre && fecha) {
                        // Guardar la reserva en el array
                        let reserva = {
                            mesa: mesa,
                            nombre: nombre,
                            fecha: fecha
                        };
                        reservas.push(reserva);

                        // Mostrar la reserva en el modal
                        document.getElementById("mensajeReserva").innerHTML = `
            La ${mesa} ha sido reservada por ${nombre} el ${fecha}.
            <br><br>
            <button onclick="enviarReserva('${mesa}', '${nombre}', '${fecha}')" class="btn btn-primary">Confirmar Reserva</button>
        `;
                        document.getElementById("modalReserva").style.display = "block";

                    } else {
                        alert("Por favor ingresa tu nombre y fecha de reserva.");
                    }
                }

                function enviarReserva(mesa, nombre, fecha) {
                    // Crear un formulario dinámico para enviar los datos
                    let form = document.createElement("form");
                    form.method = "POST";
                    form.action = "/admin/notificaciones/reservas.php";

                    // Crear campos ocultos para enviar los datos
                    let inputMesa = document.createElement("input");
                    inputMesa.type = "hidden";
                    inputMesa.name = "mesa";
                    inputMesa.value = mesa;

                    let inputNombre = document.createElement("input");
                    inputNombre.type = "hidden";
                    inputNombre.name = "nombre";
                    inputNombre.value = nombre;

                    let inputFecha = document.createElement("input");
                    inputFecha.type = "hidden";
                    inputFecha.name = "fecha";
                    inputFecha.value = fecha;

                    // Agregar los campos al formulario
                    form.appendChild(inputMesa);
                    form.appendChild(inputNombre);
                    form.appendChild(inputFecha);

                    // Agregar el formulario al cuerpo y enviarlo
                    document.body.appendChild(form);
                    form.submit();
                }

                function cerrarModal() {
                    document.getElementById("modalReserva").style.display = "none";
                    console.log("Reservas guardadas:", reservas); // Para verificar las reservas en la consola
                }
            </script>

    </section>

    <section id="testimonios">
        <h2>Testimonios de Clientes</h2>
        <?php mostrarTestimonios($testimonios); ?>
    </section>

    <section id="contacto" class="container mt-4"> <br>
        <h2>Contacto</h2>
        <p>Para cualquier consulta o pedido, no dudes en contactarnos</p>
        <form action="/admin/notificaciones/sugerencias.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre"><br>
            <input type="text" class="form-control" name="email" id="email" placeholder="Ingrese su email"><br>
            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Ingrese su telefono"><br>
            <div class="mb-3">
                <label for="mensaje" class="form-label">mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="6"
                    placeholder="Ingrese su mensaje"></textarea>
            </div>
            <br>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Enviar mensaje" name="enviar">
            </div>
        </form>
    </section>


    <main>

    </main>


    <footer class="bg-dark text-white text-center p-3">
        <p> &copy ; 2023 Company, Inc. All rights reserved.</p>


    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>


</body>