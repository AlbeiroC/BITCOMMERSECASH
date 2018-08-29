base = window.location.protocol+'//'+window.location.host;
$(function() {
	dataRefresh = function(){
		$session = (!empty(setCookie('user_login'))) ? setCookie('user_login') : 2;
		$.ajax({
			url: base+'/api_v2/user/info.php',
			type: 'get',
			buffer:false,
			data: {token: $session},
			success:function(r){
				btc_price = parseInt(r.btc.data.price);
				setCookie('btc_price',btc_price,parseInt($.now()+180));
				var toJSON = jsonToHTML('user','-',r);
				$.each(toJSON,function(index, el) {
					selector = (!index) ? false : '.'+index;
					$('input'+selector+',select'+selector+',textarea'+selector+',radio'+selector+',checkbox'+selector)
					.val(el);
					$('img'+selector)
					.attr('data-src',el);
					$(selector)
					.not('input,select,textarea,radio,checkbox,img')
					.html(el);
				});
				data_src();
			}
		});
	};
	dataRefresh();
});