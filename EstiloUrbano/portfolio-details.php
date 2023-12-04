<?php 
  require 'includes/funciones.php';
  incluirTemplate('header',true);
  
?>

<?php
  $db = new PDO('mysql:host=localhost;dbname=sistematienda;charset=utf8','root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $token = isset($_GET['token']) ? $_GET['token']: '';

  if($id == '' || $token == ''){
    echo 'Error al procesar la informacion';
    exit;
  }else{

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){
      $stmt = $db->prepare("SELECT count(id) FROM productos WHERE id=? AND activo = 1");
	    $stmt->execute([$id]);
      if($stmt -> fetchColumn() > 0){
        $stmt = $db->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? AND activo = 1 LIMIT 1");
	      $stmt->execute([$id]);
        $row = $stmt ->fetch(PDO::FETCH_ASSOC);
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $descuento = $row['descuento'];
        $precio_des = $precio -(($precio * $descuento)/100);
        $dir_image = 'assets/img/productos/'.$id.'/';
        
        $rutaImg = $dir_image.'principal.jpg';

        if(!file_exists($rutaImg)){
          $rutaImg = 'assets/img/no-photo.jpg';
        }

        $imagenes = array();
        if(file_exists($dir_image)){
          $dir = dir($dir_image);

          while(($archivo = $dir -> read()) != false ){
            if($archivo !='principal.jpg' && (strpos($archivo,'jpg') || strpos($archivo,'jpeg'))){
              $imagenes[] = $dir_image . $archivo;
            }
          }
          $dir->close();
        }
      }

    }else{
      echo 'Error al procesar la informacion';
      exit;
    }
  }
?>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Portfolio Details</li>
        </ol>
        <h2>Portfolio Details</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

              <!-- imagen predeterminada descomentar -->
                <div class="swiper-slide">
                  <img src="<?php echo $rutaImg; ?>" alt="">
                </div>


                <?php foreach($imagenes as $img){; ?>
                <div class="swiper-slide">
                  <img src="<?php echo $img; ?>" alt="">
                </div>
                <?php }; ?>
                <!-- <div class="swiper-slide">
                  <img src="assets/img/portfolio/portfolio-details-2.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="assets/img/portfolio/portfolio-details-3.jpg" alt="">
                </div> -->

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3><?php echo $nombre;?></h3>
              <ul>
                <li><strong>Categoria</strong>: Web design</li>
                <li><strong>Color</strong>: ASU Company</li>
                <?php if($descuento >0 ){?> 
                  <li><del><strong>Precio antes</strong>: <?php echo MONEDA .number_format($precio,2,'.',',');?></del></li>
                  <li><strong>Precio promoción</strong>: <?php echo MONEDA .number_format($precio_des,2,'.',',');?> </li>
                  <li><strong>Descuento</strong>: <?php echo $descuento;?> % descuento </li>
                <?php } else{?>
                <li><strong>Precio</strong>: <?php echo MONEDA .number_format($precio,2,'.',',');?> </li>
                <?php }?>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>Descripcion</h2>
              <p>
              <?php echo $descripcion?>
              </p>
            </div>
            <input class="formulario__form-btn" type="button" value="Comprar ahora">
            <input class="formulario__form-btn" type="button" onclick="addProducto(<?php echo $id;?>,'<?php echo $token_tmp;?>')" value="Agregar a carrito">

          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

<script>
  function addProducto(id, token){
    let url = 'clases/carrito.php';
    let formData = new FormData();
    formData.append('id',id);
    formData.append('token',token);

    fetch(url,{
      method: 'POST',
      body: formData,
      mode: 'cors'
      }).then(response => response.json())
      .then(data =>{
        if(data.ok){
          let elemento = document.getElementById("num_cart").innerHTML = data.numero;
        }
      })
  }
</script>
<?php 
incluirTemplate('footer');
?>
