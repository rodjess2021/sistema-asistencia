<?php
if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtId"])) {
        $id = $_POST["txtId"];
        $nombre = $_POST["txtNombre"];
        $telefono = $_POST["txtTelefono"];
        $ubicacion = $_POST["txtUbicacion"];
        $ruc = $_POST["txtRuc"];
        $sql = $conexion->query("update empresa set nombre='$nombre', telefono='$telefono', ubicacion='$ubicacion', ruc='$ruc' where id_empresa=$id ");
        if ($sql == true) { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "CORRECTO",
                        type: "success",
                        text: "Los datos se han modificado correctamente",
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
                    text: "No se ha enviado el identificador",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0)
    </script>
<?php }
?>