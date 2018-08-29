(function($){

	// Plugin para cargar los comentarios de un producto o todos los comentarios no leidos por un usuario
	$.fn.comentarios = function(params={}){
		body = $(this);
		list = '0';
		$(body).find('[id_comment]').each(function(index, el) {
			list += ','+$(this).attr('id_comment');
		});
		defaults = {
			direction:'up',
			data:{
				comments:"all",
				list:list,
				up_than:0,
				down_than:"9999999999999999999",
			},
			index:null,
			scroll:false,
			preppend:true,
			sort:false,
			reply:true,
			chat_template:function(data={},is_form=false){
				c = data;
				html = '<div class="column is-full" id_comment="'+c.id+'" style="display:block;float:right;width:100%;left:0px;">';
				html += '	<div>';
				html += '		<img data-src="'+c.user.user_imagen+'" width="30px" height="30px" data-style='+"'"+'{"background-size":"cover","border-radius":"9999999999999px"}'+"'"+' style="float: '+((c.user.is_my===true) ? "right" : "left")+';">';
				html += '	</div>';
				html += '	<div class="box '+((c.user.is_my===true) ? "notification is-link " : false)+'" style="float:'+((c.user.is_my===true) ? "right" : "left")+';display: table;word-break: break-all;padding: 2px 10px;">';
				html += 		c.comentario;
				html += '		<br>';
				html += '		<div class="'+((c.user.is_my===true) ? false : "has-text-grey-light")+' has-text-weight-normal is-size-7">'+moment(new Date(c.fecha).getTime()).locale('es').fromNow()+'</div>';
				html += '	</div>';
				html += '</div>';
				return html;
			},
			full_template:function(data={},is_form=false,is_only=true){
				c = data;
				by = c.user.user_id;
				switch (is_only) {
					case	true:
						html  = '		<li from="'+c.user.user_id+'">';
						html += '			<div class="comment-main-level">';
						html += '				<div class="comment-avatar">';
						html += '					<img data-src="'+c.user.user_imagen+'" class="" data-style='+"'"+'{"background-color":"#fff"}'+"'"+'>';
						html += '				</div>';
						html += '				<div class="comment-box" id_comment="'+c.id+'">';
						html += '					<div class="comment-head">';
						html += '						<div class="level">';
						html += '							<div class="level-left">';
						html += '								<h6 class="comment-name">';
						html += '									<a href="#">@'+c.user.user_username+'</a>';
						html += '								</h6>';
						html += '							</div>';
						html += '							<div class="level-right">';
						html += '								<span></span>';
						html += '							</div>';
						html += '						</div>';
						html += '					</div>';
						html += '					<div class="comment-content"></div>';
						html += '				</div>';
						html += '			</div>';
						html += '		</li>';
						break;
					default:
						html  = '		<li from="'+c.user.user_id+'">';
						html += '			<div class="comment-main-level">';
						html += '				<div class="comment-avatar">';
						html += '					<img data-src="'+c.user.user_imagen+'" class="" data-style='+"'"+'{"background-color":"#fff"}'+"'"+'>';
						html += '				</div>';
						html += '				<div class="comment-box" id_comment="'+c.id+'">';
						html += '					<div class="comment-head">';
						html += '						<div class="level">';
						html += '							<div>';
						html += '								<h6 class="comment-name">';
						html += '									<a href="#">@'+c.user.user_username+'</a>';
						html += '								</h6>';
						html += '							</div>';
						html += '							<div>';
						html += '								<span>' + moment(new Date(c.fecha).getTime()).locale('es').fromNow() + '</span>';
						html += '							</div>';
						html += '						</div>';
						html += '					</div>';
						html += '					<div class="comment-content">' + c.comentario + '</div>';
						html += '				</div>';
						html += '			</div>';
						html += '		</li>';
						break;
				}
				form_to_response  = '<div style="margin-top:15px;padding-bottom:10px;border-bottom:solid 1px #ccc;" class="comment-container">';
				form_to_response += '	<div class="level">';
				form_to_response += '		<div class="level-left">';
				form_to_response += '			<a class="level-item"  json-show="'+c.item.imagen.join('[EXPLODE_IMAGES]')+'">';
				form_to_response += 				ucfirst(c.item.producto);
				form_to_response += '			</a>';
				form_to_response += '			<div class="level-item">';
				form_to_response += 				moment(new Date(c.fecha).getTime()).locale('es').fromNow();
				form_to_response += '			</div>';
				form_to_response += '		</div>';
				form_to_response += '	</div>';
				form_to_response += '	<div>';
				form_to_response += 		c.comentario;
				form_to_response += '	</div>';
				form_to_response += '	<form onsubmit="return false;" class="response-form" id="'+c.id+'">';
				form_to_response += '		<input type="hidden" name="id_comment" value="'+c.id+'" />';
				form_to_response += '		<div class="field has-addons">';
				form_to_response += '			<div class="control is-expanded">';
				form_to_response += '				<input type="text" class="input" name="response_comment"/>';
				form_to_response += '			</div>';
				form_to_response += '			<div class="control">';
				form_to_response += '				<button class="button is-link">Responder</button>';
				form_to_response += '			</div>';
				form_to_response += '		</div>';
				form_to_response += '	</form>';
				form_to_response += '</div>';
				return (is_form===true&&params.reply===true) ? form_to_response : html;
			}
		}
		params = $.extend(true,defaults, params);
		params.data.up_than = ((params.direction=='down'&&$(body).hasClass('is_chat'))||(params.index=='first')) ? $(body).find('[id_comment]').first().attr('id_comment') : 0;
		params.data.down_than = ((params.direction=='up'&&$(body).hasClass('is_chat'))||(params.index=='last')) ? $(body).find('[id_comment]').first().attr('id_comment') : "99999999999999999999999999999999";
		params.preppend = (!params.preppend) ? 'append' : 'prepend';
		selector = $(this).selector;
		if ($('[target="'+selector+'"]')[0]) {
			if (!$('[target="'+selector+'"]').attr('no-ajax')) {
				$('[target="'+selector+'"]')
				.addClass('no-ajax')
				.unbind('click')
				.on('click', function(event) {
					event.preventDefault();
					$(body).comentarios({
						data:{
							comments:$item,
							encode:true,
						},
						reply:false,
						direction:'up',
						index:'auto',
						sort:false,
						prepend:false,
					});
				});
			}
		}
		$.ajax({
			url: './api_v1/items/items.php',
			data: params.data,
			xhr:function () {
				if (window.XMLHttpRequest){
				    xhr = new window.XMLHttpRequest();
				    if(xhr.overrideMimeType){
				        xhr.overrideMimeType( "text/json" );
				    }
				}else{
				    xhr = new ActiveXObject('Microsoft.XMLHTTP');
				}
				return xhr;
			},
			beforeSend:function () {
				$(body)
				.parent()
				.find('.refresh-comentarios-target')
				.addClass('box')
				.html('<i class="fa fa-sync fa-spin"></i>');
			},
			success:function (r) {
				if (r.type=='success') {
					if (r.data.length>0) {
						$(body)
						.parent()
						.find('.refresh-comentarios-target')
						.removeClass('notification')
						.removeClass('is-danger')
						.addClass('box')
						.html('Mostrar mas');
					}
					else{
						$(body)
						.parent()
						.find('.refresh-comentarios-target')
						.removeClass('notification')
						.removeClass('is-danger')
						.addClass('box')
						.html('Sin comentarios');
					}
					i = 0;
					switch (params.direction) {
						case 'down':
							r.data = sortJson(r.data,'id','asc');
							break;
						case 'up':
							r.data = sortJson(r.data,'id','desc');
							break;
					}
					if (body.hasClass('is_chat')) {
						while (i<r.data.length) {
							c = r.data[i];
							if (!$(body).find('[id_comment="'+c.id+'"]')[0]) {
								switch (params.preppend) {
									case 'prepend':
										$(body).prepend(params.chat_template(c,false));
										break;
									default:
										$(body).append(params.chat_template(c,false));
										break;
								}
							}
							i++;
						}
						if (!$(body).hasClass('scrolling-ajax-added')) {
							$(body).addClass('scrolling-ajax-added')
							.scroll(function(event) {
								if ($(this).scrollTop()<=0) {
									params.direction = 'up';
									params.scroll = false;
									params.preppend = true;
									$(this).comentarios(params);
								}
								else if ($(this).scrollBottom()) {
									params.direction = 'down';
									params.scroll = params.preppend = false;
									$(this).comentarios(params);
								}
							});
						}
					}
					else{
						if (params.reply===true) {
							s = (!$(body).find('.no-readed-comments')[0]&&r.data.length>0) ? $(body).html('<div class="comments-container"><ul class="comments-list no-readed-comments"></ul></div>') : false;
							while (i<r.data.length) {
								c = r.data[i];
								by = c.user.user_id;
								if(!$(body).find('.no-readed-comments li[from="'+c.user.user_id+'"]')[0]) {
									s = (params.preppend===true) ? $('.no-readed-comments').prepend(params.full_template(c,false)).find('li[from="'+c.user.user_id+'"] .comment-content').prepend(params.full_template(c,true)) : $('.no-readed-comments').append(params.full_template(c,false)).find('li[from="'+c.user.user_id+'"] .comment-content').append(params.full_template(c,true));
								}
								else{
									s = (params.preppend===true) ? $('.no-readed-comments li[from="'+c.user.user_id+'"] .comment-content').prepend(params.full_template(c,true)) : $('.no-readed-comments li[from="'+c.user.user_id+'"] .comment-content').append(params.full_template(c,true));
								}
								i++;
							}
						}
						else{
							s = (!$(body).find('.no-readed-comments')[0]&&r.data.length>0) ? $(body).html('<div class="comments-container"><ul class="comments-list no-readed-comments"></ul></div>') : false;
							while (i<r.data.length) {
								c = r.data[i];
								by = c.user.user_id;
								switch (params.prepend) {
									case true:
										$(body).find('.no-readed-comments').prepend(params.full_template(c,false,false));
										break;
									default:
										$(body).find('.no-readed-comments').append(params.full_template(c,false,false));
										break;
								}
								i++;
							}
						}
					}
				}
				else{
					$(body)
					.parent()
					.find('.refresh-comentarios-target')
					.removeClass('box')
					.addClass('notification')
					.addClass('is-danger')
					.html('Oops! Volver a cargar');
					console.log('Se ha recibido un error en la busqueda de comentarios', r);
				}
				data_src();
			}
		});
	}
	// Fin de Plugin para cargar los comentarios de un producto o todos los comentarios no leidos por un usuario




	// Plugin para cargar los productos de manera dinámica.
	$.fn.cargarProductos = function(params={}){
		if (!this.get(0)) {
			return;
		}
		body = this.get(0);
		if ($(body).hasClass('on-ajax')) {
			return false;
		}
		defaults = {
			data:{
				method:'get',
				list:false,
				index:false,
				pais:false,
				order:false,
				set_by:false,
				query:'rand',
				limit:6,				
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
				d = $.extend({}, d, arg);
				precio = $.number( d.precio, 2, ',' );
				btc_price = (!empty(setCookie('btc_price'))) ? parseInt(setCookie('btc_price')) : 0;
				html  = '<div class="column '+clase+' item-to-buy-'+d.categoria+' '+((this.data.query=='favoritos') ? 'favorite_panel_token' : false)+'">';
				html += '	<div class="box" style="margin-left: 10px;margin-right: 10px;position: relative;min-height:100%;">';
				html += '<!-- Modificacion 1 -->';
				html += '<div class="level  is-mobile" style="margin-top: -10px;">';
				html += '	<div class="level-left">';
				
				html += '		<div class="level-item">';
				html += (!empty(d.is_my)) ? '<a href="/profile?page=product&manage=true&product_id='+d.id_producto+'"><i class="fa fa-edit"></i></a>' : '';
				html += '		</div>';

				html += '		<div class="level-item">';
				html += (!empty(d.is_my)) ? '<a href="/profile?page=product&manage=true&product_id='+d.id_producto+'&delete=true"><i class="fa fa-trash has-text-danger"></i></a>' : '';
				html += '		</div>';

				html += '	</div>';

				html += '	<div class="level-right '+((d.is_fav.response==false&&d.is_fav.code==false||d.is_fav=='unavaible') ? 'is-hidden' : '')+'">';
				html += '		<a class="level-item">';
				html += '			<span id="'+d.id_producto+'" class="boton-favorito '+((d.is_fav.response=='is_fav'&&d.is_fav.code==true) ? 'trusted' : '')+'"></span>';
				html += '		</a>';
				html += '		<a class="level-item coments_toggle" triger-click-toggle=".produtc-item-'+d.id_producto+'" panel-toggle=".coments-panel-'+d.id_producto+'" panel=".coments-list-'+d.id_producto+'" post-id="'+d.id_producto+'" scrollBottom="true">';
				html += '			<span class="icon is-small"><i class="fas fa-comment"></i></span>';
				html += '		</a>';
				html += '	</div>';
				
				html += '</div>';
				html += '<!-- Fin de Modificacion 1 -->';

				html += '		<div class="produtc-item-'+d.id_producto+'">';
				html += '		  <div class="is-hidden-mobile">';
				html += '			<center>';
				html += '			<figure class="image is-128x128">';
				html += '			  <img data-src="http://'+d.imagen[0].replace(/^.*:\/\//i, '')+'?format=png&w=80" json-show="'+d.imagen.join('[EXPLODE_IMAGES]')+'">';
				html += '			</figure>';
				html += '			</center>';
				html += '		  </div>';
				html += '		  <article class="media">';
				html += '			<div class="is-hidden-desktop">';
				html += '				<figure class="image is-96x96">';
				html += '				  <img data-src="http://'+d.imagen[0].replace(/^.*:\/\//i, '')+'?format=png&w=80" json-show="'+d.imagen.join('[EXPLODE_IMAGES]')+'">';
				html += '				</figure>';
				html += '			</div>';
				html += '			<div class="media-content">';
				html += '			  <div class="">';
				html += '				<p>';
				html += '				  <strong><a href="item_'+d.id_producto+'">'+d.producto.substr(0,20)+'</a></strong>';
				html += '				  <br>';
				html += '					<div class="" style="min-height:50px;max-height:50px;overflow:hidden;">';
				html += 						linkit(d.descripcion.substr(0,70));
				html += '					</div>';
				html += '				</p>';
				html += '			  </div>';
				html += '			  <nav class="is-mobile">';
				html += '					<!-- Modificacion 3 -->';
				html += '					<div class="">';
				html += '						<div class=" has-text-link">';
				html += '							<i><small><strong class="has-text-link">'+precio+'</strong></small></i>&nbsp;<span title="'+d.nombre_divisa+'">'+d.divisa.toUpperCase()+'</span>';
				html += '						</div>';
				html += '						<div class=" has-text-success">';
				html += '							<i><small><strong class="has-text-success">'+d.precio_usd+'</strong></small></i>&nbsp;<span title="Dolares Americanos">USD</span>';
				html += '						</div>';
				html += '					</div>';
				html += '					<!-- Fin de Modificacion 3 -->';
				html += '			  </nav>';
				html += '			</div>';
				html += '		  </article>';
				html += '		</div>';
				html += '		<div class="coments-panel-'+d.id_producto+'">';
				html += '			<div class="has-scroll no-rounded is-primary coments-list-'+d.id_producto+' is_chat"></div>';
				html += '			<div class="form-coment">';
				if (!empty(setCookie('user_login'))) {
					html += '				<form method="post" style="width: 100%;" class="form-comment">';
					html += '					<input type="hidden" name="post" value="'+d.id_producto+'">';
					html += '					<div class="field has-addons" style="width: 100%;">';
					html += '						<div class="control">';
					html += '							<button class="button is-primary coments_toggle" triger-click-toggle=".produtc-item-'+d.id_producto+'" panel=".coments-panel-'+d.id_producto+'" type="button"><i class="fa fa-arrow-left"></i></button>';
					html += '						</div>					';
					html += '						<div class="control is-expanded">';
					html += '							<input type="text" class="input share-comment" title="ENTER para enviar y ESC para volver" name="text" placeholder="Escribe tu comentario" autocomplete="off">';
					html += '						</div>';
					html += '					</div>';
					html += '			</div>';
				}
				else{
					html += '<div class="has-text-centered"><a href="#back" class="coments_toggle" triger-click-toggle=".produtc-item-'+d.id_producto+'" panel=".coments-panel-'+d.id_producto+'" >Volver</a> · <a href="login?rf=bar">Inicar Sesión</a></div>';
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
			params.data.list = params.data.list.join(',');
		}

		$.each(params.data,function(index, el) {
			if (empty(el)) {
				delete params.data[el];
			}
		});

		params.data.method = (arrayToURL(params.data).length>3000&&params.data.method.toLowerCase().trim()=='get') ? 'post' : 'get';
		$.ajax({
			url:'./api_v1/items/items.php',
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
				if (r.items.length>0) {
					while (r.items[i]) {
						p = r.items[i];
						if (i<params.data.limit) {
							if (!$(params.columns()).find('.produtc-item-'+p.id_producto)[0]) {
								$(params.columns()).append(params.template(p));
							}
						}
						i++;
					}
				}
				else if (r.optionals.items.length>0) {
					i=0;
					if (!$(params.columns()).find('.optionals_headers')[0]) {
						$(params.columns()).append('<div class="column optionals_headers is-12"><div class="notification is-info has-text-left">No tenemos mas para mostrar, pero te puede interesar: </div></div>');
					}

					while (r.optionals.items[i]) {
						p = r.optionals.items[i];
						if (i<params.data.limit) {
							if (!$(params.columns()).find('.produtc-item-'+p.id_producto)[0]) {
								$(params.columns()).append(params.template(p));
							}
						}
						i++;
					}
				}
				else{
					$(params.columns()).append('<div class="column is-12 empty-no-more"><div class="box"><div class="has-text-centered"><i class="fa fa-ban has-text-danger"></i> · No se hayaron resultados</div></div></div>');
				}
				$('[title]').tipsy();
				data_src();
			}
		})
		.always(function() {
			$(body).removeClass('on-ajax');
		});
	};
	// Fin de Plugin para cargar los productos de manera dinámica.
})(jQuery);



$(document)
	.on('click', 'd', function(event) {
		event.preventDefault();
		/* Act on the event */
	})
	// Formulario para publicar un producto
	.on('submit', '.form-upload-item', function(event) {
		event.preventDefault();
		form = $(this);
		data = form.serialize()+'&ajax=true';
		$.ajax({
			url: './../../upload/product_manager.php',
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
		toShow = btn.attr('panel-toggle') ? btn.attr('panel-toggle') : btn.attr('panel') ? btn.attr('panel') : false;
		panel = btn.attr('panel') ? btn.attr('panel') : false;
		scrollToBottom = btn.attr('scrollBottom') ? true : false;
		toggle = btn.attr('triger-click-toggle') ? btn.attr('triger-click-toggle') : 'brutalustitus';
		if ($(toggle)[0]) {
			$(toggle).slideToggle('slow');
		}
		if (toShow.length>0&&panel.length>0) {
			toShow = $(toShow);
			panel = $(panel);
			toShow.slideToggle('slow', function() {
				if (toShow.is(':visible')) {
					panel.show(1);
					id = panel.attr('class').replace(/^(.*)coments\-list\-(\d+)(.*)$/gi,"$2");
					id = (id*1);
					return (isNaN(id)) ? false : panel.comentarios({
													data:{
														comments:id,
														encode:true,
													},
													scroll:true,
													index:'auto',
												});
				}
				else{
					panel.hide(1);
				}
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
			if (!comentario) {
				return;
			}

			$.ajax({
				url:'./api_v1/items/items.php',
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
					if (r.type!='error') {
						by = r.send_by;
						if (window.location.pathname.indexOf('/item_')>=0) {
							html  = '<li class="new-comment" style="display:none;">';
							html += '	<div class="comment-main-level">';
							html += '		<div class="comment-avatar">';
							html += '			<img class="user-imagen" data-style='+"'"+'{"background-color":"#fff"}'+"'"+'>';
							html += '		</div>';
							html += '		<div class="comment-box">';
							html += '			<div class="comment-head">';
							html += '				<div class="level">';
							html += '					<div class="level-left">';
							html += '						<h6 class="comment-name">';
							html += '							<a href="#">@'+r.send_by['user_username']+'</a>';
							html += '						</h6>									';
							html += '					</div>';
							html += '					<div class="level-right">';
							html += '						<span>Hace un momento</span>';
							html += '					</div>';
							html += '				</div>';
							html += '			</div>';
							html += '			<div class="comment-content">';
							html += 				linkit(data.send);
							html += '			</div>';
							html += '		</div>';
							html += '	</div>';
							html += '</li>';
							$('.comments-container')
							.find('.comments-list')
							.prepend(html)
							.parent()
							.find('.new-comment')
							.slideDown('slow', function() {
								$(this).removeClass('new-comment')
							});
						}
						else{
							push(false,"productid="+id+"&coment_id=last");
							card.append(function(){
							html = '<div class="column is-full" id_comment="'+r.send_by.coment_id+'" style="display:block;float:right;width:100%;left:0px;">';
							html += '	<div>';
							html += '		<img data-src="'+r.send_by.user_imagen+'" width="30px" height="30px" data-style='+"'"+'{"background-size":"cover","border-radius":"9999999999999px"}'+"'"+' style="float: right;">';
							html += '	</div>';
							html += '	<div class="box notification is-link" style="float:right;display: table;word-break: break-all;padding: 2px 10px;">					';
							html += 		linkit(comentario);
							html += '		<br>';
							html += '		<div class="has-text-weight-normal is-size-7">Justo ahora</div>';
							html += '	</div>';
							html += '</div>';
								return html;
							}).animate({
								scrollTop:'+=1000000000'
							},"slow");
							data_src();
						}
						input.removeAttr('readonly').val('').removeClass('is-danger');
					}
					else{
						input.removeAttr('readonly').addClass('input is-danger');
					}
				}
			});
	})
	// Fin de Trabajamos el input que se encarga de enviar el comentario


	// Agregamos un producto a nuestra lista de favoritos
	.on('click', '.boton-favorito', function(event) {
		event.preventDefault();
		btn = $(this);
		item = btn.attr('id') ? btn.attr('id') : false;
		data = {
			item_fav: item,
			ajax:true
		};
		if (!item||btn.hasClass('unavaible')) {
			return false;
		};
		if (item.length > 0 && !isNaN(item)) {
			$.ajax({
				url:'./api_v1/items/items.php',
				data: data,
				xhr:function (argument) {
					if (window.XMLHttpRequest){xhr = new window.XMLHttpRequest(); if(xhr.overrideMimeType){xhr.overrideMimeType( "text/json" ); } }else{xhr = new ActiveXObject('Microsoft.XMLHTTP'); }
					return xhr;
				},
				beforeSend:function(){
					btn
					.addClass('unavaible');
				},
				success: function(r) {
					if (r.type=='error') {
						btn
						.addClass('unavaible');
					}
					else if(r.type!='error'&&r.response=='add_fav'&&r.code==true){
						btn
						.addClass('trusted')
						.removeClass('unavaible');
						btn.parents('.favorite_panel_token').removeClass('deleted');
					}
					else if(r.type!='error'&&r.response=='add_fav'&&r.code==false){
						btn
						.removeClass('unavaible')
						.removeClass('trusted');
						btn.parents('.favorite_panel_token').addClass('deleted');
						setTimeout(function () {
							if (btn.parents('.favorite_panel_token').hasClass('deleted')) {
								btn.parents('.favorite_panel_token').slideUp('slow',function () {
									$(this).remove();
								});
							}
						},5000);
					}
				}
			});
		}
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
		data_src();
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