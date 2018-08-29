base = window.location.protocol+'//'+window.location.host;
(function($){
	$.fn.comentarios = function (params={},data={}) {
		body = $(this);
		if ($(body).hasClass('no-ajax')) {return false; }		
 		defaults = {
			url: base+'/api_v2/items/items.php',
	 		data:{
	 			comments:'',
	 			min_id:false,
	 			max_id:false,
	 			limit:12,
	 			encode:true,
	 		},
	 		direction:"down",
	 		success:function () {},
			chat_template:function(data={}){
				c = data;
				html = '<div class="column is-full" id_comment="'+c.id+'" style="display:block;float:right;width:100%;left:0px;">';
				html += '	<div>';
				html += '		<img data-src="'+c.user.data.user.imagen+'" width="30px" height="30px" data-style='+"'"+'{"background-size":"cover","border-radius":"9999999999999px"}'+"'"+' style="background-color:#fff;float: '+((c.user.is_my===true) ? "right" : "left")+';">';
				html += '	</div>';
				html += '	<div class="box '+((c.user.is_my===true) ? "notification is-link " : false)+'" style="float:'+((c.user.is_my===true) ? "right" : "left")+';display: table;word-break: break-all;padding: 2px 10px;">';
				html += '      <div style="word-break:break-all;">';
				html += 		linkit(c.texto);
				html += '	   </div>';
				html += '		<div class="'+((c.user.is_my===true) ? false : "has-text-grey-light")+' has-text-weight-normal is-size-7">'+((c.fecha!='now') ? moment((c.fecha*1000)).locale('es').fromNow() : "Hace un momento")+'</div>';
				html += '	</div>';
				html += '</div>';
				return html;
			},
			full_template:function(data={}){
				c = data;
				html  = '<div class="box" id_comment="'+c.id+'">';
				html += '  <article class="media">';
				html += '    <div class="media-left">';
				html += '      <figure class="image is-64x64">';
				html += '        <img data-src="'+c.user.data.user.imagen+'" class="is-rounded">';
				html += '      </figure>';
				html += '    </div>';
				html += '    <div class="media-content">';
				html += '      <div>';
				html += '        <p>';
				html += '          <strong>'+c.user.data.user.nombre+'</strong> <small>@'+c.user.data.user.username+'</small> <small>'+((c.fecha!='now') ? moment((c.fecha*1000)).locale('es').fromNow() : "Hace un momento")+'</small>';
				html += '          <br>';
				html += '		      <div style="word-break:break-all;">';
				html += 				linkit(c.texto);
				html += '   		   </div>';
				html += '        </p>';
				html += '      </div>';
				html += '    </div>';
				html += '  </article>';
				html += '</div>';
				return html;
			}
 		};
 		params = (typeof params == 'string'&&!empty(defaults[params])) ? defaults[params] : params;
 		if (typeof params == 'function') {
 			return params(data);
 		}
 		var list_txt = $(body).find('[id_comment]');
 		var first_comment = (list_txt.length>0) ? parseInt(list_txt.first().attr('id_comment')) : 0;
 		var last_comment = (list_txt.length>0) ? parseInt(list_txt.last().attr('id_comment')) : 0;
 		var is_chat = ($(body).hasClass('is_chat')) ? true : false;
 		params = $.extend({},defaults, params);
 		params.data.min_id = (!params.data.min_id) ? 0 : params.data.min_id;
 		params.data.max_id = (!params.data.max_id) ? "99999999999999999" : params.data.max_id;
 		params.data.min_id = (is_chat&&params.direction=='up') ? 0 : params.data.min_id;
 		params.data.min_id = (is_chat&&params.direction=='down') ? last_comment : params.data.min_id;
 		params.data.max_id = (is_chat&&params.direction=='up') ? first_comment : params.data.max_id;
 		params.data.max_id = (is_chat&&params.direction=='down') ? "99999999999999999" : params.data.max_id;
 		params.data.min_id = (!is_chat&&params.direction=='up'&&(first_comment>last_comment)) ? first_comment : params.data.min_id;
 		params.data.max_id = (!is_chat&&params.direction=='up'&&(first_comment>last_comment)) ? "99999999999999999" : params.data.max_id;
 		params.data.min_id = (!is_chat&&params.direction=='up'&&(first_comment<last_comment)) ? 0 : params.data.min_id;
 		params.data.max_id = (!is_chat&&params.direction=='up'&&(first_comment<last_comment)) ? first_comment : params.data.max_id;
 		params.data.min_id = (!is_chat&&params.direction=='down'&&(first_comment>last_comment)) ? 0 : params.data.min_id;
 		params.data.max_id = (!is_chat&&params.direction=='down'&&(first_comment>last_comment)) ? last_comment : params.data.max_id;
 		params.data.min_id = (!is_chat&&params.direction=='down'&&(first_comment<last_comment)) ? last_comment : params.data.min_id;
 		params.data.max_id = (!is_chat&&params.direction=='down'&&(first_comment<last_comment)) ? "99999999999999999" : params.data.max_id;
 		params.data.order = 'desc';
 		params.data.order = (is_chat&&params.direction=='down') ? 'asc' : params.data.order;
 		params.data.order = (is_chat&&params.direction=='up') ? 'desc' : params.data.order;
 		params.data.order = (is_chat&&list_txt.length<=0) ? 'desc' : params.data.order;
 		preppend_append = (is_chat&&params.direction=='down') ? 'append' : 'preppend';
 		preppend_append = (is_chat&&params.direction=='up') ? 'preppend' : 'append';
 		params.data.sort = (!params.data.sort) ? "desc" : params.data.sort;
 		params.data.sort = (is_chat&&list_txt.length<=0) ? "asc" : params.data.sort;
 		params.data.sort = (is_chat&&params.direction=='up') ? "desc" : params.data.sort;
 		params.data.sort = (is_chat&&params.direction=='down') ? "asc" : params.data.sort;
 		sB = ($(body).hasScroll()) ? $(body).scrollBottom() : 0;
 		sT = ($(body).hasScroll()) ? $(body).scrollTop() : 0;
 		$.ajax({
 			url:params.url,
			data:params.data,
			buffer:false,
			beforeSend:function () {
				$(body).addClass('no-ajax no-ajax-on-scroll');
				$('[target-comments="'+body.selector+'"]').html('Cargando...');
			},
			success:function (r) {
				$('[target-comments="'+body.selector+'"]').html('Cargar más');
				if (r.status=="success") {
					i = 0;
					if ((r.data.length-1)<=0) {$('[target-comments="'+body.selector+'"]').html('Volver a buscar'); }
					while (txt=r.data[i]) {
						if (!$(body).find('[id_comment="'+txt.id+'"]')[0]) {
							var html = ($(body).hasClass('is_chat')) ? params.chat_template(txt) : params.full_template(txt);
							(preppend_append=='append') ? $(body).append(html) : $(body).prepend(html);
						}
						i++;
					}
					$(body).removeClass('no-ajax');
				}
				$(body).unbind('scroll').scroll(function(event) {
					event.preventDefault();
					s = ($(this).scrollBottom()<=0&&!$(body).hasClass('no-ajax-on-scroll')) ? $(body).comentarios({
						url:params.url,
						data:params.data,
						direction:'down',
					}) : false;
					s = ($(this).scrollTop()<=0&&!$(body).hasClass('no-ajax-on-scroll')) ? $(body).comentarios({
						url:params.url,
						data:params.data,
						direction:'up',
					}) : false;
				});
				if (is_chat&&params.direction=='up') {
					$(body).scrollBottom(sB,1);
				}
				else if (is_chat&&params.direction=='down'){
					if (sB<=5) {$(body).scrollBottom(1,1); }
					setTimeout(function () {
						$(body).comentarios({
							url:params.url,
							data: params.data,
						});
					},5000);
				}
				setTimeout(function () {
					$(body).removeClass('no-ajax-on-scroll');
				},500);
				return params.success(body, params);
			}
 		});
	}
	// Plugin para cargar los productos de manera dinámica.
	$.fn.cargarProductos = function(params={},data={}){
		if (!this.get(0)) {
			return;
		}
		body = this.get(0);
		if ($(body).hasClass('on-ajax')) {
			return false;
		}

		defaults = {
			url:base+'/api_v2/items/items.php',
			data:{
				method:'get',
				list:false,
				index:false,
				pais:false,
				order:false,
				set_by:false,
				query:false,
				limit:6,
			},
			data2:{
				"query":(!this.data.query) ? '' : this.data.query ,
				"list":(!this.data.list) ? '' : this.data.list ,
				"min_price":0,
				"max_price":"99999999999999999999999",
				"min_stock":0,
				"max_stock":"99999999999999999999999",
				"destino":"national",
				"pais":(!this.data.pais) ? '' : this.data.pais ,
				"limit":(isNaN(this.data.limit)) ? 12 : this.data.limit,
			},
			clase:'is-one-third-desktop is-half-tablet is-full-mobile',			
			body:body,
			columns:function(body=defaults.body,adder=false){
				if (!$(body).children('.columns').last()[0]||adder ==true) {
					$(body).append('<div class="columns is-multiline"></div>');
				}
				return $(body).children('.columns').last();
			},
			template:function(arg={}){
				clase = this.clase;
				d = {
					id_producto:false,
					imagen:'',
					producto:'Desconocido',
					user:'system',
					fecha:'Error',
					descripcion:'Sin descripcion...',
					categoria:'undefined',
					is_fav:"unavaible"
				};
				d = $.extend({}, d.item, arg);
				btc_price = (!empty(setCookie('btc_price'))) ? parseFloat(setCookie('btc_price').replace(/,/gi,'')) : arg.user.data.btc.data.price;
				d = d.item;
				html  = '<div class="column '+clase+' item-to-buy-'+d.categoria+' '+((this.data.query=='favoritos') ? 'favorite_panel_token' : false)+'">';
				html += '	<div class="box" item-quick-data="'+d.id+'" style="margin-left: 10px;margin-right: 10px;position: relative;min-height:100%;">';
				html += '		<div class="level  is-mobile" style="margin-top: -10px;">';
				html += '			<div class="level-left">';
				html += '				<div class="level-item">';
				html +=  		(!empty(d.is_my)) ? '<a href="/profile?page=product&manage=true&product_id='+d.id+'"><i class="fa fa-edit"></i></a>' : '';
				html += '				</div>';
				html += '				<div class="level-item">';
				html +=  		(!empty(d.is_my)) ? '<a href="/profile?page=product&manage=true&product_id='+d.id+'&delete=true"><i class="fa fa-trash has-text-danger"></i></a>' : '';
				html += '				</div>';
				html += '			</div>';
				html += '			<div class="level-right '+((d.is_my==true) ? 'is-hidden' : '')+'">';
				html += '				<a class="level-item">';
				html += '					<span id="'+d.id+'" class="boton-favorito '+((d.is_fav==true) ? 'trusted' : '')+'"></span>';
				html += '				</a>';
				html += '				<a class="level-item coments_toggle">';
				html += '					<span class="icon is-small"><i class="fas fa-comment"></i></span>';
				html += '				</a>';
				html += '			</div>';
				html += '		</div>';
				html += '		<div class="produtc-item-'+d.id+'">';
				html += '		  <div class="is-hidden-mobile">';
				html += '			<center>';
				html += '				<figure class="image is-128x128">';
				html += '				  <img data-src="http://'+d.imagenes[0].replace(/^.*:\/\//i, '')+'" json-show="'+d.imagenes.join('[EXPLODE_IMAGES]')+'">';
				html += '				</figure>';
				html += '			</center>';
				html += '		  </div>';
				html += '		  <article class="media">';
				html += '			<div class="is-hidden-desktop">';
				html += '				<figure class="image is-96x96">';
				html += '					  <img data-src="http://'+d.imagenes[0].replace(/^.*:\/\//i, '')+'" json-show="'+d.imagenes.join('[EXPLODE_IMAGES]')+'">';
				html += '				</figure>';
				html += '			</div>';
				html += '			<div class="media-content">';
				html += '			  <div class="">';
				html += '				<p>';
				html += '				  <strong><a href="/view.php?id='+d.id+'">'+d.nombre.substr(0,20)+'</a></strong>';
				html += '				  <br>';
				html += '					<div class="" style="min-height:50px;max-height:50px;overflow:hidden;">';
				html += 						linkit(d.descripcion.substr(0,70));
				html += '					</div>';
				html += '				</p>';
				html += '			  </div>';
				html += '			  <nav class="is-mobile">';
				html += '				<div class="">';
				html += '					<div class=" has-text-link">';
				html += '						<i><small><strong class="has-text-link">'+d.precioUSD+'</strong></small></i>&nbsp;<span title="Dolares Americanos">USD</span>';
				html += '					</div>';
				html += '					<div class=" has-text-danger">';
				html += '						<i title="Bitcoin" class="fab fa-bitcoin"></i> <i><small><strong class="has-text-danger" style="font-family: '+"'Roboto Mono'"+', monospace;">'+(isNaN(d.precioBTC) ? ((d.precioUSD*1)/(btc_price*1)).toFixed(8) : d.precioBTC)+'</strong></small></i>';
				html += '					</div>';
				html += '				</div>';
				html += '			  </nav>';
				html += '			</div>';
				html += '		  </article>';
				html += '		</div>';
				html += '		<div class="coments-panel-'+d.id+'">';
				html += '			<div class="has-scroll no-rounded is-primary coments-list-'+d.id+' is_chat"></div>';
				html += '			<div class="form-coment">';
				if (!empty(setCookie('user_login'))) {
					html += '				<form method="post" style="width: 100%;" class="form-comment">';
					html += '					<input type="hidden" name="post" value="'+d.id+'">';
					html += '					<div class="field has-addons" style="width: 100%;">';
					html += '						<div class="control">';
					html += '							<button class="button is-primary coments_toggle" type="button"><i class="fa fa-arrow-left"></i></button>';
					html += '						</div>					';
					html += '						<div class="control is-expanded">';
					html += '							<input type="text" class="input share-comment" name="text" placeholder="Escribe tu comentario" autocomplete="off">';
					html += '						</div>';
					html += '					</div>';
					html += '			</div>';
				}
				else{
					html += '<div class="has-text-centered"><a href="#back" class="coments_toggle">Volver</a> · <a href="login?rf=bar">Inicar Sesión</a></div>';
				}
				html += '				</form>';
				html += '		</div>';
				html += '	</div>';
				html += '</div>';
				return html;
			}
		};
		data_r = (!empty(params.data)) ? params.data : {};		
		params = $.extend({}, defaults, params);
		
		params.data = $.extend({}, defaults.data, data_r);
		exist = params.columns().find('.column').last().find('.boton-favorito').attr('id');
		params.data.index = (exist&&!empty(params.data.order)&&params.data.order.trim().toLowerCase()!='rand') ? params.columns().find('.column').last().find('.boton-favorito').attr('id') : false;
		if (params.data.list.length<=0||empty(params.data.list)) {
			params.data.list = [];
			params.columns().find('[class*=produtc-item-]').each(function(index, el) {
				id = $(this).attr('class').split(' ');
				$.each(id,function(index, el) {
					if (el.indexOf('produtc-item-'>=0)) {
						e = el.replace('produtc-item-','');
						params.data.list.push(e);
					}
				});
			});
			params.data2.list = params.data.list.join(',');
		}
		$.each(params.data2,function(index, el) {
			if ($.trim(params.data2[index]).length<=0) {
				delete params.data2[index];
			}
		});
		params.data.method = (arrayToURL(params.data).length>3000&&params.data.method.toLowerCase().trim()=='get') ? 'post' : 'get';
		params.data = $.extend(true, params.data, params.data2);
		$.each(params.data,function(index, el) {
			if ($.trim(params.data[index]).length<=0||!params.data[index]) {
				params.data[index] = '';
			}
		});
		
		$.ajax({
			url: params.url,
			retry:true,
			type:params.data.method,
			data: params.data,
			beforeSend:function(){
				$(body).addClass('on-ajax');
				$(params.columns())
				.find('.is-loading.is-ajax-items').remove();
			},
			success:function(r){
				$(body).removeClass('on-ajax');
				$('.is-loading.is-ajax-items').remove();
				max = params.data.limit;
				$(params.columns()).find('.empty-no-more').remove();
				i = 0;
				if (r.data.length>0) {
					while (r.data[i]) {
						p = r.data[i];
						if (i<params.data.limit) {
							if (!$(params.columns()).find('.produtc-item-'+p.item.id)[0]) {
								$(params.columns()).append(params.template(p));
							}
						}
						i++;
					}
				}
				else if(!empty(r.data.item)){
					$(params.columns()).append(params.template(r.data));
				}
				else{
					$(params.columns()).append('<div class="column is-12 empty-no-more"><div class="box"><div class="has-text-centered"><i class="fa fa-ban has-text-danger"></i> · No se hayaron resultados</div></div></div>');
				}
				$('[title]').tipsy();
			}
		})
		.always(function() {
			$(body).removeClass('on-ajax');
		});
	};
	// Fin de Plugin para cargar los productos de manera dinámica.
})(jQuery);



$(document)
	// Formulario para publicar un producto
	.on('submit', '.form-upload-item', function(event) {
		event.preventDefault();
		form = $(this);
		data = form.serialize()+'&ajax=true';
		$.ajax({
			url: base+'/upload/product_manager.php',
			type:'post',
			data: data,
			error:function(err){
				console.log(err);
			},
			success:function(upload){
				if (upload.type=='error') {
					form.prev('.notification').remove().end().before(function(){
						return '<div class="notification is-danger"><button class="delete"></button>'+upload.response+'</div>';
					});
				}
				else {
					form
					.find('input,textarea')
					.val('')
					.end()
					.find('checkbox,radio')
					.prop(':checked',false)
					.end()
					.find('.clear')
					.trigger('click')
					.end()
					.prev('.notification').remove().end().before(function(){
						return '<div class="notification is-success"><button class="delete"></button>'+upload.response+'</div>';
					});
				}
			}
		});
		return false;
	})
	// Fin de Formulario para publicar un producto
	// Mostramos u ocultamos los comentarios de un producto
	.on('click', '.coments_toggle', function(event) {
		event.preventDefault();
		btn = $(this);
		quick_data = btn.parents('[item-quick-data]');
		id = (parseInt(quick_data.attr('item-quick-data'))) ? parseInt(quick_data.attr('item-quick-data')) : false;
		error = (!id);
		if (!error) {
			quick_data.scss({
				toggleClass:'is_active_chat',
			},function (ui) {
				ui.find('.is_chat').comentarios({
					data:{
						comments:id,
					},
					success:function (body) {
						a = this;
					}
				});
			});
		}
	})
	// Trabajamos el input que se encarga de enviar el comentario
	.on('submit', '.form-comment', function(event) {
		event.preventDefault();
		form = $(this);
		input = $(this).find('.share-comment');
		panel = $(input.parents('[class*=coments-panel-]')[0]);
		id = input.parents('form').find('[name="post"]').val();
		card = $(panel.find('[class*=coments-list-]')[0]);
		comentario = input.val().trim().length>0 ? input.val().trim() : false;
		data = {send: comentario,post:id,ajax:"true"};
			if (!comentario) {return; }
			$.ajax({
				url: base+'/api_v2/items/items.php',
				data: data,
				type:'post',
				beforeSend:function(){
					form.find('button').addClass('is-loading');
					input.attr('readonly','readonly');
				},
				error:function(r){
					console.log(r);
					input.addClass('is-danger');
				},
				success:function(r){
					form.find('button').removeClass('is-loading');
					input.val('').removeAttr('readonly');
					$('.coments-list-'+id)
					.not('.is_chat')
					.prepend(function () {
						return $('.coments-list-'+id).comentarios('full_template', r.data);
					});
					$('.coments-list-'+id+'.is_chat')
					.append(function () {
						return $('.coments-list-'+id).comentarios('chat_template', r.data);
					})
					.scrollBottom(1,1);
				}
			});
	})
	// Fin de Trabajamos el input que se encarga de enviar el comentario
	// Agregamos un producto a nuestra lista de favoritos
	.on('click', '.boton-favorito', function(event) {
		event.preventDefault();
		var btn = $(this);
		var item = btn.attr('id') ? btn.attr('id') : false;
		var data = {
			item_fav: item,
			encode:true,
		};
		if (!item||btn.hasClass('unavaible')||isNaN(item)) {return false;};
		$.ajax({
			url: base+'/api_v2/items/items.php',
			data: data,
			buffer:false,
			beforeSend:function(xhr, opts){
				btn.addClass('unavaible');
			},
			success:function (r) {
				btn.removeClass('unavaible');
				if (r.status=='success') {
					(r.data.code==1) ? btn.addClass('trusted') : btn.removeClass('trusted');
				}
			}
		});
	});


$(function(){
	$(document)
	.on('click', '[json-show]', function(event) {
		event.preventDefault();
		images = $(this).attr('json-show').split('[EXPLODE_IMAGES]');
		index = 0;
		max = (images.length-1);
		html  = '<div class="modal is-active modal-image-preview" style="display:none;">';
		html += '  <div class="modal-background"></div>';
		html += '  <div class="modal-card">';
		html += '    <header class="modal-card-head" style="background:#fff;border:0px;">';
		html += '      <button class="delete" aria-label="close"></button>';
		html += '    </header>';
		html += '    <section class="modal-card-body">';
		html += '      <img data-src="'+images[index]+'" to-preview style="width:100%;height:40vh;" data-style='+"'"+'{"background-size":"contain"}'+"'"+'/>';
		html += '    </section>';
		html += '    <footer class="modal-card-foot" style="background:#fff;border:0px;">';
		html += '      <button class="button is-primary btn-prev"><</button>';
		html += '      <button class="button is-primary btn-next">></button>';
		html += '    </footer>';
		html += '  </div>';
		html += '</div>';
		if ($('body').find('.modal-image-preview').remove().end().append(html).find('.modal-image-preview').last().fadeIn('fast')) {
			if(max<=0){
				$('.btn-next,.btn-prev').hide('fast');
			}
			else if(index==max){
				$('.btn-next').hide('fast');
				$('.btn-prev').show('fast');
			}
			else if(index<=0){
				$('.btn-prev').hide('fast');
				$('.btn-next').show('fast');
			}
			else{
				$('.btn-next,.btn-prev').show(0);
			}
		};
		$('.btn-prev,.btn-next')
		.unbind('click')
		.show()
		.on('click', function(event) {
			event.preventDefault();
			index = ($(this).hasClass('btn-next')&&(index<max)) ? (index*1+1) : ($(this).hasClass('btn-next')&&(index>=max)) ? 0 : ($(this).hasClass('btn-prev')&&index<=0) ? max : (index-1);
			$('.modal-image-preview [to-preview]').css('background-image','url('+images[index]+')');
		});
	})
	.on('dblclick', '[to-preview]', function(event) {
		event.preventDefault();
		nImg = $(this).clone();
		nImg
		.unbind('click')
		.addClass('shower-preview')
		.removeAttr('to-preview')
		.appendTo('body')
		.css({
			position: 'fixed',
			width: '100%',
			top:0,
			left:0,
			height: '100%',
			"z-index": "99999999999999999999"
		});
	})
	.on('click', '.shower-preview', function(event) {
		event.preventDefault();
		$(this).remove();
	})
	.on('click', '.modal .delete,.modal .modal-background', function(event) {
		event.preventDefault();
		$(this).parents('.modal').fadeOut('fast');
	});;
});