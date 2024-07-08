<?php
if (!empty($_POST["btnEntrada"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("select count(*) as 'total' from empleado where dni='$dni'");
        $id = $conexion->query("select id_empleado from empleado where dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d h:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("select entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1");
            $fechaBD = $consultaFecha->fetch_object()->entrada;
            if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró su entrada el día de hoy.",
                            styling: "bootstrap3"
                        })
                    })
                </script>
                <?php } else {
                $sql = $conexion->query("insert into asistencia(id_empleado,entrada)values($id_empleado,'$fecha')");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Asistencia registrada exitosamente, Bienvenid@ :)",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                <?php } else { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "INCORRECTO",
                                type: "error",
                                text: "Error al registrar entrada",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
            <?php }
            }
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "El DNI ingresado no existe, pida a un administrador que lo registre",
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
                    text: "Ingrese su DNI, es obligatorio",
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

<?php
if (!empty($_POST["btn1Sshhinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `1Sshh_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(`1Sshh_inicio`) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'1Sshh_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el inicio de su primer baño del día de hoy.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else {
                if ($id_asistencia) {
                    // Actualizar registro existente
                    $sql = $conexion->query("UPDATE asistencia SET `1Sshh_inicio`='$fecha' WHERE id_asistencia=$id_asistencia");
                } else {
                    // Insertar nuevo registro
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, `1Sshh_inicio`) VALUES($id_empleado, '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Baño registrado exitosamente",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                <?php } else { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "INCORRECTO",
                                type: "error",
                                text: "Error al registrar Inicio de Baño",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                <?php }
            }
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "El DNI ingresado no existe, pida a un administrador que lo registre",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Ingrese su DNI, es obligatorio",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
<?php }
?>

<!-- Registro de Fin de 1Sshh -->
<?php
if (!empty($_POST["btn1Sshhfin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `1Sshh_inicio`, `1Sshh_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(`1Sshh_inicio`) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (!$datos || !$datos->{'1Sshh_inicio'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar el inicio de su primer baño",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else if ($datos->{'1Sshh_fin'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya registró el fin de su primer baño del día de hoy.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else {
                $id_asistencia = $datos->id_asistencia;
                $sql = $conexion->query("UPDATE asistencia SET `1Sshh_fin`='$fecha' WHERE id_asistencia=$id_asistencia");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Fin de Primer Baño registrado correctamente",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                <?php } else { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "INCORRECTO",
                                type: "error",
                                text: "Error al registrar Fin de Primer Baño",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                <?php }
            }
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "El DNI ingresado no existe",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php }
    } else { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Ingrese el DNI, es obligatorio",
                    styling: "bootstrap3"
                });
            });
        </script>
    <?php } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
<?php }
?>


<!-- Registro de Salida -->
<?php
if (!empty($_POST["btnSalida"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("select count(*) as 'total' from empleado where dni='$dni'");
        $id = $conexion->query("select id_empleado from empleado where dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {

            $fecha = date("Y-m-d h:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;
            $busqueda = $conexion->query("select id_asistencia, entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1");

            while ($datos = $busqueda->fetch_object()) {
                $id_asistencia = $datos->id_asistencia;
                $entradaBD = $datos->entrada;
            }

            if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar su entrada",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else {
                $consultaFecha = $conexion->query("select salida from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1");
                $fechaBD = $consultaFecha->fetch_object()->salida;
    
                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "ERROR",
                                type: "error",
                                text: "Usted ya registro su salida el día de hoy",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                    <?php } else {
                    $sql = $conexion->query("update asistencia set salida='$fecha' where id_asistencia=$id_asistencia");
                    if ($sql == true) { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "CORRECTO",
                                    type: "success",
                                    text: "Salida registrada exitosamente, vuelve pronto",
                                    styling: "bootstrap3"
                                });
                            });
                        </script>
                    <?php } else { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "INCORRECTO",
                                    type: "error",
                                    text: "Error al registrar salida",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                <?php }
                }
            }  
        } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "El DNI ingresado no existe",
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
                    text: "Ingrese el DNI, es obligatorio",
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