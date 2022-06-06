<?php
    require '../config/conexion.php';

    Class Tienda 
    {
        public function __construct()
        {

        }

        public function insertar($nombre,$direccion,$idmunicipio)
        {
            $sql = "INSERT INTO 
                        tienda (
                            nombre,
                            direccion,
                            idMunicipio
                        ) 
                    VALUES (
                        '$nombre',
                        '$direccion',
                        '$idmunicipio'
                        )";
            
            return ejecutarConsulta($sql);
        }

        public function insertarBodega($nombre,$direccion,$idmunicipio)
        {
            $sql = "INSERT INTO 
                        tienda (
                            nombre,
                            direccion,
                            idMunicipio,
                            tipoTienda
                        ) 
                    VALUES (
                        '$nombre',
                        '$direccion',
                        '$idmunicipio',
                        0
                        )";
            
            return ejecutarConsulta($sql);
        }

        public function moverProductos($idbodega,$idtienda,$articulos,$cantidad,$stockBodega,$stockTienda)
        {
            $contador=0;
            $sw = true;
            while($contador< count($articulos)){
                $cant = (int)$cantidad[$contador];
                $art = (int)$articulos[$contador];
                if ($stockTienda[$contador] == ''){
                    $st=(int)$stockTienda[$contador];
                    $sql = "INSERT INTO inventario VALUES ('$art','$idtienda','$cant')";
                    ejecutarConsulta($sql) or $sw = false;
                }else{
                    $suma = $cant+ (int)$stockTienda[$contador];
                    $sqlsuma = "UPDATE inventario
                        SET cantidad= '$suma'
                        WHERE idtienda='$idtienda' AND idproducto='$art'";
                    ejecutarConsulta($sqlsuma) or $sw = false;
                }
                $resta = (int)$stockBodega[$contador] - $cant;
                $sqlresta = "UPDATE inventario
                        SET cantidad= '$resta'
                        WHERE idtienda='$idbodega' AND idproducto='$art'";
                ejecutarConsulta($sqlresta) or $sw = false;
                $contador++;
            }
            return $sw;

            //return ejecutarConsulta($sql);*/
        }

        public function editar($idtienda,$nombre,$direccion,$idmunicipio)
        {
            $sql = "UPDATE tienda SET 
                    nombre = '$nombre', 
                    direccion = '$direccion', 
                    idMunicipio = '$idmunicipio' 
                    WHERE idTienda='$idtienda'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR ARTICULOS
        public function desactivar($idarticulo)
        {
            $sql= "DELETE FROM tienda  
                        WHERE idtienda='$idarticulo'";
            // $sql= "UPDATE articulo SET condicion='0' 
            //        WHERE idarticulo='$idarticulo'";
            
            return ejecutarConsulta($sql);
        }

        public function desactivarP($idarticulo)
        {
            $sql= "UPDATE tienda SET estado='0' 
                   WHERE idtienda='$idarticulo'";

            return ejecutarConsulta($sql);
        }

        public function activar($idarticulo)
        {
            $sql= "UPDATE tienda SET estado='1' 
                   WHERE idtienda='$idarticulo'";

            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idtienda)
        {
            $sql = "SELECT * FROM tienda 
                    WHERE idtienda='$idtienda'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {

            $sql = "SELECT t.idtienda, t.nombre, t.direccion, m.nombre  as municipio, t.estado from tienda t, municipio m WHERE t.idmunicipio=m.idmunicipio
            and tipotienda=1";

            return ejecutarConsulta($sql);
        }
        public function listarAll()
        {

            $sql = "SELECT t.idtienda, t.nombre, t.direccion, m.nombre  as municipio from tienda t, municipio m WHERE t.idmunicipio=m.idmunicipio
            ";

            return ejecutarConsulta($sql);
        }

        public function listarBodega()
        {

            $sql = "SELECT t.idtienda, t.nombre, t.direccion, m.nombre  as municipio, t.estado from tienda t, municipio m WHERE t.idmunicipio=m.idmunicipio
            and tipotienda=0";

            return ejecutarConsulta($sql);
        }

        public function listarProducto(){
 
            $sql = "SELECT * from producto";

            return ejecutarConsulta($sql);
        }

        public function listarMunicipio(){
 
            $sql = "SELECT * from municipio";

            return ejecutarConsulta($sql);
        }

        public function buscarTienda($id){
            $sql="SELECT * from tienda WHERE idTienda='$id'";

            return ejecutarConsulta($sql);
        }

    }

?>