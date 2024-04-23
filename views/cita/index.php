<datalist id="work-hours">
 <option value="09:00"></option>
  <option value="09:15"></option>
  <option value="09:30"></option>
  <option value="09:45"></option>
  <option value="10:00"></option>
  <option value="10:15"></option>
  <option value="10:30"></option>
  <option value="10:45"></option>
  <option value="11:00"></option>
  <option value="11:15"></option>
  <option value="11:30"></option>
  <option value="11:45"></option>
  <option value="12:00"></option>
  <option value="12:15"></option>
  <option value="12:30"></option>
  <option value="12:45"></option>
  <option value="13:00"></option>
  <option value="13:15"></option>
  <option value="16:00"></option>
  <option value="16:15"></option>
  <option value="16:30"></option>
  <option value="16:45"></option>
  <option value="17:00"></option>
  <option value="17:15"></option>
  <option value="17:30"></option>
  <option value="17:45"></option>
  <option value="18:00"></option>
  <option value="18:15"></option>
  <option value="18:30"></option>
  <option value="18:45"></option>

</datalist>


<h1 class="nombre-pagina">Crear nueva cita</h1>

<p class="descripcion-pagina">Elije tus servicios y coloca tus datos</p>

<div class="barra">
    <p>Hola <?php echo $nombre ?? '' ?></p>

    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<div id="app">

    <nav class="tabs">
        <button  class="actual" type="button" data-paso="1">Servicios</button>
        <button  type="button" data-paso="2">Información cita</button>
        <button  type="button" data-paso="3">Resumen</button>
    </nav>

    <div class="seccion-citas mostrar" id="paso-1" >

        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
        
    </div>

    <div class="seccion-citas" id="paso-2">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Introduce tus datos y la fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre"
                    placeholder="Tu nombre"
                    <?php if($nombre):?>    
                        value= "<?php echo $nombre; ?>"
                    <?php endif; ?>
                    disabled
                />
            </div>

            

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date" 
                    name="fecha" 
                    id="fecha"
                    min="<?php echo date("Y-m-d", strtotime('+1 day'));?>"
                />
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time" 
                    name="hora" 
                    id="hora"
                    min="09:00"
                    max="19:00"
                    list="work-hours"
                />
                <span class="validity"></span>
            </div>

            <input type="hidden" id="usuarioId" name="usuarioId" value="<?php echo $usuarioId; ?>"/>
        </form>

    </div>
    <div class="seccion-citas contenido-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>

    </div>

    <div class="paginacion">
        <button
            id= "anterior"
            class="animatedButton"
        ><span>&laquo; Anterior</span></button>
        <button
            id= "siguiente"
            class="animatedButton"
        ><span> Siguiente &raquo;</span></button>
    </div>
</div>

<?php 
    $script =  "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/nav.js'></script>
    ";
?>