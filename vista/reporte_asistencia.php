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

    <h4 class="text-secondary text-center">REPORTE AVANZADO</h4>
    <?php
    include "../modelo/conexion.php";
    $sql = $conexion->query("select * from empleado");
    ?>

    <form id="reporteForm">
        <input required type="date" name="txtFechainicio" class="input input__text mb-2">
        <input required type="date" name="txtFechafinal" class="input input__text mb-2">
        <select required name="txtAsesor" id="" class="input input__select mb-3">
            <option value="todos">Todos los empleados</option>
            <?php while ($datos = $sql->fetch_object()) { ?>
                <option value="<?= $datos->id_empleado ?>"><?= $datos->nombre . " " . $datos->apellido ?></option>
            <?php } ?>
        </select>
        <button type="button" onclick="submitForm('fpdf/reporteAsistenciaAvanzado.php')" class="btn btn-primary w-100 p-3">Generar Reporte</button>
        <!-- <button type="button" onclick="submitForm('fpdf/reporteBano.php')" class="btn btn-success w-100 p-3 mt-2">Generar Reporte de Primer Baño</button> -->
        <!-- <button type="button" onclick="submitForm('fpdf/reporteBano2.php')" class="btn btn-success w-100 p-3 mt-2">Generar Reporte de Segundo Baño</button> -->
        <button type="button" onclick="submitForm('fpdf/reporteBanoTotal.php')" class="btn btn-success w-100 p-3 mt-2">Generar Reporte Total de Baño</button>
    </form>

    <script>
        function submitForm(action) {
            var form = document.getElementById('reporteForm');
            form.action = action;
            form.target = "_blank"; // Abre el reporte en una nueva pestaña
            form.submit();
        }
    </script>


</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>