<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php' 
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
    <div class="campo">
            <label for="mostrarTipoCitas">Mostrar:</label>
            <select id="mostrarTipoCitas" name="mostrarTipoCitas">
                <option value="activas"<?php echo ($tipoCita === 'activas') ? 'selected' : ''?>>Citas Activas</option>
                <option value="todas"<?php echo ($tipoCita === 'todas') ? 'selected' : ''?>>Todas las citas</option>  
                <option value="canceladas"<?php echo ($tipoCita === 'canceladas') ? 'selected' : ''?>>Citas Canceladas</option>
            </select>
        </div>
        <div class="campo">
            <label for="year">Año:</label>
            <select id="year" name="year" onchange="updateMonths()">
                <option>Seleccione</option>
            </select>
        </div>
        <div class="campo">
            <label for="mes">Mes:</label>
            <select id="mes" name="mes" onchange="updateDays()">
            </select>
        </div>
        <div class="campo">
            <label for="dia">Día:</label>
            <select id="dia" name="dia">
            </select>
        </div>

    </form>
</div>

<?php 
    if(count($citas) === 0){
        echo "<div class='alerta error'>No Hay citas para este día</div>";
    }
?>


<div class="citas-admin">
    <h3>Citas del : <?php echo $fecha?></h3>
    <ul class="citas">
        <?php 
            $idCita = '';
            foreach($citas as $key => $cita){

                
                if($idCita !== $cita->id){
                    $total = 0;?>
                    
                    <li>
                        <div>
                        <p>Hora: <span><?php echo $cita->hora;?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
                        <?php 
                            if($cita->activo === '0') {
                                echo "<div class='alerta error'>Cita cancelada</div>";
                            } 
                        ?>
                        <button class="boton boton-mostrar" data-idCita="cita<?php echo $cita->id;?>">Mostrar/Ocultar Datos</button>
                        </div>

                        <div class="datos-cita ocultar" id="cita<?php echo $cita->id;?>">
                        <p>ID: <span><?php echo $cita->id;?></span></p>
                        <p>Email: <span><?php echo $cita->email;?></span></p>
                        <p>Teléfono: <span><?php echo $cita->telefono;?></span></p>
                        <h3>Servicios</h3>

                    

                        <?php 
                            } //end if
                            $total = $total + intval($cita->precio);
                        ?>
                            <p class="servicio"><?php echo $cita->servicio;?> ---- <?php echo $cita->precio;?> €</p>  
                        <?php

                        $idCita = $cita->id;
                        $proximo = $citas[$key + 1]->id ?? 0;

                        if($idCita !==  $proximo) {?>
                            <p class="total">Total: <span><?php echo $total.' €';?></span></p>
                        <?php 
                            if($cita->activo === '1'){ 
                        ?>
                            <form action="/api/eliminar" method="POST">
                                <input type="hidden" name="id" value="<?php echo $cita->id;?>"/>
                                <input type="submit" class="boton-eliminar" value="Eliminar">
                            </form>
                        <?php 
                            } 
                        ?>
                        </div>
                    </li>  
                            
                        <?php 
                        }//endIf
        } //end foreach?>
    </ul>


</div>

<?php 
    $script =  "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/admin.js'></script>
    ";
?>