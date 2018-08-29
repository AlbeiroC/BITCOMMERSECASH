<?php
include './cm/function.beta.php';
$need_show = 'inicio,ingresar';
$con       = connection();
if (is_session()) {
	$error = '';
	if (!empty($_GET['error'])) {
		$error = '?error=' . $_GET['error'];
	}
	header('Location: profile' . $error);
	exit();
}

$paises = array(0 =>
array(
	"value" => "null",
	"html"  => "Sin resultados",
));
if ($res = $con->query("SELECT * FROM paises")) {
	if ($res->num_rows > 0) {
		$paises = array();
		while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
			$paises[] = array(
				"value" => $data['iso3'],
				"html"  => $data['pais'],
			);
		}
	}
} else {
	$paises = array(0 => array(
		"value" => "null",
		"html"  => "Sin conexion con el servidor",
	));
}


?>
<!DOCTYPE html>
<html class="">
	<head>
		<meta charset="utf-8">
			<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
				<meta content="BitCommerseCash" property="og:title">
					<meta content="https://bitcommersecash.com/img/og/facebook_860x451.png" property="og:image">
						<meta content="Bitcommercash es una pagina web de ventas online con excelente idea de negocio, basado en la implementacion de BTC como medio de pago." property="og:description"/>
						<meta content="article:published" property="og:type"/>
						<meta content="https://bitcommersecash.com/" property="og:url"/>
						<link href="./img/logo/favicon.png" rel="icon" type="text/css">
							<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
								<link href="./fonts/google.css" rel="stylesheet" type="text/css"/>
								<link href="./css/jquery.tipsy.css" rel="stylesheet" type="text/css"/>
								<link href="./css/menu.css" rel="stylesheet" type="text/css"/>
								<link href="./css/select2.min.css" rel="stylesheet" type="text/css"/>
								<link href="./fonts/google.css" rel="stylesheet" type="text/css"/>
								<link href="./css/bulma.css" rel="stylesheet" type="text/css">
									<link href="./css/croppie.css" rel="stylesheet" type="text/css">
										<title>
											BitCommerseCash
										</title>
										<style>
											html, body {min-height: 100vh; background: rgb(63,76,107); background: -webkit-linear-gradient(rgba(63,76,107,1) 0%, rgba(63,76,107,1) 100%); background: -o-linear-gradient(rgba(63,76,107,1) 0%, rgba(63,76,107,1) 100%); background: linear-gradient(rgba(63,76,107,1) 0%, rgba(63,76,107,1) 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3f4c6b', endColorstr='#3f4c6b',GradientType=0 ); }
										</style>
									</link>
								</link>
							</link>
						</link>
					</meta>
				</meta>
			</meta>
		</meta>
	</head>
	<body>
		<?php
include './cm/nav.php';
echo "<br>
		";
if (!empty($_SESSION['notification'])) {
	echo '
		<div class="notification is-' . $_SESSION['notification']['icon'] . '">
			<button class="delete">
			</button>
			';
	echo urldecode($_SESSION['notification']['texto']);
	echo '
		</div>
		';
	unset($_SESSION['notification']);
}
?>
		<div class="container">
			<style>
	html,body{
		height: calc(100vh);
		background: #EDEDED;
	}
/*form styles*/
#msform {
	width: 400px;
	margin: 50px auto;
	text-align: center;
	position: relative;
}
#msform fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 12px 2px rgba(0, 0, 0, 0.2);
	padding: 20px 30px;
	box-sizing: border-box;
	width: 80%;
	margin: 0 10%;
	/*stacking fieldsets above each other*/
	position: relative;
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
	display: none;
}
/*buttons*/
#msform .action-button {
	width: 100px;
	background: #27AE60;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
}
/*headings*/
.fs-title {
	font-size: 15px;
	text-transform: uppercase;
	color: #2C3E50;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 13px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: white;
	text-transform: uppercase;
	font-size: 9px;
	width: 33.33%;
	float: left;
	position: relative;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none;
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #27AE60;
	color: white;
}

.button-target{
	position: relative;
	width: 200px;
	height: 200px;
	border: dashed 1px #ccc;
	cursor: pointer;
	border-radius: 5px;
}
#msform fieldset.done {
	display: block !important;
	position: fixed;
	left: -200vw;
	top: -200vh;
}
			</style>
			<!-- multistep form -->
			<form id="msform">
				<?php
					$security = security(true);
					echo '<input type="hidden" name="trp" value="'.$security.'">';
				?>
				<fieldset>
					<div class="field">
						<div class="control has-icons-right">
							<input autocomplete="new-username" class="input" name="username" placeholder="Usuario" required="required" type="text">
						</div>
						<br>
						<div class="control has-icons-right">
							<input class="input" name="email" placeholder="Email" required="required" type="email">
						</div>
					</div>
					<a class="button next is-link" disabled="disabled" href="#contact"> Siguiente </a>
				</fieldset>
				<fieldset>
					<div class="field">
						<div class="control has-icons-right">
							<input autocomplete="new-username" class="input" name="nombre" placeholder="Nombre para mostrar" required="required" type="text">
						</div>
						<div class="control">
							<textarea class="textarea" maxlength="500" name="about" placeholder="Hablamos de ti" style="resize: none;"></textarea>
						</div>
					</div>
					<a class="button previous" href="#about"> Volver </a>
					<a class="button next is-link" disabled="disabled" href="#contact"> Siguiente </a>
				</fieldset>
				<fieldset>
					<div class="field">
						<div class="control has-icons-right">
							<input class="input" name="password" placeholder="Clave" required="required" type="password">
							<br>
							<progress class="progress" value="0" max="100" style="margin:10px 0px 20px 0px;"></progress>
						</div>
						<div class="control has-icons-right">
							<input class="input" name="repassword" placeholder="Repetir Clave" required="required" type="password">
						</div>
					</div>
					<button class="button is-link" disabled="disabled" type="submit"> Registrarme </button>
				</fieldset>
			</form>
		</div>
		<script defer="" src="./js/fontawesome-all.min.js" sync=""></script>
		<script src="./js/cookie.js" sync=""></script>
		<script src="./js/jquery-3.1.1.slim.min.js" sync=""></script>
		<script src="./js/jquery.min.js" sync=""></script>
		<script src="./js/jquery-ui.min.js" sybc=""></script>
		<script src="./js/moment.min.js" sync=""></script>
		<script src="./js/jquery.number.min.js" sync=""></script>
		<script src="./js/popper.min.js" sync=""></script>
		<script src="./js/jquery.tipsy.js" sync=""></script>
		<script src="./js/croppie.js" sync=""></script>
		<script src="./js/functions.js" sync=""></script>
		<script src="./js/plugins.js" sync=""></script>
		<script async="">
			function reset() {
				$('#msform').unbind('submit');
				$('#msform')
				.find('fieldset')
				.removeAttr('style')
				.removeAttr('dtr-style')
				.removeClass('done');
			}
			$(function () {
				//jQuery time
				var current_fs, next_fs, previous_fs; //fieldsets
				var left, opacity, scale; //fieldset properties which we will animate
				var animating; //flag to prevent quick multi-click glitches
				$('#msform').unbind('submit');
				$(document)
				.on('submit', '#msform', function(event) {
					event.preventDefault();
					form = $(this);
					$('#msform')
					.find('fieldset:not(:last-of-type)')
					.each(function(index, el) {
						$(this).attr('dtr-style',$(this).attr('style'));
					})
					.addClass('done');
					$.ajax({
						url: './api_v2/login/login.php',
						buffer:false,
						type: 'post',
						data: form.serialize(),
						error:function(err) {
							console.log(err);
						},
						success:function(json){
							if (json.type!='error') {
								form
								.find('fieldset')
								.last()
								.hide()
								.after('<div class="box"><span class="icon is-large"><span class="fa fa-check-circle has-text-success fa-3x"></span></span><br /> <center>Exitoso, ahora verifica tu correo electronico.</center></div>');
							}
							else{
								s = json.response.split('_');
								input = form.find('[name="'+s[0]+'"]');
								fieldset = input.parents('fieldset');
								response = s[1];
								form
								.find('fieldset')
								.removeAttr('style')
								.removeAttr('dtr-style')
								.removeClass('done')
								.css('display','none');
								fieldset.css('display','block');
								ntf = (input.parent().find('small')[0]) ? input.parent().find('small') : false;
								ntf = (!ntf&&input.parent().append('<br /> <small></small>')) ? input.parent().find('small') : ntf;
								input
								.addClass('is-danger')
								.focus()
								.parents('fieldsets')
								.find('.next,[type="submit"]')
								.attr(disabled);
								ntf.addClass('has-text-danger').html(response);
							}
						}
					});
				})
				.on('keyup', '[name]', function(event) {
					event.preventDefault();
					input = $(this);
					ntf = (input.parent().find('small')[0]) ? input.parent().find('small') : false;
					ntf = (!ntf&&input.parent().append('<br /> <small></small>')) ? input.parent().find('small') : ntf;
					$('#msform')
					.find('fieldset')
					.each(function(index, el) {
						$(this).attr('style',$(this).attr('dtr-style'));
					})
					.removeClass('done');
					str = {
						value:input.val().trim(),
						keychars:input.val().replace(/(\d+)/gi,'').replace(/(\w+)/gi,'').trim(),
						number:input.val().replace(/(\D+)/gi,'').trim(),
						string:input.val().replace(/(\d+)/gi,'').trim(),
						lower:input.val().trim().toLowerCase(),
						upper:input.val().trim().toUpperCase(),
						first:ucfirst(input.val().trim()),
						words:ucwords(input.val().trim()),
					};
					exist = function (f,v) {
						ex = $.ajax({
							buffer:false,
							url: './api_v2/login/login.php',
							async:false,
							data: {validate: f,value:v},
							success:function (er) {
								ex = er;
							},
						})
						.always(function(){
							$('body').find('.loading-buffer,.buffer-btn').remove();
						});
						return !isNaN(parseInt(ex.responseText));
					};
					disabled = function(i,s=true){
						$(i).toggleClass('is-danger',s);
						h = ($(i).parents('fieldset').find('[required],.is-danger').filter(function() { return (($(this).val().length<=0)||$(this).hasClass('is-danger')); }).length>0);
						$(i).parents('fieldset')
						.find('.next,[type="submit"]')
						.attr('disabled', h);
					};
					ds = true;/*Desactivar los botones*/
					if (input.is('[name="username"]')) {
						len = (str.value.length>=5); /*TRUE*/
						char = (str.keychars.length>0); /*FALSE*/
						if (!len) {ntf.addClass('has-text-danger').html('5 caracteres minimo.');ds = true; }
						else if (char) {ntf.addClass('has-text-danger').html('Solo letras y numeros.');ds = true; }
						else if (exist('username',str.value)) {ntf.addClass('has-text-danger').html('Este usuario ya existe.');ds = true; }
						else {ntf.prev('br').remove();ntf.remove();ds=false;}
						disabled(input,ds);
					}
					else if (input.is('[name="email"]')) {
						len = (str.value.length>=5); /*TRUE*/
						char = (isEmail(str.value)); /*TRUE*/
						if (!len) {ntf.addClass('has-text-danger').html('5 caracteres minimo.');ds = true; }
						else if (!char) {ntf.addClass('has-text-danger').html('Email incorrecto.');ds = true; }
						else if (exist('email',str.value)) {ntf.addClass('has-text-danger').html('Este usuario ya existe.');ds = true; }
						else {ntf.prev('br').remove();ntf.remove();ds=false;}
						disabled(input,ds);
					}
					else if (input.is('[name="nombre"]')) {
						len = (str.value.length>=5); /*TRUE*/
						char = (str.keychars.length>0); /*FALSE*/
						if (!len) {ntf.addClass('has-text-danger').html('5 caracteres minimo.');ds = true; }
						else if (char) {ntf.addClass('has-text-danger').html('Solo letras y numeros.');ds = true; }
						else {ntf.prev('br').remove();ntf.remove();ds=false;}
						disabled(input,ds);
					}
					else if (input.is('[name="about"]')) {
						len = (str.value.length<=160); /*TRUE*/
						char = (str.keychars.length>0); /*FALSE*/
						if (char) {ntf.addClass('has-text-danger').html('Solo letras y numeros.');ds = true; }
						else if (!len) {ntf.addClass('has-text-danger').html('160 caracteres maximo.');ds = true; }
						else {ntf.prev('br').remove();ntf.remove();ds=false;}
						disabled(input,ds);
					}
					
					else if (input.is('[name="password"]')) {
						len = (str.value.length>=5);
						char = (str.keychars.length>0);
						numbers = (str.number.length>0);
						strings = (str.string.length>0);
						level = 0;
						level = (len) ? (level+25) : level;
						level = (len&&char) ? (level+25) : level;
						level = (len&&numbers) ? (level+25) : level;
						level = (len&&strings) ? (level+25) : level;
						cls = 'is-danger';
						cls = (level>0&&level<=50) ? 'is-warning' : cls;
						cls = (level>50&&level<=75) ? 'is-link' : cls;
						cls = (level>75) ? 'is-success' : cls;
						input
						.parent()
						.find('progress')
						.removeClass('is-danger')
						.removeClass('is-warning')
						.removeClass('is-link')
						.removeClass('is-success')
						.addClass(cls)
						.val(level);
						if (len){ntf.prev('br').remove();ntf.remove();ds=false;}
						disabled(input,ds);
					}
					else if (input.is('[name="repassword"]')) {
						pr = input.parents('form').find('[name="password"]').val();
						ds = true;
						ds = (pr.length>=5&&str.value.length>=5&&str.value===pr) ? false : ds;
						disabled(input,ds);
					}
				})
				.on('click', '.next', function(event) {
					event.preventDefault();
					animating = false;
					$(this)
					.parents('fieldset')
					.find('[required]')
					.each(function(index, el) {
						if ($(this).val().trim().length<=0||$(this).hasClass('is-danger')) {
							animating = true;
						}
					});
					if(animating==true){
						animating=false;
						$(this).attr('disabled',true);
						return false;
					};
					animating = true;
					$(this).attr('disabled',!animating);

					current_fs = $(this).parent();
					next_fs = $(this).parent().next();
					//activate next step on progressbar using the index of next_fs
					$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
					//show the next fieldset
					next_fs.show();
					//hide the current fieldset with style
					current_fs.animate({opacity: 0}, {
						step: function(now, mx) {
							//as the opacity of current_fs reduces to 0 - stored in "now"
							//1. scale current_fs down to 80%
							scale = 1 - (1 - now) * 0.2;
							//2. bring next_fs from the right(50%)
							left = (now * 50)+"%";
							//3. increase opacity of next_fs to 1 as it moves in
							opacity = 1 - now;
							current_fs.css({
						'transform': 'scale('+scale+')',
						'position': 'absolute'
					  });
							next_fs.css({'left': left, 'opacity': opacity});
						},
						duration: 800,
						complete: function(){
							current_fs.hide();
							animating = false;
						},
						//this comes from the custom easing plugin
						easing: 'easeInOutBack'
					});
				});

				$(".previous").click(function(){
					if(animating) return false;
					animating = true;
					current_fs = $(this).parent();
					previous_fs = $(this).parent().prev();
					//de-activate current step on progressbar
					$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
					//show the previous fieldset
					previous_fs.show();
					//hide the current fieldset with style
					current_fs.animate({opacity: 0}, {
						step: function(now, mx) {
							//as the opacity of current_fs reduces to 0 - stored in "now"
							//1. scale previous_fs from 80% to 100%
							scale = 0.8 + (1 - now) * 0.2;
							//2. take current_fs to the right(50%) - from 0%
							left = ((1-now) * 50)+"%";
							//3. increase opacity of previous_fs to 1 as it moves in
							opacity = 1 - now;
							current_fs.css({'left': left});
							previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
						},
						duration: 800,
						complete: function(){
							current_fs.hide();
							animating = false;
						},
						//this comes from the custom easing plugin
						easing: 'easeInOutBack'
					});
				});
			});
		</script>
	</body>
</html>