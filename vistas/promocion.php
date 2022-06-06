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

    if($_SESSION['almacen'] == 1)
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
                            <h1 class="box-title">Promoción 
                              <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
                                <i class="fa fa-plus-circle"></i> 
                                Agregar
                              </button>
                              <!-- <a target="_blank" href="../reportes/rptarticulos.php">
                                <button class="btn btn-info">Reporte</button>
                              </a> -->
                            </h1>
                          <div class="box-tools pull-right">
                          </div>
                      </div>
                      <!-- /.box-header -->
                      <!-- centro -->
                      <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                              <th>Opciones</th>
                              <th>Fecha Inicio</th>
                              <th>Fecha Final</th>
                              <th>Producto</th>
                              <th>Descuento</th>
                              <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Fecha Inicio</th>
                              <th>Fecha Final</th>
                              <th>Producto</th>
                              <th>Descuento</th>
                              <th>Estado</th>
                            </tfoot>
                          </table>
                      </div>
                      <div class="panel-body"  id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha Inicio:</label>
                              <input type="hidden" name="idpromocion" id="idpromocion">
                              <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                              <input type="date" class="form-control" name="fechai" id="fechai" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha Final:</label>
                              <input type="date" class="form-control" name="fechaf" id="fechaf" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Producto:</label>
                              <select name="idproducto" id="idproducto" data-live-search="true" class="form-control selectpicker" required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Descuento:</label>
                              <input type="number" step="any" class="form-control" name="descuento" id="descuento" placeholder="Descuento" required>
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
  
  <script src="./scripts/promocion.js"></script>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>

     

<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>