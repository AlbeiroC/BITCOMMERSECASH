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


if (!empty($_POST['confirmed'])) {
	header('Content-type: text/json');
	$ticket = ticketDetails($_POST['confirmed'], false);
	$r = array(
		"status"=>"error",
		"confirmed"=>"false",
		"imbox"=>base64_encode(md5($ticket['ticket']['id'])),
		"data"=>array(
			"available_balance"=>"0.00000000",
		)
	);
	if (!empty($ticket['seller'])) {
		$sql = "SELECT * FROM wallets WHERE TRIM(direccion) = TRIM('".$ticket['ticket']['wallet']."') LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$wallet = $res->fetch_array(MYSQLI_ASSOC);
				$api_key = $wallet['api_key'];
				$url = 'https://block.io/api/v2/get_address_balance/?api_key='.$api_key.'&addresses='.$wallet['direccion'];
				$json = json_decode(getURL($url), true);
				if ($json['status']=='success') {
					$r['status'] = 'success';
					$r['data'] = $json['data'];
				}
			}
		}
	}
	if (floatval($r['data']['available_balance'])>=$ticket['ticket']['precio_btc']) {
		$sql = "UPDATE orden_de_compras SET status = 'finish' WHERE id = '".$ticket['ticket']['id']."'";
		if ($con->query($sql)) {$r['confirmed']='true'; }
		$sql = "UPDATE wallets SET user = '".$ticket['seller']['user_id']."',balance = '".floatval($r['data']['available_balance'])."' WHERE TRIM(direccion) = '".$ticket['ticket']['wallet']."'";
		if ($con->query($sql)) {}
	}
	print_r(json_encode($r, JSON_PRETTY_PRINT));
	exit();
}
if (!empty($_POST['private'])&&!empty($_POST['public'])&&!empty($_POST['key_generated'])&&!empty($_POST['item'])) {
	$private = base64_decode($_POST['private']);
	$public = base64_decode($_POST['public']);
	$key_generated = base64_decode($_POST['key_generated']);
	$validate = (($public/2.5)==$private&&(($public-$private)==$key_generated)) ? true : false;
	if (!empty($validate)) {
		$item = itemInfo($_POST['item'], false);
		$ticket = ticketDetails($_GET['id'], false);
		if ($ticket['ticket']['status']=='pending') {
			$wallet = $ticket['ticket']['wallet'];
			if (empty($wallet)||$wallet=='0'||strlen($wallet)<=10) {
				$sql = "SELECT * FROM wallets WHERE user = 0 OR user = 'false' ORDER BY RAND() LIMIT 1";
				if ($res=$con->query($sql)) {
					$wallet = $res->fetch_array(MYSQLI_ASSOC);
					$sql = "UPDATE wallets SET user = '".$ticket['seller']['user_id']."' WHERE id = '".$wallet['id']."'";
					if ($res=$con->query($sql)) {$wallet = $wallet['direccion']; }
					$sql = "UPDATE orden_de_compras SET wallet = '".$wallet."' WHERE id = '".$ticket['id']."'";
					if ($res=$con->query($sql)) {}
				}
				else{
					echo "Error: ".$con->error;
				}
			}
		}
	}
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

<div class="container">
	<div class="columns is-multiline is-mobile">
		<div class="column is-half-desktop is-8-mobile is-offset-2-mobile is-offset-3-desktop">
			<center>
				<img src="./img/logo/logo_brand_inverse.png" style="max-height: 100px;">
			</center>
			<div class="box">
				<center>
					<img data-src="https://blockchain.info/es/qr?data=<?php echo $ticket['ticket']['wallet']; ?>&size=200" style="height: 100px;width: auto;">
				</center>
				<br>
				Para completar el pago de tu factura debes enviar <b><?php echo $ticket['item']['precio_btc']; ?></b> a la siguiente direccion:
				<br>
				<div class="field has-addons">
					<div class="control">
						<input type="text" class="input has-text-centered" readonly="" value="<?php echo $ticket['ticket']['wallet']; ?>">
					</div>
					<div class="control">
						<button class="button" data-clipboard-target="#foo">
						    <img data-src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" style="width: 20px;height: 20px;">
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script sync 		src="./../js/cookie.js"></script>
<script sync 		src="./../js/bulma-steps.min.js"></script>
<script sync 		src="./../js/jquery-3.1.1.slim.min.js"></script>
<script sync 		src="./../js/jquery.min.js"></script>
<script sync 		src="https://clipboardjs.com/dist/clipboard.min.js"></script>

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

	function confirmPayment(id='<?php echo $ticket['ticket']['id']; ?>') {
			$.ajax({
				url: '',
				type: 'post',
				data: {confirmed: id},
				error:function (err) {
					console.log(err);
				},
				success:function (r) {
					if (r.confirmed=='true') {
						dialog.alert({
							message:'El pago se ha recibido exitosamente y ha sido abonado a la cuenta del vendedor.',
							button:'Cerrar',
							callback:function (e) {
								window.location.href = '/contact/'+r.imbox;
							}
						});
					}
					setTimeout(function () {
						confirmPayment(id);
					},60000);
				}
			});
	}

	$(function () {
		confirmPayment();
	});
</script>


</body>
</html>