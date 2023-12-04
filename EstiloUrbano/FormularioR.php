<?php 
    require 'includes/funciones.php';
    incluirTemplate('header',true);
?>
<div class="formulario">
    <form class="formulario__form" action="">
        <h2 class="formulario__form-h2">Registro</h2>
        <span class="line"></span>
        <p class="formulario__form-p">Llena los campos</p>
        <div class="formulario__form__input-group">
            <label class="formulario__form-label" for="em">Nombres</label>
            <input class="formulario__form-input" type="text" name="name" id="name" placeholder="Nombres" required>
            
            <label class="formulario__form-label" for="em">Apellidos</label>
            <input class="formulario__form-input" type="text" name="lastname" id="lastname" placeholder="Apellidos" required>
            
            <label class="formulario__form-label" for="em">Correo Electronico</label>
            <input class="formulario__form-input" type="email" name="email" id="email" placeholder="Email" required>

            <label class="formulario__form-label" for="password">Contraseña</label>
            <input class="formulario__form-input" type="password" name="password" id="password" placeholder="Contraseña" required>
            
            <label class="formulario__form-label" for="password">Repita la contraseña</label>
            <input class="formulario__form-input" type="password" name="rPassword" id="rPassword" placeholder="Repita contraseña" required>
            
            <input class="formulario__form-btn" type="submit" value="Registrar">
        </div>
    </form>
</div>
<?php 
    incluirTemplate('footer');
?>