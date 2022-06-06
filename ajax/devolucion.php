<?php
    
    require_once '../modelos/Devolucion.php';

    $persona = new Devolucion();

    $idpersona=isset($_POST["iddevolucion"])? limpiarCadena($_POST["iddevolucion"]):"";
    $noVenta=isset($_POST["noVenta"])? limpiarCadena($_POST["noVenta"]):"";
    $fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
    $motivo=isset($_POST["motivo"])? limpiarCadena($_POST["motivo"]):"";
    $estado=isset($_POST["idestado"])? limpiarCadena($_POST["idestado"]):"";

    switch($_GET["op"])
    {
        case 'guardaryeditar':
            if (empty($idpersona)){
                $rspta=$persona->insertar($noVenta,$fecha,$motivo,$estado);
                if($estado==2){
                    $rspta=$persona->editar($noVenta);
                    
                }   
                echo $rspta ? "Devolución registrado" : "Devolución no se pudo registrar";             
            }else {
                $rspta=$persona->editar2($idpersona,$estado);
                $rspta=$persona->editar($noVenta);
                echo $rspta ? "Devolución actualizado" : "Devolución no se pudo actualizar";
            } 
        break;

        case 'mostrar':
            $rspta = $persona->mostrar($idpersona);
            echo json_encode($rspta);
        break;

        case 'listarp':
            $rspta = $persona->listarp();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                switch($reg->estado) {
                    case 1:
                        $tag='<span class="label bg-orange">Revision</span>';
                        break;
                    case 2:
                        $tag='<span class="label bg-green">Aprobado</span>';
                        break;
                }

                $data[] = array(
                    "0"=>
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idDevolucion.')"><li class="fa fa-eye"></li></button>'                        ,
                    "1"=>$reg->idVentaEncabezado,
                    "2"=>$reg->fecha,
                    "3"=>$reg->comentario,
                    "4"=>$tag
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

        case 'listarBusqueda':
            //Recibimos el idingreso
          
            $id=$_GET['id'];
            $rspta = $persona->listarBusqueda($id);
            $total = 0;
            if($reg = $rspta->fetch_object()){
            echo '    
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Cliente:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->nombre.' '.$reg->apellido.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Correo:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->correo.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Nit:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->nit.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Fecha:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->fecha.'">
                         </div>

                         ';

                         $rspta2 = $persona->listarDetalle($id);
                         echo '
                                     <table class="table table-striped table-bordered table-condensed table-hover">
                                     <thead style="background-color:#A9D0F5">
                                         <th>Producto</th>
                                         <th>Cantidad</th>
                                         <th>Precio</th>
                                         <th>Subtotal</th>
                                     </thead>
                                
                         ';
             
                         while ($reg = $rspta2->fetch_object()) {
                             echo '<tbody>
                                          <tr class="filas">
                                              <td>'.$reg->nombre.'</td> 
                                              <td>'.$reg->cantidad.'</td> 
                                              <td>Q '.$reg->precio.'</td> 
                                              <td>Q '.$reg->precio * $reg->cantidad.'</td> 
                                          </tr>
                                        </tbody>
                                     ';
                                 $total += ($reg->precio*$reg->cantidad);
                         }
             
                         echo '<tfoot>
                                 <th>TOTAL</th>
                                 <th></th>
                                 <th></th>
                                 <th>
                                     <h4 id="total">Q '.$total.'</h4>
                                 </th>
                             </tfoot>
                             </table>';
            }else{
                echo '<h1>Venta no Encontrada</h1>';
            }



        break;

        case 'listarBusquedaD':
            //Recibimos el idingreso
          
            $id=$_GET['id'];
            $rspta = $persona->listarBusquedaD($id);
            $total = 0;
            if($reg = $rspta->fetch_object()){
            echo '    
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Cliente:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->nombre.' '.$reg->apellido.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Correo:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->correo.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Nit:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->nit.'">
                         </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <label>Fecha:</label> <br>
                           <input type="text" class="form-control"maxlength="100" disabled value="'.$reg->fecha.'">
                         </div>

                         ';

                         $rspta2 = $persona->listarDetalle($id);
                         echo '
                                     <table class="table table-striped table-bordered table-condensed table-hover">
                                     <thead style="background-color:#A9D0F5">
                                         <th>Producto</th>
                                         <th>Cantidad</th>
                                         <th>Precio</th>
                                         <th>Subtotal</th>
                                     </thead>
                                
                         ';
             
                         while ($reg = $rspta2->fetch_object()) {
                             echo '<tbody>
                                          <tr class="filas">
                                              <td>'.$reg->nombre.'</td> 
                                              <td>'.$reg->cantidad.'</td> 
                                              <td>Q '.$reg->precio.'</td> 
                                              <td>Q '.$reg->precio * $reg->cantidad.'</td> 
                                          </tr>
                                        </tbody>
                                     ';
                                 $total += ($reg->precio*$reg->cantidad);
                         }
             
                         echo '<tfoot>
                                 <th>TOTAL</th>
                                 <th></th>
                                 <th></th>
                                 <th>
                                     <h4 id="total">Q '.$total.'</h4>
                                 </th>
                             </tfoot>
                             </table>';
            }else{
                echo '<h1>Venta no Encontrada</h1>';
            }



        break;

    }

?>