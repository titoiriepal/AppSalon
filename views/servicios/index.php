<h1 class="nombre-pagina">Servicios</h1>

<p class="descripcion-pagina">Administración de servicios</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';

    
?>
    <ul class="servicios">
    <?php 
        foreach($servicios as $servicio)  { ?> 
    
        <li>
            
            <p>Nombre: <span><?php echo $servicio->nombre;?></span></p>
            <p>Precio: <span><?php echo $servicio->precio;?> €</span></p>
            <?php 
                if  (($servicio->activo ==='0')){
                    echo '<p class= "alerta error"> Servicio no activo</p> ';
                }
            ?>
            
            <div class="acciones acciones-admin">
                <a class="boton"href="/servicios/actualizar?id=<?php echo $servicio->id;?>">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" id='id' name='id' method='POST' value="<?php echo $servicio->id;?>"/>
                    
                    <input type="submit" value="<?php echo ($servicio->activo ==='1') ? 'Eliminar' : 'Reactivar' ?>" class="boton boton-eliminar"/>
                </form>
            </div>
            

        </li>



    <?php 
        } 
    ?>

    </ul>