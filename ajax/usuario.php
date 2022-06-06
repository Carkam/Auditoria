<?php

    session_start();
    
    require_once '../modelos/Usuario.php';

    $usuario = new Usuario();

    $idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
    $nombre=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
    $clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
    $secretclave=isset($_POST["secretclave"])? limpiarCadena($_POST["secretclave"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $idempleado=isset($_POST["Empleado"])? limpiarCadena($_POST["Empleado"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':

            if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
            {
                $imagen = $_POST["imagenactual"];
            }
            else
            {
                $ext = explode(".",$_FILES["imagen"]["name"]);
                if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
                {
                    $imagen = round(microtime(true)).'.'.end($ext);
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
                }
            }

            //Hash SHA256 en la contraseña
            $clavehash = hash("SHA256",$clave);

            if (empty($idusuario)){
                $rspta=$usuario->insertar($nombre,$clavehash,$imagen,$idempleado,$_POST['permiso']);
                echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
            }
            else {
                if($clave==$secretclave){
                    $rspta=$usuario->editar($idusuario,$nombre,$clave,$imagen,$idempleado,$_POST['permiso']);
                }else{
                    $rspta=$usuario->editar($idusuario,$nombre,$clavehash,$imagen,$idempleado,$_POST['permiso']);
                }
                echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $usuario->desactivar($idusuario);
                echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;

        case 'selectEmpleado':
            require_once '../modelos/Trabajador.php';
            $trabajador = new Trabajador();

            $rspta = $trabajador->listarp();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idempleado.'>'.$reg->nombre.' '.$reg->apellido.'</option>';
            }
        break;

        case 'activar':
            $rspta = $usuario->activar($idusuario);
            echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $usuario->mostrar($idusuario);
            echo json_encode($rspta);
        break;

        case 'eliminar':
            $rspta = $usuario->eliminar($idusuario);
            echo $rspta ? "Usuario eliminado" : "Usuario no se pudo eliminar";
        break;

        case 'listar':
            $rspta = $usuario->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="eliminar('.$reg->idusuario.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')" title="inactivar"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="eliminar('.$reg->idusuario.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')" title="activar"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->usuario,
                    "2"=>$reg->nombre.' '.$reg->apellido,
                    "3"=>$reg->correo,
                    "4"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' alt='".$reg->usuario."'>",
                    "5"=>($reg->condicion) ?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;

        case 'selectUsuario':
            $rspta = $usuario->listar();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idusuario.'>'.$reg->usuario.'</option>';
            }
        break;

        case 'permisos':
            //obtenemos los permisos de la tabla permisos
            require_once '../modelos/Permiso.php';
            $permiso = new Permiso();
            $rspta = $permiso->listar();

            //Obtener los permisos del usuario
            $id=$_GET['id'];
            $marcados = $usuario->listarmarcados($id);
            
            //declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenar los permisos asignados al usuario en el array
            while ($per = $marcados->fetch_object()) 
            {
                array_push($valores,$per->idpermiso);
            }

            while($reg = $rspta->fetch_object())
            {
                $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';

                echo '<li> 
                        <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'
                        .$reg->nombre.
                    '</li>';
            }
        break;


        case 'verificar':
            $usuarioa = $_POST['usuarioa'];
            $clavea = $_POST['clavea'];
            $_SESSION['tiendaActual'] = $_POST['tienda'];
            //Desencriptar clave SHA256
            $clavehash = hash("SHA256",$clavea);

            $rspta = $usuario->verificar($usuarioa, $clavehash);

            $fetch = $rspta->fetch_object();
            
            if(isset($fetch))
            {
                //Declarando variables de session
                $_SESSION['idusuario'] = $fetch->idusuario;
                $_SESSION['nombre'] = $fetch->nombre;
                $_SESSION['imagen'] = $fetch->imagen;

                //Obtenemos los permisos del usuario
                $permisos = $usuario->listarmarcados($fetch->idusuario);

                //Array para almacenar los permisos
                $valores= array();

                while($per = $permisos->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                }

                //Determinando los accesos del usuario
                in_array(1,$valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
                in_array(2,$valores) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
                in_array(3,$valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
                in_array(4,$valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
                in_array(5,$valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
                in_array(6,$valores) ? $_SESSION['reportes'] = 1 : $_SESSION['reportes'] = 0;
                in_array(7,$valores) ? $_SESSION['graficas'] = 1 : $_SESSION['graficas'] = 0;
                in_array(8,$valores) ? $_SESSION['pagos'] = 1 : $_SESSION['pagos'] = 0;
                in_array(9,$valores) ? $_SESSION['recursosh'] = 1 : $_SESSION['recursosh'] = 0;
                in_array(10,$valores) ? $_SESSION['configuracion'] = 1 : $_SESSION['configuracion'] = 0;
                in_array(11,$valores) ? $_SESSION['cambiosp'] = 1 : $_SESSION['cambiosp'] = 0;
            }

            echo json_encode($fetch); //Retornando JSON
        break;

        case 'salir':
            require_once "../modelos/Bitacora.php";
            $bitacora = new Bitacora();

            $rspta = $bitacora->insertar($_SESSION["idusuario"],"Usuario cerró sesión");
                       /*session_unset(); //Limpiamos las variables de sesion
            session_destroy(); //Destriumos la <sesion*></sesion*/
            $_SESSION['idusuario'] = null;
            $_SESSION['nombre'] = null;
            $_SESSION['imagen'] = null;
            $_SESSION['escritorio'] = null;
            $_SESSION['almacen'] = null;
            $_SESSION['compras'] = null;
            $_SESSION['ventas'] = null;
            $_SESSION['acceso'] = null;
            $_SESSION['reportes'] = null;
            $_SESSION['graficas'] = null;
            $_SESSION['pagos'] = null;
            $_SESSION['recursosh'] = null;
            $_SESSION['configuracion'] = null;
            $_SESSION['cambiosp'] = null;
            header("Location: ../index.php");
        break;

    }

?>