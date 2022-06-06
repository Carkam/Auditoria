<?php
    
    require_once '../modelos/Moneda.php';

    $moneda = new Moneda();

    $idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $simbolo=isset($_POST["simbolo"])? limpiarCadena($_POST["simbolo"]):"";
    $tcambio=isset($_POST["tcambio"])? limpiarCadena($_POST["tcambio"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idmoneda)){
                $rspta=$moneda->insertar($nombre, $simbolo, $tcambio);
                echo $rspta ? "Moneda registrada" : "Moneda no se pudo registrar";
            }
            else {
                $rspta=$moneda->editar($idmoneda,$nombre,$simbolo,$tcambio);
                echo $rspta ? "Moneda actualizada" : "Moneda no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $moneda->desactivar($idmoneda);
                echo $rspta ? "Moneda desactivada" : "Moneda no se pudo desactivar";
        break;

        case 'desactivarP':
                $rspta = $moneda->desactivarP($idmoneda);
                echo $rspta ? "Moneda desactivada" : "Moneda no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $moneda->activar($idmoneda);
            echo $rspta ? "Moneda activado" : "Moneda no se pudo activar";
        break;

        case 'mostrar':            
            $rspta = $moneda->mostrar($idmoneda);         
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $moneda->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado) ? 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipomoneda.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idtipomoneda.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivarP('.$reg->idtipomoneda.')" title="inactivar"><li class="fa fa-close"></li></button>'
                    :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idtipomoneda.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idtipomoneda.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idtipomoneda.')" title="activar"><li class="fa fa-check"></li></button>'
                    ,
                     "1"=>$reg->moneda,
                     "2"=>$reg->simbolo,
                     "3"=>$reg->tipocambio,
                     "4"=>($reg->estado) ?
                     '<span class="label bg-green">Activado</span>'
                     :      
                     '<span class="label bg-red">Desactivado</span>'
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

        case 'selectCategoria':
            require_once "../modelos/Articulo.php";
            $producto = new Articulo();

            $rspta = $producto->listarProducto();
            
            while($reg = $rspta->fetch_object())
            {
                
                echo '<option value='.$reg->idProducto.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
            
        break;
    }

?>