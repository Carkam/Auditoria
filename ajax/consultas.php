<?php
    
    require_once '../modelos/Consultas.php';

    $consulta = new Consultas();
    $fechainicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
    $fechafin=isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";
    $idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
    $idtienda=isset($_POST["idtienda"])? limpiarCadena($_POST["idtienda"]):"";

    switch($_GET["op"])
    {

        case 'comprasfecha':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];

            $rspta = $consulta->comprafecha($fecha_inicio, $fecha_fin);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
                    "2"=>$reg->proveedor,
                    "3"=>$reg->tienda,
                    "4"=>$reg->moneda,
                    "5"=>$reg->cantidadprod,
                    "6"=>$reg->impuesto,
                    "7"=>$reg->total,
                    "8"=>($reg->estado== 1) ?
                         '<span class="label bg-green">Aceptado</span>'
                         :      
                         '<span class="label bg-red">Anulado</span>'
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


        case 'ventasfechacliente':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            if($idcliente==0){
                $rspta = $consulta->ventasfecha($fecha_inicio, $fecha_fin);
                $data = Array();
            }else{
                $rspta = $consulta->ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente);
                $data = Array();
            }

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
                    "2"=>$reg->cliente,
                    "3"=>$reg->tienda,
                    "4"=>$reg->descuento,
                    "5"=>$reg->iva,
                    "6"=>$reg->total,
                    "7"=>$reg->cantidadprod,
                    "8"=>($reg->estado==1) ?
                         '<span class="label bg-green">Aceptado</span>'
                         :      
                         '<span class="label bg-red">Anulado</span>'
                );
                
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data,
                
            );
            echo json_encode($results);
        break;

        case 'devolucionfechacliente':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            if($idcliente==0){
                $rspta = $consulta->devolucionfecha($fecha_inicio, $fecha_fin);
                $data = Array();
            }else{
                $rspta = $consulta->devolucionfechacliente($fecha_inicio, $fecha_fin, $idcliente);
                $data = Array();
            }

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fechaventa,
                    "1"=>$reg->usuario,
                    "2"=>$reg->cliente,
                    "3"=>$reg->tienda,
                    "4"=>$reg->cantidadprod,
                    "5"=>$reg->total,
                    "6"=>$reg->fechadevolucion,
                    "7"=>$reg->comentario,
                    "8"=>($reg->estado==1) ?
                         '<span class="label bg-green">Aceptado</span>'
                         :      
                         '<span class="label bg-red">Anulado</span>'
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

        case 'bitacorafechausuario':

            $fecha_inicio = $_REQUEST["fecha_inicio"];
            $fecha_fin = $_REQUEST["fecha_fin"];
            $idcliente = $_REQUEST["idcliente"];

            if($idcliente==0){
                $rspta = $consulta->bitacorafecha($fecha_inicio, $fecha_fin);
                $data = Array();
            }else{
                $rspta = $consulta->bitacorafechausuario($fecha_inicio, $fecha_fin, $idcliente);
                $data = Array();
            }

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->fecha,
                    "1"=>$reg->usuario,
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

        case 'inventarioxtienda':

            $idtienda = $_REQUEST["idtienda"];

            $rspta = $consulta->inventarioxtienda($idtienda);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->nombre,
                    "1"=>$reg->precio,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->proveedor,
                    "4"=>$reg->cantidad,
                    "5"=>($reg->estado) ?
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

        case 'inventario':

            $rspta = $consulta->inventario();
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->nombre,
                    "1"=>$reg->precio,
                    "2"=>$reg->descripcion,
                    "3"=>$reg->proveedor,
                    "4"=>$reg->cantidad,
                    "5"=>($reg->estado) ?
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

        case 'totalVenta':
				
			$rspta=$consulta->totalVenta($fechainicio,$fechafin,$idcliente);
 		//Codificar el resultado utilizando json
 			echo json_encode($rspta);
		
	    break;

        case 'totalCompra':
				
			$rspta=$consulta->totalCompra($fechainicio,$fechafin);
 		//Codificar el resultado utilizando json
 			echo json_encode($rspta);
		
	    break;

        case 'totalInventario':
				
			$rspta=$consulta->totalInventario($idtienda);
 		//Codificar el resultado utilizando json
 			echo json_encode($rspta);
		
	    break;

        case 'totalDevoluciones':
				
			$rspta=$consulta->totalDevoluciones($fechainicio,$fechafin,$idcliente);
 		//Codificar el resultado utilizando json
 			echo json_encode($rspta);
		
	    break;
    }

?>