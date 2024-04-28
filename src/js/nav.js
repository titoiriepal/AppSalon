let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3
let dia = '';

const cita = {
    usuarioId : '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
})

function iniciarApp(){
    
    tabs(); //Cambia la sección cuando se presionen los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador.
    siguientePagina();
    anteriorPagina();

    consultarAPI(); //Consulta la Api en el backend de php

    identificarCliente();//lleva el nombre del cliente al objeto de cita

    seleccionarFecha();//Añade la fecha de la cita en el objeto

    seleccionarHora(); //Añade la hora de la cita en el objeto

    mostrarResumen(); //Muestra el resumen de la cita

}

function mostrarSeccion(){

    //Ocultar la sección que se está mostrando
    const seccionAnterior = document.querySelector('.mostrar');
    seccionAnterior.classList.remove('mostrar');
    //Seleccionar la seccion según su paso

    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    //Quita la clase actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    tabAnterior.classList.remove('actual');

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}


function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    
    botones.forEach( boton => {
        boton.addEventListener('click', function(e){
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();

        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    
    
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaSiguiente.classList.remove('ocultar');
        paginaAnterior.classList.remove('ocultar');
    }
}

function siguientePagina() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if (paso < pasoFinal){
            paso++;
            mostrarSeccion();
            botonesPaginador();
        }
    })
}

function anteriorPagina() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if (paso > pasoInicial){
            paso--;
            mostrarSeccion();
            botonesPaginador();
        }
    })
}

async function consultarAPI() {
    try{
        const url = `${location.origin}/api/servicios`;//URL  de la API a consumir
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio;
            
            const nombreServicio = document.createElement('P');
            nombreServicio.classList.add('nombre-servicio');
            nombreServicio.textContent = nombre;
    
            const precioServicio = document.createElement('P');
            precioServicio.classList.add('precio-servicio');
            precioServicio.textContent = `${precio} €`;
    
            const servicioDiv = document.createElement('DIV');
            servicioDiv.classList.add('servicio');
            servicioDiv.dataset.idServicio = id;

            servicioDiv.onclick = function(){
                seleccionarServicio(servicio);
            }

            servicioDiv.appendChild(nombreServicio);
            servicioDiv.appendChild(precioServicio);

            document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    //Identificamos el elemento al que hemos dado click
    const divServicio = document.querySelector(`[data-id-servicio ="${id}"]`);

    //Comprobar si un servicio ya está en la lista de servicios anteriores
    if(servicios.some(agregado => agregado.id === id)){
        cita.servicios = servicios.filter(agregado => agregado.id !==id)

    }else{
        cita.servicios = [...servicios, servicio]
    
    }

    
    divServicio.classList.toggle('seleccionado');

    
}

function identificarCliente(){
    cita.nombre = document.querySelector( '#nombre' ).value;
    cita.usuarioId = document.querySelector( '#usuarioId' ).value.toString();
    
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    const listaDatos = document.querySelector( "#work-hours" );
    inputFecha.addEventListener('input',function(e) {

        dia = new Date(e.target.value).getUTCDay();

        if([0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Cerramos Sábados por la tarde y Domingos', 'error', '.formulario');
            
        }else{
            if([6].includes(dia)) {
            listaDatos.innerHTML=`
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
            `
            }else{
                listaDatos.innerHTML=`
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
                `
            }
            cita.fecha = e.target.value
        }
        
    })
}

function seleccionarHora(){
    const tablaMinutos = ['00', '15', '30', '45'];

    const inputHora = document.querySelector('#hora');  
    inputHora.addEventListener('input', function (e) {
        
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];
        const minutos = horaCita.split(':')[1];
        if(hora < "09" || (((hora >="13" && minutos >"15") || hora > "13") && hora < "16") || (hora >= "18" && minutos > "45") || hora >="19"){
            mostrarAlerta('Nuestro horario es de 09 de la mañana a 13:30 y de 16:00 a 19:00 horas', 'error', '.formulario');
            e.target.value='';
        }else if (!tablaMinutos.find((element) => element === minutos)){
            mostrarAlerta('Por favor, elige una hora válida. Aquellas que acaben en 00, 15, 30 y 45', 'error', '.formulario');
            e.target.value='';
        }else if([6].includes(dia) && ((hora === "13" && minutos > "15")|| hora > "13")){
            mostrarAlerta('Los Sábados abrimos de 09:00 a 13:30', 'error', '.formulario');
            e.target.value='';
        }
        cita.hora = e.target.value
        

    });
}

function mostrarAlerta(mensaje,tipo, loc, desaparece = true){

    //previene la creación de más de una alerta

        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia){
            alertaPrevia.remove();
        };
 
    

    //Creamos la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    //La añadimos al elemento padre que le proporcionamos
    const formulario = document.querySelector(loc);
    formulario.appendChild(alerta);

    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 4000)
    }

}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');
    let precioTotal = 0;
    //Limpiar el contenido de Resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }
    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta("Faltan datos de servicios, fecha u hora",'error','.contenido-resumen', false);
        return;
    }

    //Formatear el div de resumen
    const{nombre, fecha, hora, servicios} = cita;
    const fechaObj = new Date (fecha);
    const mes = fechaObj.getMonth() ;
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();

    const nombreCliente = document.createElement('P');
    const fechaCita = document.createElement('P');
    const horaCita = document.createElement('P');

    const fechaUTC = new Date( Date.UTC(year,mes,dia));
    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones);

    nombreCliente.innerHTML = ` <span>Nombre:</span> ${nombre}` ;
    fechaCita.innerHTML = ` <span>Fecha:</span> ${fechaFormateada}` ;
    horaCita.innerHTML = ` <span>Hora:</span> ${hora} horas` ;

        //Heading para servicios en resumen
        const headingDatos = document.createElement('H3');
        headingDatos.textContent= 'Datos de la cita';
        
        //Agregando Heading a la lista de servicios
        resumen.appendChild(headingDatos);

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    //Heading para servicios en resumen
    const headingServicios = document.createElement('H3' );
    headingServicios.textContent= 'Resumen de Servicios';
    
    //Agregando Heading a la lista de servicios
    resumen.appendChild(headingServicios);

    //Mostrar los Servicios
    servicios.forEach((servicio)=>{
        const{id, precio, nombre} = servicio
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent= nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span>${precio} €`;
        precioTotal =  precioTotal + parseInt(precio);

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    })

    const precioServicios = document.createElement('P');
    precioServicios.innerHTML=`<span>Precio Total: </span> ${precioTotal}.00 €` 
    
    resumen.appendChild(precioServicios);

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
  
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(botonReservar);



}

async function reservarCita(){
    alert('LLEGA');
    const{nombre, fecha, hora, servicios, usuarioId} = cita;

    const idServicios = servicios.map( servicio => servicio.id); //Mapeamos el arreglo de servicios y creamos un nuevo arreglo que contenga el id de cada servicio.
    const datos = new FormData(); //Creamos el objeto en el que pasaremos los datos
    datos.append('nombre', nombre); //Añadimos los datos que tenga que llevar la petición (Consultar la documentación de la api)
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', usuarioId);
    datos.append('servicios', idServicios);
    
    

    try {
        const url = '/api/citas'; //Establecemos la url a la que vamos a hacer la consulta


        const respuesta = await fetch(url, { //hacemos la consulta y pasamos como parametros la url y un arreglo con...
            method:'POST',  // El método de la consulta
            body:datos  //El body con los datos que tienen que ir a la consulta. En este caso el objeto FormData que creamos antes
        });
    
        const resultado = await respuesta.json(); //Convertir la respuesta del servidor a json para trabajar con ella de manera más sencilla
        console.log(resultado);
        if(resultado.resultado){
            Swal.fire({
                title: "GUARDADO",
                text: "Cita creada correctamente",
                icon: "success"
              }).then( () =>{
                window.location.reload();
              })
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "No se ha podido guardar la cita correctamente",
            footer: error
          });
    }
    

}
