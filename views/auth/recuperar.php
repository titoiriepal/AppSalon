<h1 class="nombre-pagina">Reestablece tu contraseña</h1>

<p class="descripcion-pagina">Introduce tu nueva contraseña</p>

<?php 
    include_once __DIR__ .'/../templates/alertas.php';
?>
<?php 
    if(!$error){ 
?>
<form class="formulario" method='POST'>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password" 
            name="password"
            placeholder="Tu Password"
        />
    </div>
    <div class="campo">
        <label for="confirma">Confirma tu Contraseña</label>
        <input 
            type="password"
            id="confirma" 
            name="confirma"
            placeholder="Confirma tu Contraseña"
        />
    </div>

    <input type="submit" class="boton" value="Guardar Password"/>
</form>

<?php 
    } 
?>


<div class="acciones">
    <a href="/"> ¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta"> ¿Aún no tienes una cuenta? Crea Una </a>

</div>