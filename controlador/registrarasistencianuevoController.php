<!-- Registrar entrada -->
<?php
if (!empty($_POST["btnEntrada"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT count(*) as 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT entrada FROM asistencia WHERE id_empleado=$id_empleado ORDER BY id_asistencia DESC LIMIT 1");
            $fechaBD = $consultaFecha->fetch_object()->entrada;
            if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró su entrada el día de hoy.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada) VALUES($id_empleado, '$fecha')");
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
                        setTimeout(() => {
                            window.location.href = "index2.php";
                        }, 2000);
                    </script>
                <?php } else { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "INCORRECTO",
                                type: "error",
                                text: "Error al registrar entrada",
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

<!-- Registrar inicio de primer baño -->
<?php
if (!empty($_POST["btn1Sshhinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `1Sshh_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'1Sshh_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el inicio de su Primer Baño del día de hoy.",
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
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada, `1Sshh_inicio`) VALUES($id_empleado, '$fecha', '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Primer Baño registrado exitosamente",
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
                                text: "Error al registrar Inicio de Primer Baño",
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

<!-- Registrar fin de primer baño -->
<?php
if (!empty($_POST["btn1Sshhfin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `1Sshh_inicio`, `1Sshh_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
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

<!-- Registrar inicio de primer descanso -->
<?php
if (!empty($_POST["btn1Descansoinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `1Descanso_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'1Descanso_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el inicio de su Primer Break del día de hoy.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                if ($id_asistencia) {
                    // Actualizar registro existente
                    $sql = $conexion->query("UPDATE asistencia SET `1Descanso_inicio`='$fecha' WHERE id_asistencia=$id_asistencia");
                } else {
                    // Insertar nuevo registro
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada, `1Descanso_inicio`) VALUES($id_empleado, '$fecha', '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Primer Break registrado exitosamente",
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
                                text: "Error al registrar Inicio de Primer Break",
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

<!-- Registrar fin de primer descanso -->
<?php
if (!empty($_POST["btn1Descansofin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `1Descanso_inicio`, `1Descanso_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (!$datos || !$datos->{'1Descanso_inicio'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar el Inicio de su Primer Break",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else if ($datos->{'1Descanso_fin'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya registró el Fin de su Primer Break del día de hoy.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                $id_asistencia = $datos->id_asistencia;
                $sql = $conexion->query("UPDATE asistencia SET `1Descanso_fin`='$fecha' WHERE id_asistencia=$id_asistencia");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Fin de Primer Break registrado correctamente",
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
                                text: "Error al registrar Fin de Primer Break",
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

<!-- Registrar inicio de almuerzo -->
<?php
if (!empty($_POST["btnAlmuerzoinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `Almuerzo_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'Almuerzo_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el inicio de su Almuerzo",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                if ($id_asistencia) {
                    // Actualizar registro existente
                    $sql = $conexion->query("UPDATE asistencia SET `Almuerzo_inicio`='$fecha' WHERE id_asistencia=$id_asistencia");
                } else {
                    // Insertar nuevo registro
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada, `Almuerzo_inicio`) VALUES($id_empleado, '$fecha', '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Almuerzo registrado correctamente",
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
                                text: "Error al registrar Inicio de Almuerzo",
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

<!-- Registrar fin de almuerzo -->
<?php
if (!empty($_POST["btnAlmuerzofin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `Almuerzo_inicio`, `Almuerzo_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (!$datos || !$datos->{'Almuerzo_inicio'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar el Inicio de su Almuerzo",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else if ($datos->{'Almuerzo_fin'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya registró el Fin de su Almuerzo",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                $id_asistencia = $datos->id_asistencia;
                $sql = $conexion->query("UPDATE asistencia SET `Almuerzo_fin`='$fecha' WHERE id_asistencia=$id_asistencia");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Fin de Almuerzo registrado correctamente",
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
                                text: "Error al registrar Fin de Almuerzo",
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

<!-- Registrar inicio de segundo baño -->
<?php
if (!empty($_POST["btn2Sshhinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `2Sshh_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'2Sshh_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el Inicio de su Segundo Baño",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                if ($id_asistencia) {
                    // Actualizar registro existente
                    $sql = $conexion->query("UPDATE asistencia SET `2Sshh_inicio`='$fecha' WHERE id_asistencia=$id_asistencia");
                } else {
                    // Insertar nuevo registro
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada, `2Sshh_inicio`) VALUES($id_empleado, '$fecha', '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Segundo Baño registrado correctamente",
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
                                text: "Error al registrar Inicio de Segundo Baño",
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

<!-- Registrar fin de segundo baño -->
<?php
if (!empty($_POST["btn2Sshhfin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `2Sshh_inicio`, `2Sshh_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (!$datos || !$datos->{'2Sshh_inicio'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar el Inicio de su Segundo Baño",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else if ($datos->{'2Sshh_fin'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya registró el Fin de su Segundo Baño",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                $id_asistencia = $datos->id_asistencia;
                $sql = $conexion->query("UPDATE asistencia SET `2Sshh_fin`='$fecha' WHERE id_asistencia=$id_asistencia");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Fin de Segundo Baño registrado correctamente",
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
                                text: "Error al registrar Fin de Segundo Baño",
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

<!-- Registrar inicio de segundo descanso -->
<?php
if (!empty($_POST["btn2Descansoinicio"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $consultaFecha = $conexion->query("SELECT id_asistencia, `2Descanso_inicio` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $consultaFecha->fetch_object();
            $id_asistencia = $datos ? $datos->id_asistencia : null;
            $fechaBD = $datos ? $datos->{'2Descanso_inicio'} : null;

            if ($fechaBD) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "INCORRECTO",
                            type: "error",
                            text: "Usted ya registró el Inicio de su Segundo Break",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                if ($id_asistencia) {
                    // Actualizar registro existente
                    $sql = $conexion->query("UPDATE asistencia SET `2Descanso_inicio`='$fecha' WHERE id_asistencia=$id_asistencia");
                } else {
                    // Insertar nuevo registro
                    $sql = $conexion->query("INSERT INTO asistencia(id_empleado, entrada, `2Descanso_inicio`) VALUES($id_empleado, '$fecha', '$fecha')");
                }

                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Inicio de Segundo Break registrado correctamente",
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
                                text: "Error al registrar Inicio de Segundo Break",
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

<!-- Registrar fin de segundo descanso -->
<?php
if (!empty($_POST["btn2Descansofin"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;

            $busqueda = $conexion->query("SELECT id_asistencia, `2Descanso_inicio`, `2Descanso_fin` FROM asistencia WHERE id_empleado=$id_empleado AND DATE(entrada) = CURDATE() ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (!$datos || !$datos->{'2Descanso_inicio'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Primero debe registrar el Inicio de su Segundo Break",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else if ($datos->{'2Descanso_fin'}) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya registró el Fin de su Segundo Break",
                            styling: "bootstrap3"
                        });
                    });
                </script>
                <?php } else {
                $id_asistencia = $datos->id_asistencia;
                $sql = $conexion->query("UPDATE asistencia SET `2Descanso_fin`='$fecha' WHERE id_asistencia=$id_asistencia");
                if ($sql == true) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "CORRECTO",
                                type: "success",
                                text: "Fin de Segundo Break registrado correctamente",
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
                                text: "Error al registrar Fin de Segundo Break",
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


<!-- Registrar Inicio y fin de Baño -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['txtdni'];

    if (empty($dni)) { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "Ingrese el DNI, es obligatorio.",
                    styling: "bootstrap3"
                });
            });
            setTimeout(() => {
                window.location.href = "index2.php";
            }, 2000);
        </script>
    <?php
        exit;
    }

    $empleadoQuery = $conexion->query("SELECT id_empleado FROM empleado WHERE dni = '$dni'");
    $empleado = $empleadoQuery->fetch_assoc();
    if (!$empleado) { ?>
        <script>
            $(function notificacion() {
                new PNotify({
                    title: "ERROR",
                    type: "error",
                    text: "El DNI ingresado no existe",
                    styling: "bootstrap3"
                });
            });
            setTimeout(() => {
                window.location.href = "index2.php";
            }, 2000);
        </script>
        <?php
        exit;
    }
    $id_empleado = $empleado['id_empleado'];

    if (isset($_POST['btnInicioBano'])) {
        // Verificar si ya hay un inicio de baño registrado sin finalizar
        $verificarBanoQuery = $conexion->query("SELECT bano_inicio FROM asistencia WHERE id_empleado = $id_empleado AND DATE(entrada) = CURDATE() AND bano_inicio IS NOT NULL");
        if ($verificarBanoQuery->num_rows > 0) {
            echo '<script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Usted ya inició su tiempo de Baño",
                            styling: "bootstrap3"
                        });
                    });
                    setTimeout(() => {
                window.location.href = "index2.php";
            }, 2000);
                  </script>';
            exit;
        }

        // Iniciar baño
        $inicioBanoQuery = $conexion->query("SELECT id_asistencia FROM asistencia WHERE id_empleado = $id_empleado AND DATE(entrada) = CURDATE()");
        $asistencia = $inicioBanoQuery->fetch_assoc();
        $id_asistencia = $asistencia['id_asistencia'];

        if ($conexion->query("UPDATE asistencia SET bano_inicio = NOW() WHERE id_asistencia = $id_asistencia") === TRUE) { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "CORRECTO",
                        type: "success",
                        text: "Inicio de tiempo de Baño registrado correctamente.",
                        styling: "bootstrap3"
                    });
                });
            </script>
        <?php } else { ?>
            <script>
                $(function notificacion() {
                    new PNotify({
                        title: "ERROR",
                        type: "error",
                        text: "Error al registrar el inicio de tiempo de Baño.",
                        styling: "bootstrap3"
                    });
                });
            </script>
            <?php }
    } elseif (isset($_POST['btnFinBano'])) {
        // Finalizar baño
        $finBanoQuery = $conexion->query("SELECT id_asistencia, bano_inicio, bano FROM asistencia WHERE id_empleado = $id_empleado AND DATE(entrada) = CURDATE()");
        $asistencia = $finBanoQuery->fetch_assoc();
        $id_asistencia = $asistencia['id_asistencia'];
        $bano_inicio = $asistencia['bano_inicio'];
        $bano_acumulado = $asistencia['bano'];

        if ($bano_inicio) {
            $tiempo_bano = strtotime("now") - strtotime($bano_inicio); // Tiempo del baño en segundos

            // Convertir el tiempo acumulado anterior y el tiempo del baño actual a segundos
            $bano_acumulado_segundos = $bano_acumulado ? strtotime("1970-01-01 $bano_acumulado UTC") - strtotime("1970-01-01 00:00:00 UTC") : 0;
            $tiempo_total_segundos = $bano_acumulado_segundos + $tiempo_bano;

            // Convertir los segundos totales a formato "HH:MM:SS"
            $bano_formato = gmdate("H:i:s", $tiempo_total_segundos);

            // Actualizar la base de datos con el tiempo acumulado en formato "HH:MM:SS"
            if ($conexion->query("UPDATE asistencia SET bano = '$bano_formato', bano_inicio = NULL WHERE id_asistencia = $id_asistencia") === TRUE) { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "CORRECTO",
                            type: "success",
                            text: "Fin de tiempo de Baño registrado correctamente.",
                            styling: "bootstrap3"
                        });
                    });
                </script>
            <?php } else { ?>
                <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "ERROR",
                            type: "error",
                            text: "Error al registrar el fin de tiempo de Baño.",
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
                        text: "No hay un inicio de baño registrado.",
                        styling: "bootstrap3"
                    });
                });
            </script>
<?php }
    }
}

?>


<!-- Registrar Salida -->
<?php
if (!empty($_POST["btnSalida"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query("SELECT count(*) as 'total' FROM empleado WHERE dni='$dni'");
        $id = $conexion->query("SELECT id_empleado FROM empleado WHERE dni='$dni'");
        if ($consulta->fetch_object()->total > 0) {
            $fecha = date("Y-m-d H:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;
            $busqueda = $conexion->query("SELECT id_asistencia, entrada FROM asistencia WHERE id_empleado=$id_empleado ORDER BY id_asistencia DESC LIMIT 1");
            $datos = $busqueda->fetch_object();

            if (substr($fecha, 0, 10) != substr($datos->entrada, 0, 10)) { ?>
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
                $consultaFecha = $conexion->query("SELECT salida FROM asistencia WHERE id_empleado=$id_empleado ORDER BY id_asistencia DESC LIMIT 1");
                $fechaBD = $consultaFecha->fetch_object()->salida;

                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "ERROR",
                                type: "error",
                                text: "Usted ya registró su salida el día de hoy",
                                styling: "bootstrap3"
                            });
                        });
                    </script>
                    <?php } else {
                    $sql = $conexion->query("UPDATE asistencia SET salida='$fecha' WHERE id_asistencia=$datos->id_asistencia");
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
                            setTimeout(() => {
                                window.location.href = "index.php";
                            }, 2000);
                        </script>
                    <?php } else { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "INCORRECTO",
                                    type: "error",
                                    text: "Error al registrar salida",
                                    styling: "bootstrap3"
                                });
                            });
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