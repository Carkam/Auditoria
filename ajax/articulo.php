<?php
    
    require_once '../modelos/Articulo.php';

    $articulo = new Articulo();

    $idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
    $precioC=isset($_POST["precioC"])? limpiarCadena($_POST["precioC"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    $caracteristicas=isset($_POST["caracteristicas"])? limpiarCadena($_POST["caracteristicas"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

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
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/" . $imagen);
                }
            }

            $caractP=$_GET['caracteristica'];
            if (empty($idarticulo)){
                $rspta=$articulo->insertar($idcategoria,$nombre,$stock,$imagen,$descripcion,$precioC,$idproveedor,$caractP);
                echo $rspta ? "Articulo registrado" : "Articulo no se pudo registrar";
            }
            else {
                $rspta=$articulo->editar($idarticulo,$idcategoria,$nombre,$stock,$imagen,$descripcion,$precioC,$idproveedor,$caractP);
                echo $rspta ? "Articulo actualizado" : "Articulo no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $articulo->desactivar($idarticulo);
                echo $rspta ? "Articulo Eliminado" : "Articulo no se pudo Eliminar";
        break;

        case 'desactivarP':
                $rspta = $articulo->desactivarP($idarticulo);
                echo $rspta ? "Articulo desactivado" : "Articulo no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $articulo->activar($idarticulo);
            echo $rspta ? "Articulo activado" : "Articulo no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $articulo->mostrar($idarticulo);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $articulo->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado) ? 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivarP('.$reg->idproducto.')" title="inactivar"><li class="fa fa-close"></li></button>'
                    :
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')" title="mostrar"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')" title="eliminar"><li class="fa fa-trash"></li></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idproducto.')" title="activar"><li class="fa fa-check"></li></button>'
                    ,
                     "1"=>$reg->nombre,
                     "2"=>$reg->categoria,
                    // "3"=>$reg->codigo,
                     "3"=>$reg->precio,
                     "4"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
                    "5"=>($reg->estado) ?
                         '<span class="label bg-green">Activado</span>'
                         :      
                         '<span class="label bg-red">Desactivado</span>'
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


        case 'listarCatP':
            $categoriaID=$_GET['categoriaID'];
            $rspta = $articulo->listarCatP($categoriaID);
            while($reg = $rspta->fetch_object()){
                if($reg->desplegable==0){
                    echo '<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>'.$reg->caracteristica.'</label>
                    <input type="text" id="'.$reg->caracteristica.'" class="objetos">
                    </div>';
                }else{
                    
                    echo '<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>'.$reg->caracteristica.'</label>                    
                    <select id="'.$reg->caracteristica.'" class="objetos">';
                    $arreglo = explode(",",$reg->opciones);
                    for ($i=0; $i < count($arreglo); $i++) { 
                        echo
                        '<option value="'.$arreglo[$i].'">'.$arreglo[$i].'</option>';
                    }
                   echo '</select>
                    </div>';
                }
            }
        break;

        case 'selectCategoria':
            require_once "../modelos/Categoria.php";
            $categoria = new Categoria();

            $rspta = $categoria->listar();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idCateogira.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;

        case 'selectArticulo':
            $rspta = $articulo->listar();
            echo '<option value=0>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idproducto.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;

        case 'selectProveedor':
            require_once "../modelos/Proveedor.php";
            $proveedor = new Proveedor();

            $rspta = $proveedor->listarp();

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idProveedor.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;
    }

?>