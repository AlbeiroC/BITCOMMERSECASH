$(function() {
	dataRefresh = function(){
		$('[class*="coments-panel-"]:visible').each(function(index, el) {
			id = $(this).find('.is_chat').attr('class').replace(/^(.*)coments\-list\-(\d+)(.*)$/gi,"$2");
			$(this).find('.is_chat').comentarios({
													data:{
														comments:id,
														encode:true,
													},
													direction:'down',
													scroll:false,
													index:'auto',
													preppend:false,
												});
		});
		$session = 2;
		if (!empty(setCookie('user_login'))) {
			$session = setCookie('user_login');
		}
		else{
			// setTimeout(function () {
			// 	dataRefresh();
			// },10000);
			// return false;
		}
		clearTimeout(clockUser);
		$.ajax({
			url: './api_v1/user/info.php',
			type: 'get',
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
			data: {token: $session},
			success:function(r){
				p = (r.btc.price) ? r.btc.price : 0;
				p = new String(p);
				setCookie('btc_price',p,($.now()+60000));
				if (r.type=='error') {
					$('.show-on-login').hide(10);
					return (r.url.indexOf('login')>=0) ? window.location.href = r.url : false;
				}
				$('.show-on-login').show(10);
				var response = [];
				i = 0;
				$.each(r,function(index, val) {
					if (index.indexOf('_')>=0) {
						n = index.split('_');
						nombre = n[0];
						valor = n[1];
						if (typeof response[nombre] != 'object') {
							response[nombre] = {};
						}
						response[nombre][valor] = val;
						i++;
					}
					else{
						response[index] = val;
					}
				});
				r = response;
				newItemsUpload = {
					url: "./api_v1/upload/upload_temp.php",
					maxFilesize:1,
					maxFiles: r.grants.max_item.image,
					acceptedFiles:'image/*',
					params:{
						key:key
					}
				};
				if ($('.product-picture-zone')[0]&&!$('.product-picture-zone').find('*')[0]) {
					new Dropzone(".product-picture-zone", newItemsUpload);	
				}
				$('.btc-usd-price').val(r.btc.price).html(r.btc.price);
				if (r.user.id==null) {
					unsetcookie('user_login');
					window.location.href = '/login?next='+encodeURI(window.location.pathname);
					return;
				}
				$.each(r.user,function(index, val) {
					$('img.user-'+index).attr({
						'data-src':val,
						'json-show':val
					});
					$('.user-'+index)
					.not('.changed-info-ajax')
					.not('img')
					.val(val)
					.html(val);
					$('.user-'+index+'.no-changeable')
					.addClass('changed-info-ajax')
					.removeClass('no-changeable');
				});
				$.each(r.imbox,function(index, val) {
					$('img.imbox-'+index).attr('data-src',val);
					$('.imbox-'+index)
					.not('img')
					.val(val)
					.html(val);
				});
				$.each(r.comentarios,function(index, val) {
					$('img.comentarios-'+index).attr('data-src',val);
					$('.comentarios-'+index)
					.not('img')
					.val(val)
					.html(val);
				});
				$.each(r.favoritos,function(index, val) {
					$('img.favoritos-'+index).attr('data-src',val);
					$('.favoritos-'+index)
					.not('img')
					.val(val)
					.html(val);
				});
				$.each(r.balance,function(index, val) {
					$('img.balance-'+index).attr('data-src',val);
					$('.balance-'+index)
					.not('img')
					.val(val)
					.html(val);
				});
				$.each(r.pais,function(index, val) {
					$('img.pais-'+index).attr({
						'data-src':val,
						'json-show':val
					});
					$('.pais-'+index)
					.not('.changed-info-ajax')
					.not('img')
					.val(val)
					.html(val);
					$('.pais-'+index+'.no-changeable')
					.addClass('changed-info-ajax')
					.removeClass('no-changeable');
				});
				$.each(r.productos,function(index, val) {
					$('img.productos-'+index).attr('data-src',val);
					$('.productos-'+index)
					.not('img')
					.val(val)
					.html(val);
				});
				data_src();
				$('.user-card').fadeIn();
				clockUser = setTimeout(function () {
					dataRefresh();
				},5000);
			}
		});
	};
	clockUser = setTimeout(function () {
		dataRefresh();
	},10);
});