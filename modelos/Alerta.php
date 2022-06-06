<?php
    require '../config/conexion.php';

    Class Alerta 
    {
        public function __construct()
        {

        }

        public function insertar($usuario,$accion)
        {
            $sql = "INSERT INTO bitacora (idusuario,fecha,accion)
            VALUES ('$usuario',(SELECT now()),'$accion')";
            
            return ejecutarConsulta($sql);
        }

        public function insertar2($usuario,$clave,$accion)
        {
            $sql = "INSERT INTO bitacora (idusuario,fecha,accion)
            VALUES ((SELECT idusuario from usuario where nombre='$usuario' and clave='$clave'),(SELECT now()),'$accion')";
            
            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listar()
        {

            $sql = "SELECT * from alertas";

            return ejecutarConsulta($sql);
        }

    }

?>