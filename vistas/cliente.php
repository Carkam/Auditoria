<?php
    //Activacion de almacenamiento en buffer
    ob_start();
    //iniciamos las variables de session
    session_start();
  
    if(!isset($_SESSION["nombre"]))
    {
      header("Location: login.html");
    }
  
    else  //Agrega toda la vista
    {
      require 'header.php';

      if($_SESSION['ventas'] == 1)
      {
        $user= $_SESSION["nombre"];
      $iduser=$_SESSION['idusuario'];
?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Cliente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Nit</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Nit</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="idcliente" id="idcliente">
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre Cliente" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido:</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" maxlength="100" placeholder="Apellido Cliente" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Nacimiento:</label>
                            <input type="date" class="form-control" name="fechan" id="fechan" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Telefono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Telefono" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Direccion" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nit:</label>
                            <input type="text" class="form-control" name="nit" id="nit" maxlength="70" placeholder="Nit" required>
                          </div>

  
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->


<?php

  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>
      <script src="./scripts/barrita.js"></script>

<script src="./scripts/cliente.js"></script>


<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>