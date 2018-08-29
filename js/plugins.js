(function($) {

	$('[data-trigger]')
	.each(function(index, el) {
		ev = $(this).attr('data-trigger');
		tar = $(this).attr('data-target');
		act = $(this).attr('data-active');
		if (!tar||!act) {return false;};
		$(this).on(act, function(event) {
			event.preventDefault();
			$(tar).trigger(ev);
		});
	});


	$.fn.carousel = function (params={}) {
		$(this).each(function(index, el) {
			if (!empty($(this).attr('img-json'))) {
				$(this).addClass('column is-full');
				img_list = $(this).attr('img-json').split('[EXPLODE_IMAGES]');
				s = (!$(this).find('.img-carousel-panel')[0]) ? $(this).append('<div class="is-full img-carousel-panel"></div>') : false;
				s = (!$(this).find('.steps-carousel-panel')[0]) ? $(this).append('<div class="is-full has-text-centered steps-carousel-panel"></div>') : false;
				img_panel =  $($(this).find('.img-carousel-panel')[0]);
				steps_panel =  $($(this).find('.steps-carousel-panel')[0]);
				i = 0;
				$.each(img_list,function(index, el) {
					if (!empty(img_list[i])) {
						img_panel.append('<img img-index="carousel-'+i+'" data-src="'+img_list[i]+'" style="min-width: 100%;min-height: 200px;max-height: 60vh;display:'+((i==0) ? 'block' : 'none')+';">');
						c = (!steps_panel.find('.pagination-list')[0]) ? steps_panel.html('<center><nav class="pagination is-small is-rounded steps-carousel-link"><ul class="pagination-list" style="justify-content: center;"></ul></nav></center>') : false;
						h = '<li><a href="#carousel-'+i+'" to-img-carousel="carousel-'+i+'" class="pagination-link '+((i==0) ? 'is-current' : false)+'"></a></li>';
						steps_panel.find('.pagination-list').append(h);
					}
					i++;
				});
				steps_panel.find('.pagination-list')
				.find('[href*=#carousel-],[to-img-carousel]')
				.unbind('click')
				.click(function(event) {
					event.preventDefault();
					index = $(this).attr('to-img-carousel') ? $(this).attr('to-img-carousel') : $(this).attr('href');
					index =  index.replace(/^(.*)carousel-(\d+)(.*)$/gi,"$2");
					$(this)
					.parents('.pagination-list')
					.find('li a')
					.removeClass('is-current')
					.end().end()
					.addClass('is-current')
					.parents('.carousel')
					.find('.img-carousel-panel')
					.find('img')
					.not('[img-index="carousel-'+index+'"]')
					.css({'opacity':'0','display':'none'})
					.end().end()
					.find('[img-index="carousel-'+index+'"]')
					.css({'opacity':'1','display':'block'});
				});
			}
		});
	}
	$.fn.tagName = function() {
	  return this.prop("tagName").toLowerCase();
	};
	$.fn.scrollBottom = function(px=false,slide=1,afterFn=function(){}) { 
		var body = this[0];
		var jBody = $(body);
		var sH = body.scrollHeight;
		var sT = body.scrollTop;
		var iH = jBody.innerHeight();
		var sb = (sH - sT - iH);
		if (!px) {	
			return sb;
		}
		else if(!isNaN(px)){
			px = (sH - (iH + px));
			jBody.animate({
				scrollTop:px
			}, slide,function () {
				return afterFn();
			});
		}
	};
    $.fn.hasScroll = function() {
        return this.get(0) ? this.get(0).scrollHeight > this.innerHeight() : false;
    }
	//Asignamos funciones al evento escroll de un elemento
	$.fn.scrollFunctions = function(f=function(){}){
		$(this).scroll(function(){
			return f($(this));
		});
	};
	// Comprobamos que un elemento posea la barra de Scroll
	$.fn.hasScrollBar = function() {
		var e = this.get(0);
		return {
			vertical: e.scrollHeight > e.clientHeight,
			horizontal: e.scrollWidth > e.clientWidth
		};
	};

	// CSS con callback
	$.fn.scss = function (arg={},callback=function () {}) {
		$(this).each(function(index, el) {
			callback = (typeof callback != 'function') ? function () {} : callback;			
			dom = $(this);
			defaults = {};
			arg = (typeof arg != 'object') ? {} : arg;
			arg = $.extend({}, defaults, arg);
			addClass = (arg.addClass) ? arg.addClass : false;
			toggleClass = (arg.toggleClass) ? arg.toggleClass : false;
			removeClass = (arg.removeClass) ? arg.removeClass : false;
			s = (addClass)		? dom.addClass(addClass)		: false;
			s = (removeClass)	? dom.removeClass(removeClass)	: false;
			s = (toggleClass)	? dom.toggleClass(toggleClass)	: false;
			return callback($(this), arg, callback);
		});
		return $(this);
	}
	// Fin de CSS con callback

})(jQuery);





$(function(){

$('.input-number').not('.input-number-without-zero').number( true, 2, ',' , '.');
$('.input-number.input-number-without-zero').number( true, 0, ',' , '.');
$('.input-number-bitcoin,.input-number-btc').number( true, 8, '.' , '');
$('[title]').tipsy({trigger: 'hover'});
	
$.ajaxSetup({
	complete:function(e){
		var the_last_request = this;
			$('body')
			.find('.loading-buffer,.buffer-btn').remove()
			.end()
			.find('.buffer-contain').html('');
			if ((e.responseText.length<=0)) {
			button  = '			<div class="button buffer-btn is-rounded is-static">';
			button += '				<i class="fa fa-spin fa-spinner"></i>';
			button += '			 	<span class="is-hidden-mobile">';
			button += '					&nbsp;';
			button += '					Cargando...';
			button += '				</span>';
			button += '			</div>';
			html  = '<div class="loading-buffer is-hidden-mobile" style="z-index:99999999999999;position: fixed;top:8px;text-align: center;left:calc(50% - (139px / 2));">';
			html += '	<div class="columns">';
			html += '		<div class="column is-full-mobile">';
			html += '			<br>';
			html += button;			
			html += '		</div>';
			html += '	</div>';
			html += '</div>';
			$('body')
			.find('.loading-buffer,.buffer-btn').remove()
			.end()
			.find('.buffer-contain').html(button)
			.end()
			.append(html);
		}
	},
	error: function(XMLHttpRequest, textStatus, errorThrown) {
		button  = '			<div class="button buffer-btn is-rounded is-static">';
		button += '				<i class="fa fa-spin fa-spinner"></i>';
		button += '			 	<span class="is-hidden-mobile">';
		button += '					&nbsp;';
		button += '					Cargando...';
		button += '				</span>';
		button += '			</div>';
		html  = '<div class="loading-buffer is-hidden-mobile" style="z-index:99999999999999;position: fixed;top:8px;text-align: center;left:calc(50% - (139px / 2));">';
		html += '	<div class="columns">';
		html += '		<div class="column is-full-mobile">';
		html += '			<br>';
		html += button;			
		html += '		</div>';
		html += '	</div>';
		html += '</div>';
		$('body')
		.find('.loading-buffer,.buffer-btn').remove()
		.end()
		.find('.buffer-contain').html(button)
		.end()
		.append(html);
        if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
        }
        else if (XMLHttpRequest.readyState == 0) {
        }
        else {
			// something weird is happening
		}
	},
	xhr: function () {
		if (window.XMLHttpRequest){xhr = new window.XMLHttpRequest(); if(xhr.overrideMimeType){xhr.overrideMimeType( "text/json" ); } }else{xhr = new ActiveXObject('Microsoft.XMLHTTP'); }
		if (this.buffer==false) {return xhr;}
		button  = '			<div class="button buffer-btn is-rounded is-static">';
		button += '				<i class="fa fa-spin fa-spinner"></i>';
		button += '			 	<span class="is-hidden-mobile">';
		button += '					&nbsp;';
		button += '					Cargando...';
		button += '				</span>';
		button += '			</div>';
		html  = '<div class="loading-buffer is-hidden-mobile" style="z-index:99999999999999;position: fixed;top:8px;text-align: center;left:calc(50% - (139px / 2));">';
		html += '	<div class="columns">';
		html += '		<div class="column is-full-mobile">';
		html += '			<br>';
		html += button;			
		html += '		</div>';
		html += '	</div>';
		html += '</div>';
		$('body')
		.find('.loading-buffer,.buffer-btn').remove()
		.end()
		.find('.buffer-contain').html(button)
		.end()
		.append(html);
		to_hide = '.buffer-btn,.loading-buffer';
		pct = px = 0;
		/* Crear XHR*/
		xhr.upload.addEventListener("progress", function (evt) {
			if (evt.lengthComputable||evt.currentTarget.status===200) {
				var pct = ((evt.loaded / evt.total)*100);
				$(to_hide).fadeOut();
			}
		}, false);
		xhr.addEventListener("progress", function (evt) {
			if (evt.lengthComputable||evt.currentTarget.status===200) {
				var pct = ((evt.loaded / evt.total)*100);
				$(to_hide).fadeOut();
			}
		}, false);
		return xhr;
	}
});


$(document)
	.ready(function(event) {
		$('.underbar-navbar').fadeOut('fast');
		$(".navbar-fostrap").click(function() {
			$(".nav-fostrap").toggleClass("visible");
			$("body").toggleClass("cover-bg");
		});
	})
	.on('DOMSubtreeModified', function(event) {
		event.preventDefault();
		data_src();
	})
	.on('change', '[type="file"][base64-target]', function(event) {
		event.preventDefault();
		input = $(this);
		target = $(input.attr('base64-target'));
		if (target[0]) {
			
		}
	})
	.on('click', '[data-close]', function(event) {
		event.preventDefault();
		$($(this).attr('data-close')).fadeOut('fast');
	})
	.on('click', '[data-open]', function(event) {
		event.preventDefault();
		$($(this).attr('data-open')).fadeIn('fast');
	})
	.on('click', '[data-toggle]', function(event) {
		event.preventDefault();
		$($(this).attr('data-toggle')).fadeToggle('fast');
	})
	.on('click', '[data-collapse]', function(event) {
		event.preventDefault();
		btn = $(this);
		target = btn.attr('data-collapse') ? btn.attr('data-collapse') : btn.attr('href') ? btn.attr('href') : false;
		if (target) {
			$(target).slideToggle('fast', function() {
				if ($(this).is(':visible')) {
					$(this).addClass('show');
				}
				else{
					$(this).removeClass('show');
				}
			});
		}
	})
	.on('click', '[data-checkbox]', function(event) {
		event.preventDefault();
		$el = $(this).toggleClass('is-link');
		if ($el.hasClass('is-link')) {
			$(this).find('[type="checkbox"]').prop('checked',true);
		}
		else{
			$(this).find('[type="checkbox"]').prop('checked',false);
		}
	})
	.on('click', '.notification .delete', function(event) {
		event.preventDefault();
		if ($(this).parents('.notification')) {
			target = $(this).parents('.notification');
			target.fadeOut('fast', function() {
				$(this).remove();
			});
		}
	});

});
