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

      if($_SESSION['compras'] == 1)
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
                          <h1 class="box-title">Devoluciones <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>No. de la Venta</th>
                            <th>Fecha Devolución</th>
                            <th>Comentario</th>
                            <th>Estad0</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>No. de la Venta</th>
                            <th>Fecha Devolución</th>
                            <th>Comentario</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:inline-block;">
                            <label>No. de la Venta:</label>
                            <input type="hidden" name="iddevolucion" id="iddevolucion">
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                            <input type="text" class="form-control" name="noVenta" id="noVenta" maxlength="100" placeholder="No. de la Venta" 
                            required>
                          </div>                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de Devolución:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Estado:</label>
                            <select name="idestado" id="idestado" data-live-search="true" class="form-control selectpicker" required >
                              <option value=""></option>
                              <option value=1>Revisión</option>
                              <option value=2>Aprobada</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <label>Motivo:</label> <br>
                              <textarea name="motivo" id="motivo" cols="220" rows="5" disabled></textarea>
                         </div>
                         <div id="informacion"></div>  
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar" disabled><i class="fa fa-save"></i> Guardar</button>

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

<script src="./scripts/devolucion.js"></script>


<?php

  }
  ob_end_flush(); //liberar el espacio del buffer
?>