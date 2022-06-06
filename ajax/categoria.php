<?php
    
    require_once '../modelos/Categoria.php';

    $categoria = new Categoria();

    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

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
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/categorias/" . $imagen);
                }
            }
            if (empty($idcategoria)){
                $rspta=$categoria->insertar($nombre,$descripcion,$imagen);
                echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
            }
            else {
                $rspta=$categoria->editar($idcategoria,$nombre,$descripcion,$imagen);
                echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $categoria->desactivar($idcategoria);
                echo $rspta ? "Categoria desactivada" : "Categoria no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $categoria->activar($idcategoria);
            echo $rspta ? "Categoria activada" : "Categoria no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $categoria->mostrar($idcategoria);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $categoria->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idCateogira.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idCateogira.')" title="inactivar"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idCateogira.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idCateogira.')" title="activar"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->descripcion,
                    "3"=>"<img src='../files/categorias/".$reg->imagen."' height='50px' width='50px' alt='".$reg->nombre."'>",
                    "4"=>($reg->estado) ?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
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
    }

?>