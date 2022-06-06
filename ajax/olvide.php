<?php

    session_start();
    
    require_once '../modelos/Usuario.php';

    $usuario = new Usuario();

    switch($_GET["op"])
    {
        case 'verificar':
            $usuarioa = $_POST['usuarioa'];
            $clavea = $_POST['clavea'];
            //Desencriptar clave SHA256
            $clavehash = hash("SHA256",$clavea);

            $rspta = $usuario->verificar2($usuarioa,$clavehash);
           
        break;

       

    }

?>