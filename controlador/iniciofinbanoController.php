<?php
// Configurar la zona horaria
date_default_timezone_set("America/Lima");

$conexion = new mysqli("localhost", "root", "", "sistema-asistencia");

// Verificar conexión
if ($conexion->connect_error) {
    die("La conexión ha fallado: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['txtdni'];

    if (empty($dni)) {
        echo "El DNI no puede estar vacío";
        exit;
    }

    $empleadoQuery = $conexion->query("SELECT id_empleado FROM empleado WHERE dni = '$dni'");
    $empleado = $empleadoQuery->fetch_assoc();
    if (!$empleado) {
        echo "Empleado no encontrado";
        exit;
    }
    $id_empleado = $empleado['id_empleado'];

    if (isset($_POST['btnInicioBano'])) {
        // Iniciar baño
        $inicioBanoQuery = $conexion->query("SELECT id_asistencia FROM asistencia WHERE id_empleado = $id_empleado AND DATE(entrada) = CURDATE()");
        $asistencia = $inicioBanoQuery->fetch_assoc();
        $id_asistencia = $asistencia['id_asistencia'];

        $conexion->query("UPDATE asistencia SET bano_inicio = NOW() WHERE id_asistencia = $id_asistencia");
        echo "Inicio del baño registrado.";
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
            $conexion->query("UPDATE asistencia SET bano = '$bano_formato', bano_inicio = NULL WHERE id_asistencia = $id_asistencia");

            echo "Fin del baño registrado.";
        } else {
            echo "No hay un inicio de baño registrado.";
        }
    }
}

$conexion->close();
?>
