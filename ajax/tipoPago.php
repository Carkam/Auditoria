<?php
    
    require_once '../modelos/TipoPago.php';

    $tipoPago = new TipoPago();

    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idcategoria)){
                $rspta=$tipoPago->insertar($nombre,$descripcion);
                echo $rspta ? "Tipo de Pago registrado" : "Tipo de Pago no se pudo registrar";
            }
            else {
                $rspta=$tipoPago->editar($idcategoria,$nombre,$descripcion);
                echo $rspta ? "Tipo de Pago actualizado" : "Tipo de Pago no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $tipoPago->desactivar($idcategoria);
                echo $rspta ? "Tipo de pago desactivado" : "Tipo de pago no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $tipoPago->activar($idcategoria);
            echo $rspta ? "Tipo de pago activado" : "Tipo de pago no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $tipoPago->mostrar($idcategoria);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $tipoPago->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipodepago.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idtipodepago.')" title="inactivar"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipodepago.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idtipodepago.')" title="activar"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>($reg->estado==1) ?
                         '<span class="label bg-green">Activo</span>'
                         :      
                         '<span class="label bg-red">Inactivo</span>'
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