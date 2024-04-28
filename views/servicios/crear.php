<h1 class="nombre-pagina">Crear Servicios</h1>

<p class="descripcion-pagina">Crear un nuevo servicio</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST">
    
    <?php 
        include_once __DIR__ .'/formulario.php'; 
    ?>

    <input type="submit" class="boton" value="Crear Servicio">
</form>