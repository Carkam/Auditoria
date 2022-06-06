<?php
    
    require_once '../modelos/Bitacora.php';

    $bitacora = new Bitacora();

    switch($_GET["op"])
    {
        case 'insertar':
            $usuario = $_REQUEST["usuario"];
            $accion = $_REQUEST["accion"];
            $rspta=$bitacora->insertar($usuario,$accion);
            echo $rspta ? "BITACORA registrado" : "BITACORA no se pudo registrar";
        break;

        case 'insertar2':
            $usuario = $_REQUEST["usuario"];
            $clave = $_REQUEST["clave"];
            $accion = $_REQUEST["accion"];
            $clavehash = hash("SHA256",$clave);
            $rspta=$bitacora->insertar2($usuario,$clavehash,$accion);
            echo $rspta ? "BITACORA registrado" : "BITACORA no se pudo registrar";
        break;

        case 'mostrar':
            // echo ('<script>console.log("'.$idtienda.'")</script>');  
            $rspta = $tienda->mostrar($idtienda);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $bitacora->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    // "0"=> '<button class="btn btn-warning" onclick="mostrar('.$reg->idBitacora.')" disabled><li class="fa fa-pencil"></li></button>'.
                    // ' <button class="btn btn-primary" onclick="desactivar('.$reg->idBitacora.')" disabled><li class="fa fa-close"></li></button>',
                    // "0"=> '<button class="btn btn-warning" onclick="mostrar('.$reg->idBitacora.')"><li class="fa fa-pencil"></li></button>'.
                    // ' <button class="btn btn-primary" onclick="desactivar('.$reg->idBitacora.')"><li class="fa fa-close"></li></button>',
                     "0"=>$reg->usuario,
                     "1"=>$reg->fecha,
                     "2"=>$reg->accion
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