<?php 
    require 'includes/funciones.php';
    incluirTemplate('header',true);
?>
<?php
$db = new PDO('mysql:host=localhost;dbname=sistematienda;charset=utf8','root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	$stmt = $db->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // session_destroy();
  // print_r($_SESSION);

  
?>
    <section id="portfolio" class="portfolio">
      <div class="container">
        
        <div class="section-title">
          <h2>Galeria</h2>
          <h3>Hecha un vistazo a nuestra <span>GaleriaUrbana</span></h3>
          <p>
            Mira en nuestra galeria las prendas que salieron mas en la temporada
          </p>
        </div>

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">Todo</li>
              <li data-filter=".filter-app">Invierno</li>
              <li data-filter=".filter-card">Verano</li>
              <li data-filter=".filter-web">Otoño</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">
            <?php foreach($rows as $row){?>
            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <?php 
                  $id = $row['id'];
                  $imagen = 'assets/img/productos/'.$id.'/principal.jpg';
                  if(!file_exists($imagen)){
                    $imagen = "assets/img/productos/no-photo.jpg";
                  }
                ?>
                <img src="<?php echo $imagen;?>" class="img-fluid" alt="">

                <!-- Codigo original imagen -->
                <!--<img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt=""> -->

                <div class="portfolio-info">
                <h4><?php echo $row['nombre'];?></h4>
                <p><?php echo number_format($row['precio'],2,'.',',');?></p>
                <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1', $row['id'],KEY_TOKEN);?>" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                </div>
            </div>
            <?php }?>
        </div>

      </div>
    </section><!-- End Portfolio Section -->


<?php 
    incluirTemplate('footer');
?>