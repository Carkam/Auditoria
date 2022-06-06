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

    if($_SESSION['reportes'] == 1)
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
                        <h1 class="box-title">Consulta de Movimientos por Fecha y Producto</h1>
                        <button class="btn btn-info" id='reporte'>Reporte</button>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label for="">Fecha Inicio</label>
                            <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                              <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d");?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label for="">Fecha Fin</label>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d");?>">
                        </div>

                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label for="">Tienda</label>
                            <select name="idtienda" id="idtienda" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label for="">Producto</label>
                            <select name="idproducto" id="idproducto" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        <div style="height:500px;">

                        </div>
                        <!--<table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Fecha Venta</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Tienda</th>
                            <th>Cantidad Productos</th>
                            <th>Total</th>
                            <th>Fecha Devolución</th>
                            <th>Comentario</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Fecha Venta</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Tienda</th>
                            <th>Cantidad Productos</th>
                            <th>Total</th>
                            <th>Fecha Devolución</th>
                            <th>Comentario</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>-->
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

<script src="./scripts/movimientos.js"></script>
<script src="./scripts/barrita.js"></script>
<script>
  $(document).ready(function(){
      $("#reporte").click(function(event){
        var fechainicial=$('#fecha_inicio').val();
        var fechafinal=$('#fecha_fin').val();
        var tienda=$('#idtienda').val();
        var tiendaname=$('select[id="idtienda"] option:selected').text();
        var producto=$('#idproducto').val();
        var prodname=$('select[id="idproducto"] option:selected').text();
        //if(tienda!=0){
          window.open("../reportes/movimientos.php?op=4&fechaini="+fechainicial+"&fechafinal="+fechafinal+"&tienda="+tienda+"&nombre="+tiendaname+"&producto="+producto+"&nombreProd="+prodname, '_blank'); 
          var usuario = $("#idusuario").val();
          $.post(
                              "../ajax/bitacora.php?op=insertar",
                              {usuario:usuario,accion:"Creó reporte de movimientos"}
                          );
        /*}else{
          bootbox.alert('Debe de elegir una tienda');
        }*/
        
      });
    });
</script>
<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>