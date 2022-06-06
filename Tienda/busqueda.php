<?php 
   session_start();
    include('./php/conexion.php');
    if(!isset($_GET['texto'])){
        header("Location: ./index.php");
    }
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
    <?php include("./layouts/header.php"); ?> 

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="float-md-left mb-4"><h2 class="text-black h5">Buscando resultados para <?php echo $_GET['texto'];?> </h2></div>
                <!-- <div class="d-flex">
                  <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Latest
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                      <a class="dropdown-item" href="#">Men</a>
                      <a class="dropdown-item" href="#">Women</a>
                      <a class="dropdown-item" href="#">Children</a>
                    </div>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                      <a class="dropdown-item" href="#">Relevance</a>
                      <a class="dropdown-item" href="#">Name, A to Z</a>
                      <a class="dropdown-item" href="#">Name, Z to A</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Price, low to high</a>
                      <a class="dropdown-item" href="#">Price, high to low</a>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="row mb-5">
              <?php 
               $limite = 9;//productos por pagina
               //$totalQuery = $conexion->query('select count(*) from producto')or die($conexion->error);
               if($_GET['precio']==0){
                    $totalQuery = $conexion->query("select count(*) from producto inner join categoria on producto.idcategoria  = categoria.idcateogira 
                        where producto.estado=1 and 
                        (producto.nombre like '%".$_GET['texto']."%' or 
                        producto.descripcion like '%".$_GET['texto']."%' or
                        categoria.nombre like '%".$_GET['texto']."%')")or die($conexion->error);
                    if(isset($_GET['limite'])){
                        $resultado = $conexion ->query("select producto.*, categoria.nombre as categoria from producto 
                        inner join categoria on producto.idcategoria  = categoria.idcateogira 
                        where producto.estado=1 and
                        (producto.nombre like '%".$_GET['texto']."%' or 
                        producto.descripcion like '%".$_GET['texto']."%' or
                        categoria.nombre like '%".$_GET['texto']."%') 
                        order by producto.idproducto DESC limit ".$_GET['limite'].",".$limite)or die($conexion -> error);
                    }else{
                        $resultado = $conexion ->query("SELECT producto.*, categoria.nombre as categoria from producto 
                        inner join categoria on producto.idcategoria  = categoria.idcateogira 
                        where producto.estado=1 and (producto.nombre like '%".$_GET['texto']."%' or 
                        producto.descripcion like '%".$_GET['texto']."%' or
                        categoria.nombre like '%".$_GET['texto']."%') 
                        ORDER BY producto.idproducto DESC limit ".$limite)or die($conexion -> error);
                    }
               }else{
                    $totalQuery = $conexion->query("select count(*) from producto inner join categoria on producto.idcategoria  = categoria.idcateogira 
                    where producto.estado=1 and producto.precio between ".$_GET['precioInicio']." AND ".$_GET['precioFinal'])or die($conexion->error);
                    if(isset($_GET['limite'])){
                        $resultado = $conexion ->query("select producto.*, categoria.nombre as categoria from producto 
                        inner join categoria on producto.idcategoria  = categoria.idcateogira 
                        where producto.estado=1 and
                        producto.precio between ".$_GET['precioInicio']." AND ".$_GET['precioFinal']. "
                        order by producto.precio limit ".$_GET['limite'].",".$limite)or die($conexion -> error);
                    }else{
                        $resultado = $conexion ->query("select producto.*, categoria.nombre as categoria from producto 
                        inner join categoria on producto.idcategoria  = categoria.idcateogira 
                        where producto.estado=1 and
                        producto.precio between ".$_GET['precioInicio']." AND ".$_GET['precioFinal']. "
                        order by producto.precio limit ".$limite)or die($conexion -> error);
                    }
               }
               $totalProductos = mysqli_fetch_row($totalQuery);
               $totalBotones = ceil($totalProductos[0] /$limite);
                if(mysqli_num_rows($resultado) > 0){ 

                   
                 while($fila = mysqli_fetch_array($resultado)){
              ?>
                                     <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
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
                <?php } }else{
                    echo  '<h2>Sin resultados</h2>';
                } ?>


            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <div class="site-block-27">
                <ul>
                   
                   <?php 
                    if($_GET['precio']==0){
                        if(isset($_GET['limite'])){
                            if($_GET['limite']>0){
                              echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&limite='.($_GET['limite']-9).'">&lt;</a></li>';
                            }
                          }
     
                          for($k=0;$k<$totalBotones;$k++){
                            echo  '<li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&limite='.($k*9).'">'.($k+1).'</a></li>';
                          }
                          if(isset($_GET['limite'])){
                            if($_GET['limite']+9 < $totalBotones*9){
                              echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&limite='.($_GET['limite']+9).'">&gt;</a></li>';
                            }
                          }else{
                            echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&limite=9">&gt;</a></li>';
                          }
                   }else{
                        if(isset($_GET['limite'])){
                            if($_GET['limite']>0){
                            echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&precioInicio='.$_GET['precioInicio'].'&precioFinal='.$_GET['precioFinal'].'&limite='.($_GET['limite']-9).'">&lt;</a></li>';
                            }
                        }
    
                        for($k=0;$k<$totalBotones;$k++){
                            echo  '<li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&precioInicio='.$_GET['precioInicio'].'&precioFinal='.$_GET['precioFinal'].'&limite='.($k*9).'">'.($k+1).'</a></li>';
                        }
                        if(isset($_GET['limite'])){
                            if($_GET['limite']+9 < $totalBotones*9){
                            echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&precioInicio='.$_GET['precioInicio'].'&precioFinal='.$_GET['precioFinal'].'&limite='.($_GET['limite']+9).'">&gt;</a></li>';
                            }
                        }else{
                            echo ' <li><a href="busqueda.php?texto='.$_GET['texto'].'&precio='.$_GET['precio'].'&precioInicio='.$_GET['precioInicio'].'&precioFinal='.$_GET['precioFinal'].'&limite=9">&gt;</a></li>';
                        }
                   }
                   ?>
               

                </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
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
                             <?php $re2 = $conexion->query("select count(*) from producto where producto.estado=1 and idCategoria=".$fila['idCateogira']);
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

            </div>
          </div>
        </div>

        <!-- <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categories</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/women.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Women</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/children.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Children</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="images/men.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Men</h3>
                      </div>
                    </a>
                  </div>
                </div>
              
            </div>
          </div>
        </div> -->
        
      <!-- </div> -->
    <!-- </div>-->
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
  <script >
    function init(){
        let searchParams = new URLSearchParams(window.location.search);
        var precioBool = searchParams.get('precio');
        if(precioBool==1){
            var precioI = searchParams.get('precioInicio');
            var precioF = searchParams.get('precioFinal');
            $('#slider-range').slider("values",[precioI,precioF]);
            $('#amount').val("Q"+precioI+" - Q"+precioF);
        }
    }
    $(document).ready(function(){
        init();
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