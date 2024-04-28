let fechas = [];

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
})

function iniciarApp(){
    conseguirFechasAPI();
    iniciarBotonMostrar();
    paginacionFechas();


}

function iniciarBotonMostrar(){
    const botonesMostrar = document.querySelectorAll('.boton-mostrar');
    botonesMostrar.forEach(boton => {
        boton.addEventListener('click', function(e){
            idDiv= e.target.dataset.idcita;
            identificador = "#" + idDiv
            divMostrar= document.querySelector( identificador); 
            divMostrar.classList.toggle('ocultar');
        });
    })
}

function paginacionFechas(){
    const botSiguiente = document.getElementById('botFechaSiguiente');
    const botAnterior = document.getElementById('botFechaAnterior');
    const tipoCitas = document.getElementById('mostrarTipoCitas').value;

    botAnterior.addEventListener("click", ()=>{
        const index = fechas.findIndex((element) => element >= botAnterior.dataset.fecha )
        if  (index != 0 ){
            const fechaAnterior = fechas[index -1 ]
            console.log (index);
            window.location = `?fecha=${fechaAnterior}&tipoCitas=${tipoCitas}`; 
        }
    });

    botSiguiente.addEventListener("click", ()=>{
        const index = fechas.findIndex((element) => element >= botSiguiente.dataset.fecha )
        if  (index != fechas.length - 1 ){
            const fechaSiguiente = fechas[index + 1 ]
            console.log (index);
            window.location = `?fecha=${fechaSiguiente}&tipoCitas=${tipoCitas}`; 
        }
    });
}

async function conseguirFechasAPI(){
    try{
        const url = `${location.origin}/api/fechas`;
        const resultado = await fetch(url);
        const fechas = await resultado.json();
        iniciarFechas(fechas);
    }catch(error){
        console.log(error);
    }
    
}

function iniciarFechas(dates){
    let selected = true;
    const years = new Set(dates.map(date => date.split('-')[0]));
    const yearSelect = document.getElementById('year');
    yearSelect.addEventListener('change',updateMonths());
    years.forEach(year => {
        yearSelect.add(new Option(year, year, selected));
        selected = false;
    });
    fechas = dates;
}

function updateMonths() {
    const selectedYear = document.getElementById('year').value;
    const months = new Set(fechas
        .filter(date => date.startsWith(selectedYear))
        .map(date => date.split('-')[1]));
    const monthSelect = document.getElementById('mes');
    monthSelect.innerHTML = '<option>Selecciona un mes</option>';
    months.forEach(month => {
        monthSelect.add(new Option(getMonthName(month), month));
    });
    document.getElementById('dia').innerHTML = '<option>Selecciona un día</option>';
}

function updateDays() {
    const selectedYear = document.getElementById('year').value;
    const selectedMonth = document.getElementById('mes').value;
    const tipoCitas = document.getElementById('mostrarTipoCitas').value;
    const days = new Set(fechas
        .filter(date => date.startsWith(`${selectedYear}-${selectedMonth}`))
        .map(date => date.split('-')[2]));

    const daySelect = document.getElementById('dia');
    daySelect.innerHTML = '<option>Selecciona un día</option>';
    days.forEach(day => {
        daySelect.add(new Option(day, day));
    });
    daySelect.addEventListener('input', function() {
        dia = daySelect.value;
        const fechaSeleccionada =`${selectedYear}-${selectedMonth}-${dia}`;
        window.location = `?fecha=${fechaSeleccionada}&tipoCitas=${tipoCitas}`; 
    });
}

function getMonthName(monthNumber) {
    const months = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    
    // Convert monthNumber to an integer and adjust for array index (0-based)
    const index = parseInt(monthNumber) - 1;
    
    // Check if the index is within the valid range (0-11)
    if (index >= 0 && index < 12) {
        return months[index];
    } else {
        return 'Mes inválido'; // or throw an Error depending on your error handling strategy
    }
}


//`${selectedYear}-${selectedMonth}-${day}`