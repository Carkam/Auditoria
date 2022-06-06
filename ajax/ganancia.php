<?php
    
    require_once '../modelos/Ganancia.php';

    $articulo = new Ganancia();

    $idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
    $precioC=isset($_POST["ganancia"])? limpiarCadena($_POST["ganancia"]):"";
    $descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    $caracteristicas=isset($_POST["caracteristicas"])? limpiarCadena($_POST["caracteristicas"]):"";
    $imagen=isset($_POST["conf"])? limpiarCadena($_POST["conf"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
                $rspta=$articulo->editar($idarticulo,$nombre,$imagen,$precioC);
                echo $rspta ? "Articulo actualizado" : "Articulo no se pudo actualizar";
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
                switch($reg->conf) {
                    case 0:
                        $tag='<span class="label bg-green">Precio mas bajo</span>';
                        break;
                    case 1:
                        $tag='<span class="label bg-green">Precio mas alto</span>';
                        break;
                    case 2:
                        $tag='<span class="label bg-green">Promedio de precios</span>';
                        break;
                    case 3:
                        $tag='<span class="label bg-green">Mantener precio establecido</span>';
                        break;
                }
                $data[] = array(
                    "0"=> 
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idProducto.')" title="mostrar"><li class="fa fa-pencil"></li></button>',
                     "1"=>$reg->nombre,
                     "2"=>$reg->ganancia,
                     "3"=>$tag
                    
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