<?php
    if (!empty($_POST["btnregistrar"])) {
        if (!empty($_POST["txtNombre"]) and !empty($_POST["txtApellido"]) and !empty($_POST["txtUsuario"]) and !empty($_POST["txtPassword"]) ) {
            $nombre=$_POST["txtNombre"];
            $apellido=$_POST["txtApellido"];
            $usuario=$_POST["txtUsuario"];
            $password=md5($_POST["txtPassword"]);

            $sql=$conexion->query(" select count(*) as 'total' from usuario where usuario='$usuario'");
            if ($sql->fetch_object()->total > 0) {  ?>
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
                $registro=$conexion->query(" insert into usuario(nombre,apellido,usuario,password)values('$nombre','$apellido','$usuario','$password')");
                if($registro==true) {?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "El usuario se ha registrado correctamente",
                            styling: "bootstrap3"
                        })
                    })
                </script>

                <?php } else {?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "ERROR",
                                type: "error",
                                text: "Error al registrar",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
                <?php }
            }

        } else {?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Todos los campos son obligatorios >:(",
                    styling: "bootstrap3"
                })
            })
        </script>

        <?php } ?>
    <script>
            setTimeout(() =>{
                window.history.replaceState(null, null, window.location.pathname);
            }, 0)
    </script>       

    <?php }
?>