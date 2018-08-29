<?php
include( './cm/functions.php');
$need_show = 'inicio,cuenta,salir';
 if ($user = is_session()) {
	if (is_grant('admin',$user['grants'])) {$need_show .= ',webmail'; }
	setcookie('init_log','1',time()+3600,'/');
	setcookie('user_login',$user['token'],time()+3600,'/');
	$_SESSION['user_login'] = $user['token'];
}
else{
	$need_show = 'inicio,facebook,instagram,ingresar';
}



$id = (!empty($_GET['id'])) ? base64_decode($_GET['id']) : false;
$_GET['id'] = $id;
$sql = "SELECT id FROM orden_de_compras WHERE md5(id) = '".$id."' LIMIT 1";
if ($res=$con->query($sql)) {
	if ($res->num_rows>0) {
		$_GET['id'] = $res->fetch_array(MYSQLI_ASSOC)['id'];
	}
	else{
		print_r("URL_NO_EXISTE");
		exit();
	}
}
else{
	print_r($con->error);
	exit();
}

$ticket = ticketDetails($_GET['id'], false);
?>
<!DOCTYPE html>
<html class="has-navbar-fixed-top">
<head>
	<!-- Primera parte -->
		<meta charset="utf-8">
		<meta name="viewport" 						content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta property="og:title"					content="BitCommerseCash">
		<meta property="og:image"					content="https://bitcommersecash.com/img/og/facebook_860x451.png">
		<meta property="og:description"				content="Bitcommercash es una pagina web de ventas online con excelente idea de negocio, basado en la implementacion de BTC como medio de pago." />
		<meta property="og:type"					content="article:published" />
		<meta property="og:url"						content="https://bitcommersecash.com/" />		
		
		<link rel="stylesheet"						hrf="https://www.jqueryscript.net/demo/Powerful-Lightweight-jQuery-Tag-Management-Plugin-tagEditor/jquery.tag-editor.css">
		<link rel="stylesheet"	type="text/css"		href="https://fonts.googleapis.com/css?family=Lobster">
		<link rel="stylesheet"	type="text/css"		href="./../fonts/google.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/select2.min.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/bulma-plugins.css">
		<link rel="stylesheet"	type="text/css"		href="./../css/jquery.tipsy.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/dropzone.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/easy-autocomplete.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/easy-autocomplete.themes.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/comentarios.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/jquery.dialog.css" />
		<link rel="stylesheet"	type="text/css"		href="./../css/bulma.css">
		<link rel="stylesheet"	type="text/css"		href="./../css/menu.css" />
		<link rel="icon" 		type="text/css"		href="./../img/logo/favicon.png">
		<title>BitCommerseCash</title>
	</head>
	<!-- Primera parte -->
<body>
	<?php include('./cm/nav.php'); ?>
<br>
<div class="container is-fluid">
	<div class="columns is-multiline">
		<div class="column is-8-desktop is-full-mobile">
			<?php
				if (!empty($_SESSION['notification'])) {
					echo '<div class="notification is-'.$_SESSION['notification']['icon'].'"><button class="delete"></button>';
					echo $_SESSION['notification']['texto'];
					echo '<br></div>';
					unset($_SESSION['notification']);
				}
			?>
			<div class="box is-hidden-desktop">
				<article class="media">
					<div class="media-left">
						<figure class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png" class="item-user-imagen">
						</figure>
					</div>
					<div class="media-content" style="height: auto;padding: 5px;">
						<div class="content" style="height: auto;">
							<p>
								<strong class="item-user-nombre"></strong> <small>@<span class="item-user-username"></span></small>
								<br>
								<span class="item-user-about"></span>
							</p>
						</div>
					</div>
				</article>
			</div>

			<div class="box" style="min-height: calc(100vh - 100px);position: relative;padding: 10px;">
				<div class="" style="display:;position:;padding:2px;font-size: 10pt;text-align: left;overflow:hidden;left: 10px;top: 10px;z-index: 9999999999999999999999;cursor: pointer;">
					<img src="" class="item-user-imagen" style="width: 20px;height: 20px;float: left;margin-left: 10px;margin-right: 10px;">
					<span class="item-user-nombre"></span>
				</div>
				<div class="newver notification is-link" style="display:none;position: absolute;padding:2px;font-size: 10pt;text-align: center;max-width: 30%;width: 30%;overflow:hidden;left: 35%;top: 3px;z-index: 9999999999999999999999;cursor: pointer;"></div>
				<div class="chat-content is_chat panel-chat-ticket-<?php echo $_GET['id']; ?> has-scroll is-link" style="background: #F7F6F6;position: absolute;height: calc(100% - 102px);width: 100%;left: 0px;top: 50px;overflow-y: auto;"></div>
				<div class="chat-input-content" style="position: absolute;width: 100%;height: 52px;padding:0px;background: #F7F7F8;bottom: 0px;left: 0px;border-radius: 0px 0px 5px 5px;border-top: solid 3px #39E6E0;">
					<form action="./api_v2/imbox/imbox.php" method="post" id="submit_imbox">
						<input name="imbox" type="hidden" value="<?php echo $_GET['id']; ?>" class="input" style="height: 30px;outline: none;box-shadow: none;border: solid 0px;border-bottom: solid 1px #d6d1d1;border-radius: 0px;background: none;color:#918e8e;font-weight: 500;">
						<input type="hidden" name="next" value="<?php echo urlencode(http().$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>">
						<input type="hidden" name="item" class="item-id">
						<input type="hidden" name="private" value="<?php $a = rand(2,49434039); $a = (is_int(($a/2))) ? $a : ($a+1); echo base64_encode($a); ?>">
						<input type="hidden" name="public" value="<?php $b = ($a*2.5); echo base64_encode($b); ?>">
						<input type="hidden" name="key_generated" value="<?php $c = ($b-$a); echo base64_encode($c); ?>">
						<div class="field has-addons">
							<div class="control is-expanded" style="padding:10px;">
								<input name="send" type="text" autocomplete="off" class="input" style="height: 30px;outline: none;box-shadow: none;border: solid 0px;border-bottom: solid 1px #d6d1d1;border-radius: 0px;background: none;color:#918e8e;font-weight: 500;">
							</div>
							<div class="control" style="padding:5px 10px 10px 0px;">
							<button type="submit" class="button is-link is-rounded has-text-centered" style="height: 40px;width: 40px;padding:4px;">
								<i class="fa fa-location-arrow" style="font-size: 13px;"></i>
							</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>

		<div class="column is-4-desktop is-full-mobile has-text-centered" style="right: 0px;">
			
			<div class="box is-hidden-mobile">
				<article class="media">
					<div class="media-left">
						<figure class="image is-64x64">
							<img src="https://bulma.io/images/placeholders/128x128.png" class="item-user-imagen">
						</figure>
					</div>
					<div class="media-content" style="height: auto;padding: 5px;">
						<div class="content" style="height: auto;">
							<p>
								<strong class="item-user-nombre"></strong> <small>@<span class="item-user-username"></span></small>
								<br>
								<span class="item-user-about"></span>
							</p>
						</div>
					</div>
				</article>
			</div>
			<?php
				if ($ticket['ticket']['status']=='pending') {
				?>
				<div class="box" style="margin-bottom: 0px;border-radius: 5px 5px 0px 0px;">
					<form action="/factura.php?id=<?php echo $_GET['id']; ?>" method="post">
						<input type="hidden" name="item" class="item-id_producto">
						<input type="hidden" name="private" value="<?php $a = rand(2,49434039); $a = (is_int(($a/2))) ? $a : ($a+1); echo base64_encode($a); ?>">
						<input type="hidden" name="public" value="<?php $b = ($a*2.5); echo base64_encode($b); ?>">
						<input type="hidden" name="key_generated" value="<?php $c = ($b-$a); echo base64_encode($c); ?>">
						<div class="field has-addons">
							<div class="control is-expanded">
								<center>
									<button type="submit" class="button is-danger is-rounded" style="width: 100%;">
										<span class="icon is-small">
											<i class="fab fa-bitcoin"></i>
										</span>
										<span class="item-precio_btc"></span>&nbsp;BTC
									</button>							
								</center>
							</div>
						</div>
					</form>
				</div>
				<div class="button is-info" style="margin-top: 0px;border-radius: 0px 0px 5px 5px;padding: 1.75rem;">
					<form action="" method="post">
						<input type="hidden" name="item" class="item-id_producto">
						<input type="hidden" name="private" value="<?php $a = rand(2,49434039); $a = (is_int(($a/2))) ? $a : ($a+1); echo base64_encode($a); ?>">
						<input type="hidden" name="public" value="<?php $b = ($a*2.5); echo base64_encode($b); ?>">
						<input type="hidden" name="key_generated" value="<?php $c = ($b-$a); echo base64_encode($c); ?>">
						<div class="field has-addons">
							<div class="control is-expanded">
								<center>
									<button type="submit" class="button is-info is-rounded" style="width: 100%;">
										<span class="icon is-small">
											<i class="far fa-file"></i>
										</span>
										<span>Reportar Pago</span>
									</button>
								</center>
							</div>
						</div>
					</form>
				</div>
				<?php
				}
			?>
		</div>
	</div>	
</div>


<script sync 		src="./../js/cookie.js"></script>
<script sync 		src="./../js/bulma-steps.min.js"></script>
<script sync 		src="./../js/jquery-3.1.1.slim.min.js"></script>
<script sync 		src="./../js/jquery.min.js"></script>
<script sync 		src="./../js/jquery.easy-autocomplete.js"></script>
<script sync 		src="./../js/jquery.dialog.js"></script>
<script sync defer	src="./../js/fontawesome-all.min.js"></script>
<script sync		src="./../js/moment.min.js"></script>
<script sync		src="./../js/moment-with-locales.min.js"></script>
<script sync		src="./../js/jquery.number.min.js"></script>
<script sync		src="./../js/popper.min.js"></script>
<script sync		src="./../js/jquery.tipsy.js"></script>
<script sync		src="./../js/functions.js"></script>
<script sync		src="./../js/plugins.js"></script>
<script sync		src="./../api_v2/user/info.js"></script>
<script sync		src="./../api_v2/items/items.js"></script>

<script	async>
	$(function () {
		id = "<?php echo $_GET['id']; ?>";

		$('.panel-chat-ticket-'+id).comentarios({
			url:"/api_v2/imbox/imbox.php",
			data:{
				imbox:id,
				order:"desc",
			},
			success:function (body,json) {
				console.log(json);
				$(body).scrollBottom(1,10);
			}
		});

		$(document)
		.on('submit', '#submit_imbox', function(event) {
			event.preventDefault();
			form = $(this);
			if (form.hasClass('no-ajax')) {return false;};
			$.ajax({
				url: window.location.protocol+'//'+window.location.host+'/api_v2/imbox/imbox.php',
				data: form.serialize(),
				beforeSend:function () {
					form
					.addClass('no-ajax')
					.find('[name="send"]')
					.attr('readonly', 'readonly')
					.end()
					.find('[type="submit"]')
					.addClass('is-loading');
				},
				success:function (r) {
					if (r.status=='success') {
						form
						.removeClass('no-ajax')
						.find('[name="send"]')
						.removeAttr('readonly')
						.end()
						.find('[type="submit"]')
						.removeClass('is-loading');
						html = $('body').comentarios('chat_template',r.data);
						$('[class*="panel-chat-ticket-"]').append(html);
					}
				}
			});
		});




		$.ajax({
			url: './../api_v2/imbox/imbox.php',
			data: {ticket: id},
			beforeSend:function () {},
			success:function (r) {
				if (r.status=='success'&&r.data.length>0) {
					item = r.data[0];
					$('.item-id_producto').val(item.id_producto);
					pbtc = item.precio_btc;
					$('.item-precio_btc').html(pbtc);
					
					// Armamos la tarjeta de presentacion correspondiente
					another = (item.item.is_my) ? item.buyer : item.seller;
					$($('title')[0]).html('Comprando - '+item.item.nombre);
					item_info = {};
					$.each(another,function(index, el) {
							$('.item-user-'+index)
							.not('img')
							.html(el)
							.val(el);
							$('img.item-user-'+index)
							.attr("data-src",el);
					});
					// Fin de Armamos la tarjeta de presentacion correspondiente
				}
				else{
					dialog.alert({
						message:'No pudimos conectar con la plataforma.',
						button:'Volver a cargar',
						callback:function () {
							window.location.reload();
						}
					});
				}

				return false;

			}
		});
	});
</script>


</body>
</html>