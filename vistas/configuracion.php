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

      if($_SESSION['acceso'] == 1)
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
                          <h1 class="box-title">Configuración </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre de Empresa</th>
                            <th>NIT</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Eslogan</th>
                            <th>Misión</th>
                            <th>Visión</th>
                            <th>Valores</th>
                            <th>Logo</th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Nombre de la Empresa(*):</label>
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                              <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                            <input type="hidden" name="idempresa" id="idempresa">
                            <input type="text" class="form-control" name="empresa" id="empresa" maxlength="45" placeholder="Nombre de Empresa u Organización" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>NIT:</label>
                            <input type="text" class="form-control" name="nit" id="nit" maxlength="8" placeholder="NIT" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="8" placeholder="Dirección" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="tel" id="tel" maxlength="8" placeholder="Teléfono" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Correo:</label>
                            <input type="text" class="form-control" name="correo" id="correo" maxlength="8" placeholder="Correo" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Eslogan:</label>
                            <input type="text" class="form-control" name="Eslogan" id="Eslogan" maxlength="45" placeholder="Eslogan" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Misión:</label>
                            <input type="text" class="form-control" name="mision" id="mision" maxlength="500" placeholder="Misión" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Visión:</label>
                            <input type="text" class="form-control" name="vision" id="vision" maxlength="500" placeholder="Visión" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label>Valores:</label>
                            <input type="text" class="form-control" name="Valores" id="Valores" maxlength="500" placeholder="Valores" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Logo:</label>
                            <input type="file" class="form-control" name="Logo" id="Logo">
                            <input type="hidden" class="form-control" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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

<script src="./scripts/configuracion.js"></script>

<?php

}
ob_end_flush(); //liberar el espacio del buffer
?>