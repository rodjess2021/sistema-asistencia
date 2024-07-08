<?php 
    session_start();
    session_destroy();
    header("location:/sistema-asistencia/vista/login/login.php")
?>