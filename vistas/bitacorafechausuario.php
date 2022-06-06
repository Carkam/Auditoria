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
                        <h1 class="box-title">Consulta de Bitácora por Fecha y usuario</h1>
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

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Usuario</label>
                            <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                        <table id="tblistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                          </tfoot>
                        </table>
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

<script src="./scripts/bitacorafechausuario.js"></script>
<script>
  $(document).ready(function(){
      $("#reporte").click(function(event){
        var fechainicial=$('#fecha_inicio').val();
        var fechafinal=$('#fecha_fin').val();
        var cliente=$('#idcliente').val();
        var clientename=$('select[id="idcliente"] option:selected').text();
        window.open("../reportes/pdfBase.php?op=5&fechaini="+fechainicial+"&fechafinal="+fechafinal+"&cliente="+cliente+"&nombre="+clientename, '_blank'); 
        var usuario = $("#idusuario").val();
        $.post(
                            "../ajax/bitacora.php?op=insertar",
                            {usuario:usuario,accion:"Creó reporte de bitácora"},
                            function(f)
                            {
                                bootbox.alert(e, function(){
                                    cancelarform();
                                })
                                
                            }
                        );
      });
    });
</script>
<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>