<?php
if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtNombre"]) and !empty($_POST["txtApellido"]) and !empty($_POST["txtUsuario"])) {
        $nombre = $_POST["txtNombre"];
        $apellido = $_POST["txtApellido"];
        $usuario = $_POST["txtUsuario"];
        $id = $_POST["txtId"];
        $sql = $conexion->query(" update usuario set nombre='$nombre', apellido='$apellido', usuario='$usuario' where id_usuario=$id ");
        if ($sql == true) { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "CORRECTO",
                        type: "success",
                        text: "Datos modificados correctamente",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "Error al modificar los datos",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Todos los campos son obligatorios",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php    } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0)
    </script>
<?php }
?>