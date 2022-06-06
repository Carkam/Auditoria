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

    if($_SESSION['escritorio'] == 1)
    {
        $user= $_SESSION["nombre"];
        $iduser=$_SESSION['idusuario'];
        require_once '../modelos/Consultas.php';
        
        $consulta = new Consultas();
        
        $rsptac = $consulta->totalCompraHoy();
        $regc = $rsptac->fetch_object();
        $totalc = $regc->total_compra;

        $rsptav = $consulta->totalVentaHoy();
        $regv = $rsptav->fetch_object();
        $totalv = $regv->total_venta;

        //Mostrar graficos 
        $compras10 = $consulta->comprasUlt10dias();
        $fechasc = '';
        $totalesc = '';

        while($regfechac = $compras10->fetch_object())
        {
            $fechasc =  $fechasc.'"'.$regfechac->fecha2.'",';
            $totalesc = $totalesc.$regfechac->total.',';
        }

        //Quitamos la ultima coma
        $fechasc = substr($fechasc,0,-1);
        $totalesc = substr($totalesc,0,-1);

         //Mostrar graficos 
         $ventas10 = $consulta->ventasUlt10dias();
         $fechasv1 = '';
         $totalesv1 = '';
 
         while($regfechav1 = $ventas10->fetch_object())
         {
             $fechasv1 =  $fechasv1.'"'.$regfechav1->fecha2.'",';
             $totalesv1 = $totalesv1.$regfechav1->total.',';
         }
 
         //Quitamos la ultima coma
         $fechasv1 = substr($fechasv1,0,-1);
         $totalesv1 = substr($totalesv1,0,-1);

        //Graficos Venta
        $compras12 = $consulta->ventas12meses();
        $fechasv = '';
        $totalesv = '';

        while($regfechav = $compras12->fetch_object())
        {
            $fechasv =  $fechasv.'"'.$regfechav->fecha.'",';
            $totalesv = $totalesv.$regfechav->total.',';
        }

        //Quitamos la ultima coma
        $fechasv = substr($fechasv,0,-1);
        $totalesv = substr($totalesv,0,-1);

        $comprasv1 = $consulta->compras12meses();
        $fechasc1 = '';
        $totalesc1 = '';

        while($regfechac1 = $comprasv1->fetch_object())
        {
            $fechasc1 =  $fechasc1.'"'.$regfechac1->fecha.'",';
            $totalesc1 = $totalesc1.$regfechac1->total.',';
        }

        //Quitamos la ultima coma
        $fechasc1 = substr($fechasc1,0,-1);
        $totalesc1 = substr($totalesc1,0,-1);
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
                          <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>Q <?php echo $totalc; ?></strong>
                                        <p>Compras</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="ingreso.php" class="small-box-footer">
                                    Compras 
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4 style="font-size:17px">
                                        <strong>Q <?php echo $totalv; ?></strong>
                                        <p>Ventas</p>
                                    </h4>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="venta.php" class="small-box-footer">
                                    Ventas 
                                     <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="idusuario" id="idusuario" value="<?php echo $iduser; ?>" disabled>
                    <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $user; ?>" disabled>
                    <div class="panel-body">
                        <div class="col-lg-12 ">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-lg btn-info" onclick="mostrarGrafica(true)">Días</button>
                                <button type="button" class="btn btn-lg btn-info" onclick="mostrarGrafica(false)">Meses</button>
                            
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="dia1">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Compras los ultimos 10 dias
                                </div>
                                <div class="box body">
                                    <canvas id="compras" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="dia2">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Ventas los ultimos 10 dias
                                </div>
                                <div class="box body">
                                    <canvas id="ventasv1" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="mes1">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Compras ultimos 12 meses
                                </div>
                                <div class="box body">
                                    <canvas id="comprasc1" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="mes2">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    Ventas ultimos 12 meses
                                </div>
                                <div class="box body">
                                    <canvas id="ventas" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>

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

<script src="./scripts/escritorio.js"></script>
<script src="./scripts/barrita.js"></script>
<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script>
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Compras en Q de los ultimos 10 dias',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(27, 201, 174, 0.8)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(25, 186, 161, 0.8)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: '# Ventas en Q de los ultimos 12 meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(27, 201, 174, 0.8)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(25, 186, 161, 0.8)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("comprasc1").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc1; ?>],
        datasets: [{
            label: '# Compras en Q de los ultimos 12 meses',
            data: [<?php echo $totalesc1; ?>],
            backgroundColor: [
                'rgba(27, 201, 174, 0.8)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(25, 186, 161, 0.8)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("ventasv1").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv1; ?>],
        datasets: [{
            label: 'Ventas en Q de los ultimos 10 dias',
            data: [<?php echo $totalesv1; ?>],
            backgroundColor: [
                'rgba(27, 201, 174, 0.8)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(25, 186, 161, 0.8)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>