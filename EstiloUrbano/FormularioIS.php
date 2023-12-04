<?php 
    require 'includes/funciones.php';
    incluirTemplate('header',true);
?>
<div class="formulario">
    <form class="formulario__form"action="">
        <h2 class="formulario__form-h2">Inicio Sesion</h2>
        <span class="line"></span>
        <p class="formulario__form-p">Coloca tu email</p>
        <div class="formulario__form-input-group">
            <label class="formulario__form-label" for="em">Email</label>
            <input class="formulario__form-input" type="email" name="email" id="email" placeholder="Email" required>
            
            <label class="formulario__form-label" for="password">Contraseña</label>
            <input class="formulario__form-input" type="password" name="password" id="password" placeholder="Contraseña" required>
            <input class="formulario__form-btn" type="submit" value="Enviar">
        </div>
    </form>
</div>
<?php 
    incluirTemplate('footer');
?>