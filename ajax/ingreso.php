<?php
    
    require_once '../modelos/Ingreso.php';
    
    if(strlen(session_id()) < 1){
        session_start();
    }

    $ingreso = new Ingreso();

    $idcompraencabezado=isset($_POST["idcompraencabezado"])? limpiarCadena($_POST["idcompraencabezado"]):"";
    $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
    $idusuario= $_SESSION['idusuario'];
    $tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
    $serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
    $num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
    $fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
    $impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
    $total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

    $idarticulo = isset($_POST['idarticulo']) ? $_POST['idarticulo'] : "";
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
    $precio_compra =isset($_POST['precio_compra']) ? $_POST['precio_compra'] : "";
    $precio_venta =isset($_POST['precio_venta']) ? $_POST['precio_venta'] : "";


    switch($_GET["op"])
    {
        case 'guardaryeditar':
            /*if (empty($idingreso)){
                $rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta);
                echo $rspta ? "Ingreso registrado" : "Ingreso no se pudo registrar";
            }*/
            $idcompraencabezado = $_REQUEST["idcompraencabezado"];
            $fecha = $_REQUEST["fecha"];
            $idproveedor = $_REQUEST["idproveedor"];
            $idtienda = $_REQUEST["idtienda"];
            $precios = $_REQUEST["precios"];
            $impuesto = $_REQUEST["impuesto"];
            $usuario = $_REQUEST["usuario"];
            $moneda = $_REQUEST["moneda"];
            $total = $_REQUEST["total"];
            $articulos = $_REQUEST["articulos"];
            $cantidad = $_REQUEST["cantidad"];
            $configuraciones = $_REQUEST["configuraciones"];
            $ganancias = $_REQUEST["ganancias"];
            $estado = $_REQUEST["estado"];
            $to = $_REQUEST["correo"];
            if($idcompraencabezado==''){
                //echo 'se va a insertar';
                $rspta=$ingreso->insertar($fecha,$idproveedor,$idtienda,$precios,$impuesto,$usuario,$moneda,$total,$articulos,$cantidad);
                echo $rspta ? "Compra registrada" : "Compra no se pudo registrar";

                $rspta=$ingreso->modificarPrecioCompra($articulos,$configuraciones);

                $rspta=$ingreso->modificarPrecioVenta($articulos,$precios,$ganancias);

                /*$subject = "Pedido Realizado";
                $message = 'Pedido Realizado con éxito'. "\r\n" ;
                $message .= 'Fecha: '.$fecha. "\r\n" ;
                $message .= 'Total: '.$total. "\r\n" ;
                $message .= 'Saludos, se realizó un pedido, en un momento recibirá un documento con el listado de artículos que se necesitan.' ;
                
                include '../Tienda/php/correo.php';
                $correo = new Correo();

                $correo->CompraRealizada($to,$subject,$message);*/
            }else{
                //echo 'se va a modificar';
                $rspta=$ingreso->modificar($idcompraencabezado,$estado,$articulos,$cantidad,$idtienda);
                echo $rspta ? "Compra modificada" : "Compra no se pudo modificar";
            }                        
            
        break;

        case 'anular':
                /*$rspta = $ingreso->anular($idcompraencabezado);
                echo $rspta ? "Ingreso anulado" : "Ingreso no se pudo anular";*/
        break;

        case 'mostrar':
            $rspta = $ingreso->mostrar($idcompraencabezado);
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
            //Recibimos el idingreso
            $id=$_GET['id'];

            $rspta = $ingreso->listarDetalle($id);
            
            $total = 0;
            
            echo '<thead style="background-color:#A9D0F5">
                    <th>Articulos</th>
                    <th>Cantidad</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Subtotal</th>
                </thead>';
            $cont=0;
            while($reg = $rspta->fetch_object())
            {
                echo '<tbody>
                        <tr class="filas">
                            <td><input type="hidden" name="idarticulo'.$cont.'" id="idarticulo'.$cont.'" value="'.$reg->idproducto.'">'.$reg->nombre.'</td> 
                            <td><input type="hidden" name="cantidad'.$cont.'" id="cantidad'.$cont.'" value="'.$reg->cantidad.'">'.$reg->cantidad.'</td> 
                            <td>Q '.$reg->precio.'</td> 
                            <td>Q '.$reg->preciocompra.'</td> 
                            <td>Q '.$reg->precio * $reg->cantidad.'</td> 
                        </tr>
                      </tbody>';

                $total += ($reg->precio*$reg->cantidad);
                $cont++;
            }

            echo '<tfoot>
                    <th>TOTAL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                    <h4 id="total">Q '.$total.'</h4>
                    <input type="hidden" name="articulos" id="articulos" value="'.$cont.'">
                    <input type="hidden" name="total_compra" id="total_compra">
                    </th>
                </tfoot>';

        break;

        case 'listar':
            $rspta = $ingreso->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                switch($reg->estado){
                    case 0: $tag='<span class="label bg-red">Inactiva</span>';
                        break;
                    case 1: $tag='<span class="label bg-green">Activa</span>';
                        break;
                    case 2: $tag='<span class="label bg-blue">Recibida</span>';
                        break;
                    case 3: $tag='<span class="label bg-orange">Devuelta</span>';
                        break;
                }
                $data[] = array(
                    "0"=> ($reg->estado == 1) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idcompraencabezado.')"><li class="fa fa-pencil"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idcompraencabezado.')"><li class="fa fa-pencil"></li></button>',
                    "1"=>$reg->fecha,
                    "2"=>$reg->idcompraencabezado,
                    "3"=>$reg->proveedor,
                    "4"=>$reg->usuario,
                    "5"=>$reg->tienda,
                    "6"=>$reg->cantidadprod,
                    "7"=>'Q'.$reg->impuesto,
                    "8"=>'Q'.$reg->total,
                    "9"=>$reg->moneda,
                    "10"=>$tag
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

        case 'selectProveedor':
            require_once '../modelos/Proveedor.php';
            $proveedor = new Proveedor();

            $rspta = $proveedor->listarp();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idProveedor.' data-correo='. $reg->correo.'>'.$reg->nombre.'</option>';
            }
        break;

        case 'selectTienda':
            require_once '../modelos/Tienda.php';
            $tienda = new Tienda();

            $rspta = $tienda->listar();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtienda.'>'.$reg->nombre.'</option>';
            }
        break;
        
        case 'selectMoneda':
            require_once '../modelos/Moneda.php';
            $moneda = new Moneda();

            $rspta = $moneda->listar();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtipomoneda.' data-cambio='.$reg->tipocambio.' data-simbolo='.$reg->simbolo.'>'.$reg->moneda.'</option>';
            }
        break;

        case 'listarArticulos':
            require_once '../modelos/Articulo.php';
            $idproveedor = $_REQUEST["idproveedor"];
            $articulo = new Articulo();
            $rspta = $articulo->listarxProveedor($idproveedor);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->preciocompra.'\',\''.$reg->conf.'\',\''.$reg->ganancia.'\')">
                                <span class="fa fa-plus"></span>
                            </button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->categoria,
                    "3"=>$reg->preciocompra,
                    "4"=>$reg->precio,
                    "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
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

        case 'listarArticulosBodega':
            require_once '../modelos/Articulo.php';
            $idbodega = $_REQUEST["idbodega"];
            $idtienda = $_REQUEST["idtienda"];
            $articulo = new Articulo();
            $rspta = $articulo->listarxBodega($idbodega,$idtienda);
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->cantidad.'\',\''.$reg->stocktienda.'\')">
                                <span class="fa fa-plus"></span>
                            </button>',
                    "1"=>$reg->nombre,
                    "2"=>$reg->categoria,
                    "3"=>$reg->precio,
                    "4"=>$reg->cantidad,
                    "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
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

        case 'mostrarTiendaCompra':
            require_once '../modelos/Tienda.php';
            $tienda = new Tienda();
            $id=$_GET['idTiendaCompra'];
            $rspta = $tienda->buscarTienda($id);
            
            while ($reg = $rspta->fetch_object()) {

                echo $reg->nombre;
            }
        break;
    }

?>