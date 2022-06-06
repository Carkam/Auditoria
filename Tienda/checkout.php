<?php 
session_start();
if(!isset($_SESSION['carrito'])){
  header('Location: ./index.php');
}
$arreglo  = $_SESSION['carrito'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Faturación</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); ?> 
    <form action="./php/insertarpedido.php" method="post" id="form" onsubmit="revisar(event)">

    <div class="site-section">
      <div class="container">
        <?php 
          if($_SESSION['idusuarioT'] == null){
            echo ' <div class="row mb-5">
            <div class="col-md-12">
              <div class="border p-4 rounded" role="alert">              
                  ¿Soy Cliente? <a href="login.php">Click Aqui</a> para Login
              </div>
            </div>
          </div>';
          }        
        ?>
       

        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Detalles de Facturación</h2>
            <div class="p-3 p-lg-5 border">
              <div class="form-group row">
                <div class="col-md-6">
                  <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_fname" class="text-black">Nombre <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_fname" name="c_fname">
                      ';
                    }else{
                      echo '
                      <label for="c_fname" class="text-black">Nombre <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_fname" name="c_fname" value="'.$_SESSION['name'].'" disabled>
                      ';
                    }
                    
                  ?>
                  
                </div>
                <div class="col-md-6">
                <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_lname" class="text-black">Apellido <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_lname" name="c_lname">
                      ';
                    }else{
                      echo '
                      <label for="c_lname" class="text-black">Apellido <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_lname" name="c_lname" value="'.$_SESSION['ape'].'" disabled>
                      ';
                    }
                    
                  ?>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_fname" class="text-black">NIT <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_nit" name="c_nit">
                      ';
                    }else{
                      echo '
                      <label for="c_fname" class="text-black">NIT <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_nit" name="c_nit" value="'.$_SESSION['nit'].'" disabled>
                      ';
                    }
                    
                  ?>
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-12">
                <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_address" class="text-black">Dirección <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Dirección">
                      ';
                    }else{
                      echo '
                      <label for="c_address" class="text-black">Dirección <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_address" name="c_address" value="'.$_SESSION['direccion'].'" disabled>
                      ';
                    }
                    
                  ?>
                </div>
              </div>

              <div class="form-group row mb-5">
                <div class="col-md-6">
                <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_email_address" class="text-black">Correo Electronico <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_email_address" name="c_email_address">
                      ';
                    }else{
                      echo '
                      <label for="c_email_address" class="text-black">Correo Electronico <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_email_address" name="c_email_address" value="'.$_SESSION['correo'].'" disabled>
                      ';
                    }
                    
                  ?>
                  
                </div>
                <div class="col-md-6">
                <?php 
                    if($_SESSION['idusuarioT'] == null){
                      echo '
                      <label for="c_phone" class="text-black">No. Teléfono <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Telefono">
                      ';
                    }else{
                      echo '
                      <label for="c_phone" class="text-black">No. Teléfono <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="c_phone" name="c_phone" value="'.$_SESSION['telefono'].'" disabled>
                      ';
                    }
                    
                  ?>
                  
                </div>
              </div>

              <div class="form-group">
                <label for="c_order_notes" class="text-black">Detalles</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="..."></textarea>
              </div>


              <div class="form-group">
                 <label for="c_address" class="text-black">Nombre de la Tarjeta <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="nombreT" name="nombreT" placeholder="">
                 <label for="c_address" class="text-black">No. de Tarjeta <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="NoT" name="NoT" placeholder="">
                  <label for="c_address" class="text-black">Codigo de Seguridad<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="codS" name="codS" placeholder="">
              </div>
            </div>
          </div>
          <div class="col-md-6">

            <!-- <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                <div class="p-3 p-lg-5 border">
                  
                  <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button" id="button-addon2">Apply</button>
                    </div>
                  </div>

                </div>
              </div>
            </div> -->
            
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Tu Orden</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Producto</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                    <?php
                        $total = 0; 
                        for($i=0;$i<count($arreglo);$i++){
                          $total =$total+ ($arreglo[$i]['Precio']*$arreglo[$i]['Cantidad']);
                        
                      ?>
                        <tr>
                          <td><?php echo $arreglo[$i]['Nombre'];?> </td>
                          <td>Q<?php echo  number_format($arreglo[$i]['Precio'], 2, '.', '');?></td>
                        </tr>
                      <?php 
                        }
                      ?>
                         <tr>
                          <td>SubTotal</td>
                          <td>Q<?php echo number_format($total, 2, '.', '');?></td>
                        </tr>
                      <tr>
                          <td> <b>Total</b>  </td>
                          <td id="tdTotalFinal" 
                            data-total="<?php echo $total;?>">Q<?php echo number_format($total, 2, '.', '');?></td>
                        </tr>
                    </tbody>
                  </table>

                  <!-- <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

                    <div class="collapse" id="collapsebank">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

                    <div class="collapse" id="collapsecheque">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>

                  <div class="border p-3 mb-5">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                    <div class="collapse" id="collapsepaypal">
                      <div class="py-2">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div> -->

                  <div class="form-group">
                    <input type="submit" value="Realizar Compra" class="btn btn-primary btn-lg py-3 btn-block" onclick="revisar()">
                  </div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <!-- </form> -->
      </div>
    </div>
  </form>  
  <!-- <button class="btn btn-primary btn-lg py-3 btn-block" onclick="revisar()">Realizar Compra</button> -->
    <!-- <?php include("./layouts/footer.php"); ?>  -->
  </div>

  <script>
    function revisar(event){
      let x1 = document.getElementById("c_fname").value;
      let x2 = document.getElementById("c_lname").value;
      let x3 = document.getElementById("c_nit").value;
      let x4 = document.getElementById("c_address").value;
      let x5 = document.getElementById("c_email_address").value;
      let x6 = document.getElementById("c_phone").value;
      let x7 = document.getElementById("c_order_notes").value;
      let x8 = document.getElementById("nombreT").value;
      let x9 = document.getElementById("NoT").value;
      let x0 = document.getElementById("codS").value;
      if(x1==='' || x2==='' || x3==='' || x4==='' || x5==='' || x6==='' || x7==='' || x8==='' || x9==='' || x0===''){
        event.preventDefault();
        alert("Campos Vacios");
      }
    }
  </script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>