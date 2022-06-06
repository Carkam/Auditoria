<?php
    
    require_once '../modelos/Caracteristicas.php';

    $categoria = new Caracteristicas();

    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion=isset($_POST["desplegable"])? limpiarCadena($_POST["desplegable"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idcategoria)){
                $rspta=$categoria->insertar($nombre,$descripcion,$imagen);
                echo $rspta ? "Caracteristica registrada" : "Caracteristica no se pudo registrar";
            }
            else {
                $rspta=$categoria->editar($idcategoria,$nombre,$descripcion,$imagen);
                echo $rspta ? "Caracteristica actualizada" : "Caracteristica no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $categoria->desactivar($idcategoria);
                echo $rspta ? "Caracteristica desactivada" : "Caracteristica no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $categoria->activar($idcategoria);
            echo $rspta ? "Caracteristica activada" : "Caracteristica no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $categoria->mostrar($idcategoria);          
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $categoria->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idCaracteristica.')" title="mostrar"><li class="fa fa-pencil"></li></button>'
                      
                        ,
                    "1"=>$reg->caracteristica,
                    "2"=>($reg->desplegable) ? 
                            "Si":"No",
                    "3"=>$reg->opciones
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