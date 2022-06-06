<?php 
session_start();

include './conexion.php';

$fecha1 = date("Y-m-d H:i:s");
$conexion->query("insert into devolucion (idVentaEncabezado,fecha,comentario,estado)  
     values( 
       '".$_POST['c_fname']."','$fecha1','".$_POST['motivo']."','1')   
   ")or die($conexion->error);

$conexion->query("update ventaencabezado set estado=2 where idVentaEncabezado='".$_POST['c_fname']."'")or die($conexion->error);
header("Location: ../gracias.php" );

?>