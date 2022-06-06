<?php
    require '../config/conexion.php';

    Class Ganancia 
    {
        public function __construct()
        {

        }


        public function editar($idarticulo,$nombre,$imagen,$precioC)
        {
            $sql= "UPDATE producto SET ganancia='$precioC', conf='$imagen' where idProducto='$idarticulo'";
             ejecutarConsulta($sql);

             $dql2 = "SELECT precio, precioCompra from producto where idproducto='$idarticulo'";
             $resultadot=ejecutarConsulta($dql2);


                if ($reg = $resultadot->fetch_object())
                {
                    $res = $reg->precioCompra * ($precioC / 100);
                    $res2 = $reg->precioCompra + $res;

                    $sql2= "UPDATE producto SET precio='$res2' where idProducto='$idarticulo'";
                    return  ejecutarConsulta($sql2);

                }
        }

        public function anular($idcompraencabezado)
        {
           /*$sql= "UPDATE compraencabezado SET estado=0
                   WHERE idcompraencabezado='$idcompraencabezado'";
            
            return ejecutarConsulta($sql);*/
        }
    
        public function mostrar($idcompraencabezado)
        {
            
            $sql = "SELECT idproducto, nombre, ganancia,conf from producto where idProducto='$idcompraencabezado'";

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
            $sql = "SELECT * from Producto";

            return ejecutarConsulta($sql);
        }

        public function listarCar()
        {
            $sql = "SELECT * from caracteristica";
            return ejecutarConsulta($sql);
        }

    }


?>