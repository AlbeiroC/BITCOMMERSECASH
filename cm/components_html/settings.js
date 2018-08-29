$(function () {
	$('[href="#countrie-tag"],.find-countrie[readonly],.find-countrie,#update-info,#update-info [name]')
	.unbind('click')
	.unbind('hover')
	.unbind('focus')
	.unbind('blur')
	.unbind('submit');
	
	var myDropzone = new Dropzone(".dropzone", {
		url: "./api_v2/update/update.php",
		maxFilesize:1,
		maxFiles:1,
		acceptedFiles:'image/*',
		paramName:'ImageFileInput',
		params:{
			key:key,
		}
	});

	myDropzone.on("addedfile", function(file) {
	  file.previewElement.addEventListener("click", function() {
   		myDropzone.removeFile(file);
	  });
	});


	// Countries Autocomplete
	$('.find-countrie').not('.no-list').easyAutocomplete({
		url:function (name='') {
			return window.location.protocol+"//"+window.location.host+"/cm/country_list.php?title="+name;
		},
		getValue:"title",
		template:{
			type:"iconLeft",
			fields:{
				iconSrc:"flag",
				description:"iso3",
			}
		},
		list:{
			onSelectItemEvent:function () {
				console.clear();
				var item = $('.find-countrie').not('.no-list').getSelectedItemData();
				$('[name="divisa"]').val(item.currencie_code);
				$('[name="pais"]').val(item.iso2);
				$('.img-flag-register').attr('data-src',item.flag);
			}
		},
	});
	// Fin de Countries Autocomplete



	// Document .on();
	$(document)
		.on('keyup', '.find-countrie.no-list', function(event) {
			event.preventDefault();
			input = $(this);

			keycode = (input.val().length>0) ? input.val() : 'a';
			keycode = keycode.toLowerCase().replace(/ /gi,'');
			if ($(this).parents('.modal')[0]) {
				$('[keycode]').not('[keycode*='+keycode+']').parents('.pais_img').css('display','none');
				$('[keycode*='+keycode+']').parents('.pais_img').css('display','block');
			}
		})
		.on('submit', '#update-info', function(event) {
			event.preventDefault();
			form = $(this);
			$.ajax({
				url: './api_v2/update/update.php',
				type: 'post',
				data: form.serialize()+'&cheked_updated='+key+'&key='+key,
				beforeSend:function () {
					$('[data-title]')
					.attr({
						"data-tipsy-disabled":"true"
					})
					.trigger('tipsy.hide');
					form
					.find('input')
					.attr('disabled','disabled')
					.end()
					.find('[type="submit"]').addClass('is-loading');
				},
				error:function(error) {
					console.log("Error", error.responseText);
				},
				success:function (r) {
					form
					.find('input')
					.removeAttr('disabled')
					.end()
					.find('[type="submit"]')
					.removeClass('is-loading');
					type = (r.type) ? r.type : false;
					if (type=='ok'||type=='success'||type=='good') {
						form
						.find('[type="reset"]')
						.trigger('click')
						.end()
						.find('.changed-info-ajax')
						.addClass('no-changeable')
						.removeClass('changed-info-ajax');
					}
					else if (type=='error') {
						$('[name="'+r.target+'"]')
						.addClass('is-danger')
						.removeAttr('data-tipsy-disabled')
						.focus()
						.attr({
							'data-title':r.response
						})
						.tipsy({trigger: 'manual'})
						.trigger('tipsy.show')
						.parents('html, body').animate({
							scrollTop: (($('[name="'+r.target+'"]').offset().top*1)-150)
						}, 300);
					}
					else if (type=='message') {
						$('[name="'+r.target+'"]')
						.addClass('is-warning')
						.removeAttr('data-tipsy-disabled')
						.focus()
						.attr({
							'data-title':r.response
						})
						.tipsy({trigger: 'manual'})
						.trigger('tipsy.show')
						.parents('.box')
						.find('.box-closeup')
						.find('.notice')
						.html(r.response);
					}
				}
			});
		})
		.on('blur', '#update-info [name]:not(.no-ajaxable)', function(event) {
			event.preventDefault();
			input = $(this);
			form = $('#update-info');
			nombre = input.val();
			$.ajax({
				url: './api_v2/update/update.php',
				type: 'post',
				data: form.serialize()+'&key='+key,
				buffer:false,
				beforeSend:function(){
					$('#update-info [name]')
					.removeClass('is-danger')
					.parents('.box')
					.find('.box-closeup')
					.find('.notice')
					.html('');
				},
				error:function (err) {
					console.log(err.responseText);
				},
				success:function(r){
					console.log(r);
					type = (r.type) ? r.type : false;
					if (type=='error') {
						$('[name="'+r.target+'"]').addClass('is-danger');
					}
					else if (type=='message') {
						$('[name="'+r.target+'"]')
						.addClass('is-warning')
						.parents('.box')
						.find('.box-closeup')
						.find('.notice')
						.html(r.response);
					}
				}
			});
		})
	// Fin de Document .on();
});