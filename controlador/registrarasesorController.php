<?php
    if (!empty($_POST["btnregistrar"])) {
        if (!empty($_POST["txtNombre"]) and !empty($_POST["txtApellido"]) and !empty($_POST["txtCargo"]) and !empty($_POST["txtDni"]) ) {
            $nombre=$_POST["txtNombre"];
            $apellido=$_POST["txtApellido"];
            $cargo=$_POST["txtCargo"];
            $dni=$_POST["txtDni"];

            $sql=$conexion->query(" select count(*) as 'total' from empleado where dni='$dni'");
            if ($sql->fetch_object()->total > 0) {  ?>
            <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "El asesor con DNI <?= $dni ?> ya existe",
                            styling: "bootstrap3"
                        })
                    })
            </script>
            <?php } else {
                $registro=$conexion->query(" insert into empleado(nombre,apellido,dni,cargo)values('$nombre','$apellido','$dni',$cargo)");
                if($registro==true) {?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "El asesor se ha registrado correctamente",
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
                                text: "Error al registrar asesor",
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
                    text: "Todos los campos son obligatorios >:C",
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