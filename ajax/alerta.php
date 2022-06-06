<?php
    
    require_once '../modelos/Alerta.php';

    $tienda = new Alerta();

    $idtienda=isset($_POST["idtienda"])? limpiarCadena($_POST["idtienda"]):"";
    $idmunicipio=isset($_POST["idmunicipio"])? limpiarCadena($_POST["idmunicipio"]):"";
    $nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idtienda)){
                $rspta=$tienda->insertar($nombre,$direccion,$idmunicipio);
                echo $rspta ? "Tienda registrado" : "Tienda no se pudo registrar";
            }
            else {
                $rspta=$tienda->editar($idtienda,$nombre,$direccion,$idmunicipio);
                echo $rspta ? "Tienda actualizado" : "Tienda no se pudo actualizar";
            }
        break;

        case 'guardaryeditarBodega':
            if (empty($idtienda)){
                $rspta=$tienda->insertarBodega($nombre,$direccion,$idmunicipio);
                echo $rspta ? "Bodega registrada" : "Bodega no se pudo registrar";
            }
            else {
                $rspta=$tienda->editar($idtienda,$nombre,$direccion,$idmunicipio);
                echo $rspta ? "Bodega actualizado" : "Bodega no se pudo actualizar";
            }
        break;

        case 'moverProductos':
            $idbodega = $_REQUEST["idbodega"];
            $idtienda = $_REQUEST["idtienda"];
            $articulos = $_REQUEST["articulos"];
            $cantidad = $_REQUEST["cantidad"];
            $stockBodega = $_REQUEST["stockBodega"];
            $stockTienda = $_REQUEST["stockTienda"];
            $rspta=$tienda->moverProductos($idbodega,$idtienda,$articulos,$cantidad,$stockBodega,$stockTienda);
            echo $rspta ? "Productos movidos" : "Productos no se pudieron mover";
        break;

        case 'desactivar':
                $rspta = $tienda->desactivar($idtienda);
                echo $rspta ? "Tienda desactivada" : "Tienda no se pudo desactivar";
        break;

        case 'desactivarBodega':
            $rspta = $tienda->desactivar($idtienda);
            echo $rspta ? "Bodega inactivada" : "Bodega no se pudo inactivar";
        break;

        case 'activar':
            $rspta = $tienda->activar($idtienda);
            echo $rspta ? "Tienda activado" : "Tienda no se pudo activar";
        break;

        case 'activarBodega':
            
            $rspta = $tienda->activar($idtienda);
            echo $rspta ? "Bodega activada" : "Bodega no se pudo activar";
        break;

        case 'mostrar':
            // echo ('<script>console.log("'.$idtienda.'")</script>');  
            $rspta = $tienda->mostrar($idtienda);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $tienda->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=>$reg->Fecha     ,
                     "1"=>$reg->Mensaje,
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

        case 'desactivarP':
            $rspta = $tienda->desactivarP($idtienda);
            echo $rspta ? "Tienda desactivada" : "Tienda no se pudo desactivar";
        break;

        case 'activarP':
            $rspta = $tienda->activar($idtienda);
            echo $rspta ? "Tienda activado" : "Tienda no se pudo activar";
        break;

        case 'listarBodega':
            $rspta = $tienda->listarBodega();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->estado==1) ? '<button class="btn btn-warning" onclick="mostrar('.$reg->idtienda.')"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idtienda.')"><li class="fa fa-close"></li></button>'
                    : '<button class="btn btn-warning" onclick="mostrar('.$reg->idtienda.')"><li class="fa fa-pencil"></li></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idtienda.')"><li class="fa fa-check"></li></button>',
                     "1"=>$reg->nombre,
                     "2"=>$reg->direccion,
                     "3"=>$reg->municipio
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

        case 'selectCategoria':
            require_once "../modelos/Tienda.php";
            $categoria = new Tienda();

            $rspta = $categoria->listarMunicipio();

            while($reg = $rspta->fetch_object())
            {
                
                echo '<option value='.$reg->idMunicipio.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;

        case 'selectTienda':
            require_once "../modelos/Tienda.php";
            $tienda = new Tienda();

            $rspta = $tienda->listar();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtienda.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;

        case 'selectTiendas':
            require_once "../modelos/Tienda.php";
            $tienda = new Tienda();

            $rspta = $tienda->listarAll();
            echo '<option value=0>General</option>';
            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtienda.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;

        case 'selectBodega':
            require_once "../modelos/Tienda.php";
            $tienda = new Tienda();

            $rspta = $tienda->listarBodega();
            echo '<option value=0></option>';

            while($reg = $rspta->fetch_object())
            {
                echo '<option value='.$reg->idtienda.'>'
                        .$reg->nombre.
                      '</option>';
               
            }
        break;
    }

?>