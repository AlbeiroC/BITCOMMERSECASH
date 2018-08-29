<?php
include( './cm/functions.php');
if ($user = is_session()) {
	$need_show = 'cuenta,ajustes,bitsend,salir';
	if (is_grant('admin',$user['grants'])) {$need_show .= ',webmail'; }

	setcookie('init_log','1',time()+3600,'/');
	setcookie('user_login',$user['token'],time()+3600,'/');
	$_SESSION['user_login'] = $user['token'];
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
<br> <br>
<div class="container">
	<div class="columns">
		<div class="column is-offset-3-desktop is-offset-1-mobile is-half-desktop is-10-mobile">
			<div class="box">
				<!-- HEADER FORM_PAYMENT -->
				<div class="has-text-centered">
					<img data-src="https://assets.pcmag.com/media/images/482365-paypal-app.png?width=333&height=245" style="height:60px;width:60px;border:solid 4px #03A9F4;border-radius: 9999999999px;box-shadow: 0px 0px 8px #000;">
				</div>
				<!-- Fin HEADER FORM_PAYMENT -->
				
				<!-- BODY FORM_PAYMENT -->
				<div>
					<p class="has-text-centered">
						Paypal
					</p>
					<br>
					<form action="">
						<div class="columns">
							<div class="column is-6">
								<div class="field">
									<div class="control">
										<input type="text" class="input" placeholder="Cantidad">
									</div>
								</div>								
							</div>
						</div>
					</form>
					<?php
						// print_r(itemInfo($_GET['id'],false));
					?>
				</div>
				<!-- Fin BODY FORM_PAYMENT -->

			</div>
		</div>
	</div>
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






});
</script>
</body>
</html>