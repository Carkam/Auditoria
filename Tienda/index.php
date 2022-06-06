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
    <style>

    .carousel{
      max-width: none;
      height: 450px;
      width: 100%;
      margin-top: 0;
      padding-top: 0;
      margin-bottom: 10px;
      background-color: #262829;
    }
    .carousel-item{
      height: 450px;
      width: 100%;
      align-content: center;
      justify-content: center;
    }
    .imgcar{
      opacity: 0.5;
      width: 100%;
      height: 450px;
    }
    .container{
      
    }
    </style>
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); 
          include('./php/conexion.php');?> 

    <div class="site-section" style="padding:0 0 0  0 !important;" >
      <div class="container">
      <div id="carousel1" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
            <?php 
              $contador=0;
              $texto='';
              $resultado = $conexion ->query("SELECT * from categoria where estado=1")or die($conexion -> error);
              while ($fila = mysqli_fetch_array($resultado)) {
                if($contador==0){
                  $texto='active';
                }else{
                  $texto='';
                }
            ?>
              <div class="carousel-item <?php echo $texto;?>" >
              <img src="../files/categorias/<?php echo $fila['imagen'];?>" alt="<?php echo $fila['nombre'];?>" class='imgcar'> 
                <div class="carousel-caption d-none d-md-block">
                  <h5><?php echo $fila['nombre'];?></h5>
                  <p><?php echo $fila['descripcion'];?></p>
                </div>    
              </div>
            <?php $contador++;} ?>
            </div>
            
            <!--Controles NEXT y PREV-->
            <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <!--Controles de indicadores-->
            <ol class="carousel-indicators">
                <?php 
                  $contador=0;
                  $texto='';
                  $resultado = $conexion ->query("SELECT * from categoria where estado=1")or die($conexion -> error);
                  while ($fila = mysqli_fetch_array($resultado)) {
                    if($contador==0){
                      $texto='active';
                    }else{
                      $texto='';
                    }
                ?>
                  <li data-target="#carousel1" data-slide-to="<?php echo $contador;?>" class="<?php echo $texto;?>"></li>
                <?php $contador++;} ?>
            </ol>
        </div>

        <div class="row mb-5">
          <div class="col-md-10 order-2">

            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="float-md-left mb-4"><h2 class="text-black h5">Comprar Todo</h2></div>
                <!-- <div class="d-flex">
                  
                  <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Referencia</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item" href="#">Relevancia</a>
                      <a class="dropdown-item" href="#">Nombre, A a Z</a>
                      <a class="dropdown-item" href="#">Nombre, Z a A</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Precio, Menor a Mayor</a>
                      <a class="dropdown-item" href="#">Precio, Mayor a Menor</a>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="row mb-5 text-center">
            <?php 
                    $limite = 12;//productos por pagina
                    $totalQuery = $conexion->query('SELECT count(*) from producto where estado=1')or die($conexion->error);
                    $totalProductos = mysqli_fetch_row($totalQuery);
                    $totalBotones = ceil($totalProductos[0] /$limite);
                    if(isset($_GET['limite'])){
                      $resultado = $conexion ->query("SELECT * from producto where estado=1 order by idProducto limit ".$_GET['limite'].",".$limite)or die($conexion -> error);
                    }else{
                      $resultado = $conexion ->query("SELECT * from producto where estado=1 order by idProducto limit ".$limite)or die($conexion -> error);
                    }
                    while ($fila = mysqli_fetch_array($resultado)) {
                    
                    
                  ?>
                    <div class="col-sm-6 col-lg-3 mb-4 " data-aos="fade-up">
                      <div class="block-4 text-center border" style="
                        border-radius:20px;  
                        box-shadow: 4px 4px 16px rgba(0,0,0,0.25);
                      ">
                        <figure class="block-4-image">
                          <a href="shop-single.php?id=<?php echo $fila['idProducto']; ?>">
                            <img src="../files/articulos/<?php echo $fila['imagen']; ?>"
                            alt="<?php echo $fila['nombre']; ?>" class="img-fluid"
                            style="width=100%; height:200px; border-top-left-radius:20px;  
                        border-top-right-radius:20px; ">
                          </a>
                        </figure>
                        <div class="block-4-text p-4">
                          <h3><a href="shop-single.php?id=<?php echo $fila['idProducto']; ?>"><?php echo $fila['nombre']; ?></a></h3>
                          <!-- <p class="mb-0"><?php echo $fila['descripcion']; ?></p> -->
                          <p class="text-primary font-weight-bold">Q<?php echo $fila['Precio']; ?></p>
                        </div>
                      </div>
                    </div>
            <?php } ?>
            </div>
            <div class="row" >
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                  <ul>
                   
                      <?php 
                        if(isset($_GET['limite'])){
                          if($_GET['limite']>0){
                            echo ' <li><a href="index.php?limite='.($_GET['limite']-12).'">&lt;</a></li>';
                          }
                        }

                        for($k=0;$k<$totalBotones;$k++){
                          echo  '<li><a href="index.php?limite='.($k*12).'">'.($k+1).'</a></li>';
                        }
                        if(isset($_GET['limite'])){
                          if($_GET['limite']+12 < $totalBotones*12){
                            echo ' <li><a href="index.php?limite='.($_GET['limite']+12).'">&gt;</a></li>';
                          }
                        }else{
                          echo ' <li><a href="index.php?limite=12">&gt;</a></li>';
                        }
                      ?>
                  
  
                   </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-2 order-1 mb-5 mb-md-0">
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categorías</h3>
              <ul class="list-unstyled mb-0">
                <?php 
                 include('./php/conexion.php');
                 $resultado = $conexion -> query("SELECT * from categoria where estado=1") or die ($conexion -> error);
                 while ($fila = mysqli_fetch_array($resultado)) {
                   
                ?>
                 <li class="mb-1">
                     <a href="./busqueda.php?texto=<?php echo $fila['nombre']?>&precio=0" class="d-flex">
                         <span><?php echo $fila['nombre']; ?></span>
                         <span class="text-black ml-auto">
                             <?php $re2 = $conexion->query("select count(*) from producto where estado=1 and idCategoria=".$fila['idCateogira']);
                                    $f= mysqli_fetch_row($re2);
                                    echo $f[0];
                                    ?>
                        </span>
                    </a>
                </li>
                <?php 
                 }
                ?>
              </ul>
            </div>

            <div class="border p-4 rounded mb-4">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filtrar por Precio</h3>
                <div id="slider-range" class="border-primary"></div>
                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
              </div>
<!-- 
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Tamaño</h3>
                <label for="s_sm" class="d-flex">
                  <input type="checkbox" id="s_sm" class="mr-2 mt-1"> <span class="text-black">Pequeño (2,319)</span>
                </label>
                <label for="s_md" class="d-flex">
                  <input type="checkbox" id="s_md" class="mr-2 mt-1"> <span class="text-black">Mediano (1,282)</span>
                </label>
                <label for="s_lg" class="d-flex">
                  <input type="checkbox" id="s_lg" class="mr-2 mt-1"> <span class="text-black">Largo (1,392)</span>
                </label>
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Red (2,429)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Green (2,298)</span>
                </a>
              </div> -->

            </div>
          </div>
        </div>


        
      </div>
    </div>
    <?php include("./layouts/footer.php"); ?> 
    
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
      $("#slider-range" ).slider({
        
        // options
        start: function (event, ui) {
            // code
        },
        slide: function( event, ui ) {
          $( "#amount" ).val( "Q" + ui.values[ 0 ] + " - Q" + ui.values[ 1 ] );
        },
        change: function(event, ui) {
          var precioinicio=ui.values[ 0];
          var preciofinal=ui.values[ 1 ];
          $(location).attr('href',"./busqueda.php?texto=1&precio=1&precioInicio="+precioinicio+"&precioFinal="+preciofinal);
        }
      });
      
    });
  </script>
  </body>
</html>