<?php
if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtClaveActual"]) and !empty($_POST["txtClaveNueva"]) and !empty($_POST["txtId"])) {
        $claveactual = md5($_POST["txtClaveActual"]);
        $clavenueva = md5($_POST["txtClaveNueva"]);
        $id = $_POST["txtId"];
        $verificarclaveactual = $conexion->query(" select password from usuario where id_usuario=$id");
        if ($verificarclaveactual->fetch_object()->password == $claveactual) {
            $sql = $conexion->query("update usuario set password='$clavenueva' where id_usuario=$id ");
            if ($sql == true) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "La contraseña se ha modificado correctamente",
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
                            text: "Error al modificar contraseña",
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
                        text: "La contraseña actual es incorrecta",
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
    <?php } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0)
    </script>
<?php }
?>