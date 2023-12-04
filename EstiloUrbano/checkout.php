<?php 
  require 'includes/funciones.php';
  incluirTemplate('header',true);

    $db = new PDO('mysql:host=localhost;dbname=sistematienda;charset=utf8','root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
    $lista_carrito = array();
    if($productos!= null){
        foreach($productos as $clave => $cantidad){
            $stmt = $db->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
            $stmt->execute([$clave]);
            $lista_carrito[] = $stmt->fetch(PDO::FETCH_ASSOC);

        }
    }
?>
<section id="portfolio-details" class="portfolio-details">
    <div class="container">
                <?php if($lista_carrito == null)
                {
                    echo '
                    <div class="col-lg-4">
                    <div class="portfolio-info">
                        <h3>    </h3>
                        <ul>
                            <li><strong>Color</strong>: ---------</li>
                            <li><strong>Precio</strong>: ---------</li>
                            <li><strong>Cantidad</strong>: ---------</li>
                            <li><strong>SubTotal</strong>:  -------- </li>

                        </ul>
                    </div>      
                    </div>';
                }else{
                    $total = 0;
                    foreach($lista_carrito as $producto){
                        $_id = $producto['id'];
                        $nombre = $producto['nombre'];
                        $precio = $producto['precio'];
                        $descuento = $producto['descuento'];
                        $cantidad = $producto['cantidad'];
                        $precio_des = $precio- (($precio * $descuento)/100);
                        $subtotal = $cantidad * $precio_des;
                        $total += $subtotal;
                    ?>
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="portfolio-details-slider swiper">
                                    <div class="swiper-wrapper align-items-center">
                                        <div class="swiper-slide">
                                            <img src="<?php echo 'assets/img/productos/'.$_id.'/principal.jpg'; ?>" alt="">
                                        </div>

                                    </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="portfolio-info">
                                <h3><?php echo $nombre;?></h3>
                                <ul>
                                    <li><strong>Color</strong>: ASU Company</li>
                                    <li><strong>Precio</strong>:<?php echo MONEDA . number_format($precio_des,2,'.',',');?></li>
                                    <li><strong>Cantidad</strong>: <input type="number" min="1" max ="10" step = "1" value ="<?php echo $cantidad?>" 
                                    size="5" id="cantidad_<?php echo $_id;?>" ochange="" ></li>
                                    <li id="subtotal_<?php echo $_id;?>" name="subtotal[]"><strong>SubTotal</strong>:<?php echo MONEDA . number_format($precio_des,2,'.',',');?></li>
                                    <a href="" id="eliminar" class="btn btn-warming btn-sm" data-bs-id="<?php echo $_id;?>"
                                    data-bs-toogle="modal" data-bs-target="eleminaModal">Eliminar</a>
                                    
                                </ul>

                            </div>      
                        </div>
                <?php }?>
                        <div class="col-lg-4">
                            <div class="portfolio-info">
                                <ul>
                                <li><strong>Total</strong>:<?php echo MONEDA . number_format($total,2,'.',',');?></li>
                                </ul>

                            </div>      
                        </div>
                        <input class="formulario__form-btn" type="button" value="Realizar pago">
                <?php }?>

    </div>
</section>

<?php 
incluirTemplate('footer');
?>
