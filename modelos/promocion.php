<?php
    require '../config/conexion.php';

    Class Promocion 
    {
        public function __construct()
        {

        }

        public function insertar($fechai,$fechaf,$idproducto,$descuento)
        {
            $sql = "INSERT INTO 
                        promocion (
                            fechaInicio,
                            fechaFinal,
                            idProducto,
                            descuento
                        ) 
                    VALUES (
                        '$fechai',
                        '$fechaf',
                        '$idproducto',
                        '$descuento')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idpromocion,$fechai,$fechaf,$idproducto,$descuento)
        {
            $sql = "UPDATE promocion SET 
                    fechaInicio ='$fechai',
                    fechaFinal = '$fechaf', 
                    idProducto = '$idproducto', 
                    descuento = '$descuento' 
                    WHERE idpromocion='$idpromocion'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($idarticulo)
        {
            $sql= "DELETE from promocion 
            WHERE idpromocion='$idarticulo'";
            // $sql= "UPDATE articulo SET condicion='0' 
            //        WHERE idarticulo='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivarP($idarticulo)
        {
            $sql= "UPDATE promocion SET estado='0' 
                   WHERE idpromocion='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idarticulo)
        {
            $sql= "UPDATE promocion SET estado='1' 
                   WHERE idpromocion='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idarticulo)
        {

            $sql = "SELECT * FROM promocion 
                    WHERE idpromocion='$idarticulo'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT 
                        pr.idpromocion, 
                        pr.fechaInicio, 
                        pr.fechaFinal,
                        p.nombre as producto, 
                        pr.descuento,
                        pr.estado 
                        from promocion pr, producto p 
                        WHERE pr.idproducto=p.idproducto;";

            return ejecutarConsulta($sql);
        }

        //Listar registros activos
        public function listarActivos()
        {
            $sql = "SELECT 
                    a.idarticulo, 
                    a.idcategoria, 
                    c.nombre as categoria,
                    a.codigo,
                    a.nombre,
                    a.stock,
                    a.descripcion,
                    a.imagen,
                    a.condicion 
                    FROM articulo a 
                    INNER JOIN categoria c 
                    ON a.idcategoria = c.idcategoria
                    WHERE a.condicion = '1'";

            return ejecutarConsulta($sql);
        }

        public function listarActivosVenta()
        {
            $sql = "SELECT 
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
                    WHERE a.condicion = '1'";

            return ejecutarConsulta($sql);
        }
    }

?>