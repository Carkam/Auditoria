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
                            <h1 class="box-title">Seguimiento de Ventas 
                              <!-- <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
                                <i class="fa fa-plus-circle"></i> 
                                Agregar
                              </button>
                              <a target="_blank" href="../reportes/rptarticulos.php">
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
                              <th>Fecha</th>
                              <th>Fase de la Venta</th>
                              <th>No. de la Venta</th>
                              <th>Comentarios</th>
                              <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                              <th>Opciones</th>
                              <th>Fecha</th>
                              <th>Fase de la Venta</th>
                              <th>No. de la Venta</th>
                              <th>Comentarios</th>
                              <th>Estado</th>
                            </tfoot>
                          </table>
                      </div>
                      <div class="panel-body"  id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha:</label>
                              <input type="hidden" name="idarticulo" id="idarticulo">
                              <input type="date" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" readOnly>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fase de la Venta:</label>
                              <select name="idcategoria" id="idcategoria" data-live-search="true" class="form-control selectpicker" required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>No. de la Venta:</label>
                              <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción" readOnly>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">                
                              <label>Comentarios:</label>
                              <input type="text" step="any" class="form-control" name="stock" id="stock" placeholder="Comentarios">
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

  <script src="./scripts/seguimientoVenta.js"></script>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>

     

<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>