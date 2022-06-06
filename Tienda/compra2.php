<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Compras &mdash; Realizadas</title>
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
      h1{
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

          <div class="row justify-content-center" >
            <div class="col-md-8 mt-5 " id="resultado" style="width:100%; background-color:#f8f9fa;
                border-radius:25px; padding:2rem; 
              ">
              <h1 class="h3 mb-3 text-black">Seguimiento de la Compra</h1>
                <form action="./php/insertarDevolucion.php" method="post">
                <?php
                  include('./php/conexion.php');
                    $resultado = $conexion -> query("SELECT s.fecha, f.nombre, s.comentarios
                    FROM seguimientoventa s, faseseguimiento f
                    where s.idfaseseguimiento=f.idfaseseguimiento and s.idventaencabezado='".$_POST['c_fname']."' and s.estado='1'") or die ($conexion -> error);
                    if (mysqli_num_rows($resultado)>0) {
                      $fila = mysqli_fetch_row($resultado);
                      echo '
                      <div class="form-group row">
                    <div class="col-md-12">
                      <label for="nombre" class="text-black">Fecha de la Compra</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" value="'.$fila[0].'">
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-md-12">
                <label for="correo" class="text-black">Fase en la que se encuentra</label>
                <input type="text" class="form-control" id="correo" name="correo"  value="'.$fila[1].'">
                  </div>
              </div>
                <div class="form-group row">
                    <div class="col-md-12">
                      <label for="nit" class="text-black">Comentarios realizados</label>
                      <input type="text" class="form-control" id="nit" name="nit"  value="'.$fila[2].'">
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