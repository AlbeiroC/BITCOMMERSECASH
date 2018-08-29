<?php
include( './cm/function.beta.php');
$need_show = 'inicio,facebook,instagram';
if (is_session()) {
	header('Location: profile');
	exit();
}
else if (!empty($_GET['u'])&&!empty($_GET['trp'])&&security(base64_decode($_GET['trp']))) {
	$user = userInfo($_GET['u']);
	if (!empty($user['data']['user']['id'])) {
		$sql = "UPDATE users SET status = 'active' WHERE id = '".$_GET['u']."'";
		$con = connection();
		if ($con->query($sql)) {
			$data = $user['data']['user'];
			$token = md5($data['id']).rand().time();
			$sql = "INSERT INTO tokens (user,token,type,fecha) VALUES ('".$data['id']."','".$token."','sesion',fecha)";
			if ($con->query($sql)) {}
			setcookie('init_log','1',time()+3600,'/');
			setcookie('user_login',$token,time()+3600,'/');
			$_SESSION['user_login'] = $token;
		}
		$con->close();
	}
	if (!empty($true)) {
		header('Location: profile');
		exit();
	}
}
setcookie('init_log','',strtotime("-10 year"),'/');
setcookie('user_login',"",strtotime("-10 year"),'/');
unset($_SESSION['user_login']);
?>
<!DOCTYPE html>
<html class="">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta property="og:title"		content="BitCommerseCash">
	<meta property="og:image"		content="https://bitcommersecash.com/img/og/facebook_860x451.png">
	<meta property="og:description"	content="Bitcommercash es una pagina web de ventas online con excelente idea de negocio, basado en la implementacion de BTC como medio de pago." />
	<meta property="og:type"		content="article:published" />
	<meta property="og:url"			content="https://bitcommersecash.com/" />

	<link rel="icon" 		type="text/css"	href="./img/logo/favicon.png">
	<link rel="stylesheet"	type="text/css"	href="https://fonts.googleapis.com/css?family=Lobster">
	<link rel="stylesheet"	type="text/css"	href="./fonts/google.css"/>
	<link rel="stylesheet"	type="text/css"	href="./css/jquery.tipsy.css" />
	<link rel="stylesheet"	type="text/css"	href="./css/menu.css" />
	<link rel="stylesheet"	type="text/css"	href="./css/select2.min.css"/>
	<link rel="stylesheet"	type="text/css"	href="./fonts/google.css"/>
	<link rel="stylesheet"	type="text/css"	href="./css/bulma.css">
	<title>BitCommerseCash</title>
	<style> html, body {min-height: 100vh; background: #F0F0F0;} </style>
</head>
<body>
	<?php include('./cm/nav.php'); ?>
	<br><br><br>
	<div class="container is-body has-text-light"><br>
		<div class="columns">
			<div class="column is-4-desktop is-offset-4-desktop is-4-tablet is-10-mobile is-offset-1-mobile is-4-tablet" style="float:left;">
				<?php 
					if (!empty($_SESSION['notification'])) {
						echo '<div class="notification is-'.$_SESSION['notification']['icon'].'"><button class="delete"></button>';
						echo urldecode($_SESSION['notification']['texto']);
						echo '</div>';
						unset($_SESSION['notification']);
					}
				?>
				<div class="box-form" style="display: none;">
					<form action="./api_v2/login/login.php" class="form-login" method="post">
						<center>
							<img data-src="./img/logo/icon_inverse.png" width="60px" height="60px" data-style='{"max-height":"60px","border":"solid 1px #ccc","border-radius":"10px","background-color":"#fff"}'>
							<br>
							<div class="field">
								<div class="control has-icons-left has-icons-right">
								<input type="hidden" name="user-check" value="">
								<input class="input" type="text" placeholder="Correo Electronico" name="username" autocomplete="off" autofocus="">
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
								</div>
							</div>
							<div class="field">
								<div class="control has-icons-left has-icons-right">
								<input class="input" type="password" name="password" autocomplete="off">
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
								</div>
							</div>
							<div class="columns">
							<div class="column" style="width: 50%;">
								<button class="button is-primary" type="submit" style="width: 100%;">
									<i class="far fa-arrow-alt-circle-right"></i>&nbsp;Entrar
								</button>
							</div>
							</div>
							<div class="columns">
								<div class="column">
									<a href="register?ref=login_btn">Soy nuevo</a>
								</div>
							</div>
						</center>
					</form>
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
<script sync src="./api_v2/login/login.js"></script>
<script sync src="./api_v2/items/items.js"></script>
<script	async>
$(function(){
	$(window).on('resize', function(event) {
		if ($(window).width()<=500) {
			$('.box-form').removeClass('box').fadeIn('slow');
		}
		else{
			$('.box-form').addClass('box').fadeIn('slow');
		}
	});
	if ($(window).width()<=500) {
		$('.box-form').fadeIn('slow');
	}
	else{
		$('.box-form').addClass('box').fadeIn('slow');
	}

});


	</script>
</body>
</html>