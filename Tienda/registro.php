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
  
  <div class="container-fluid">
      <div class="row">
          <div class="login col-6 100vh">
              <h2>Registro</h2>
                <form action="./php/registro.php" method="post">
                    <div class="form-row">
                        <label for="usuario">Nombre Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario"></input>
                        <label for="contra">Contraseña</label>
                        <input type="password" class="form-control" id="contra" name="contra">
                    </div>
                    <div class="form-row">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"></input>
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido">
                    </div>
                    <div class="form-row">
                        <label for="fecha">Fecha Nacimiento</label>
                        <input type="date" class="form-control" id="fecha" name="fecha"></input>
                        <label for="correo">Correo</label>
                        <input type="text" class="form-control" id="correo" name="correo">
                    </div>
                    <div class="form-row">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"></input>
                        <label for="dir">Dirección</label>
                        <input type="text" class="form-control" id="dir" name="dir">
                    </div>
                    <div class="form-row">
                        <label for="nit">NIT</label>
                        <input type="text" class="form-control" id="nit" name="nit"></input>
                    </div>
                    <button class="btn btn-primary inicio" type="submit">Registrarse</button>
                    <input type="button" onclick="history.back()" name="volver atrás" value="Cancelar" class="btn btn-primary inicio">
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