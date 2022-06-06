<?php
    require '../config/conexion.php';

    Class Moneda 
    {
        public function __construct()
        {

        }

        public function insertar($nombre, $simbolo, $tcambio)
        {
            $sql = "INSERT INTO tipomoneda (moneda,simbolo,tipoCambio) 
                    VALUES ('$nombre','$simbolo','$tcambio')";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idmoneda,$nombre,$simbolo,$tcambio)
        {
            $sql = "UPDATE tipomoneda SET 
                    moneda='$nombre', 
                    simbolo='$simbolo',
                    tipoCambio='$tcambio'
                    WHERE idtipomoneda='$idmoneda'";
            
            return ejecutarConsulta($sql);
        }

        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivar($idCategoria)
        {
            $sql= "DELETE FROM tipomoneda
                   WHERE idtipomoneda='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }
        //METODOS PARA ACTIVAR CATEGORIAS
        public function desactivarP($idCategoria)
        {
            $sql= "UPDATE tipomoneda SET estado='0' 
                   WHERE idtipomoneda='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idCategoria)
        {
            $sql= "UPDATE tipomoneda SET estado='1' 
                   WHERE idtipomoneda='$idCategoria'";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idCategoria)
        {
            $sql = "SELECT 
                        idtipomoneda, moneda, simbolo,tipoCambio
                     FROM tipomoneda 
                    WHERE idtipomoneda='$idCategoria'";

            return ejecutarConsultaSimpleFila($sql);
        } 

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {
            $sql = "SELECT idtipomoneda, moneda,simbolo, tipocambio,estado FROM tipomoneda";

            return ejecutarConsulta($sql);
        }

        /*//METODO PARA LISTAR LOS REGISTROS Y MOSTRAR EN EL SELECT
        public function select()
        {
            /*$sql = "SELECT * FROM categoria 
                    WHERE condicion = 1";

            return ejecutarConsulta($sql);
        }*/
    }

?>