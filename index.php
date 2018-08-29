<?php
include( './cm/function.beta.php');
if ($user = is_session()) {
	$need_show = 'bts,bts_trades,cuenta,ajustes,bitsend,salir';
	setcookie('init_log','1',time()+3600,'/');
	setcookie('user_login',$user['data']['user']['token'],time()+3600,'/');
	$_SESSION['user_login'] = $user['data']['user']['token'];
}
else{
	$need_show = 'facebook,instagram,ingresar';
}
?>
<!DOCTYPE html>
<html class="">
	<!-- Primera parte -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" 						content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta property="og:title"					content="BitCommerseCash">
		<meta property="og:image"					content="https://bitcommersecash.com/img/og/facebook_860x451.png">
		<meta property="og:description"				content="Bitcommercash es una pagina web de ventas online con excelente idea de negocio, basado en la implementacion de BTC como medio de pago." />
		<meta property="og:type"					content="article:published" />
		<meta property="og:url"						content="https://bitcommersecash.com/" />		
		
		<link rel="stylesheet"						hrf="https://www.jqueryscript.net/demo/Powerful-Lightweight-jQuery-Tag-Management-Plugin-tagEditor/jquery.tag-editor.css">
		<link rel="stylesheet"	type="text/css"		href="https://fonts.googleapis.com/css?family=Lobster">
		<link rel="stylesheet"	type="text/css"		href="./fonts/google.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/bulma-plugins.css">
		<link rel="stylesheet"	type="text/css"		href="./css/jquery.tipsy.css" />
		<link rel="stylesheet"	type="text/css"		href="./css/bulma.css">
		<link rel="stylesheet"	type="text/css"		href="./css/menu.css" />
		<link rel="icon" 		type="text/css"		href="./img/logo/favicon.png">
		<title>BitCommerseCash</title>
	</head>
	<!-- Primera parte -->
<body>
<?php include('./cm/nav.php'); ?>
<br><br>
<div class="container is-fluid">
	<?php 
		if (!empty($_SESSION['notification'])) {
			echo '<div class="notification is-'.$_SESSION['notification']['icon'].'"><button class="delete"></button>';
			echo urldecode($_SESSION['notification']['texto']);
			echo '</div>';
			unset($_SESSION['notification']);
		
		}
	?>
</div>
<br>


	
<div class="container is-body empty-body is-fluid has-text-light">
	<div class="columns is-multiline"></div>
</div>


<div class="container has-text-centered">
	<div class="columns" style="padding-top: 10px;padding-bottom: 10px;">
		<div class="column is-4-desktop is-offset-4-desktop is-full-mobile">
			<a href="#load_more">Cargar más</a>
		</div>
	</div>
	<br>
</div>


<script sync src="./js/cookie.js"></script>
<script sync src="./js/jquery-3.1.1.slim.min.js"></script>
<script sync src="./js/jquery.min.js"></script>
<script sync defer src="./js/fontawesome-all.min.js"></script>
<script sync src="./js/moment.min.js"></script>
<script sync src="./js/jquery.number.min.js"></script>
<script sync src="./js/popper.min.js"></script>
<script sync src="./js/jquery.tipsy.js"></script>
<script sync src="./js/functions.js"></script>
<script sync src="./js/plugins.js"></script>
<script sync src="./api_v2/user/info.js"></script>
<script sync src="./api_v2/items/items.js"></script>
<script	async>
$(function(){
	$('.is-body').cargarProductos();
	$(document)
	.on('click', '[href="#load_more"]', function(event) {
		event.preventDefault();
		$('.is-body').cargarProductos();
	});
});
</script>
</body>
</html>