<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function insertar($nit,$fecha,$total,$descuentocompra,$iva,$usuario,$idtienda,$pago,$moneda,$articulos,$cantidad,$descuento)
        {

            $sql = "INSERT INTO ventaencabezado (
                        idcliente,
						fecha,
						total,
						descuento,
						iva,
						idusuario,
						idtienda,
						idtipodepago,
						idtipomoneda
                    ) 
                    VALUES (
                        (SELECT IDCLIENTE FROM CLIENTE WHERE NIT='$nit'),
                        '$fecha',
                        '$total',
                        '$descuentocompra',
                        '$iva',
                        '$usuario',
                        '$idtienda',
						'$pago',
						'$moneda'
                        )";
            
            //Devuelve id registrado
            $idingresonew = ejecutarConsulta_retornarID($sql);
			
            $num_elementos = 0;
            $sw = true;
            while($num_elementos < count($articulos))
            {
                $idarticulo = $articulos[$num_elementos];
                $cantart = $cantidad[$num_elementos];
				$descart = $descuento[$num_elementos];
                $sql_detalle ="INSERT INTO ventadetalle (
									idventaencabezado,
                                    idproducto,
                                    cantidad,
                                    descuento
                                )
                                VALUES (
                                    '$idingresonew',
									'$idarticulo',
                                    '$cantart',
									'$descart'
                                )";

                ejecutarConsulta($sql_detalle) or $sw = false;
                $num_elementos = $num_elementos + 1;
            }
			//actualización de inventario
			$num_elementos = 0;
            while($num_elementos < count($articulos))
            {
                $idarticulo = $articulos[$num_elementos];
                $cantart = $cantidad[$num_elementos];
                $sql_detalle ="UPDATE inventario i
								JOIN inventario j ON j.idproducto=i.idproducto AND j.idtienda=i.idtienda
								SET i.cantidad=(j.cantidad-'$cantart')
								WHERE i.idtienda='$idtienda' AND i.idproducto='$idarticulo'";

                ejecutarConsulta($sql_detalle) or $sw = false;
				
				$SQL22="SELECT m.CANTIDADMINIMA, i.cantidad FROM MINIMOS m, inventario i WHERE i.idProducto=m.idProducto and i.idTienda=m.idTienda and m.IDPRODUCTO='$idarticulo' AND m.IDTIENDA='$idtienda'";

				$resultadot=ejecutarConsulta($SQL22);

				if ($reg = $resultadot->fetch_object())
				{
										
					if(intval($reg->cantidad) <= intval($reg->CANTIDADMINIMA)){
						$SQL44="SELECT nombre FROM producto WHERE idProducto='$idarticulo'";

						$resultadott=ejecutarConsulta($SQL44);

						if ($regis = $resultadott->fetch_object()){

							$mensaje="La cantidad de  " .$regis->nombre. " es demasiado baja contacte a su proveedor";
							$sql33="INSERT INTO alertas( Fecha, Mensaje, estado) VALUES (CURRENT_DATE,'$mensaje','1')";
							ejecutarConsulta($sql33);

						}

					}
				}

                $num_elementos = $num_elementos + 1;
            }

            return $sw;
        }
	
	//Implementamos un método para anular la venta
	public function anular($idventaencabezado)
	{
		$sql="UPDATE ventaencabezado 
			  SET estado=0 
			  WHERE idventaencabezado='$idventaencabezado'";

		return ejecutarConsulta($sql);
	}

	public function activar($idventaencabezado)
	{
		$sql="UPDATE ventaencabezado 
			  SET estado=1
			  WHERE idventaencabezado='$idventaencabezado'";

		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventaencabezado)
	{
		$sql="SELECT 
					v.idventaencabezado,
					v.idtienda,
					DATE(v.fecha) as fecha,
					u.nombre as usuario,
					c.nit,
					v.idtipomoneda,
					v.idtipodepago
				FROM ventaencabezado v 
				INNER JOIN usuario u ON v.idusuario=u.idusuario
				INNER JOIN cliente c ON v.idcliente=c.idcliente
				WHERE v.idventaencabezado='$idventaencabezado'";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventaencabezado)
	{
		$sql="SELECT 
				dv.idventaencabezado,
				dv.idproducto,
				p.nombre,
				dv.cantidad,
				p.precio,
				dv.descuento,
				(p.precio*dv.cantidad)*0.12 as iva,
				(dv.cantidad*p.precio)-dv.descuento as subtotal 
				FROM ventadetalle dv 
				inner join producto p 
				on dv.idproducto=p.idproducto
				where dv.idventaencabezado='$idventaencabezado'";

		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT v.idventaencabezado, DATE(v.fecha) as fecha, c.nombre, c.apellido, v.total, 
		v.descuento, v.iva, v.estado, SUM(vd.cantidad) as cantidadprod, m.moneda, t.nombre as tienda, p.nombre as pago 
		FROM ventaencabezado v 
		INNER JOIN ventadetalle vd ON v.idVentaEncabezado=vd.idVentaEncabezado 
		INNER JOIN cliente c ON v.idcliente=c.idcliente 
		INNER JOIN tipomoneda m ON v.idtipomoneda = m.idtipomoneda 
		INNER JOIN tienda t ON v.idtienda = t.idtienda 
		INNER JOIN tipodepago p ON v.idtipodepago = p.idtipodepago 
		GROUP BY V.idVentaEncabezado
		ORDER by v.fecha desc";
			   
		return ejecutarConsulta($sql);		
	}

	public function ventaCabecera($idventa)
	{
		/*$sql= "SELECT 
				v.idventa,
				v.idcliente,
				p.nombre as cliente,
				p.direccion,
				p.tipo_documento,
				p.num_documento,
				p.email,
				p.telefono,
				v.idusuario,
				u.nombre as usuario,
				v.tipo_comprobante,
				v.serie_comprobante,
				v.num_comprobante,
				DATE(v.fecha_hora) as fecha,
				v.impuesto,
				v.total_venta
			  FROM
			  	venta v
			  INNER JOIN
			  	persona p
			  ON
			  	v.idcliente = p.idpersona
			  INNER JOIN
			  	usuario u
			  ON
			  	v.idusuario = u.idusuario
		      WHERE
			  	v.idventa = '$idventa'";

		return ejecutarConsulta($sql);*/
	}
	
	public function ventaDetalle($idventa)
	{
		/*$sql = "SELECT
					a.nombre as articulo,
					a.codigo,
					d.cantidad,
					d.precio_venta,
					d.descuento,
					(d.cantidad*d.precio_venta-d.descuento) as subtotal
				FROM
					detalle_venta d
				INNER JOIN	
					articulo a
				ON
					d.idarticulo = a.idarticulo
				WHERE
					d.idventa = '$idventa'";

		return ejecutarConsulta($sql);*/
	}
}
?>