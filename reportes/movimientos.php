<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 

  if(!isset($_SESSION["nombre"]))
  {
    echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  }

  else  //Agrega toda la vista
  {

    if($_SESSION['almacen'] == 1)
    {
        require 'PDF_MC_Table.php';

        //instanciamos a la clase
        $pdf = new PDF_MC_Table('L','mm',[216,200.4]);

        //Agregamos la primera pagina al documento PDF
        $pdf->AddPage();
        require_once '../modelos/Configuracion.php';
        $configuracion = new Configuracion();
        $rspta = $configuracion->listar();
        $imagen="";
        while ($reg = $rspta->fetch_object()) 
        {
          $imagen=$reg->logo;
        }
        $pdf->Image("../files/empresa/".$imagen,0,8,33);
        //Margenes de 25 pixeles
        $y_axis_initial = 10;

        //Tipo de letra y titulo de la pagina (no es encabezado)
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(45,6,'',0,0,'C');
        $titulo="Reporte de Movimientos de Inventario";
        $hoy=date('d-m-Y');;
        $pdf->Cell(100,6,utf8_decode($titulo.'    Generado: '.$hoy),0,0,'C');
        $pdf->Ln(10);
        $pdf->Cell(75,6,'',0,0,'C');
        $parametros='Rango:'.$_GET['fechaini'].'/'.$_GET['fechafinal'].'   Tienda: '.$_GET['nombre'];
        $pdf->Cell(45,6,utf8_decode($parametros),0,0,'C');
        $pdf->Ln(10);
        if($_GET['producto']!=0){
          $parametros='   Producto:'.$_GET['nombreProd'];
          $pdf->Cell(75,6,'',0,0,'C');
          $pdf->Cell(45,6,utf8_decode($parametros),0,0,'C');
          $pdf->Ln(10);
        }
        require_once '../modelos/Consultas.php';
        $consultas = new Consultas();

        if($_GET['producto']!=0){
          //Celdas para los titulos de cada columna y asignamos color y tipo letra
          $pdf->SetFillColor(232,232,232); //fondo gris RGB
          $pdf->SetFont('Arial','B',10);
          $pdf->Cell(195,6,'Inventario Inicial',1,0,'C',1);
          $pdf->Ln(7);

          $pdf->SetFillColor(232,232,232); //fondo gris RGB
          $pdf->SetFont('Arial','B',10);
          $pdf->Cell(35,6,'Fecha',1,0,'C',1);
          $pdf->Cell(55,6,'Tienda',1,0,'C',1);
          $pdf->Cell(65,6,'Producto',1,0,'C',1);
          $pdf->Cell(40,6,'Total ',1,0,'C',1);
          $pdf->Ln(7);
          $productos[]=array(0,0,0,0,0,0,0,0);
          unset($productos);
          $rspta = $consultas->inventarioDetInixtiendaProd($_GET['fechaini'],$_GET['tienda'],$_GET['producto']);
          $pdf->SetWidths(array(35,55,65,40)); //Anchos de las celdas (igula al de las de arrriba)
          $total=0;
          $entro=false;
          while ($reg = $rspta->fetch_object()) 
          {
              $entro=true;
              $tienda = $reg->tienda;
              $producto = $reg->producto;
              $cantidad = $reg->cantidad;
              $total+=$cantidad;
              $pdf->SetFont('Arial','',10);
              $pdf->Row(array(
                  utf8_decode($_GET['fechaini']),
                  utf8_decode($tienda),
                  utf8_decode($producto),
                  utf8_decode($cantidad),
              ));
              $cantidad=0;
              if(isset($productos[$reg->idproducto])){
                $cantidad=intval($productos[$reg->idproducto]['inventarioInicial'])+$reg->cantidad;
              }else{
                $cantidad=$reg->cantidad;
              }
              $productos[$reg->idproducto]=array(
                'idproducto'=>$reg->idproducto,
                'producto'=> $reg->producto,
                'descripcion'=> $reg->descripcion,
                'inventarioInicial'=>$cantidad,
                'movimientos'=>array(),
              );
          }
          if($entro){
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Total: '.$total,1,0,'R',1);
            $pdf->Ln(7);
            $pdf->Ln(5);
            //Celdas para los titulos de cada columna y asignamos color y tipo letra
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Movimientos',1,0,'C',1);
            $pdf->Ln(7);
  
            //meter movimientos
  
            $movimientos[]=array(0,0,0,0,0,0,0,0);
            unset($movimientos);
            $rspta = $consultas->compraDetfechaProd($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda'],$_GET['producto']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->proveedor,
                'mov'=> 'Compra',
                'cantidad'=> $reg->cantidad,
                'subtotal'=> 0,
              );
            }
  
            $rspta = $consultas->ventaDetfechaProd($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda'],$_GET['producto']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->cliente,
                'mov'=> 'Venta',
                'cantidad'=> $reg->cantidad,
                'subtotal'=> 0,
              );
            }
            if(isset($movimientos)){
              usort($movimientos, function($a1, $a2) {
                $v1 = strtotime($a1['fecha']);
                $v2 = strtotime($a2['fecha']);
                return $v1 - $v2; 
            });
            }
            
          /*var_dump($movimientos);
          var_dump($productos);*/
          foreach($productos as $producto){
            $j=0;
            if(isset($movimientos)){
              foreach($movimientos as $movimiento){
                if($producto['idproducto']==$movimiento['idproducto']){
                  array_push($productos[$producto['idproducto']]['movimientos'],$movimientos[$j]);
                }
                $j++;
              }
            }    
          }
            /*foreach($productos as $producto){
              var_dump($producto);
            }*/
            unset($movimientos);
            
            foreach($productos as $producto){
              $j=0;
              encabezadoProducto($pdf);
              $pdf->SetFont('Arial','',10);
              $pdf->SetWidths(array(5,20,45,90,30,5)); 
              $pdf->Row(array(
                '',
                utf8_decode($producto['idproducto']),
                utf8_decode($producto['producto']),            
                utf8_decode($producto['descripcion']),  
                utf8_decode($producto['inventarioInicial']),  
                '',          
              ));
              if(count($producto['movimientos'])>0){
                encabezadoMovimiento($pdf);
              }
              $movanterior[0]=array();
              foreach($producto['movimientos'] as $movimiento){
                $cantant=0;
                if($j==0){
                  $cantant=$producto['inventarioInicial'];
                }else{
                  /*echo($j);
                  var_dump($movanterior);*/
                  $cantant=$movanterior[0]['subtotal'];
                }
                $pdf->SetWidths(array(7,25,30,35,25,20,20,26,7)); 
                $pdf->SetFont('Arial','',10);
                if($movimiento['mov']=='Compra'){
                  $movimiento['subtotal']=$cantant+$movimiento['cantidad'];
                  $pdf->Row(array(
                    '',
                    utf8_decode($movimiento['fecha']),
                    utf8_decode($movimiento['tienda']),  
                    utf8_decode($movimiento['prcl']),    
                    utf8_decode($movimiento['mov']),  
                    utf8_decode($movimiento['cantidad']),   
                    '',    
                    utf8_decode($movimiento['subtotal']), 
                    '',        
                  ));
                }else{
                  $movimiento['subtotal']=$cantant-$movimiento['cantidad'];
                  $pdf->Row(array(
                    '',
                    utf8_decode($movimiento['fecha']),
                    utf8_decode($movimiento['tienda']),  
                    utf8_decode($movimiento['prcl']),    
                    utf8_decode($movimiento['mov']),  
                    '',   
                    utf8_decode($movimiento['cantidad']),    
                    utf8_decode($movimiento['subtotal']), 
                    '',        
                  ));
                }
                $j++;
                $movanterior[0]=$movimiento;
              }
              $pdf->SetFillColor(232,232,232); //fondo gris RGB
              $pdf->SetFont('Arial','B',10);
              if(isset($movanterior[0]['subtotal'])){
                $pdf->Cell(195,6,'Inventario Final: '.$movanterior[0]['subtotal'],1,0,'R',1);
              }else{
                $pdf->Cell(195,6,'Inventario Final: '.$producto['inventarioInicial'],1,0,'R',1);
              }
              $pdf->Ln(7);
              $pdf->Ln(5);
            }
  
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Inventario Final',1,0,'C',1);
            $pdf->Ln(7);
  
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(35,6,'Fecha',1,0,'C',1);
            $pdf->Cell(55,6,'Tienda',1,0,'C',1);
            $pdf->Cell(65,6,'Producto',1,0,'C',1);
            $pdf->Cell(40,6,'Total ',1,0,'C',1);
            $pdf->Ln(7);
  
            $fecha=$_GET['fechafinal'];
            $fechaActual = date('Y-m-d');
      
            if($fechaActual==$fecha){
              $rspta = $consultas->inventarioDetFinActualxtiendaProd($fecha,$_GET['tienda'],$_GET['producto']);
            }else{
              $date_future = strtotime('+1 day', strtotime($fecha));
              $date_future = date('Y-m-d', $date_future);
              $rspta = $consultas->inventarioDetFinxtiendaProd($date_future,$_GET['tienda'],$_GET['producto']);
            }
            $pdf->SetWidths(array(35,55,65,40)); //Anchos de las celdas (igula al de las de arrriba)
            $total=0;
            while ($reg = $rspta->fetch_object()) 
            {
                $tienda = $reg->tienda;
                $producto = $reg->producto;
                $cantidad = $reg->cantidad;
                $total+=$cantidad;
                $pdf->SetFont('Arial','',10);
                $pdf->Row(array(
                    utf8_decode($_GET['fechafinal']),
                    utf8_decode($tienda),
                    utf8_decode($producto),
                    utf8_decode($cantidad),
                ));
            }
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Total: '.$total,1,0,'R',1);
            $pdf->Ln(7);
            $pdf->Ln(5);
          }else{
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'No hay datos de inventario para esta seleccion ',1,0,'R',1);
          }
        }else{
          //Celdas para los titulos de cada columna y asignamos color y tipo letra
          $pdf->SetFillColor(232,232,232); //fondo gris RGB
          $pdf->SetFont('Arial','B',10);
          $pdf->Cell(195,6,'Inventario Inicial',1,0,'C',1);
          $pdf->Ln(7);

          $pdf->SetFillColor(232,232,232); //fondo gris RGB
          $pdf->SetFont('Arial','B',10);
          $pdf->Cell(35,6,'Fecha',1,0,'C',1);
          $pdf->Cell(55,6,'Tienda',1,0,'C',1);
          $pdf->Cell(65,6,'Producto',1,0,'C',1);
          $pdf->Cell(40,6,'Total ',1,0,'C',1);
          $pdf->Ln(7);
          $productos[]=array(0,0,0,0,0,0,0,0);
          unset($productos);
          $rspta = $consultas->inventarioDetInixtienda($_GET['fechaini'],$_GET['tienda']);
          $pdf->SetWidths(array(35,55,65,40)); //Anchos de las celdas (igula al de las de arrriba)
          $total=0;
          $entro=false;
          while ($reg = $rspta->fetch_object()) 
          {
              $entro=true;
              $tienda = $reg->tienda;
              $producto = $reg->producto;
              $cantidad = $reg->cantidad;
              $total+=$cantidad;
              $pdf->SetFont('Arial','',10);
              $pdf->Row(array(
                  utf8_decode($_GET['fechaini']),
                  utf8_decode($tienda),
                  utf8_decode($producto),
                  utf8_decode($cantidad),
              ));
              $cantidad=0;
              if(isset($productos[$reg->idproducto])){
                $cantidad=intval($productos[$reg->idproducto]['inventarioInicial'])+$reg->cantidad;
              }else{
                $cantidad=$reg->cantidad;
              }
              $productos[$reg->idproducto]=array(
                'idproducto'=>$reg->idproducto,
                'producto'=> $reg->producto,
                'descripcion'=> $reg->descripcion,
                'inventarioInicial'=>$cantidad,
                'movimientos'=>array(),
              );
          }
          if($entro){
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Total: '.$total,1,0,'R',1);
            $pdf->Ln(7);
            $pdf->Ln(5);
            //Celdas para los titulos de cada columna y asignamos color y tipo letra
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Movimientos',1,0,'C',1);
            $pdf->Ln(7);
  
            //meter movimientos
  
            $movimientos[]=array(0,0,0,0,0,0,0,0);
            unset($movimientos);
            $rspta = $consultas->compraDetfecha($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->proveedor,
                'mov'=> 'Compra',
                'cantidad'=> $reg->cantidad,
                'subtotal'=> 0,
              );
            }
  
            $rspta = $consultas->ventaDetfecha($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->cliente,
                'mov'=> 'Venta',
                'cantidad'=> $reg->cantidad,
                'subtotal'=> 0,
              );
            }
            if(isset($movimientos)){
              usort($movimientos, function($a1, $a2) {
                $v1 = strtotime($a1['fecha']);
                $v2 = strtotime($a2['fecha']);
                return $v1 - $v2; 
            });
            }
            
          /*var_dump($movimientos);
          var_dump($productos);*/
          foreach($productos as $producto){
            $j=0;
            if(isset($movimientos)){
              foreach($movimientos as $movimiento){
                if($producto['idproducto']==$movimiento['idproducto']){
                  array_push($productos[$producto['idproducto']]['movimientos'],$movimientos[$j]);
                }
                $j++;
              }
            }
          }
            /*foreach($productos as $producto){
              var_dump($producto);
            }*/
            unset($movimientos);
            
            foreach($productos as $producto){
              $j=0;
              encabezadoProducto($pdf);
              $pdf->SetFont('Arial','',10);
              $pdf->SetWidths(array(5,20,45,90,30,5)); 
              $pdf->Row(array(
                '',
                utf8_decode($producto['idproducto']),
                utf8_decode($producto['producto']),            
                utf8_decode($producto['descripcion']),  
                utf8_decode($producto['inventarioInicial']),  
                '',          
              ));
              if(count($producto['movimientos'])>0){
                encabezadoMovimiento($pdf);
              }
              $movanterior[0]=array();
              foreach($producto['movimientos'] as $movimiento){
                $cantant=0;
                if($j==0){
                  $cantant=$producto['inventarioInicial'];
                }else{
                  /*echo($j);
                  var_dump($movanterior);*/
                  $cantant=$movanterior[0]['subtotal'];
                }
                $pdf->SetWidths(array(7,25,30,35,25,20,20,26,7)); 
                $pdf->SetFont('Arial','',10);
                if($movimiento['mov']=='Compra'){
                  $movimiento['subtotal']=$cantant+$movimiento['cantidad'];
                  $pdf->Row(array(
                    '',
                    utf8_decode($movimiento['fecha']),
                    utf8_decode($movimiento['tienda']),  
                    utf8_decode($movimiento['prcl']),    
                    utf8_decode($movimiento['mov']),  
                    utf8_decode($movimiento['cantidad']),   
                    '',    
                    utf8_decode($movimiento['subtotal']), 
                    '',        
                  ));
                }else{
                  $movimiento['subtotal']=$cantant-$movimiento['cantidad'];
                  $pdf->Row(array(
                    '',
                    utf8_decode($movimiento['fecha']),
                    utf8_decode($movimiento['tienda']),  
                    utf8_decode($movimiento['prcl']),    
                    utf8_decode($movimiento['mov']),  
                    '',   
                    utf8_decode($movimiento['cantidad']),    
                    utf8_decode($movimiento['subtotal']), 
                    '',        
                  ));
                }
                $j++;
                $movanterior[0]=$movimiento;
              }
              $pdf->SetFillColor(232,232,232); //fondo gris RGB
              $pdf->SetFont('Arial','B',10);
              if(isset($movanterior[0]['subtotal'])){
                $pdf->Cell(195,6,'Inventario Final: '.$movanterior[0]['subtotal'],1,0,'R',1);
              }else{
                $pdf->Cell(195,6,'Inventario Final: '.$producto['inventarioInicial'],1,0,'R',1);
              }
              $pdf->Ln(7);
              $pdf->Ln(5);
            }
  
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Inventario Final',1,0,'C',1);
            $pdf->Ln(7);
  
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(35,6,'Fecha',1,0,'C',1);
            $pdf->Cell(55,6,'Tienda',1,0,'C',1);
            $pdf->Cell(65,6,'Producto',1,0,'C',1);
            $pdf->Cell(40,6,'Total ',1,0,'C',1);
            $pdf->Ln(7);
  
            $fecha=$_GET['fechafinal'];
            $fechaActual = date('Y-m-d');
      
            if($fechaActual==$fecha){
              $rspta = $consultas->inventarioDetFinActualxtienda($fecha,$_GET['tienda']);
            }else{
              $date_future = strtotime('+1 day', strtotime($fecha));
              $date_future = date('Y-m-d', $date_future);
              $rspta = $consultas->inventarioDetFinxtienda($date_future,$_GET['tienda']);
            }
            $pdf->SetWidths(array(35,55,65,40)); //Anchos de las celdas (igula al de las de arrriba)
            $total=0;
            while ($reg = $rspta->fetch_object()) 
            {
                $tienda = $reg->tienda;
                $producto = $reg->producto;
                $cantidad = $reg->cantidad;
                $total+=$cantidad;
                $pdf->SetFont('Arial','',10);
                $pdf->Row(array(
                    utf8_decode($_GET['fechafinal']),
                    utf8_decode($tienda),
                    utf8_decode($producto),
                    utf8_decode($cantidad),
                ));
            }
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Total: '.$total,1,0,'R',1);
            $pdf->Ln(7);
            $pdf->Ln(5);
          }else{
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'No hay datos de inventario para esta seleccion ',1,0,'R',1);
          }
          
        }
        
        $pdf->Output();
    } 

    else
    {
        echo 'No tiene permiso para visualizar el reporte';
    }


   }
   ob_end_flush(); //liberar el espacio del buffer
   
   function encabezadoProducto($pdf){
    
    
    $pdf->SetFillColor(232,232,232); //fondo gris RGB
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(5,6,'',1,0,'C',1);
    $pdf->Cell(20,6,utf8_decode('Código'),1,0,'C',1);
    $pdf->Cell(45,6,'Producto',1,0,'C',1);
    $pdf->Cell(90,6,utf8_decode('Descripción'),1,0,'C',1);
    $pdf->Cell(30,6,utf8_decode('Inventario Inicial'),1,0,'C',1);
    $pdf->Cell(5,6,'',1,0,'C',1);
    $pdf->Ln(7);
   }
   function encabezadoMovimiento($pdf){
    //Celdas para los titulos de cada columna y asignamos color y tipo letra
    $pdf->SetFillColor(232,232,232); //fondo gris RGB
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(7,6,'',1,0,'C',1);
    $pdf->Cell(25,6,'Fecha',1,0,'C',1);
    $pdf->Cell(30,6,'Tienda',1,0,'C',1);
    $pdf->Cell(35,6,'Proveedor/Cliente',1,0,'C',1);
    $pdf->Cell(25,6,'Movimiento',1,0,'C',1);
    $pdf->Cell(20,6,'Suma',1,0,'C',1);
    $pdf->Cell(20,6,'Resta',1,0,'C',1);
    $pdf->Cell(26,6,'SubTotal',1,0,'C',1);
    $pdf->Cell(7,6,'',1,0,'C',1);
    $pdf->Ln(7);
   }
   

   function getEncabezados($pdf,$opcion){
    switch($opcion){
      case 1: 
          $pdf->Cell(25,6,'Fecha',1,0,'C',1);
          $pdf->Cell(35,6,'Usuario Vendedor',1,0,'C',1);
          $pdf->Cell(40,6,'Cliente',1,0,'C',1);
          $pdf->Cell(30,6,'Tienda',1,0,'C',1);
          $pdf->Cell(30,6,'Descuento (Q)',1,0,'C',1);
          $pdf->Cell(20,6,'IVA (Q)',1,0,'C',1);
          $pdf->Cell(30,6,'Total Venta (Q)',1,0,'C',1);
          $pdf->Cell(35,6,utf8_decode('Cant. Artículos'),1,0,'C',1);
          $pdf->Cell(20,6,'Estado',1,0,'C',1);  
        break;
      case 2: 
          $pdf->Cell(25,6,'Fecha',1,0,'C',1);
          $pdf->Cell(30,6,'Usuario',1,0,'C',1);
          $pdf->Cell(30,6,'Proveedor',1,0,'C',1);
          $pdf->Cell(30,6,'Tienda',1,0,'C',1);
          $pdf->Cell(30,6,'Moneda',1,0,'C',1);
          $pdf->Cell(35,6,'Cant. Productos',1,0,'C',1);
          $pdf->Cell(30,6,'Impuesto (Q)',1,0,'C',1);
          $pdf->Cell(35,6,'Total (Q)',1,0,'C',1);
          $pdf->Cell(20,6,'Estado',1,0,'C',1);  
        break;
      case 3: 
          $pdf->Cell(25,6,'Tienda',1,0,'C',1);
          $pdf->Cell(35,6,'Producto',1,0,'C',1);
          $pdf->Cell(30,6,'Precio',1,0,'C',1);
          $pdf->Cell(85,6,utf8_decode('Descripción'),1,0,'C',1);
          $pdf->Cell(30,6,'Proveedor',1,0,'C',1);
          $pdf->Cell(30,6,'Cantidad',1,0,'C',1);
          $pdf->Cell(20,6,'Estado',1,0,'C',1);
        break;
      case 4: 
          $pdf->Cell(25,6,'Fecha Venta',1,0,'C',1);
          $pdf->Cell(30,6,'Usuario',1,0,'C',1);
          $pdf->Cell(40,6,'Cliente',1,0,'C',1);
          $pdf->Cell(30,6,'Tienda',1,0,'C',1);
          $pdf->Cell(30,6,'Cant. Productos',1,0,'C',1);
          $pdf->Cell(20,6,'Total',1,0,'C',1);
          $pdf->Cell(35,6,utf8_decode('Fecha Devolución'),1,0,'C',1);
          $pdf->Cell(35,6,'Comentario',1,0,'C',1);
          $pdf->Cell(20,6,'Estado',1,0,'C',1);  
        break;
      case 5: 
          $pdf->Cell(45,6,'Fecha',1,0,'C',1);
          $pdf->Cell(55,6,'Usuario',1,0,'C',1);
          $pdf->Cell(150,6,utf8_decode('Acción'),1,0,'C',1);
        break;
    }
   }

   
     
?>