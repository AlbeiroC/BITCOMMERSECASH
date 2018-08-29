function showThumbnail(datas, id=false,w=50, h=50){
	id = (!id) ? getId() : id;
	key = document.querySelector('[key]').getAttribute('key');

	var img = document.createElement('img');
	img.onload = function() {
		width = $(this).width();
		height = $(this).height();
		if (width>w) {
			calculo = Math.round((100*w)/ width); //porcentaje
			h = Math.round((height*calculo)/100);
		}
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		canvas.width = w;
		canvas.height = h;
		ctx.drawImage(this, 0, 0, w, h);
		var dataURI = canvas.toDataURL();
	};
	img.setAttribute('class',"button");	
	img.setAttribute('id',"thumb_"+id);	
	img.style.width = '70px';
	img.style.height = '50px';
	img.src = datas;
	html = '<div class="column is-2 img_thumb_'+id+'" style="opacity:0.5;min-width: 70px;text-align:center;"></div>';
	$.ajax({
		url: './../../api_v2/upload/upload_temp.php',
		type: 'post',
		data: {picture:datas,upload:'true',key:key,img_key:id},
		error:function (err) {
			console.log(err);
		},
		beforeSend:function (e) {
			$('.offer')
			.find('.column')
			.last()
			.before(html)
			.end()
			.end()
			.find('.column:empty')
			.first()
			.html(img);
		},
		buffer:false,
		success:function (r) {
			if (!r.upload) {
				$('.img_thumb_'+id).remove();
			}
			else{
				$('.img_thumb_'+id).css('opacity','1');
			}
		}
	});
}


function createThumbnail(file) {
	fReader = new FileReader();
	fReader.onloadend = function () {
		var id = getId();
		showThumbnail(fReader.result,id);
	}
	if (file) {
	 	fReader.readAsDataURL(file);
	}
}


$(function () {

	$(document)
	// Enviar el formulario
	.on('submit', 'form[key]', function(event) {
		event.preventDefault();
		form = $(this);
		if (form.hasClass('is-ajax')) {return false;}
		key = form.attr('key');
		data = form.serialize()+'&finish=true&key='+key;
		$.ajax({
			url: './../../api_v2/upload/upload_temp.php',
			type:'post',
			data: data,
			error:function (err) {
				return this.success(err.responseText);
			},
			beforeSend:function () {
				form.addClass('is-ajax');
			},
			success:function (r) {
				form.removeClass('is-ajax');
				console.log(r);
				if (r.type=='success') {
					dialog.alert({
						message:"Tu producto se ha guardado correctamente.",
						button:"Aceptar",
						callback:function () {
							push(false,false,"manage,product_id");
							window.location.reload();
						}
					});
				}
				else{
					dialog.alert({
						message:"Se necesita completar un campo en el formulario: '"+r.error+"'.",
						button:"Cerrar"
					});					
				}
			}
		});
		
	})
	// Fin de Enviar el formulario

	// Activar el input file
	.on('click', '[data-file]', function(event) {
		event.preventDefault();
		input = $(this).attr('data-file');
		if ($(input)[0]) {
			$(input).trigger('click');
		}
	})
	// Fin de Activar el input file
	// Leer las imagenes que estan en el input file
	.on('change', '[name="file-uploads"]', function(event) {
		event.preventDefault();
		id = $(this).attr('id') ? $(this).attr('id') : getId();
		$(this).attr('id', id);
		input = document.getElementById(id);
		container = $($('[data-file]')[0]).parents('.columns');
		for (var i = 0; i < input.files.length; i++) {
			createThumbnail(input.files[i]);
		}
		$(this).val('');
	})
	// Fin de Leer las imagenes que estan en el input file
	// Eliminar imagenes que van a subirse
	.on('click','[id*="thumb_"]',function (event) {
		event.preventDefault();
		btn = $(this);
		id = btn.attr('id');
		if (!id) {
			btn.parent('.column').remove();
		}
		else{
			id = id.replace(/^thumb_(.*)$/gi,"$1");
			$.ajax({
				url: './../../api_v2/upload/upload_temp.php',
				type: 'post',
				data: {key:key,img_key:id,delete:"true"},
				buffer:false,
				error:function (err) {
					console.log(err);
				},
				beforeSend:function (e) {
					btn.parent('.column').css('opacity','.5');
				},
				success:function (r) {
					if (r.delete==true) {
						btn.parent('.column').remove();
					}
					else{
						btn.parent('.column').css('opacity','1');
					}
				}
			});
		}
	})
	// Fin de Eliminar imagenes que van a subirse
	
	// Calculadora de precios
	.on('keyup','[name=usd_price]',function (event) {
		event.preventDefault();
		input = $(this);
		usd_price = parseFloat(input.val());
		btc_price = $($('input.btc-usd-price')[0]).val().replace(/,/gi,'');
		btc_price = parseFloat(btc_price);
		btc_result = (usd_price/btc_price).toFixed(8);
		$('[name=btc_price]').val(btc_result);
	})
	// Fin de Calculadora de precios

	// Fijar el precio en bitcoin
	.on('click', '.fixed-btc-price', function(event) {
		event.preventDefault();
		btn = $(this);
		is_active = btn.hasClass('is-link') ? true : false;
		if (is_active) {
			btn.removeClass('is-link').html('<i class="far fa-circle fa-3x"></i>');
			$('[name="automatic_price"]').val('1');
		}
		else{
			btn.addClass('is-link').html('<i class="fa fa-check-circle fa-3x"></i>');
			$('[name="automatic_price"]').val('');
		}
	})
	// Fin de Fijar el precio en bitcoin

	// Guardar borrador en tiempo real
	.on('blur','form[key] input,form[key] textarea',function (event) {
		event.preventDefault();
		key = document.querySelector('[key]').getAttribute('key');
		input = $($(this)[0]);
		val = (input.val().length>0) ? input.val().charAt(0).toUpperCase()+input.val().substring(1) : '';
		val = (input.is('input')) ? val.substring(0, 150) : val;
		val = (input.is('textarea')) ? val.substring(0, 500) : val;
		input.val(val);
		data = input.parents('form[key]').serialize()+'&key='+key;
		$.ajax({
			url: './../../api_v2/upload/upload_temp.php',
			type: 'post',
			data: data,
			buffer:false,
			beforeSend:function () {},
			success:function (r) {}
		});
	});
	// Fin de Guardar borrador en tiempo real



});