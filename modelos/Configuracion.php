<?php
    require '../config/conexion.php';

    Class Configuracion 
    {
        public function __construct()
        {

        }

        public function editar($idempresa,$empresa,$nit,$direccion,$correo,$telefono,$eslogan,$mision,$vision,$valores,$logo)
        {
            $sql = "UPDATE empresa SET 
                    nombre='$empresa', 
                    nit='$nit',
                    direccion='$direccion',
                    telefono='$telefono',
                    correo='$correo',
                    eslogan='$eslogan',
                    mision='$mision',
                    vision='$vision',
                    valores='$valores',
                    logo='$logo'
                    WHERE idempresa='$idempresa'";
            
            return ejecutarConsulta($sql);
        }
    
        public function mostrar($idempresa)
        {
            $sql = "SELECT 
                        idempresa,
                        nombre,
                        nit, direccion,correo,telefono,
                        eslogan,
                        mision,
                        vision,
                        valores,
                        logo
                    FROM empresa
                    WHERE idempresa='$idempresa'";

            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar()
        {
            $sql = "SELECT 
                        idempresa,
                        nombre,
                        nit, direccion, telefono, correo,
                        eslogan,
                        mision,
                        vision,
                        valores,
                        logo
                    FROM empresa";

            return ejecutarConsulta($sql);
        }

    }

?>