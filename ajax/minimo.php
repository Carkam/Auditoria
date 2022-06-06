<?php
    
    require_once '../modelos/Minimo.php';
    
    if(strlen(session_id()) < 1){
        session_start();
    }

    $carCat = new Minimo();

    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $idTienda=isset($_POST["idTienda"])? limpiarCadena($_POST["idTienda"]):"";
    $producto=isset($_POST["producto"])? limpiarCadena($_POST["producto"]):"";
    $tiendatienda=isset($_POST["tiendatienda"])? limpiarCadena($_POST["tiendatienda"]):"";
    $minimo=isset($_POST["minimo"])? limpiarCadena($_POST["minimo"]):"";
    
    switch($_GET["op"])
    {
        case 'editar':                
            $rspta=$carCat->editar($idcategoria,$idTienda,$minimo);
            echo $rspta ? "Minimo registrada" : "Minimo no se pudieron registrar";       
        
        break;

        case 'mostrar':
            $rspta = $carCat->mostrar($idcategoria,$idTienda);
            echo json_encode($rspta);
        break;

        case 'listarDetalle':
            //Recibimos el idingreso
            $id=$_GET['id'];

            $rspta = $carCat->listarDetalle($id);
            
            echo '<thead style="background-color:#A9D0F5">
                    <th>Acciones</th>
                    <th>Características</th>
                    <th>Desplegable</th>
                    <th>Opciones</th>
                </thead>';
            $cont=0;
            while($reg = $rspta->fetch_object())
            {
                echo '<tbody>
                        <tr class="filas" id="fila'.$cont.'">
                            <td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$cont.')">X</button></td>
                            <td><input type="hidden" name="idcar'.$cont.'" id="idcar'.$cont.'" value="'.$reg->idCaracteristica.'">'.$reg->caracteristica.'</td> 
                            <td>'.($reg->desplegable == 1 ? 'SI':'NO').'</td> 
                            <td>'.($reg->desplegable == 1 ? $reg->opciones:'NO APLICA').'</td> 
                        </tr>
                      </tbody>';

                $cont++;
            }

        break;

        case 'listar':
            $rspta = $carCat->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.','.$reg->idtienda.')"><li class="fa fa-pencil"></li></button>',
                    "1"=>$reg->tienda,
                    "2"=>$reg->producto,
                    "3"=>$reg->cantidadminima
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
            require_once '../modelos/Categoria.php';
            $categoria = new Categoria();

            $rspta = $categoria->listar();
            echo '<option value=0></option>';
            while($reg = $rspta->fetch_object())
            {
                $desc=str_replace(' ','_',$reg->descripcion);
                echo '<option value='.$reg->idCateogira.' data-desc='. $desc.'>'.$reg->nombre.'</option>';
            }
        break;

        case 'listarCar':
            require_once '../modelos/CarCat.php';
            $carCat = new CarCat();
            $rspta = $carCat->listarCar();
            $data = Array();

            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> '<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idCaracteristica.',\''.$reg->caracteristica.'\',\''.$reg->desplegable.'\',\''.$reg->opciones.'\')">
                                <span class="fa fa-plus"></span>
                            </button>',
                    "1"=>$reg->caracteristica,
                    "2"=>($reg->desplegable == 1 ? 'SI':'NO'),
                    "3"=>($reg->desplegable == 1 ? $reg->opciones:'NO APLICA')
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