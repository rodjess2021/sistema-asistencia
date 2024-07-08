<?php
   session_start();
   if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
       header('location:login/login.php');
   }

?>

<style>
    ul li:nth-child(2) .activo{
        background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

    <h4 class="text-secondary text-center">REGISTRO DE USUARIOS</h4>
    <?php
    include '../modelo/conexion.php';
    include "../controlador/registrarusuarioController.php"
    ?>

    <div class="row">
        <form action="" method="POST">
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Nombre" class="input input__text" name="txtNombre">
            </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Apellido" class="input input__text" name="txtApellido">
            </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="text" placeholder="Usuario" class="input input__text" name="txtUsuario">
            </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
                <input type="password" placeholder="Contraseña" class="input input__text" name="txtPassword">
            </div>

            <div class="text-right p-2">
                <a href="usuario.php" class="btn btn-secondary btn-rounded">Atras</a>
                <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
            </div>
        </form>
    </div>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>