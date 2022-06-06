<?php 

session_start();
include './conexion.php';

    $_SESSION['idusuarioT'] = null;
    $_SESSION['nombreT'] = null;
    $_SESSION['idcliente'] = null;
    $_SESSION['name'] = null;
    $_SESSION['ape'] = null;
    $_SESSION['nit'] = null;
    $_SESSION['direccion'] = null;
    $_SESSION['correo'] = null;
    $_SESSION['telefono'] = null;

    header("Location: ../index.php" );



?>