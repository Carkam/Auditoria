<footer class="site-footer border-top" style="padding:none;">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Navegación</h3>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Ventas</a></li>
                  <li><a href="#">Productos</a></li>
                  <li><a href="#">Carro</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Comercio</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="#">Punto de Venta</a></li>
                  <li><a href="#">Categorias</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <h3 class="footer-heading mb-4"></h3>
          </div>
          <?php 
                    include('./php/conexion.php');
                    $resultado = $conexion -> query("SELECT * from empresa") or die ($conexion -> error);
                    while ($fila = mysqli_fetch_array($resultado)) {
                    
                    
                  ?>
          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Información de Contacto</h3>
              <ul class="list-unstyled">
                <li class="address"><?php echo $fila['direccion']; ?></li>
                <li class="phone"><a href="tel://23923929210">+502 <?php echo $fila['telefono']; ?></a></li>
                <li class="email"><?php echo $fila['correo']; ?></li>
              </ul>
            </div>
            <?php } ?>   
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-12">
            <p>
         
            Copyright &copy;
            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script>document.write(new Date().getFullYear());</script> Todos los derechos reservados</i>
        
            </p>
          </div>
          
        </div>
      </div>
    </footer>