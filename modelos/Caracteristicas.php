<?php
    require '../config/conexion.php';

    Class Caracteristicas 
    {
        public function __construct()
        {

        }

        public function insertar($nombre, $descripcion, $imagen)
        {
            $sql = "INSERT INTO caracteristica (caracteristica,desplegable,opciones) 
                    VALUES ('$nombre','$descripcion','$imagen')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idCategoria,$nombre, $descripcion, $imagen)
        {
            $sql = "UPDATE caracteristica SET caracteristica='$nombre', desplegable='$descripcion', opciones='$imagen'
                    WHERE idcaracteristica='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivar($idCategoria)
        {
            $sql= "UPDATE categoria SET estado='0' 
                   WHERE idcateogira='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idCategoria)
        {
            $sql= "UPDATE categoria SET estado='1' 
                   WHERE idcateogira='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idcategoria)
        {
            
            $sql = "SELECT 
                        idCaracteristica as id, caracteristica, desplegable,opciones
                     FROM caracteristica 
                    WHERE idCaracteristica='$idcategoria'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT * FROM caracteristica";

            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function select()
        {
            /*$sql = "SELECT * FROM categoria 
                    WHERE condicion = 1";

            return ejecutarConsulta($sql);*/
        }
    }

?>