<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
    <link rel="stylesheet" href="public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- pNotify -->
    <link href="public/pnotify/css/pnotify.css" rel="stylesheet" />
    <link href="public/pnotify/css/pnotify.buttons.css" rel="stylesheet" />
    <link href="public/pnotify/css/custom.min.css" rel="stylesheet" />
    <!-- pnotify -->
    <script src="public/pnotify/js/jquery.min.js">
    </script>
    <script src="public/pnotify/js/pnotify.js">
    </script>
    <script src="public/pnotify/js/pnotify.buttons.js">
    </script>
</head>

<body>
    <?php
    date_default_timezone_set("America/Lima");
    ?>
    <h1>BIENVENID@, REGISTRA TU ASISTENCIA</h1>
    <h2 id="fecha"><?= date("d/m/Y, h:i:s") ?></h2>
    <?php
    include "modelo/conexion.php";
    include "controlador/registrarasistencianuevoController.php";
    ?>
    <div class="container">
        <a class="acceso" href="vista/login/login.php">Ingresar al Sistema</a>
        <p class="dni">Ingrese su DNI</p>
        <form id="formAsistencia" action="" method="POST">
            <input type="number" placeholder="DNI del asesor" name="txtdni" id="txtdni">
            <div class="botones">
                <button id="botonEntrada" class="entrada" type="submit" name="btnEntrada" value="ok">ENTRADA</button>
            </div>
        </form>
    </div>

    <footer class="footer">
        Developed by: <a class="letra-footer" href="https://www.instagram.com/rodjessperu/">rodjess</a>
    </footer>

    <script>
        let dni = document.getElementById("txtdni");
        dni.addEventListener("input", function() {
            if (this.value.length > 9) {
                this.value = this.value.slice(0, 9)
            }
        })
    </script>

    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0)

        setInterval(() => {
            let fecha = new Date();
            let fechaHora = fecha.toLocaleString();
            document.getElementById("fecha").textContent = fechaHora;
        }, 1000);
    </script>
</body>

</html>