<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idventaencabezado=isset($_POST["idventaencabezado"])? limpiarCadena($_POST["idventaencabezado"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		$nit = $_REQUEST["nit"];
		$fecha = $_REQUEST["fecha"];
		$total = $_REQUEST["total"];
		$descuentocompra = $_REQUEST["descuentocompra"];
		$iva = $_REQUEST["iva"];
		$usuario = $_REQUEST["usuario"];
		$idtienda = $_REQUEST["idtienda"];
		$pago = $_REQUEST["pago"];
		$moneda = $_REQUEST["moneda"];
		$articulos = $_REQUEST["articulos"];
		$cantidad = $_REQUEST["cantidad"];
		$descuento = $_REQUEST["descuento"];
		$to = $_REQUEST["correo"];
		
		$rspta=$venta->insertar($nit,$fecha,$total,$descuentocompra,$iva,$usuario,$idtienda,$pago,$moneda,$articulos,$cantidad,$descuento);
		echo $rspta ? "Venta registrada" : "Venta no se pudo registrar";   
		
		/*$subject = "Compra Realizada";
		$message = 'Compra realizada con exito'. "\r\n" ;
		$message .= 'Fecha: '.$fecha. "\r\n" ;
		$message .= 'NIT: '.$nit. "\r\n" ;
		$message .= 'Total: '.$total. "\r\n" ;
		$message .= 'Pronto estará recibiendo su factura electrónica, de lo contrario comuníquese con nosotros' ;
		
		include '../Tienda/php/correo.php';
		$correo = new Correo();

		$correo->CompraRealizada($to,$subject,$message);*/
	break;

	case 'anular':
		$rspta=$venta->anular($idventaencabezado);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'activar':
		$rspta=$venta->activar($idventaencabezado);
 		echo $rspta ? "Venta activada" : "Venta no se puede activar";
	break;

	case 'mostrar':
				
			$rspta=$venta->mostrar($idventaencabezado);
 		//Codificar el resultado utilizando json
 			echo json_encode($rspta);
		
		
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
									<th>Descuento</th>
									<th>IVA</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>Q'.$reg->precio.'</td>
					<td>Q'.$reg->descuento.'</td><td>Q'.$reg->iva.'</td><td>Q'.$reg->subtotal.'</td></tr>';
					$total+=($reg->precio*$reg->cantidad)-$reg->descuento;
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
									<th></th>
									<th></th>
                                    <th><h4 id="total">Q '.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
		
 		//Vamos a declarar un array
 		$data= Array();
		 while ($reg=$rspta->fetch_object())
		 {
			/*if($reg->tipo_comprobante=='Ticket')
			{
				$url = '../reportes/exTicket.php?id='; //Ruta del archivo exTicket
			}
			else
			{
				$url = '../reportes/exFactura.php?id='; //Ruta del archivo exFactura
			}*/
			switch($reg->estado){
				case 0: $tag='<span class="label bg-red">Inactiva</span>';
					break;
				case 1: $tag='<span class="label bg-green">Activa</span>';
					break;
				case 2: $tag='<span class="label bg-blue">Devuelta</span>';
					break;
			}
 			$data[]=array(
 				"0"=>(
					 ($reg->estado==1)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventaencabezado.')"><i class="fa fa-eye"></i></button>'.
						' <button class="btn btn-danger" onclick="anular('.$reg->idventaencabezado.')"><i class="fa fa-close"></i></button>':
						'<button class="btn btn-warning" onclick="mostrar('.$reg->idventaencabezado.')"><i class="fa fa-eye"></i></button>'.
						' <button class="btn btn-primary" onclick="activar('.$reg->idventaencabezado.')"><i class="fa fa-check"></i></button>'
					 )/*.
					 '<a target="_blank" href="'.$url.$reg->idventaencabezado.'">
						  <button class="btn btn-info">
						 <i class="fa fa-file"></i>
						 </button>
					 </a>'*/
					 ,
					"1"=>$reg->idventaencabezado,
					"2"=>$reg->fecha,
					"3"=>$reg->nombre.' '.$reg->apellido,
					"4"=>$reg->cantidadprod,
					"5"=>'Q '.$reg->descuento,
					"6"=>'Q '.$reg->iva,
					"7"=>'Q '.$reg->total,
					"8"=>$reg->tienda,
					"9"=>$reg->pago,
					"10"=>$reg->moneda,
					"11"=>$tag
					);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectCliente':
		require_once "../modelos/Cliente.php";
		$cliente = new Cliente();

		$rspta = $cliente->listarp();
		echo '<option value=0></option>';
		while ($reg = $rspta->fetch_object())
				{
				echo '<option value='. $reg->NIT.' data-nombre='. $reg->Nombre.' data-apellido='. $reg->Apellido.' data-correo='. $reg->Correo.' data-dir='. $reg->Direccion.'>' . $reg->Nombre .' '.$reg->Apellido. '</option>';
				}
	break;

	case 'selectCliente2':
		require_once "../modelos/Cliente.php";
		$cliente = new Cliente();

		$rspta = $cliente->listarp();
		echo '<option value=0></option>';
		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idCliente . '>' . $reg->Nombre .' '.$reg->Apellido. '</option>';
				}
	break;

	case 'selectPago':
		require_once "../modelos/TipoPago.php";
		$tipoPago = new TipoPago();

		$rspta = $tipoPago->listar();
		echo '<option value=0></option>';
		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idtipodepago . '>' . $reg->nombre . '</option>';
				}
	break;
	

	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();
		$idtienda = $_REQUEST["idtienda"];
		$rspta=$articulo->listarActivosVenta($idtienda);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->precio.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->stock,
 				"4"=>$reg->precio,
 				"5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;
}
?>