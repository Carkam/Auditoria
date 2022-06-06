<header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="./busqueda.php" class="site-block-top-search" method="GET">
                <span class="icon icon-search2"></span>
                <input type="text" class="form-control border-0" placeholder="Buscar" name="texto">
                <input type="hidden" class="form-control border-0" placeholder="Buscar" name="precio" value=0>
              </form>
            </div>
            <?php 
                    include('./php/conexion.php');
                    $resultado = $conexion -> query("SELECT * from empresa") or die ($conexion -> error);
                    while ($fila = mysqli_fetch_array($resultado)) {
                    
                    
                  ?>
            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">               
                <a href="http://localhost:8090/PuntoDeVentaSeminario/Tienda/index.php" style="border: none"><img src="../files/empresa/<?php echo $fila['logo']; ?>"
                      alt="<?php echo $fila['nombre']; ?>" class="img-fluid" style="height:50px;"></a>
               
              </div>
            </div>
            <?php } ?>      
            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                  <li>
                    <a href="cart.php" class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                      <span class="count">
                        <?php 
                          if(isset($_SESSION['carrito'])){
                            echo count($_SESSION['carrito']);
                          }else{ 
                            echo 0;
                          }
                        ?>
                      </span>
                    </a>
                  </li>
                  <li>
                  <?php 
                  if(isset($_SESSION['idusuarioT'])){
                    if($_SESSION['idusuarioT'] == null){
                      echo '<a href="login.php">Login</a>';
                    }else{
                      echo '<a href="./php/cerrar.php">Cerrar Sesión</a>';                 
                    }
                  }else{
                      echo '<a href="login.php">Login</a>';
                  }
                    
                  
                  ?>
                  </li>
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                </ul>
              </div> 
            </div>

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li>
              <a href="index.php">Inicio</a>
            
            </li>
            <li>
              <a href="about.php">Sobre</a>           
            </li>
            <?php 
              if(isset($_SESSION['idusuarioT'])){
                if($_SESSION['idusuarioT'] != null){
                  echo '
                  <li><a href="devolucion.php">Devoluciones</a></li>
                  <li><a href="compra.php">Compras</a></li>
                  ';
                }  
              }   
                                
                ?>

          </ul>
        </div>
      </nav>
    </header>