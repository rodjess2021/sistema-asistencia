<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header('location:login/login.php');
}

?>

<style>
    ul li:nth-child(1) .activo {
        background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

    <h4 class="text-secondary text-center">ASISTENCIA DE ASESORES</h4>
    <?php
    include "../modelo/conexion.php";
    include "../controlador/eliminarasistenciaController.php";
    $sql = $conexion->query(" SELECT
	asistencia.id_asistencia, 
	asistencia.id_empleado, 
	asistencia.entrada, 
	asistencia.1Descanso_inicio, 
	asistencia.1Descanso_fin, 
	asistencia.2Descanso_inicio, 
	asistencia.2Descanso_fin, 
	asistencia.Almuerzo_inicio, 
	asistencia.Almuerzo_fin,
    asistencia.bano,
    asistencia.bano_inicio, 
	asistencia.salida, 
	empleado.id_empleado, 
	empleado.nombre as 'nom_empleado', 
	empleado.apellido, 
	empleado.dni, 
	empleado.cargo, 
	cargo.id_cargo, 
	cargo.nombre as 'nom_cargo'
FROM
	asistencia
	INNER JOIN
	empleado
	ON 
		asistencia.id_empleado = empleado.id_empleado
	INNER JOIN
	cargo
	ON 
		empleado.cargo = cargo.id_cargo
    ORDER BY
        cargo.nombre ASC, asistencia.entrada ASC ");
    ?>

    <div class="text-right">
        <a href="fpdf/reporteAsistencia.php" target="_blank" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Exportar PDF</a>
    </div>

    <div class="text-right">
        <a href="reporte_asistencia.php" class="btn btn-primary mt-2"><i class="fas fa-plus"></i> Reporte avanzado</a>
    </div>

    <div class="text-right">
        <a href="fpdf/export_excel.php" class="btn btn-success mt-2 mb-2"><i class="fas fa-file-excel"></i> Exportar a Excel</a>
    </div>
    <table class="table table-bordered table-hover col-12" id="example">
        <thead>
            <tr>
                <th hidden scope="col">ID</th>
                <th scope="col">ASESOR</th>
                <!-- <th scope="col">DNI</th> -->
                <th scope="col">CARGO</th>
                <th scope="col-12">ENTRADA</th>
                <th scope="col">1BREAK_inicio</th>
                <th scope="col">1BREAK_fin</th>
                <th scope="col">2BREAK_inicio</th>
                <th scope="col">2BREAK_fin</th>
                <th scope="col">ALMUERZO_INICIO</th>
                <th scope="col">ALMUERZO_FIN</th>
                <th scope="col">INICIO BAÑO</th>
                <th scope="col">BAÑO</th>
                <th scope="col">SALIDA</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($datos = $sql->fetch_object()) { ?>
                <tr>
                    <td hidden><?= $datos->id_asistencia ?></td>
                    <td><?= $datos->nom_empleado . " " . $datos->apellido ?></td>
                    <!-- <td><?= $datos->dni ?></td> -->
                    <td><?= $datos->nom_cargo ?></td>
                    <td><?= $datos->entrada ?></td>
                    <td><?= $datos->{'1Descanso_inicio'} ?></td>
                    <td><?= $datos->{'1Descanso_fin'} ?></td>
                    <td><?= $datos->{'2Descanso_inicio'} ?></td>
                    <td><?= $datos->{'2Descanso_fin'} ?></td>
                    <td><?= $datos->Almuerzo_inicio ?></td>
                    <td><?= $datos->Almuerzo_fin ?></td>
                    <td><?= $datos->bano_inicio ?></td>
                    <td><?= $datos->bano ?></td>
                    <td><?= $datos->salida ?></td>
                    <!-- <td>
                    <a href="inicio.php?id=<?= $datos->id_asistencia ?>" onclick="advertencia(event)" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                </td> -->

                </tr>
            <?php  }
            ?>


        </tbody>
    </table>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>