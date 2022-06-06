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
        $pdf = new PDF_MC_Table('L','mm',[216,279.4]);

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
        $pdf->Image("../files/empresa/".$imagen,10,8,33);
        //Margenes de 25 pixeles
        $y_axis_initial = 25;

        //Tipo de letra y titulo de la pagina (no es encabezado)
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(75,6,'',0,0,'C');
        $titulo=getTitulo($_GET['op']);
        $hoy=date('d-m-Y');;
        $pdf->Cell(100,6,utf8_decode($titulo.'    Generado: '.$hoy),0,0,'C');
        $pdf->Ln(10);
        $pdf->Cell(75,6,'',0,0,'C');
        $parametros='Rango:'.$_GET['fechaini'].'/'.$_GET['fechafinal'];
        $c="";
        switch($_GET['op']){
          case 1:
          case 2:
          case 4: $c="Cliente";
            break;
          case 3: $c="Tienda";
                  $parametros="";
            break;
          case 5: $c="Usuario";
            break;
        }
        if($_GET['cliente']!=0 || $_GET['op']==3){
          $parametros=$parametros.'   '.$c.': '.$_GET['nombre'];
        }
        $pdf->Cell(100,6,utf8_decode($parametros),0,0,'C');
        $pdf->Ln(10);

        //Celdas para los titulos de cada columna y asignamos color y tipo letra
        $pdf->SetFillColor(232,232,232); //fondo gris RGB
        $pdf->SetFont('Arial','B',10);
        getEncabezados($pdf,$_GET['op']);
        $pdf->Ln(10);

        require_once '../modelos/Consultas.php';
        $consultas = new Consultas();
        switch($_GET['op']){
          case 1: if($_GET['cliente']==0){
                    $rspta = $consultas->ventasfecha($_GET['fechaini'],$_GET['fechafinal']);
                  }else{
                    $rspta = $consultas->ventasfechacliente($_GET['fechaini'],$_GET['fechafinal'],$_GET['cliente']);
                  }
                  $pdf->SetWidths(array(25,35,40,30,30,20,30,35,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $fecha = $reg->fecha;
                      $vendedor = $reg->usuario;
                      $cliente = $reg->cliente;
                      $tienda = $reg->tienda;
                      $descuento = $reg->descuento;
                      $iva = $reg->iva;
                      $total = $reg->total;
                      $cantarticulos = $reg->cantidadprod;
                      $estado = $reg->estado;
                      if($estado==1){
                        $estado='Activa';
                      }else{
                        $estado='Desactiva';
                      }
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode($fecha),
                          utf8_decode($vendedor),
                          utf8_decode($cliente),
                          utf8_decode($tienda),
                          utf8_decode($descuento),
                          utf8_decode($iva),
                          utf8_decode($total),
                          utf8_decode($cantarticulos),
                          utf8_decode($estado),
                      ));
                  }
            break;
          case 2: $rspta = $consultas->comprafecha($_GET['fechaini'],$_GET['fechafinal']);
                  $pdf->SetWidths(array(25,30,30,30,30,35,30,35,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $fecha = $reg->fecha;
                      $usuario = $reg->usuario;
                      $proveedor = $reg->proveedor;
                      $tienda = $reg->tienda;
                      $moneda = $reg->moneda;
                      $cantarticulos = $reg->cantidadprod;
                      $impuesto = $reg->impuesto;
                      $total = $reg->total;
                      $estado = $reg->estado;
                      if($estado==1){
                        $estado='Activa';
                      }else{
                        $estado='Desactiva';
                      }
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode($fecha),
                          utf8_decode($usuario),
                          utf8_decode($proveedor),
                          utf8_decode($tienda),
                          utf8_decode($moneda),
                          utf8_decode($cantarticulos),
                          utf8_decode($impuesto),
                          utf8_decode($total),
                          utf8_decode($estado),
                      ));
                  }
            break;
          case 3: if($_GET['cliente']==0){
                      $rspta = $consultas->inventario();
                    }else{
                      $rspta = $consultas->inventarioxtienda($_GET['cliente']);
                    }
                    $pdf->SetWidths(array(25,35,30,85,30,30,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $tienda = $reg->tienda;
                      $producto = $reg->nombre;
                      $precio = $reg->precio;
                      $descripcion = $reg->descripcion;
                      $proveedor = $reg->proveedor;
                      $cantidad = $reg->cantidad;
                      $estado = $reg->estado;
                      if($estado==1){
                        $estado='Activo';
                      }else{
                        $estado='Desactivo';
                      }
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode($tienda),
                          utf8_decode($producto),
                          utf8_decode($precio),
                          utf8_decode($descripcion),
                          utf8_decode($proveedor),
                          utf8_decode($cantidad),
                          utf8_decode($estado)
                      ));
                  }
            break;
          case 4: if($_GET['cliente']==0){
                    $rspta = $consultas->devolucionfecha($_GET['fechaini'],$_GET['fechafinal']);
                  }else{
                    $rspta = $consultas->devolucionfechacliente($_GET['fechaini'],$_GET['fechafinal'],$_GET['cliente']);
                  }
                  $pdf->SetWidths(array(25,30,40,30,30,20,35,35,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $fechaventa = $reg->fechaventa;
                      $usuario = $reg->usuario;
                      $cliente = $reg->cliente;
                      $tienda = $reg->tienda;
                      $cantarticulos = $reg->cantidadprod;
                      $total = $reg->total;
                      $fechadev = $reg->fechadevolucion;
                      $comentario = $reg->comentario;
                      $estado = $reg->estado;
                      if($estado==1){
                        $estado='Activa';
                      }else{
                        $estado='Desactiva';
                      }
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode($fechaventa),
                          utf8_decode($usuario),
                          utf8_decode($cliente),
                          utf8_decode($tienda),
                          utf8_decode($cantarticulos),
                          utf8_decode($total),
                          utf8_decode($fechadev),
                          utf8_decode($comentario),
                          utf8_decode($estado),
                      ));
                    }
            break;
          case 5: if($_GET['cliente']==0){
                    $rspta = $consultas->bitacorafecha($_GET['fechaini'],$_GET['fechafinal']);
                  }else{
                    $rspta = $consultas->bitacorafechausuario($_GET['fechaini'],$_GET['fechafinal'],$_GET['cliente']);
                  }
                  $pdf->SetWidths(array(45,55,150)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $fechaventa = $reg->fecha;
                      $usuario = $reg->usuario;
                      $accion = $reg->accion;
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode($fechaventa),
                          utf8_decode($usuario),
                          utf8_decode($accion)
                      ));
                    }
            break;
        }
        switch($_GET['op']){
          case 1: 
                  $rspta = $consultas->totalVentas($_GET['fechaini'],$_GET['fechafinal'],$_GET['cliente']);
                  $pdf->SetWidths(array(25,35,40,30,30,20,30,35,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $total = $reg->total;
                      $iva = $reg->iva;
                      $descuento = $reg->descuento;
                      
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode('TOTALES'),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode('Q'.$descuento),
                          utf8_decode('Q'.$iva),
                          utf8_decode('Q'.$total),
                          utf8_decode(''),
                          utf8_decode(''),
                      ));
                  }
            break;
          case 2: $rspta = $consultas->totalCompras($_GET['fechaini'],$_GET['fechafinal']);
                  $pdf->SetWidths(array(25,30,30,30,30,35,30,35,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $total = $reg->total;
                      $iva = $reg->iva;
                      
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode('TOTALES'),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode('Q'.$iva),
                          utf8_decode('Q'.$total),
                          utf8_decode(''),
                      ));
                  }
            break;
          case 3: $rspta = $consultas->totalInventarios($_GET['cliente']);
                    $pdf->SetWidths(array(25,35,30,85,30,30,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $total = $reg->total;
                      
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode('TOTALES'),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode(''),
                          utf8_decode($total),
                          utf8_decode('')
                      ));
                  }
            break;
          case 4: $rspta = $consultas->totalDevolucioness($_GET['fechaini'],$_GET['fechafinal'],$_GET['cliente']);
                  $pdf->SetWidths(array(245,20)); //Anchos de las celdas (igula al de las de arrriba)
                  while ($reg = $rspta->fetch_object()) 
                  {
                      $total = $reg->total;
                      
                      $pdf->SetFont('Arial','',10);
                      $pdf->Row(array(
                          utf8_decode('TOTAL DE DEVOLUCIONES'),
                          utf8_decode(''.$total),
                      ));
                    }
            break;
        }
        $pdf->Output();
    } 

    else
    {
        echo 'No tiene permiso para visualizar el reporte';
    }


   }
   ob_end_flush(); //liberar el espacio del buffer
   

   function getTitulo($opcion){
    switch($opcion){
      case 1: if($_GET['cliente']==0){
                return "Ventas por Fecha";
              }else{
                return "Ventas por Fecha y Cliente";
              }
        break;
      case 2: return "Compras por Fecha";
        break;
      case 3: return "Inventario por Tienda";
        break;
      case 4: if($_GET['cliente']==0){
                return "Devoluciones por Fecha";
              }else{
                return "Devoluciones por Fecha y Cliente";
              }
        break;
      case 5: if($_GET['cliente']==0){
                return "Bitácora por Fecha";
              }else{
                return "Bitácora por Fecha y Usuario";
              }
        break;
    }
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