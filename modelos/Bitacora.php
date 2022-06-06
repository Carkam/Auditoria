<?php
    require '../config/conexion.php';

    Class Bitacora 
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

            $sql = "SELECT b.idBitacora, u.nombre  as usuario, b.fecha, b.accion from bitacora b, usuario u WHERE b.idUsuario=u.idUsuario";

            return ejecutarConsulta($sql);
        }

    }

?>