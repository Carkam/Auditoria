<?php
    require '../config/conexion.php';

    Class Minimo 
    {
        public function __construct()
        {

        }


        public function editar($idcategoria,$idTienda,$minimo)
        {
            $sql= "UPDATE minimos set CantidadMinima='$minimo' WHERE idproducto='$idcategoria' and idtienda='$idTienda'";  
            return ejecutarConsulta($sql);


        }

        public function anular($idcompraencabezado)
        {
           /*$sql= "UPDATE compraencabezado SET estado=0
                   WHERE idcompraencabezado='$idcompraencabezado'";
            
            return ejecutarConsulta($sql);*/
        }
    
        public function mostrar($idcategoria,$idTienda)
        {
            $sql = "SELECT m.idproducto, p.nombre as producto, m.idtienda, t.nombre as tiendatienda,m.cantidadminima 
            from minimos m,producto p,tienda t where m.idproducto=p.idproducto and m.idtienda=t.idtienda and
             m.idproducto='$idcategoria' and m.idtienda='$idTienda'";

            return ejecutarConsultaSimpleFila($sql);
        }

        public function listarDetalle($idcompraencabezado)
        {
            $sql = "SELECT c.* 
            FROM caracteristica c 
            INNER JOIN caracteristicascategoria cc ON c.idcaracteristica = cc.idcaracteristica 
            INNER JOIN categoria ca ON ca.idCateogira = cc.idCategoria 
            WHERE cc.idcategoria='$idcompraencabezado'";

            return ejecutarConsulta($sql);
        }

        public function listar()
        {
            $sql = "SELECT m.idproducto, p.nombre as producto, m.idtienda, t.nombre as tienda,m.cantidadminima 
            from minimos m,producto p,tienda t where m.idproducto=p.idproducto and m.idtienda=t.idtienda";

            return ejecutarConsulta($sql);
        }

        public function listarCar()
        {
            $sql = "SELECT * from caracteristica";
            return ejecutarConsulta($sql);
        }

    }


?>