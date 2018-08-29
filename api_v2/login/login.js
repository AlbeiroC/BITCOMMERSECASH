base = window.location.protocol+'//'+window.location.host;
	$(function(){
		$('.form-login').find('[type="password"]').parents('.field').remove();
		
		$(document).on('submit', '.form-login', function(event) {
			event.preventDefault();
			form = $(this);
			paso = 'correo';
			form.find('input').each(function(index, el) {
				if ($(this).attr('type')=='password') {
					paso = 'password';
				}
			});
			switch (paso) {
				case 'correo':
					correo = form.find('input[name="username"]').val();
					data = {username:correo};
					good = function(r){
						form.find('[type="submit"]').removeClass('is-loading');
						if (r.length>0) {
						r = r[0];
							if (r.status!==undefined) {
								if (r.status.toLowerCase()=='ok') {
									form
									.find('[name="username"]')
									.removeClass('is-danger')
									.addClass('is-success')
									.attr('disabled','disabled')
									.fadeOut('fast')
									.next('.icon')
									.html('<i class="fas fa-lock"></i>')
									.end()
									.before('<input type="password" class="input" placeholder="* * * * * * * *" name="password" autocomplete="off" autofocus />')
									.end()
									.find('[type="password"]')
									.focus()
									.end()
									.find('[name="user-check"]')
									.val(correo);
									form
									.find('img')
									.attr('data-src',r.pic);
								}
								else if(r.status.toLowerCase()=='inactive'){
									form
									.parents('.box')
									.prev('.notice')
									.remove();
									form
									.parents('.box')
										.before('<div class="notice"><div class="notification is-danger"><button class="delete"></button> Tu cuenta actualmente está inactiva, debes verificar tu correo electronico.</div><br /></div>');
								}
								else{
									form.find('[name="username"]').addClass('is-danger');									
								}
							}
						}
						else{
							form.find('[name="username"]').addClass('is-danger');
						}
					};
					break;
				case 'password':
					clave = form.find('input[type="password"]').val();
					correo = $('[name="user-check"]').val();
					data = {"user-check":correo,clave:clave};
					good = function(r){
						form.find('.is-loading').removeClass('is-loading')
						if (r.length>0) {
							form
							.find('input[type="password"]')
							.removeClass('is-danger')
							.attr('disabled','disabled')
							.end()
							.find('button')
							.addClass('is-loading')
							.attr('disabled','disabled');
							next = '/';
							if (!empty($_GET('next'))) {
								next = decodeURIComponent($_GET('next'));
							}
							push(false,'params=false&next=false');
							window.location.href = next;
						}
						else{
							form
							.find('input[type="password"]')
							.removeAttr('disabled')
							.removeAttr('readonly')
							.addClass('is-danger')
							.focus();
						}
					}
				break;
			}
			$.ajax({
				url: base+'/cm/login.php',
				data: data,
				beforeSend:function(){
					form
					.find('[type="submit"]')
					.addClass('is-loading')
					.end()
					.find('input[type="password"]')
					.removeClass('is-danger')
					.attr('disabled','disabled');
				},
				success:function(r){
					return good(r);
				}
			});
		});
	});