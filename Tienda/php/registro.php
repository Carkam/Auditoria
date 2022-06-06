<?php 
session_start();

include './conexion.php';


$conexion->query("insert into cliente (nombre,apellido,fechanacimiento,correo,telefono,direccion,nit)  
     values( 
       '".$_POST['nombre']."',
       '".$_POST['apellido']."',
       '".$_POST['fecha']."',
       '".$_POST['correo']."',
       '".$_POST['telefono']."',
       '".$_POST['dir']."',
       '".$_POST['nit']."'
       )   
   ")or die($conexion->error);
$id_cliente = $conexion ->insert_id;

$conexion->query("insert into usuariocliente (nombre,clave,imagen,idcliente)  
     values( 
       '".$_POST['usuario']."',
       '".$_POST['contra']."',
       '',
       '".$id_cliente."'
       )   
   ")or die($conexion->error);


header("Location: ../login.php" );

?>