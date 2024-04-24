<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php' 
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha:</label>
            <input 
                type="date" 
                id="fecha" 
                name="fecha"
            />
        </div>
    </form>
</div>

<div class="citas-admin">
    <ul class="citas">
        <?php 
            $idCita = '';
            foreach($citas as $key => $cita){

                
                if($idCita !== $cita->id){
                    $total = 0;?>
                    
                    <li>
                        <p>ID: <span><?php echo $cita->id;?></span></p>
                        <p>Hora: <span><?php echo $cita->hora;?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
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
                    </li>  
                            
                        <?php 
                            
                        }//endIf
        } //end foreach?>
    </ul>


</div>