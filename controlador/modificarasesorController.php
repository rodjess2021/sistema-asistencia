<?php
if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtId"]) and !empty($_POST["txtNombre"]) and !empty($_POST["txtApellido"]) and !empty($_POST["txtDni"]) and !empty($_POST["txtCargo"])) {
        $id = $_POST["txtId"];
        $nombre = $_POST["txtNombre"];
        $apellido = $_POST["txtApellido"];
        $dni = $_POST["txtDni"];
        $cargo = $_POST["txtCargo"];
        $sql = $conexion->query("update empleado set nombre='$nombre', apellido='$apellido', cargo='$cargo' where id_empleado=$id");
        if ($sql == true) { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "CORRECTO",
                        type: "success",
                        text: "El asesor se ha modificado correctamente",
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
                        text: "Error al modificar asesor",
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
<?php    }
?>