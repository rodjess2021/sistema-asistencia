<?php
    if (!empty($_POST["btnmodificar"])) {
        if (!empty($_POST["txtNombre"]) and !empty($_POST["txtApellido"]) and !empty($_POST["txtUsuario"])) {
            $nombre=$_POST["txtNombre"];
            $apellido=$_POST["txtApellido"];
            $usuario=$_POST["txtUsuario"];
            $id=$_POST["txtId"];
            $sql=$conexion->query(" select count(*) as 'total' from usuario where usuario='$usuario' and id_usuario!=$id");
            if ($sql->fetch_object()->total > 0) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "El usuario <?= $usuario ?> ya existe",
                            styling: "bootstrap3"
                        })
                    })
                </script>
           <?php } else {
                $modificar=$conexion->query( " update usuario set nombre='$nombre', apellido='$apellido', usuario='$usuario' where id_usuario=$id ");
                if ($modificar == true) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "El usuario se ha modificado correctamente",
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
                                text: "Error al modificar usuario",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
            <?php    }
            }
        } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Todos los campos son obligatorios >:( ",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php    } ?>
    <script>
            setTimeout(() =>{
                window.history.replaceState(null, null, window.location.pathname);
            }, 0)
    </script>

<?php   }