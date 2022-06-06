<?php

    session_start();
    
    require_once '../modelos/Configuracion.php';

    $configuracion = new Configuracion();

    $idempresa=isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
    $empresa=isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";
    $nit=isset($_POST["nit"])? limpiarCadena($_POST["nit"]):"";
    $Eslogan=isset($_POST["Eslogan"])? limpiarCadena($_POST["Eslogan"]):"";
    $mision=isset($_POST["mision"])? limpiarCadena($_POST["mision"]):"";
    $vision=isset($_POST["vision"])? limpiarCadena($_POST["vision"]):"";
    $Valores=isset($_POST["Valores"])? limpiarCadena($_POST["Valores"]):"";
    $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $tel=isset($_POST["tel"])? limpiarCadena($_POST["tel"]):"";
    $correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
    

    switch($_GET["op"])
    {
        case 'guardaryeditar':

            if(!file_exists($_FILES['Logo']['tmp_name']) || !is_uploaded_file($_FILES['Logo']['tmp_name']))
            {
                $Logo = $_POST["imagenactual"];
            }
            else
            {
                $ext = explode(".",$_FILES["Logo"]["name"]);
                if($_FILES['Logo']['type'] == "image/jpg" || $_FILES['Logo']['type'] == "image/jpeg" || $_FILES['Logo']['type'] == "image/png")
                {
                    $Logo = round(microtime(true)).'.'.end($ext);
                    move_uploaded_file($_FILES['Logo']['tmp_name'], "../files/empresa/" . $Logo);
                }
            }

            $rspta=$configuracion->editar($idempresa,$empresa,$nit,$direccion,$correo,$tel,$Eslogan,$mision,$vision,$Valores,$Logo);
            echo $rspta ? "Configuracion actualizada" : "Configuracion no se pudo actualizar";
            
        break;

        case 'mostrar':
            $rspta = $configuracion->mostrar($idempresa);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $configuracion->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="mostrar('.$reg->idempresa.')"><li class="fa fa-pencil"></li></button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->nit,
                    "3"=>$reg->direccion,
                    "4"=>$reg->telefono,
                    "5"=>$reg->correo,
                    "6"=>$reg->eslogan,
                    "7"=>$reg->mision,
                    "8"=>$reg->vision,
                    "9"=>$reg->valores,
                    "10"=>"<img src='../files/empresa/".$reg->logo."' height='50px' width='50px'>",
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;

    }

?>