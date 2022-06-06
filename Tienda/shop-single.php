<?php 
   session_start();
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tienda</title>
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
    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); 
      include("./php/conexion.php");
      if( isset($_GET['id'])){
        $resultado = $conexion -> query("SELECT * FROM producto where idProducto=".$_GET['id'])or die($conexion->error);
        if (mysqli_num_rows($resultado)>0) {
          $fila = mysqli_fetch_row($resultado);
          echo '<script>console.log("bien")</script>';
          echo '<script>console.log("'.$fila[6].'")</script>';
          echo mysqli_num_rows($resultado);
        } else {
          header("Location: ./index.php");
        }
        
      }else{
        header("Location: ./index.php");
      }?> 

    <div class="site-section">
      <div class="container-fluid">
        <div class="row">
          
            <div class="col-3 ml-5">
              <div style="width:100%; background-color:#f8f9fa;
                border-radius:25px; padding:1rem; 
              ">
              <h2 style="border-bottom:1px solid black; color:black;" class="mb-3 pt-2">Disponibilidad en Tiendas</h2>
                <?php
                $resultado2 = $conexion -> query("SELECT t.nombre, t.direccion, i.cantidad 
                FROM  tienda t, inventario i, producto p 
                where i.idtienda=t.idtienda and p.idproducto=i.idproducto and p.idProducto=".$_GET['id'])or die($conexion->error);
                while ($fila2 = mysqli_fetch_array($resultado2)) {
                    echo '
                      <section class="pt-2 pb-2">
                        <p>'.$fila2[0].' <span style="position:absolute; right:100px; color:green;">'.$fila2[2].'</span></p>
                        <span style="position:relative; top:-15px;">Dirección: '.$fila2[1].'</span>                        
                      </section>                
                    ';
                }
                ?>
                
              </div>
            </div>

            <div class="col-8">
              
              <div class="row">
                <div style="width:100%; background-color:#f8f9fa;
                border-radius:25px; padding:1rem; ">
                  <div class="row">
                    <div class="col-md-6">
                      <img src="../files/articulos/<?php echo $fila[6]; ?>" alt="<?php echo $fila[1]; ?>" class="img-fluid" style="border-radius:5px;">
                    </div>
                    <div class="col-md-6">
                      <h2 class="text-black"><?php echo $fila[1]; ?></h2>
                      <h3 class="text-black"><?php echo $fila[8]; ?></h3>
                      <input type="hidden" id="txtId" value="<?php echo $fila[0]; ?>">
                      <p><?php echo $fila[2]; ?></p>
                      <p><strong class="text-primary h4">Q<?php echo $fila[3]; echo '<script>console.log("'.$fila[6].'")</script>';?></strong></p>
                      <div class="mb-1 d-flex">
                        <!-- <label for="option-sm" class="d-flex mr-3 mb-3">
                          <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-sm" name="shop-sizes"></span> <span class="d-inline-block text-black">Small</span>
                        </label>
                        <label for="option-md" class="d-flex mr-3 mb-3">
                          <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-md" name="shop-sizes"></span> <span class="d-inline-block text-black">Medium</span>
                        </label>
                        <label for="option-lg" class="d-flex mr-3 mb-3">
                          <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-lg" name="shop-sizes"></span> <span class="d-inline-block text-black">Large</span>
                        </label>
                        <label for="option-xl" class="d-flex mr-3 mb-3">
                          <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xl" name="shop-sizes"></span> <span class="d-inline-block text-black"> Extra Large</span>
                        </label> -->
                      </div>
                      <div class="mb-5">
                        <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center" value="1" placeholder="" id="txtCant" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                      </div>
                      </div>
                      <p><a href="#" class="buy-now btn btn-sm btn-primary">Agregar al Carro</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
        </div>
      </div>
    </div>

    <!-- <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h2>Featured Products</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Tank Top</a></h3>
                    <p class="mb-0">Finding perfect t-shirt</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_2.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Polo Shirt</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/cloth_3.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">T-Shirt Mockup</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="block-4 text-center">
                  <figure class="block-4-image">
                    <img src="images/shoe_1.jpg" alt="Image placeholder" class="img-fluid">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><a href="#">Corater</a></h3>
                    <p class="mb-0">Finding perfect products</p>
                    <p class="text-primary font-weight-bold">$50</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
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
    $(document).ready(function(){
      $(".buy-now").click(function(event){
        var cantidad=$('#txtCant').val();
        var id=$('#txtId').val();
        $(location).attr('href',"cart.php?id="+id+"&cant="+cantidad);
      });
    });
  </script>
    
  </body>
</html>

