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
                          <h1 class="box-title">Compras <h1 id="referencia" type="hidden" class="box-title"># de Referencia: </h1><h1 id="idcompraencabezado" class="box-title"></h1>  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>No. de Referencia</th>
                            <th>Proveedor</th>
                            <th>Usuario</th>
                            <th>Tienda</th>
                            <th>Cantidad de Productos</th>
                            <th>Impuesto</th>
                            <th>Total</th>
                            <th>Moneda</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Proveedor(*):</label>
                            <select name="idproveedor" id="idproveedor" data-live-search="true" class="form-control selectpicker" onchange="bloquear()" required>
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Tienda:</label><br>
                            <label id="mTienda"></label>
                            <!-- <select name="idtienda" id="idtienda" data-live-search="true" class="form-control selectpicker" onchange="bloquearTienda()" required> -->
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha:</label>
                            <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="" >
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Usuario:</label>
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled required>
                            <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Moneda:</label>
                            <select name="idmoneda" id="idmoneda" data-live-search="true" class="form-control selectpicker" onchange="cambioMoneda()" required>
                            </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12" id="estado">
                            <label>Estado:</label>
                            <select name="idestado" id="idestado" data-live-search="true" class="form-control selectpicker" required>
                              <option value=0></option>
                              <option value=1>Inactiva</option>
                              <option value=2>Activa</option>
                              <option value=3>Recibida</option>
                              <option value=4>Devuelta</option>
                            </select>
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
                                  <th>Precio Compra</th>
                                  <th>IVA</th>
                                  <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                  <th>TOTAL</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>
                                    <h4 id="totaliva">Q 0.00</h4>
                                    <input type="hidden" name="total_iva" id="total_iva">
                                  </th>
                                  <th>
                                    <h4 id="total">Q 0.00</h4>
                                    <input type="hidden" name="total_compra" id="total_compra">
                                  </th>
                                </tfoot>
                                <tbody>

                                </tbody>
                              </table>
                          </div>
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" onclick="guardaryeditar()" type="button" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-info" onclick="desbloquear(true)" type="button" id="btnLimpiar"><i class="fa fa-refresh"></i> Limpiar</button>
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
             <h4 class="modal-title">Seleccione un articulo</h4>
           </div>

           <div class="modal-body">
             <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
               <thead>
                 <th>Opciones</th>
                 <th>Nombre</th>
                 <th>Categoria</th>
                 <th>Precio Compra</th>
                 <th>Precio Venta</th>
                 <th>Imagen</th>
               </thead>
               <tbody>

               </tbody>
               <tfoot>
                 <th>Opciones</th>
                 <th>Nombre</th>
                 <th>Categoria</th>
                 <th>Precio Compra</th>
                 <th>Precio Venta</th>
                 <th>Imagen</th>
               </tfoot>
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
<script src="./scripts/ingreso.js"></script>


<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>