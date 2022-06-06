<?php
    require '../config/conexion.php';

    Class TipoPago 
    {
        public function __construct()
        {

        }

        public function insertar($nombre, $descripcion)
        {
            $sql = "INSERT INTO tipodepago (nombre,descripcion) 
                    VALUES ('$nombre','$descripcion')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idCategoria,$nombre, $descripcion)
        {
            $sql = "UPDATE tipodepago SET nombre='$nombre', descripcion='$descripcion'
                    WHERE idtipodepago='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivar($idCategoria)
        {
            $sql= "UPDATE tipodepago SET estado='0' 
                   WHERE idtipodepago='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idCategoria)
        {
            $sql= "UPDATE tipodepago SET estado='1' 
                   WHERE idtipodepago='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idCategoria)
        {
            $sql = "SELECT 
                        idtipodepago as idtipopago, nombre, descripcion
                     FROM tipodepago 
                    WHERE idtipodepago='$idCategoria'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT idtipodepago, nombre,descripcion, estado FROM tipodepago";

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