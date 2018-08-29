<?php
include( './cm/function.beta.php');

$user = is_session();

if (!empty($user['data']['user']['id'])) {
	$need_show = 'inicio,cuenta,salir';
	setcookie('init_log','1',strtotime("+1 hour"),'/');
	setcookie('user_login',$user['data']['user']['token'],strtotime("+1 hour"),'/');
	$_SESSION['user_login'] = $user['data']['user']['token'];
}
else{
	$need_show = 'inicio,facebook,instagram,ingresar';
}

if (!empty($_GET['id'])) {
	$item = itemInfo($_GET['id']);
	if (empty($item['item']['id'])) {
		echo "404";
		exit();
	}
}




if (!empty($user['data']['user']['id'])&&!empty($_POST['trp'])) {
	if (security(base64_decode($_POST['trp']))) {
		if (is_numeric($_POST['quanty'])&&$_POST['quanty']<=$item['item']['stock']) {
			$cantidad = $_POST['quanty'];
			$precio_usd = intval($item['item']['precioUSD']*$cantidad);
			$precio_btc = number_format(floatval($item['item']['precioBTC']*$cantidad), 8);
			$sql = "INSERT INTO orden_de_compras (user,id_producto,cantidad,precio_usd,precio_btc,status) VALUES ('".$user['data']['user']['id']."','".$item['item']['id']."','".$_POST['quanty']."','".$precio_usd."','".$precio_btc."','pending')";
			$con=connection();
			if ($con->query($sql)) {
				$_SESSION['notification'] = array(
					"icon"=>"link",
					"texto"=>'Se ha creado una factura a tu nombre, <a href="/contact/'.base64_encode(md5($con->insert_id)).'">Click aqui</a> para ingresar al panel de conversacion y negocio del producto.',
				);					
			}
			else{
				$_SESSION['notification'] = array(
					"icon"=>"danger",
					"texto"=>$con->error,
				);
			}
			$con->close();
		}
	}
}

?>
<!DOCTYPE html>
<html class="has-navbar-fixed-top">
<head>
	<!-- Primera parte -->
		<meta charset="utf-8">
		<meta name="viewport" 						content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta property="og:title"					content="<?php echo substr($item['item']['nombre'], 0 ,150); ?> en Bitcommersecash">
		<meta property="og:image"					content="https://rsz.io/<?php echo str_replace('http://','',str_replace('https://','',$item['item']['imagenes'][0])).'?w=300'; ?>">
		<meta property="og:description"				content="<?php echo substr($item['item']['descripcion'], 0 ,500); ?>" />
		<meta property="og:url"						content="https://bitcommersecash.com/view.php?id=<?php echo $item['item']['id']; ?>" />
		<meta property="og:type"					content="meli-ve:product"/>
		<meta property="fb:app_id"					content="359616804083790"/>

		<link rel="stylesheet"						hrf="https://www.jqueryscript.net/demo/Powerful-Lightweight-jQuery-Tag-Management-Plugin-tagEditor/jquery.tag-editor.css">
		<link rel="stylesheet"	type="text/css"		href="https://fonts.googleapis.com/css?family=Lobster">
		<link rel="stylesheet"	type="text/css"		href="./fonts/google.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/select2.min.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/bulma-plugins.css">
		<link rel="stylesheet"	type="text/css"		href="./css/jquery.tipsy.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/dropzone.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/easy-autocomplete.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/easy-autocomplete.themes.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/comentarios.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/jquery.dialog.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/bulma.css">
		<link rel="stylesheet"	type="text/css"		href="./css/menu.css" />
		<link rel="icon" 		type="text/css"		href="./img/logo/favicon.png">
		<title><?php echo (strlen($item['item']['nombre'])>70) ? substr($item['item']['nombre'], 0, 70).'...' : substr($item['item']['nombre'], 0, 70); ?> en Bitcommersecash</title>
	</head>
	<!-- Primera parte -->
<body>
	<?php include('./cm/nav.php'); ?>
<br>
<div class="container is-fluid">

	<div class="columns is-multiline">
		<div class="column is-8-desktop is-full-mobile">
			<div class="carousel"></div>
			<div class="box is-hidden-desktop">
				<div class="" style="padding-bottom: 25px;">
					<div class="boton-favorito item-id" id="" style="float: right;"></div>
					<span class="is-size-5 item-producto"></span>
					<div class="is-size-7 item-descripcion"></div>
					<div class="is-divider"></div>
					<form action="" method="post">
						<input type="hidden" name="item" class="item-id">
						<input type="hidden" name="trp" value="<?php echo base64_encode(security(true)); ?>">
						<div class="field has-addons">
							<div class="control is-expanded">
								<input type="text" class="input input-number input-number-without-zero" required="" name="quanty">
							</div>
							<div class="control">
								<button type="submit" class="button is-primary">
									<span>Comprar</span>
									<span class="icon is-small">
										<i class="fab fa-bitcoin"></i>
									</span>
								</button>							
							</div>
						</div>
					</form>
					<div class="has-text-grey-ligh is-size-7 has-text-left">Bitcommersecash garantiza seguridad en pagos con Bitcoin.</div>
				</div>
			</div>
			<?php
				if (!empty($_SESSION['notification'])) {
					echo '<div class="notification is-'.$_SESSION['notification']['icon'].'"><button class="delete"></button>';
					echo $_SESSION['notification']['texto'];
					echo '<br></div>';
					unset($_SESSION['notification']);
				}
			?>
			<div class="column is-full show-on-login" style="display:;">
				<div class="box">
					<div style="position: relative;">
						<form action="./api_v2/items/items.php" method="post" class="form-comment">
							<input type="hidden" class="item-id" name="post" value="">
							<input type="hidden" name="redirect" value="<?php echo urlencode(host('url').$_SERVER['REQUEST_URI']); ?>">
							<textarea name="send" class="textarea share-comment"></textarea>
							<button style="position: absolute;bottom: 0px;right: 0px;" class="button is-link">Comentar</button>
						</form>
					</div>
				</div>
			</div>
			<div class="column is-full is-comentarios <?php echo 'coments-list-'.$_GET['id']; ?>"></div>
			<div class="box has-text-centered">
				<a href="#" target-comments=".is-comentarios"></a>
			</div>
			<div class="column is-full">
				<div class="has-text-centered"><a class="refresh-comentarios-target" target=".is-comentarios"></a></div>
			</div>
		</div>

		<div class="column is-4-desktop is-full-mobile has-text-centered" style="right: 0px;">
			<div class="box is-hidden-mobile">
				<div class="" style="padding-bottom: 25px;">
					<div class="boton-favorito item-id" id="" style="float: right;"></div>
					<span class="is-size-5 item-producto"></span>
					<div class="is-size-7 item-descripcion"></div>
					<div class="is-divider"></div>
					<form action="" method="post">
						<input type="hidden" name="item" class="item-id">
						<input type="hidden" name="trp" value="<?php echo base64_encode(security(true)); ?>">
						<div class="field has-addons">
							<div class="control is-expanded">
								<input type="text" class="input input-number input-number-without-zero" required="" name="quanty">
							</div>
							<div class="control">
								<button type="submit" class="button is-primary">
									<span>Comprar</span>
									<span class="icon is-small">
										<i class="fab fa-bitcoin"></i>
									</span>
								</button>							
							</div>
						</div>
					</form>
					<div class="has-text-grey-ligh is-size-7 has-text-left">Bitcommersecash garantiza seguridad en pagos con Bitcoin.</div>
				</div>
			</div>
			<div class="box">				
				<!-- Tarjeta del Vendedor -->
				<div class="is-hiddens">
					<img data-src="" data-style='{"background-size":"cover"}' alt="" class="item-user-imagen" style="width: 100%;max-width:100px;height: 100px;border-radius: 9999999px;">
					<div class="item-user-nombre is-size-5 has-text-centered"></div>
					<div class="item-user-about has-text-centered"></div>
					<br>
					<div class="has-text-centered">
						<span class="item-user-btc-price has-text-link"></span> USD / BTC 
					</div>
					<div class="is-divider"></div>
				</div>
				<!-- Fin de Tarjeta del Vendedor -->
				<div class="is-hidden-mobile">
					<img data-src="<?php echo host('url'); ?>img/logo/logo_banner.png" data-style='{"background-size":"cover"}' style="width: 100%;height: auto;background-size: cover;">
				</div>
			</div>
		</div>

	</div>	
</div>


<script sync src="./js/cookie.js"></script>
<script sync src="./js/bulma-steps.min.js"></script>
<script sync src="./js/jquery-3.1.1.slim.min.js"></script>
<script sync src="./js/jquery.min.js"></script>
<script sync src="./js/jquery.easy-autocomplete.js"></script>
<script sync src="./js/jquery.dialog.js"></script>

<script sync defer src="./js/fontawesome-all.min.js"></script>
<script sync src="./js/moment.min.js"></script>
<script sync src="./js/moment-with-locales.min.js"></script>
<script sync src="./js/jquery.number.min.js"></script>
<script sync src="./js/popper.min.js"></script>
<script sync src="./js/jquery.tipsy.js"></script>
<script sync src="./js/functions.js"></script>
<script sync src="./js/plugins.js"></script>
<script sync src="./api_v2/user/info.js"></script>
<script sync src="./api_v2/items/items.js"></script>

<script	async>
	$(function(){
		$item = <?php echo (!empty($_GET['id'])) ? $_GET['id'] : 'false'; ?>;
		if (empty($item)) {
			dialog.alert({
				message:"El producto indicado no se encuentra registrado",
				callback:function () {
					window.location.href = '';
				}
			});
			return;
		}
		$.ajax({
			url: './api_v2/items/items.php',
			data: {item: $item},
			beforeSend:function(){},
			success:function (json) {
				images = json.item.imagenes.join('[EXPLODE_IMAGES]');
				$('.carousel')
				.attr('img-json',images)
				.carousel();
				$('.item-id').val(json.item.id);
				$('.item-producto').html(json.item.nombre);
				$('.item-descripcion').html(json.item.descripcion);
				$('.item-precio_usd').html(json.item.precioUSD);
				$('.item-precio_btc').html(json.item.precioBTC);
				$('.item-id')
				.addClass(function () {
					return (json.item.is_fav==true) ? 'trusted' : false;
				})
				.attr('id',json.item.id);
			}
		});
		$('.is-comentarios').comentarios({
			data:{comments:$item},
		});
		$(document)
		.on('click', '[target-comments=".is-comentarios"]', function(event) {
			event.preventDefault();
			$('.is-comentarios').comentarios({
				data:{comments:$item},
			});
		});
	});
</script>
</body>
</html>