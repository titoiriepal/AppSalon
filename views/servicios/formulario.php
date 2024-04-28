

<div class="campo">
    <label for="nombre">Nombre</label>
    <input 
        type="text" 
        name="nombre" 
        id="nombre" 
        placeholder="Nombre del Servicio"
        value="<?php echo $servicio->nombre ?>"
    />
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input 
        type="num" 
        name="precio" 
        id="precio" 
        placeholder="Precio del Servicio"
        value="<?php echo ($servicio->precio != '0' ? $servicio->precio : '')?>"
    />
</div>