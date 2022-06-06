<?php
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ventas | VENTAS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/favicon.ico">

    <!--DATATABLES-->
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
    
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
    

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>VE</b>Ventas</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Ventas</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
              <b>Tienda Actual:</b>
              <select name="tienda" id="tienda" required class="form-control  radius" onchange="actualizarTienda()">
              <option value="" disabled selected hidden>Seleccione una Tienda</option>
              <?php 
                 include('../config/conexion.php');
                $resultado = $conexion ->query("SELECT * from tienda WHERE tipotienda=1")or die($conexion -> error);
                while ($fila = mysqli_fetch_array($resultado)) {
              ?>
                <option value="<?php echo $fila['idTienda'];?>"><?php echo $fila['nombre'];?></option>
               
              <?php } ?>
            </select>


              </li>
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      Desarrollando Software
                      <small>www.google.com</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat"><i class="fa fa-power-off"></i><span>  Cerrar Sesión</span></a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php
              /*if($_SESSION['escritorio'] == 1)
              {
                echo 
                '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Escritorio</span>
                  </a>
                </li>';
              }*/

              if($_SESSION['almacen'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-laptop"></i>
                      <span>Almacén</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                      <li><a href="caracteristicas.php"><i class="fa fa-circle-o"></i> Caracteristicas</a></li>
                      <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                      <li><a href="carCat.php"><i class="fa fa-circle-o"></i> Características de Categoría</a></li>
                      <li><a href="promocion.php"><i class="fa fa-circle-o"></i> Promoción</a></li>
                      <li><a href="bodega.php"><i class="fa fa-circle-o"></i> Bodegas</a></li>
                      <li><a href="bodegaTienda.php"><i class="fa fa-circle-o"></i> Artículos de Bodega a Tienda</a></li>
                      <li><a href="minimo.php"><i class="fa fa-circle-o"></i> Minimos</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['compras'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-truck"></i>
                      <span>Compras</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                      <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['ventas'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      <span>Ventas</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="venta.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                      <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                      <li><a href="tienda.php"><i class="fa fa-circle-o"></i> Tienda</a></li>
                      <li><a href="seguimientoVenta.php"><i class="fa fa-circle-o"></i>Seguimiento de Venta</a></li>
                      <li><a href="devolucion.php"><i class="fa fa-circle-o"></i>Devolución</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['pagos'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-usd"></i>
                      <span>Pagos</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="moneda.php"><i class="fa fa-circle-o"></i>Tipo Moneda</a></li>
                      <li><a href="tipoPago.php"><i class="fa fa-circle-o"></i> Tipo de Pago</a></li>
                    </ul>
                  </li>'
                 ;
              }
              //cambiar permiso a recursos humanos
              if($_SESSION['recursosh'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-users"></i>
                      <span>Recursos Humanos</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="trabajador.php"><i class="fa fa-circle-o"></i> Trabajadores</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['acceso'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-user-secret"></i> <span>Acceso</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                      <li><a href="bitacora.php"><i class="fa fa-circle-o"></i> Bitacora</a></li>
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['configuracion'] == 1)
              {
                echo 
                '<li>
                    <a href="configuracion.php">
                      <i class="fa fa-gear"></i> <span>Configuración</span>
                    </a>
                  </li>
                  <li>
                    <a href="alerta.php">
                      <i class="fa fa-gear"></i> <span>Alertas</span>
                    </a>
                  </li>
                  <li>
                    <a href="ganancia.php">
                      <i class="fa fa-gear"></i> <span>% de Ganancia</span>
                    </a>
                  </li>'
                 ;
              }
              if($_SESSION['reportes'] == 1)
              {
                echo 
                '<li class="treeview">
                    <a href="#">
                      <i class="fa fa-file-pdf-o"></i> <span>Reportes</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Ventas</a></li>  
                      <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Compras</a></li>   
                      <li><a href="inventario.php"><i class="fa fa-circle-o"></i> Inventario</a></li>   
                      <li><a href="movimientos.php"><i class="fa fa-circle-o"></i> Movimientos de Inventario</a></li>   
                      <li><a href="devolucionfechacliente.php"><i class="fa fa-circle-o"></i> Devoluciones</a></li>   
                      <li><a href="bitacorafechausuario.php"><i class="fa fa-circle-o"></i> Bitácora</a></li>   
                      <li><a href="repganancia.php"><i class="fa fa-circle-o"></i> Ganancias</a></li>                
                    </ul>
                  </li>'
                 ;
              }
              if($_SESSION['graficas'] == 1)
              {
                echo 
                '<li>
                    <a href="escritorio.php">
                      <i class="fa fa-dashboard"></i> <span>DashBoards</span>
                    </a>
                  </li>'
                 ;
              }
            ?>  
            <!-- arreglar lo de cerrar session -->                              
            <li>
              <a href="../ajax/usuario.php?op=salir">
                <i class="fa fa-power-off"></i> <span>Cerrar Sesión</span>
              </a>
            </li>
            <!-- <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li> -->
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- <script src="./scripts/barrita.js"></script> -->