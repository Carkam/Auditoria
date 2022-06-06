<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADVentas | www.ventas.com</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../public/css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        /* .container-fluid, .row{
            height:100vh;
        } */

      .login-box{
          border:0 solid black;
          background-color: white;
          border-radius:20px;
          padding:5rem 2rem;
          box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2), 0px 0px 10px rgba(0, 0, 0, 0.2);
          text-align:center;
      }

      .inputs{
        padding: 2.5rem 1rem;
        font-size: 2rem;
      }

      .spans{
        height: 100%;
        position: absolute;
        top: 10px;
      }

      .logo{
        height: 100px;
        width: auto;
      }

      .radius{
        border-radius: 5px;
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2), 0px 0px 5px rgba(0, 0, 0, 0.2);
      }

  </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <?php 
               include('../config/conexion.php');
              $resultado = $conexion ->query("SELECT * from empresa")or die($conexion -> error);
              while ($fila = mysqli_fetch_array($resultado)) {
            ?>
              <b><?php echo $fila['nombre'];?></b>
              <img src="../files/empresa/<?php echo $fila['logo'];?>" alt="<?php echo $fila['nombre'];?>" class='logo'> 
            <?php } ?>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <h2 class="login-box-msg">Ingrese sus Correo Electronico</h2>
        <p class="login-box-msg">Le estaremos enviando a su correo su contraseña</p>
        <form method="post" id="frmOlvide">
          <div class="form-group has-feedback">
            <input type="text" class="form-control inputs  radius" id="usuarioa" name="usuarioa" placeholder="Usuario">
            <span class="fa fa-user form-control-feedback spans"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="clavea" name="clavea" class="form-control inputs radius" placeholder="Nueva Contraseña">
            <span class="fa fa-key form-control-feedback spans"></span>
          </div>
          <div class="row" style="margin-top: 4rem; margin-bottom: 2rem;">
            <div class="col-xs-8">

            </div><!-- /.col -->
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat radius">Enviar</button>
            </div><!-- /.col -->
          </div>
        </form>        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

     <!-- jQuery 3.1.1 -->
     <script src="../public/js/jquery-3.1.1.min.js"></script>
     <!-- Bootstrap 3.3.5 -->
     <script src="../public/js/bootstrap.min.js"></script>

      <!-- Bootbox -->
     <script src="../public/js/bootbox.min.js"></script>

     <!-- Funciones -->
     <script src="scripts/login.js"></script>

  </body>
</html>
