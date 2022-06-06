<?php
    require '../config/conexion.php';

    Class Proveedor 
    {
        public function __construct()
        {

        }

        public function insertar($nombre,$direccion,$telefono,$nit,$email)
        {
            $sql = "INSERT INTO proveedor (
                    nombre,
                    direccion,
                    telefono,
                    nit,
                    correo
                   ) 
                    VALUES (
                        '$nombre',
                        '$direccion',
                        '$telefono',
                        '$nit',
                        '$email'
                        )";
            
            return ejecutarConsulta($sql);
        }

        public function editar($idpersona,$nombre,$direccion,$telefono,$nit,$email)
        {
            $sql = "UPDATE proveedor SET 
                    nombre='$nombre',
                    direccion='$direccion',
                    telefono='$telefono',
                    nit='$nit',
                    correo='$email'
                    WHERE idproveedor='$idpersona '";
            
            return ejecutarConsulta($sql);
        }

        
        public function eliminar($idpersona)
        {
            $sql= "DELETE FROM proveedor 
                   WHERE idproveedor='$idpersona'";
            
            return ejecutarConsulta($sql);
        }


        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idpersona)
        {
            $sql = "SELECT * FROM proveedor 
                    WHERE idProveedor='$idpersona'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarp()
        {
            $sql = "SELECT * FROM proveedor";

            return ejecutarConsulta($sql);
        }

        public function desactivarP($idpersona)
        {

            $sql= "UPDATE proveedor SET estado='0' 
                   WHERE idproveedor='$idpersona'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idpersona)
        {
            $sql= "UPDATE proveedor SET estado='1' 
                   WHERE idproveedor='$idpersona'";
            
            return ejecutarConsulta($sql);
        }


    }

?>