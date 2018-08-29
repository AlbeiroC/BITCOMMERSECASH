$(document).ready(function() {

// Para navegadores que soportan la función.

if (typeof window.history.pushState == 'function') {

pushstate();

}else{

check(); hash();

}

    });

// Chequear si existe el hash.

function check(){

var direccion = ""+window.location+"";

var nombre = direccion.split("#!");

if(nombre.length > 1){

var url = nombre[1]; 

alert(url);

}

}


function pushstate(){

var links = $("a");

// Evento al hacer click.

links.live('click', function(event) {

var url = $(this).attr('href');

// Cambio el historial del navegador.

history.pushState({ path: url }, url, url);

// Muestro la nueva url

alert(url);

return false;

});


// Función para determinar cuando cambia la url de la página.

$(window).bind('popstate', function(event) {

var state = event.originalEvent.state;

if (state) {

// Mostrar url.

alert(state.path);

}

});

}


function hash(){

// Para i.e

// Función para determinar cuando cambia el hash de la página.

$(window).bind("hashchange",function(){

var hash = ""+window.location.hash+"";

hash = hash.replace("#!","")

if(hash && hash != ""){

alert(hash);

}

}); 

// Evento al hacer click.

$("a").bind('click', function(e) {

e.preventDefault();

var url = $(this).attr('href');

// Cambio el historial del navegador.

window.location.hash = "#!"+url;

//$(window).trigger("hashchange");

return false

});

}