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
        .container-fluid, .row{
            height:100vh;
        }

        .login{
            margin:auto;
            border:0 solid black;
            border-radius:20px;
            padding:4rem;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2), 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align:center;
        }

        .inicio{
            margin-top:2rem;
            width:100%;
        }

        .registrate{
            margin-top:2rem;
        }

    </style>
  </head>
  <body>
  <!-- <?php include("./layouts/header.php"); ?>  -->
  <div class="container-fluid">
      <div class="row">
          <div class="login col-3 100vh">
                <form action="./php/login.php" method="post">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="c_fname" name="c_fname"></input>
                    <label for="contra">Contraseña</label>
                    <input type="password" class="form-control" id="contra" name="contra">
                    <button class="btn btn-primary inicio" type="submit">Iniciar Sesión</button>
                    <br>
                    <input type="button" onclick="history.back()" name="volver atrás" value="Cancelar" class="btn btn-primary inicio">
                    <br>
                    <a href="registro.php" class="registrate">Registrarse</a>
                </form>
          </div>
      </div>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html> 