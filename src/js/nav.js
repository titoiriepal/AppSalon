let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3
let dia = '';
var tablaFech = {};

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

function mostrarSeccion(){ //Muestra las diferentes secciones del apartado CITA según naveguemos con los botones o los tabs

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


function tabs() { //Navegación por Tabs
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
    
    
    if (paso === 1) { //Si estamos en la primera pagina ocultamos el botón de 'Anterior'
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) { //Si estamos en la última página, ocultamos el botón de siguiente y Mostramos el resumen de la cita
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{//Si no es ni la primera ni la última página, mostramos ambos botones.
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

async function consultarAPI() { //Nos trae todos los servicios ACTIVOS de la BD
    try{
        const url = `${location.origin}/api/servicios`;//URL  de la API a consumir
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    }catch(error){
        console.log(error);
    }
}

function mostrarServicios(servicios){ //Mostramos cada uno de los servicios activos
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

function seleccionarServicio(servicio){//Seleccionar o deseleccionar servicios de la cita
    const {id} = servicio;
    const {servicios} = cita;

    //Identificamos el elemento al que hemos dado click
    const divServicio = document.querySelector(`[data-id-servicio ="${id}"]`);

    //Comprobar si un servicio ya está en la lista de servicios anteriores
    if(servicios.some(agregado => agregado.id === id)){
        cita.servicios = servicios.filter(agregado => agregado.id !==id) //Reescribimos los servicios obviando el servicio que tenga el mismo id que el servicio clickeado

    }else{ //El servicio no está en la lista de servicios
        cita.servicios = [...servicios, servicio] //añadimos el servicio a los servicios de la cita
    }
 
    divServicio.classList.toggle('seleccionado'); //Añadimos o quitamos la clase de seleccionado

    
}

function identificarCliente(){ //Pasamos el nombre y el id del cliente a los datos de la cita
    cita.nombre = document.querySelector( '#nombre' ).value;
    cita.usuarioId = document.querySelector( '#usuarioId' ).value.toString();
    
}

async function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',function(e) { //Cuando seleccionamos una nueva fecha en el input 
        
        fecha = new Date(e.target.value);
        fecha = fecha.toLocaleDateString("fr-CA"); //Pasámos la fecha a formato ('Y-m-d')
        

        if(!Object.keys(tablaFech).includes(fecha)){//comprobar que la fecha no esté en tabla fechas que podemos tener en memoria
            conseguirFechas(fecha).then(tablaFechas => { //Si los horarios de la fecha no están en memoria descargamos los horarios de la fecha señalada, los de los diez días anteriores y los de los diez días posteriores, para intentar no sobrecargar las consultas a la BD. Podemos cambiar el número de días que devuelve la API desde el back-end
            tablaFech = tablaFechas;//Damos el valor al objeto tablaFech de las fechas que nos trae la base de datos
            mostrarHorarios();//Iniciamos los horarios del Input según estén disponibles en la base de datos
            });

        }else{
            mostrarHorarios();//mostrar los horarios
        }
        
        
    })
}

function mostrarHorarios(){
    const listaDatos = document.querySelector( "#work-hours" );
    const inputFecha = document.querySelector('#fecha');

    var horarios = '';
    fecha = new Date (inputFecha.value);
    //Leemos la fecha del input correspondiente y le damos formato ('Y-m-d').
    dia = fecha.getUTCDay();
    fechaFormateada = fecha.toLocaleDateString("fr-CA");
    
    const tablaHorariosMorning = ['09:00:00',
        '09:15:00',
        '09:30:00',
        '09:45:00',
        '10:00:00',
        '10:15:00',
        '10:30:00',
        '10:45:00',
        '11:00:00',
        '11:15:00',
        '11:30:00',
        '11:45:00',
        '12:00:00',
        '12:15:00',
        '12:30:00',
        '12:45:00',
        '13:00:00',
        '13:15:00',
    ]
    const tablaHorariosTarde = [
        '16:30:00',
        '16:45:00',
        '17:00:00',
        '17:15:00',
        '17:30:00',
        '17:45:00',
        '18:00:00',
        '18:15:00',
        '18:30:00',
        '18:45:00'
    ]

    if([0].includes(dia)) { //si el día es Domingo, mensaje de error
        inputFecha.value = '';
        mostrarAlerta('Cerramos Sábados por la tarde y Domingos', 'error', '.formulario');
        
    }else{
        if([6].includes(dia)) { //si el día es Sábado, solo incluimos en las horas seleccionables los horarios de mañana que estén disponibles
            var items = tablaHorariosMorning.filter(function (item){ //Recorremos la tabla de horarios y por cada horario que no esté ya reservado en la bd creamos una opción para seleccionarlo
                if(!tablaFech[fechaFormateada].includes(item)){ 
                    horarios += "<option value="+item +"></option>"
                };
            })
        }else{//Si es un día de diario, incluimos los horarios de tarde y de mañana.
            var items = tablaHorariosMorning.filter(function (item){
                if(!tablaFech[fechaFormateada].includes(item)){
                    horarios += "<option value="+item +"></option>"
                };
            })
            var items = tablaHorariosTarde.filter(function (item){
                if(!tablaFech[fechaFormateada].includes(item)){
                    horarios += "<option value="+item +"></option>"
                };
            })
        }
        listaDatos.innerHTML = horarios; //pasamos los horarios a los options del Select de horarios
        cita.fecha=inputFecha.value; // Inicializamos la fecha de la cita
    }

}

async function conseguirFechas(fecha){ //Consultamos la BD con esta api pasándole la fecha elegida para la cita

    const datos = new FormData(); //Creamos el objeto en el que pasaremos los datos
    datos.append('fecha', fecha);
    try{
        const url = `${location.origin}/api/horas-libres`;//URL  de la API a consumir
        const resultado = await fetch(url,  {method:'POST', body:datos});
        tablaFechas = await resultado.json();
        return tablaFechas;
    }catch(error){
        console.log(error);
    }
}

function seleccionarHora(){ //seleccionamos los horarios para la nueva cita filtrandolos por los horarios disponibles
    const tablaMinutos = ['00', '15', '30', '45'];

    const inputHora = document.querySelector('#hora');  
    inputHora.addEventListener('input', function (e) {
        //VALIDACIÓN DE LA HORA DE LA CITA. Dentro de los horarios disponibles. Las citas han de ser a ciertas horas determinadas, que acaban on los minutos de la tabla 'tablaminutos'
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
    const{nombre, fecha, hora, servicios, usuarioId} = cita;

    const idServicios = servicios.map( servicio => servicio.id); //Mapeamos el arreglo de servicios y creamos un nuevo arreglo que contenga el id de cada servicio.
    const datos = new FormData(); //Creamos el objeto en el que pasaremos los datos
    datos.append('nombre', nombre); //Añadimos los datos que tenga que llevar la petición (Consultar la documentación de la api)
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', usuarioId);
    datos.append('servicios', idServicios);
    
    

    try {
        const url = `${location.origin}/api/citas`; //Establecemos la url a la que vamos a hacer la consulta


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
        }else{
            Swal.fire({
                title: "ERROR",
                text: resultado.error,
                icon: "error"
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
