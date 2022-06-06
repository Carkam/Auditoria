<?php
    require '../config/conexion.php';

    Class Devolucion 
    {
        public function __construct()
        {

        }

        public function insertar($noVenta,$fecha,$motivo,$estado)
        {
            $sql = "INSERT INTO devolucion (
                    idVentaEncabezado,
                    fecha,
                    comentario,
                    estado
                   ) 
                    VALUES (
                        '$noVenta',
                        '$fecha',
                        '$motivo',
                        '$estado'
                        )";
            
            return ejecutarConsulta($sql);
        }

        public function editar($noVenta)
        {
            $sql = "UPDATE ventaencabezado SET 
                    estado='2'
                    WHERE idVentaEncabezado='$noVenta'";
            
            return ejecutarConsulta($sql);
        }

        public function editar2($id,$estado)
        {
            $sql = "UPDATE devolucion SET 
                    estado='$estado'
                    WHERE idDevolucion='$id'";
            
            return ejecutarConsulta($sql);
        }



        //METODO PARA MOSTRAR LOS DATOS DE UN REGISTRO A MODIFICAR
        public function mostrar($idpersona)
        {
            $sql = "SELECT * FROM devolucion 
                    WHERE idDevolucion='$idpersona'";

            return ejecutarConsultaSimpleFila($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarp()
        {
            $sql = "SELECT * FROM devolucion";

            return ejecutarConsulta($sql);
        }


        //METODO PARA LISTAR LOS REGISTROS
        public function listarBusqueda($id)
        {
            $sql = "SELECT c.nombre, c.apellido, c.correo, c.nit, v.fecha FROM ventaencabezado v, cliente c where v.idcliente=c.idcliente and v.idVentaEncabezado='$id' and v.estado='1'";
            return ejecutarConsulta($sql);
        }
        //METODO PARA LISTAR LOS REGISTROS
        public function listarBusquedaD($id)
        {
            $sql = "SELECT c.nombre, c.apellido, c.correo, c.nit, v.fecha FROM ventaencabezado v, cliente c where v.idcliente=c.idcliente and v.idVentaEncabezado='$id' and v.estado='2'";
            return ejecutarConsulta($sql);
        }

        //METODO PARA LISTAR LOS REGISTROS
        public function listarDetalle($id)
        {
            $sql = "SELECT p.nombre, v.cantidad, p.precio FROM ventadetalle v, producto p WHERE v.idproducto=p.idproducto and v.idVentaEncabezado='$id'";

            return ejecutarConsulta($sql);
        }

    }

?>