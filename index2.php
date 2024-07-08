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
    <h1 class="text-3xl font-bold">¡Que su jornada laboral sea productiva desde el inicio!</h1>
    <h2 id="fecha"><?= date("d/m/Y, h:i:s") ?></h2>
    <?php
    include "modelo/conexion.php";
    include "controlador/registrarasistencianuevoController.php";
    ?>
    <div class="container-final">
        <a class="acceso" href="vista/login/login.php">Ingresar al Sistema</a>
        <p class="dni">Ingrese su DNI</p>
        <form id="formAsistencia" action="" method="POST">
            <input type="number" placeholder="DNI del asesor" name="txtdni" id="txtdni">

            <div class="botones">
                <button id="boton1Descansoinicio" class="descanso" type="submit" name="btn1Descansoinicio" value="ok">1 BREAK inicio</button>
                <button id="boton1Descanso" class="descanso" type="submit" name="btn1Descansofin" value="ok">1 BREAK fin</button>

            </div>

            <div class="botones">
                <button id="boton2Descansoinicio" class="descanso" type="submit" name="btn2Descansoinicio" value="ok">2 BREAK inicio</button>
                <button id="boton2Descanso" class="descanso" type="submit" name="btn2Descansofin" value="ok">2 BREAK fin</button>
            </div>

            <div class="botones">
                <button id="botonAlmuerzoinicio" class="almuerzo" type="submit" name="btnAlmuerzoinicio" value="ok">ALMUERZO inicio</button>
                <button id="botonAlmuerzofin" class="almuerzo" type="submit" name="btnAlmuerzofin" value="ok">ALMUERZO fin</button>
            </div>

            <div class="botones">
                <button id="inicioBano" class="bano" type="submit" name="btnInicioBano" value="ok">Inicio Baño</button>
                <button id="finBano" class="bano" type="submit" name="btnFinBano" value="ok">Fin Baño</button>
            </div>
            <button id="botonSalida" class="salida" type="submit" name="btnSalida" value="ok">SALIDA</button>
        </form>
    </div>

    <footer class="footer-final">
        Developed by: <a class="letra-footer" href="https://www.instagram.com/rodjessperu/">rodjess</a>
    </footer>

    <script>
        // Función para copiar el DNI al formulario de baño
        document.getElementById('formBano').addEventListener('submit', function(event) {
            var dni = document.getElementById('txtdni').value;
            document.getElementById('txtdniBano').value = dni;
        });

        // Función para copiar el DNI al formulario de salida
        document.getElementById('formAsistenciaSalida').addEventListener('submit', function(event) {
            var dni = document.getElementById('txtdni').value;
            document.getElementById('txtdniSalida').value = dni;
        });
    </script>

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