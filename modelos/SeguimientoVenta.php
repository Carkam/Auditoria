<?php
    require '../config/conexion.php';

    Class SeguimientoVenta 
    {
        public function __construct()
        {

        }

        public function insertar($nombre,$idcategoria,$descripcion,$stock)
        {
            $sql = "INSERT INTO 
                        seguimientoventa (
                            fecha,
                            idfaseseguimiento,
                            idventaencabezado,
                            comentarios
                        ) 
                    VALUES (
                        '$nombre',
                        '$idcategoria',
                        '$descripcion',
                        '$stock')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idarticulo)
        {
            $sql = "UPDATE seguimientoventa SET 
                    estado=0
                    WHERE idseguimientoventa='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        public function buscarCliente($idventa)
        {
            $sql = "SELECT idcliente from ventaencabezado 
                    WHERE idventaencabezado='$idventa'";
            
            return ejecutarConsulta($sql);
        }

        public function correoCliente($idventa)
        {
            $sql = "SELECT correo from cliente 
                    WHERE idcliente='$idventa'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($idarticulo)
        {
            $sql= "DELETE from producto 
            WHERE idproducto='$idarticulo'";
            // $sql= "UPDATE articulo SET condicion='0' 
            //        WHERE idarticulo='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }
        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivarP($idarticulo)
        {

            $sql= "UPDATE producto SET estado='0' 
                   WHERE idproducto='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idarticulo)
        {
            $sql= "UPDATE producto SET estado='1' 
                   WHERE idproducto='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idarticulo)
        {
            $sql = "SELECT sv.idSeguimientoVenta, DATE(sv.fecha) as fecha, sv.idVentaEncabezado,
                    sv.comentarios, sv.idFaseSeguimiento FROM seguimientoventa sv
                    WHERE idseguimientoventa='$idarticulo'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {

            $sql = "SELECT 
                    sv.idseguimientoventa as id,
                    DATE(sv.fecha) as fecha,
                    fs.nombre as faseseguimiento,
                    sv.idventaencabezado,
                    sv.comentarios,
                    sv.estado
                    FROM seguimientoventa sv, faseseguimiento fs
                    WHERE sv.idfaseseguimiento=fs.idfaseseguimiento";

            return ejecutarConsulta($sql);
        }

        public function listarPP(){
 
            $sql = "SELECT * from faseseguimiento";

            return ejecutarConsulta($sql);
        }
        //Listar registros activos
        public function listarxProveedor($idproveedor)
        {
            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira
                    WHERE p.idproveedor='$idproveedor'";

            return ejecutarConsulta($sql);
        }

        public function listarxBodega($idbodega)
        {
            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen,
                    i.cantidad
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira
                    INNER JOIN inventario i 
                    ON i.idproducto = p.idproducto
                    WHERE i.idtienda='$idbodega'";

            return ejecutarConsulta($sql);
        }

        public function listarActivosVenta()
        {
            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira";

            /*$sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
                    a.codigo,
                    a.nombre,
                    a.stock,
                    (
                        SELECT precio_venta 
                        FROM detalle_ingreso
                        WHERE idarticulo = a.idarticulo
                        ORDER BY iddetalle_ingreso 
                        desc limit 0,1 

                    ) as precio_venta, 
                    a.descripcion,
                    a.imagen,
                    a.condicion
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
                    WHERE a.condicion = '1'";*/

            return ejecutarConsulta($sql);
        }
    }

?>