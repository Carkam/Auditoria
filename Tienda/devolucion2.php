<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Devoluciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    

    <style>
      h2{
        text-align:center;
      }
    </style>
  </head>
  <body>
  
  <div class="site-wrap">
  <?php include("./layouts/header.php"); ?> 

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Devoluciones</h2>
          </div>
          <div class="col-md-12">

            <!-- <form action="#" method="post">
              
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_fname" class="text-black">No. de Venta<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="c_fname" value="<?php $_POST['c_fname']; ?>">             
                  </div>
                 <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar">
                  </div>
                </div> 
              </div>
            </form> -->
          </div>


            <div class="col-md-12 mt-5 center" id="resultado">
              <form action="./php/insertarDevolucion.php" method="post">
              <?php 
                echo'              
                <div class="p-3 p-lg-5 border">
                  <div class="form-group row">
                    <div class="col-md-12">
                      <label for="c_fname" class="text-black">No. de Venta<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_fname" name="c_fname" value="'.$_POST['c_fname'].'">             
                    </div>
                  <!-- <div class="form-group row">
                    <div class="col-lg-12">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar">
                    </div>
                  </div> -->
                </div>
                
                ';
                include('./php/conexion.php');
                  $resultado = $conexion -> query("SELECT c.nombre, c.apellido, c.correo, c.nit, v.fecha, v.total FROM ventaencabezado v, cliente c where v.idcliente=c.idcliente
                  and v.idcliente='".$_SESSION['idcliente']."' and v.idVentaEncabezado='".$_POST['c_fname']."' and v.estado='1'") or die ($conexion -> error);
                  if (mysqli_num_rows($resultado)>0) {
                    $fila = mysqli_fetch_row($resultado);
                    echo '
                    <div class="form-group row">
                  <div class="col-md-6">
                    <label for="nombre" class="text-black">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="'.$fila[0].' ' .$fila[1].'">             
                  </div>
                  <div class="col-md-6">
                    <label for="correo" class="text-black">Correo</label>
                    <input type="text" class="form-control" id="correo" name="correo"  value="'.$fila[2].'">             
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-6">
                    <label for="nit" class="text-black">Nit</label>
                    <input type="text" class="form-control" id="nit" name="nit"  value="'.$fila[3].'">             
                  </div>
                  <div class="col-md-6">
                    <label for="fecha" class="text-black">Fecha</label>
                    <input type="text" class="form-control" id="fecha" name="fecha"  value="'.$fila[4].'">             
                  </div>
              </div>
                    
                    ';
        
                    $resultado2 = $conexion -> query("SELECT p.nombre, v.cantidad, p.precio FROM ventadetalle v, producto p WHERE v.idproducto=p.idproducto and v.idVentaEncabezado='".$_POST['c_fname']."'") or die ($conexion -> error);
                    echo '
                    <h2 class="mt-5">Resumen de la Compra</h2>
                    <table class="table table-bordered mt-5">
                      <thead>
                      <tr>
                        <th class="product-name">Producto</th>
                        <th class="product-price">Precio (Q)</th>
                        <th class="product-quantity">Cantidad</th>
                        <th class="product-total">SubTotal (Q)</th>
                      </tr>
                      </thead>
                      <tbody>

                    ';
                    while ($fila2 = mysqli_fetch_array($resultado2)) {
                      $total= ((double)$fila2[1] * (double)$fila2[2]) ;
                      echo '
                          <tr>
                            <td>'.$fila2[0].'</td>
                            <td>'.$fila2[2].'</td>  
                            <td>'.$fila2[1].'</td>
                            <td>'.$total.'</td>
                          </tr>                         
                      ';
                    }

                    echo '
                    </tbody>
                    <tfooter>
                    <td>Total (Q)</td>
                    <td></td>  
                    <td></td>
                    <td>'.$fila[5].'</td>
                  </tr>     
                    </tfooter>
                     </table>
                     

                     <div class="form-group row">
                     <div class="col-md-12">
                       <label for="motivo" class="text-black mt-5"><h3>Motivo de la devolución</h3></label>
                       <textarea name="motivo" id="motivo" cols="140" rows="5"></textarea>    
                       <input type="submit" class="btn btn-primary btn-lg btn-block mt-3" value="Enviar">         
                     </div>
                     </div>
                     ';
                  }else{
                    echo '<h1>Venta no Encontrada</h1>';
                  }   

                  
        
          ?>
              


              </form>
            </div>

        </div>
      </div>
    </div>

    <!-- <?php include("./layouts/footer.php"); ?>  -->
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  <script>
    
  </script>
  </body>
</html>