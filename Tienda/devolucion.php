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

          <?php
                  include('./php/conexion.php');
                    $resultado = $conexion -> query("SELECT s.idventaencabezado ,v.fecha, v.total
                    FROM seguimientoventa s, faseseguimiento f, ventaencabezado v
                    where s.idfaseseguimiento=f.idfaseseguimiento and s.idventaencabezado=v.idventaencabezado
                    and v.idcliente='".$_SESSION['idcliente']."' and s.idfaseseguimiento='2' and s.estado=1 and v.estado=1") or die ($conexion -> error);

                    if (mysqli_num_rows($resultado)>0) {   
                      echo '
                      <table class="table table-bordered mt-5"
                        <thead>
                        <tr>
                          <th class="product-name">No. de la Compra</th>
                          <th class="product-price">Fecha de la Compra</th>
                          <th class="product-quantity">Total (Q)</th>
                        </tr>
                        </thead>
                        <tbody>
  
                      ';                   
                      while ($fila = mysqli_fetch_array($resultado)){
                        echo '
                        <tr>
                          <td>'.$fila[0].'</td>
                          <td>'.$fila[1].'</td>  
                          <td>'.$fila[2].'</td>
                        </tr>                         
                    ';
                        // echo '<script>console.log("'.$fila[0].'")</script>';
                      }  
                      echo '
                    </tbody>
                    </table>';  
                    
                    
                    echo'
                    <form action="devolucion2.php" method="post">
              
                    <div class="p-3 p-lg-5 border">
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label for="c_fname" class="text-black">Escribe el No. de la Compra que deseas devolver<span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="c_fname" name="c_fname">   
                          <input type="submit" class="btn btn-primary btn-lg btn-block mt-3" value="Siguiente">                
                        </div>
                      <!-- <div class="form-group row">
                        <div class="col-lg-12">
                          <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar">
                        </div>
                      </div> -->
                    </div>
                  </form> 
                    ';
                    }else{
                      echo '<h1>Este cliente no tiene ninguna compra pendiente de entrega</h1>';
                    }

            
            ?>

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