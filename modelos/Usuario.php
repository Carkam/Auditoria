<?php
    require '../config/conexion.php';

    Class Usuario 
    {
        public function __construct()
        {

        }

        public function insertar($nombre,$clave,$imagen,$idempleado,$permisos)
        {
            $sql = "INSERT INTO usuario (
                        nombre,
                        clave,
                        imagen,
                        idempleado,
                        condicion
                    ) 
                    VALUES (
                        '$nombre',
                        '$clave',
                        '$imagen',
                        '$idempleado',
                        '1'
                        )";
            
            //return ejecutarConsulta($sql);
            $idusuarionew = ejecutarConsulta_retornarID($sql);

            $sql2 = "UPDATE empleado SET 
                    idusuario='$idusuarionew'
                    WHERE idempleado='$idempleado'";
            
            ejecutarConsulta($sql2);

            $num_elementos = 0;
            $sw = true;

            while($num_elementos < count($permisos))
            {
                $sql_detalle ="INSERT INTO usuario_permiso (
                                    idusuario,
                                    idpermiso
                                )
                                VALUES (
                                    '$idusuarionew',
                                    '$permisos[$num_elementos]'
                                )";

                ejecutarConsulta($sql_detalle) or $sw = false;

                $num_elementos = $num_elementos + 1;
            }

            return $sw;
        }

        public function editar($idusuario,$nombre,$clave,$imagen,$idempleado,$permisos)
        {
            $sql = "UPDATE usuario SET 
                    nombre='$nombre', 
                    clave='$clave',
                    idempleado='$idempleado',
                    imagen='$imagen'
                    WHERE idusuario='$idusuario'";
            
            ejecutarConsulta($sql);

            //Eliminamos todos los permisos asignados para volverlos a registrar
            $sqldel = "DELETE FROM usuario_permiso
                        WHERE idusuario='$idusuario'";
            
            ejecutarConsulta($sqldel);

            $num_elementos = 0;
            $sw = true;

            while($num_elementos < count($permisos))
            {
                $sql_detalle = "INSERT INTO usuario_permiso(
                    idusuario,
                    idpermiso
                    )
                    VALUES (
                        '$idusuario',
                        '$permisos[$num_elementos]'
                    )";
                    ejecutarConsulta($sql_detalle) or $sw = false;
                    $num_elementos = $num_elementos + 1;
            }

            return $sw;
        }

        public function desactivar($idusuario)
        {
            $sql= "UPDATE usuario SET condicion=0 
                   WHERE idusuario='$idusuario'";
            
            return ejecutarConsulta($sql);
        }

        public function activar($idusuario)
        {
            $sql= "UPDATE usuario SET condicion=1 
                   WHERE idusuario='$idusuario'";
            
            return ejecutarConsulta($sql);
        }

        public function mostrar($idusuario)
        {
            $sql = "SELECT 
                        u.idusuario,
                        u.clave,
                        u.nombre as usuario,
                        t.nombre,
                        t.apellido,
                        u.imagen,
                        u.condicion     
                    FROM usuario u
                    INNER JOIN empleado t
                    ON t.idempleado=u.idempleado
                    WHERE u.idusuario='$idusuario'";

            return ejecutarConsultaSimpleFila($sql);
        }

        public function listar()
        {
            $sql = "SELECT 
                        u.idusuario,
                        u.nombre as usuario,
                        t.nombre,
                        t.apellido,
                        t.correo,
                        u.imagen,
                        u.condicion 
                    FROM usuario u
                    INNER JOIN empleado t
                    ON t.idempleado=u.idempleado";

            return ejecutarConsulta($sql);
        }

        public function eliminar($idusuario)
        {
            $sql= "DELETE FROM usuario 
                   WHERE idusuario='$idusuario'";
            
            return ejecutarConsulta($sql);
        }

        public function listarmarcados($idusuario)
        {
           $sql = "SELECT * FROM usuario_permiso
                    WHERE idusuario='$idusuario'";
            
            return ejecutarConsulta($sql);
        }

        //Verficacion de acceso
        public function verificar($usuario,$clave)
        {
            $sql = "SELECT 
                        idusuario,
                        nombre,
                        imagen
                    FROM usuario
                    WHERE nombre='$usuario' 
                    AND clave='$clave'
                    AND condicion='1'";
            
            return ejecutarConsulta($sql);
        }

        //Verficacion de acceso
        public function verificar2($usuario,$clave)
        {
            $sql = "UPDATE usuario
                     SET   clave='$clave'
                    WHERE nombre='$usuario'";
            
            return ejecutarConsulta($sql);
        }

    }

?>