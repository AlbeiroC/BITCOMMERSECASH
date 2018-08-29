key = getId()+getId()+getId();

// Funcion que genera un valor aleatorio para asiganr una id que no pertenezca a ningun elemento en la página
function getId() {rand = Math.floor((Math.random() * 895645) + 1);
	if (!document.getElementById(rand)) {return rand; } else {return getId(); } }

// Coloca en mayúsculas las primeras letras de cada palabra
function ucwords(str) {return (str + '').replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {return $1.toUpperCase() }) }

// Coloca en mayúscula la primera letra de toda la cadena
function ucfirst(str) {str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

// Obtenemos los valores recibidos en una variable por el metodo get
function $_GET(variable) {variable = variable.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]"); var regex = new RegExp("[\\?&]" + variable + "=([^&#]*)"), results = regex.exec(location.search); return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " ")); }

// Coprobamos si una variable no está vacía
function empty(variable) {if (variable !== null && variable !== undefined) {if (variable != '') {return false; } else {return true; } } else {return true; } }


function jsonToHTML(pre=false,implode=false,json={}) {
	var pre = (typeof pre != 'object') ? pre : '';
 	var json = (typeof json == 'object') ? json : {};
 	var implode = (!implode || typeof implode != 'string') ? '-' : implode;
 	var prent = {};
 	$.each(json,function(index, el) {
 		pre2 = pre+implode+index;
 		if (typeof el == 'object') {
 			prent = $.extend({}, prent, jsonToHTML(pre2,implode,el));
 		}
 		else{
 			prent[pre2] = (!el) ? false : el;
 		}
 	});
 	return prent;
}


function linkit(textBlock){
  return textBlock
		.replace(/&/g, '&amp;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;')
		.replace(/(^|&lt;|\s)(www\..+?\..+?)(\s|&gt;|$)/g, '$1<a target="blank_" href="http://$2">$2</a>$3')
		.replace(/(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g, '$1<a target="blank_" href="$2">$2</a>$5');
}

function urlToArray(url) {
	var request = {};
	var pairs = url.substring(url.indexOf('?') + 1).split('&');
	for (var i = 0; i < pairs.length; i++) {
		if(!pairs[i]){
			continue;
		}
		var pair = pairs[i].split('=');
		request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
	}
	return request;
}

function arrayToURL(array) {
	var pairs = [];
	for (var key in array){
		if (array.hasOwnProperty(key)){
			pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(array[key]));
		}
	}
	return pairs.join('&');
}



function push(url=false,gets={},erase={}){
	// Definimos las variables por defecto
	defaults = {
		url:window.location.origin+window.location.pathname,
		gets:{},
		erase:{},
		query:window.location.search.replace(/\?/gi,'').trim().length > 0 ? window.location.search.replace(/\?/gi,'').trim().split('&') : ''.split('&')
	};
	// Fin de Definimos las variables por defecto

	if (typeof url == 'string') {
		defaults.url = url;		
	}
	else if (typeof url == 'object') {
		defaults = url;
	}
	else{
		defaults.url = window.location.origin+window.location.pathname;		
	}

	// Obtenemos las variables gets que ya estan en la url
	i = 0;
	while(defaults.query[i]){
		o = defaults.query[i];
		if (o.indexOf('=')>=0) {
			o = o.split('=');
			defaults.gets[o[0]] = o[1].length>0 ? o[1] : '';
		}
		else{
			defaults.gets[o] = '';
		}
		i++;
	}
	delete defaults.query;
	// Fin de Obtenemos las variables gets que ya estan en la url

	// Convertimos los parametros de gets recibidos en caso de que sea string
	if ('string' == typeof gets) {
		gets = gets.replace(/\?/gi,'').split('&');
		i = 0;
		temp = {};
		while(gets[i]){
			o = gets[i].split('=');
			if (o.length>1) {
				temp[o[0]] = o[1];
			}
			else{
				temp[o[0]] = '';
			}
			i++;
		}
		gets = temp;
		delete temp;
	}
	else if('boolean' == typeof gets){
		gets = {};
	}
	// Fin de Convertimos los parametros de gets recibidos en caso de que sea string
	
	// Unimos las variables recibidas con las estandares
	defaults.gets = $.extend(true, defaults.gets, gets);

	// Convertimos los parametros de erase recibidos en caso de que sea string
	if ('string' == typeof erase) {
		erase = erase.split(',');
		i = 0;
		while(erase[i]){
			o = erase[i].split('=');
			defaults.erase[o[0]] = o[1]!==undefined ? o[1] : '';
			i++;
		}
		delete erase;
	}
	else if('boolean' == typeof erase){
		erase = {};
	}
	// Fin de Convertimos los parametros de erase recibidos en caso de que sea string

	// Eliminamos de gets las variables que hemos indicado a borrar
	Object.keys(defaults.erase).map(function(k) {
		delete defaults.gets[k];
	});
	delete defaults.erase;
	// Fin de Eliminamos de gets las variables que hemos indicado a borrar

	defaults.str = '?'+Object.keys(defaults.gets).map(function(k) {
	    return encodeURIComponent(k) + '=' + encodeURIComponent(defaults.gets[k])
	}).join('&');

	serverPath = defaults.url + defaults.str;

	history.pushState({
		path: serverPath
	}, serverPath, serverPath);
	return false;
}




function isJson (jsonString){
    try {
        var o = JSON.parse(jsonString);
        if (o && typeof o === "object") {
            return true;
        }
    }
    catch (e) { }
    return false;
};


function preloader(row=1){
	done_col = 0;
	i = 0;
	html = '';
	while (i<row) {
		if (done_col==0) {
			html += '<div class="columns index-'+done_col+'">';
		}
		html += '	<div class="column is-one-third-desktop is-half-tablet is-full-mobile item-to-buy-loader_item">';
		html += '		<div class="card" style="min-height:100%;padding-bottom:3rem;">';
		html += '				<div class="card-image">';
		html += '						<figure class="image is-4by3"><img data-src="" data-style='+"'{"+'"background-size":'+'"cover"'+"}'"+'></figure>';
		html += '				</div>';
		html += '				<div class="card-content">';
		html += '						<p class="title is-4 bottom-shadow-fade" style="max-height:40px;min-height:40px;overflow:hidden;">Cargando...</p>';
		html += '						<div class="content" style="max-height:80px;height:80px;overflow:hidden;">Cragando detalles del producto...</div>';
		html += '				</div>';
		html += '		</div>';
		html += '	</div>';
		done_col++;
		if (done_col==3) {
			done_col = 0;
			html += '</div>';
		}
		i++;
	}
	return html;
}




function isEmail(email){
	var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	if (email.match(pattern)) {
	    return (email.match(pattern).length>0);
	}
	return false;
}






function data_src(element=false){
	if (!$(element)[0]) {
		element = 'img[data-src]';
	}
	// Cambiamos las imagenes para asi evitar la tardanza en la carga del sitio web
	$(element).addClass('no-data-src').each(function(index, el) {
		if (!$(this).hasClass('no-data-src')) {return;}
		img = $(this);
		var attr = {
			src:window.location.protocol+"//"+window.location.host+'/img/1x1.png'
		};
		var style = {
			"background-position":'center',
			"background-repeat":'no-repeat',
			"background-size" : 'contain'
		};
		var dataStyle = img.attr('data-style') ? $.parseJSON(img.attr('data-style')) : style;
		var style = $.extend(style,dataStyle);
		style["background-image"] = (img.attr('data-src')) ? 'url('+img.attr('data-src')+')' : false;
		if (style["background-image"]) {
			img
			.attr(attr)
			.css(style)
			.removeClass('no-data-src')
			.removeAttr('data-src')
			.removeAttr('data-style');
		}
	});		
}


function sortJson(json,field=false, asc='asc') {
	if (!field||empty(json)) {
		return json;
	}
	else{
		newJson = json.sort(function(a, b) {
			if (asc.toLowerCase().trim()=='asc') {
				return (a[field] > b[field]) ? 1 : ((a[field] < b[field]) ? -1 : 0);
			}
			else {
				return (b[field] > a[field]) ? 1 : ((b[field] < a[field]) ? -1 : 0);
			}
		});
		return newJson;		
	}
}


function jsonSort(json, prop, order='asc') {
    return json.sort(function(a, b) {
        if (order=='asc') {
            return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
        } else {
            return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
        }
    });
}




if (!empty($_GET('error'))) {
	f = $_GET('error');
	$('html,body')
	.animate({
		scrollTop:$('[name="'+f+'"]').offset().top
	},"slow")
	.find('[name="'+f+'"]')
	.focus();
}
