<?php
    require '../config/conexion.php';

    Class CarCat 
    {
        public function __construct()
        {

        }


        public function modificar($idcategoria,$caracteristicas)
        {
            $sql= "DELETE FROM caracteristicascategoria
            WHERE idcategoria='$idcategoria'";  
            ejecutarConsulta($sql);

            $num_elementos = 0;
            $sw = true;
            while($num_elementos < count($caracteristicas))
            {
                $idcar = $caracteristicas[$num_elementos];
                if($idcar!=-1){
                    $sql_detalle ="INSERT INTO caracteristicascategoria
                                VALUES (
                                    '$idcategoria',
                                    '$idcar'
                                )";

                    ejecutarConsulta($sql_detalle) or $sw = false;
                }
                $num_elementos = $num_elementos + 1;
            }           
            return ($sw);
        }

        public function anular($idcompraencabezado)
        {
           /*$sql= "UPDATE compraencabezado SET estado=0
                   WHERE idcompraencabezado='$idcompraencabezado'";
            
            return ejecutarConsulta($sql);*/
        }
    
        public function mostrar($idcompraencabezado)
        {
            $sql = "SELECT c.idcateogira as idcategoria, c.descripcion,c.nombre, (select count(cc.idcategoria) 
            from caracteristicascategoria cc where cc.idCategoria=c.idCateogira)  AS cantidadcar
            from categoria c
            WHERE c.idcateogira='$idcompraencabezado'";

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
            $sql = "SELECT c.idcateogira as idcategoria, c.descripcion,c.nombre, (select count(cc.idcategoria) 
            from caracteristicascategoria cc where cc.idCategoria=c.idCateogira) AS cantidadcar
            from categoria c";

            return ejecutarConsulta($sql);
        }

        public function listarCar()
        {
            $sql = "SELECT * from caracteristica";
            return ejecutarConsulta($sql);
        }

    }


?>