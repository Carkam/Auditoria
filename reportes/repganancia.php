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
        $titulo="Reporte de Ganancias";
        $hoy=date('d-m-Y');;
        $pdf->Cell(100,6,utf8_decode($titulo.'    Generado: '.$hoy),0,0,'C');
        $pdf->Ln(10);
        $pdf->Cell(75,6,'',0,0,'C');
        $parametros='Rango:'.$_GET['fechaini'].'/'.$_GET['fechafinal'].'   Tienda: '.$_GET['nombre'];
        $pdf->Cell(45,6,utf8_decode($parametros),0,0,'C');
        $pdf->Ln(10);
        require_once '../modelos/Consultas.php';
        $consultas = new Consultas();

          $movimientos[]=array(0,0,0,0,0,0,0,0);
          unset($movimientos);
            //Celdas para los titulos de cada columna y asignamos color y tipo letra
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'Movimientos',1,0,'C',1);
            $pdf->Ln(7);
  
            //meter movimientos
            $entro=false;
            $rspta = $consultas->compraDetfecha($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $entro=true;
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->proveedor,
                'mov'=> 'Compra',
                'cantidad'=> $reg->total,
                'subtotal'=> 0,
              );
            }
  
            $rspta = $consultas->ventaDetfecha($_GET['fechaini'],$_GET['fechafinal'],$_GET['tienda']);
            $pdf->SetWidths(array(50,70,65,65)); //Anchos de las celdas (igula al de las de arrriba)
            while ($reg = $rspta->fetch_object()) 
            {
              $entro=true;
              $movimientos[]=array(
                'idproducto'=>$reg->idproducto,
                'fecha'=> $reg->fecha,
                'tienda'=> $reg->tienda,
                'prcl'=> $reg->cliente,
                'mov'=> 'Venta',
                'cantidad'=> $reg->total,
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
            if($entro){
              encabezadoMovimiento($pdf);
            $movanterior[0]=array();
            $j=0;
            $totaltotal=0;
              foreach($movimientos as $movimiento){
                $cantant=0;
                if($j==0){
                  $cantant=0;
                }else{
                  /*echo($j);
                  var_dump($movanterior);*/
                  $cantant=$movanterior[0]['subtotal'];
                }
                $pdf->SetWidths(array(7,25,30,35,25,20,20,26,7)); 
                $pdf->SetFont('Arial','',10);
                if($movimiento['mov']=='Compra'){
                  $movimiento['subtotal']=$cantant-$movimiento['cantidad'];
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
                  $movimiento['subtotal']=$cantant+$movimiento['cantidad'];
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
                $totaltotal=$movimiento['subtotal'];
              }
              $pdf->SetFillColor(232,232,232); //fondo gris RGB
              $pdf->SetFont('Arial','B',10);
              $pdf->Cell(195,6,utf8_decode('Pérdida o Ganancia:          '.$totaltotal),1,0,'R',1);
          /*var_dump($movimientos);
          var_dump($productos);*/
            /*foreach($productos as $producto){
              var_dump($producto);
            }*/
            
          }else{
            $pdf->SetFillColor(232,232,232); //fondo gris RGB
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(195,6,'No hay datos de inventario para esta seleccion ',1,0,'R',1);
          }
        
        $pdf->Output();
    }else
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
    $pdf->Cell(20,6,'Resta',1,0,'C',1);
    $pdf->Cell(20,6,'Suma',1,0,'C',1);
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