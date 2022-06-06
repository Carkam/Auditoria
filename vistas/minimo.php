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
      $iduser=$_SESSION['idusuario']
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
                          <h1 class="box-title">Minimo Producto </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Tienda</th>
                            <th>Producto</th>
                            <th>Cantidad Minima</th>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                           <label>Tienda:</label>
                           <input type="hidden" class="form-control" name="idTienda" id="idTienda" >                            
                            <input type="text" class="form-control" name="tiendatienda" id="tiendatienda" disabled>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Producto:</label>
                            <input type="hidden" class="form-control" name="idcategoria" id="idcategoria" >
                            <input type="text" class="form-control" name="producto" id="producto" disabled>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Cantidad Minima:</label>
                            <input type="text" class="form-control" name="minimo" id="minimo">
                          </div>                    
                  
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!--VENTANA MODAL-->
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title">Seleccione una caracteristica</h4>
           </div>

           <div class="modal-body">
             <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
               <thead>
                 <th>Opciones</th>
                 <th>Característica</th>
                 <th>Desplegable</th>
                 <th>Opciones</th>
               </thead>
               <tbody>

               </tbody>
             </table>
           </div>

           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
           </div>

         </div>
       </div>
     </div>
  <!--FIN VENTANA MODAL-->


<?php
  
  } //Llave de la condicion if de la variable de session

  else
  {
    require 'noacceso.php';
  }

  require 'footer.php';
?>
      <script src="./scripts/barrita.js"></script>

<script src="./scripts/minimo.js"></script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>