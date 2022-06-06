<?php
    
    require_once '../modelos/promocion.php';

    $promocion = new Promocion();

    $idpromocion=isset($_POST["idpromocion"])? limpiarCadena($_POST["idpromocion"]):"";
    $fechai=isset($_POST["fechai"])? limpiarCadena($_POST["fechai"]):"";
    $fechaf=isset($_POST["fechaf"])? limpiarCadena($_POST["fechaf"]):"";
    $idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
    $descuento=isset($_POST["descuento"])? limpiarCadena($_POST["descuento"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idpromocion)){
                $rspta=$promocion->insertar($fechai,$fechaf,$idproducto,$descuento);
                echo $rspta ? "Promoción registrada" : "Promoción no se pudo registrar";
            }
            else {
                $rspta=$promocion->editar($idpromocion,$fechai,$fechaf,$idproducto,$descuento);
                echo $rspta ? "Promocion actualizada" : "Promocion no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $promocion->desactivar($idpromocion);
                echo $rspta ? "Promocion desactivada" : "Promocion no se pudo desactivar";
        break;

        case 'desactivarP':
                $rspta = $promocion->desactivarP($idpromocion);
                echo $rspta ? "Promocion desactivada" : "Promocion no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $promocion->activar($idpromocion);
            echo $rspta ? "Promocion activado" : "Promocion no se pudo activar";
        break;

        case 'mostrar':            
            $rspta = $promocion->mostrar($idpromocion);         
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $promocion->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado) ? 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idpromocion.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idpromocion.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivarP('.$reg->idpromocion.')" title="inactivar"><li class="fa fa-close"></li></button>'
                    :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idpromocion.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idpromocion.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idpromocion.')" title="activar"><li class="fa fa-check"></li></button>'
                    ,
                     "1"=>$reg->fechaInicio,
                     "2"=>$reg->fechaFinal,
                     "3"=>$reg->producto,
                     "4"=>$reg->descuento,
                     "5"=>($reg->estado) ?
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