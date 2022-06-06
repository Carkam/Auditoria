<?php 

session_start();
include './conexion.php';

$us=$_POST['c_fname'];
$con=$_POST['contra'];


$respuesta=$conexion->query("select nombre, idusuariocliente, idcliente from usuariocliente 
where nombre='".$us."' and 
clave='".$con."'")or die($conexion->error);

if (mysqli_num_rows($respuesta)>0){
    $fila = mysqli_fetch_row($respuesta);
    $_SESSION['idusuarioT'] = $fila[1];
    $_SESSION['nombreT'] = $fila[0];
    $_SESSION['idcliente'] = $fila[2];

    $consulta = $conexion ->query("select nombre, apellido, nit, direccion, correo, telefono 
    from cliente
    where idcliente='".$_SESSION['idcliente']."'") or die($conexion->error);
    if (mysqli_num_rows($consulta)>0){
        $fila2 = mysqli_fetch_row($consulta);
        $_SESSION['name'] = $fila2[0];
        $_SESSION['ape'] = $fila2[1];
        $_SESSION['nit'] = $fila2[2];
        $_SESSION['direccion'] = $fila2[3];
        $_SESSION['correo'] = $fila2[4];
        $_SESSION['telefono'] = $fila2[5];
    }

    echo '<script>console.log("'.$_SESSION['idcliente'].'")</script>';
    header("Location: ../index.php" );

}else {
    header("Location: ../login.php" );
}

?>