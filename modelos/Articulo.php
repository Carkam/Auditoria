<?php
    require '../config/conexion.php';

    Class Articulo 
    {
        public function __construct()
        {

        }

        public function insertar($idcategoria,$nombre,$stock,$imagen,$descripcion,$precioC,$idproveedor,$caracteristicas)
        {
            $sql = "INSERT INTO 
                        producto (
                            nombre,
                            descripcion,
                            precioCompra,
                            idProveedor,
                            caracteristicas,
                            idCategoria,
                            precio,
                            imagen
                        ) 
                    VALUES (
                        '$nombre',
                        '$descripcion',
                        '$precioC',
                        '$idproveedor',
                        '$caracteristicas',
                        '$idcategoria',
                        '$stock',
                        '$imagen')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idarticulo,$idcategoria,$nombre,$stock,$imagen,$descripcion,$precioC,$idproveedor,$caracteristicas)
        {
            $sql = "UPDATE producto SET 
                    idCategoria ='$idcategoria',
                    nombre = '$nombre', 
                    precio = '$stock', 
                    imagen = '$imagen',
                    descripcion = '$descripcion',
                    precioCompra = '$precioC',
                    idProveedor = '$idproveedor',
                    caracteristicas = '$caracteristicas'
                    WHERE idproducto='$idarticulo'";
            
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
            $sql = "SELECT * FROM producto 
                    WHERE idproducto='$idarticulo'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {

            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen,
                    p.estado
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira";

            return ejecutarConsulta($sql);
        }

        /*listar cat*/
        public function listarCatP($id)
        {
            $sql = "SELECT 
                    ct.caracteristica,
                    ct.desplegable,
                    ct.opciones
                    FROM caracteristicascategoria cc
                    , categoria c, caracteristica ct
                    WHERE cc.idcategoria = c.idcateogira
                    AND ct.idcaracteristica=cc.idcaracteristica
                    AND c.idcateogira='$id'";

            return ejecutarConsulta($sql);
        }

        public function listarProducto(){
 
            $sql = "SELECT * from producto";

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
                    p.preciocompra,
                    p.conf,
                    p.ganancia,
                    p.imagen
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira
                    WHERE p.idproveedor='$idproveedor'";
            return ejecutarConsulta($sql);

            return ejecutarConsulta($sql);
        }

        public function listarxBodega($idbodega,$idtienda)
        {
            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen,
                    i.cantidad,
                    (SELECT CANTIDAD FROM INVENTARIO WHERE IDTIENDA='$idtienda' and idproducto=p.idproducto) as stocktienda
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira
                    INNER JOIN inventario i 
                    ON i.idproducto = p.idproducto
                    WHERE i.idtienda='$idbodega' AND i.cantidad>0";

            return ejecutarConsulta($sql);
        }

        public function listarActivosVenta($idtienda)
        {
            $sql = "SELECT 
                    p.idproducto, 
                    p.idcategoria, 
                    c.nombre as categoria,
                    p.nombre,
                    p.precio,
                    p.imagen,
                    i.cantidad as stock
                    FROM producto p
                    INNER JOIN categoria c 
                    ON p.idcategoria = c.idcateogira
                    INNER JOIN inventario i 
                    ON i.idproducto = p.idproducto
                    WHERE i.idtienda='$idtienda' AND i.cantidad>0 and p.estado=1";

            return ejecutarConsulta($sql);
        }
    }

?>