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
                            <h1 class="box-title">Mover artículos de Bodega a Tienda 
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
                              <th>Nombre</th>
                              <th>Direccion</th>
                              <th>Municipio</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                              <th>Nombre</th>
                              <th>Direccion</th>
                              <th>Municipio</th>
                            </tfoot>
                          </table>
                      </div>
                      <div class="panel-body"  id="formularioregistros">
                          <form name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Bodega:</label>
                              <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                              <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                              <select name="idbodega" id="idbodega" data-live-search="true" class="form-control selectpicker" onchange="bloquear()" required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Tienda:</label>
                              <select name="idtienda" id="idtienda" data-live-search="true" class="form-control selectpicker" onchange="bloquearTienda()" required></select>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <a data-toggle="modal" href="#myModal" >
                                <button id="btnAgregarArt" type="button" class="btn btn-primary">
                                  <span class="fa fa-plus"></span>
                                  Agregar Articulos
                                </button>
                              </a>
                          </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5">
                                  <th>Opciones</th>
                                  <th>Articulos</th>
                                  <th>Cantidad</th>
                                </thead>
                                <tfoot>
                                  <th>TOTAL</th>
                                  <th></th>
                                  <th>
                                    <h4 id="total">0</h4>
                                    <input type="hidden" name="total_compra" id="total_compra">
                                  </th>
                                </tfoot>
                                <tbody>
                                </tbody>
                              </table>
                          </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" onclick="guardaryeditar()" type="button" id="btnGuardar"><i class="fa fa-exchange"></i> Mover</button>
                              <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                              <button class="btn btn-info" onclick="desbloquear(true)" type="button" id="btnLimpiar"><i class="fa fa-refresh"></i> Limpiar</button>
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
             <h4 class="modal-title">Seleccione un articulo</h4>
           </div>
           <div class="modal-body">
             <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
               <thead>
                 <th>Opciones</th>
                 <th>Nombre</th>
                 <th>Categoria</th>
                 <th>Precio</th>
                 <th>Stock</th>
                 <th>Imagen</th>
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
  
  <script src="./scripts/bodegaTienda.js"></script>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
     
<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>