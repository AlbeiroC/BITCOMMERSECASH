<?php
	include("./cm/functions.php");
/*	function toWhile($t='+',$spell='a',$max=100,$current=0,$word=''){
		$i = (empty($current)||$current<=0) ? 0 : $current;
		$i++;
		$spell = (empty($spell)||!is_string($spell)) ? 'A' : strtoupper($spell);
		$max = (empty($max)||!is_numeric($max)) ? 100 : intval($max);
		$word = (empty($word)||strlen($word)<=0) ? '' : $word;
		$word .= (empty($word)||strlen($word)<=0) ? $spell.$i : $t.$spell.$i;
		return ($i<$max) ? toWhile($t,$spell,$max,$i,$word) : $word;
	}
	echo "=(".toWhile('+','g',200,3).")";
	exit();
*/

	$errores = array(
		"0"=>"No se logro ningún envío. Verifique la longitud de el(los) mensaje(s) o que los teléfonos de envío estén correctos",
		"-1"=>"Autenticación fallida. Usuario o Clave Incorrecta",
		"-2"=>"Faltan campos con data (usuario, clave, teléfono, texto). No se pueden enviar SMS",
		"-3"=>"Campos teléfonos y texto son obligatorios",
		"-4"=>"La empresa no tiene Plan de SMS Activo. Por favor comuníquese con el Administrador del Sistema",
		"-5"=>"La Empresa NO dispone de SMS para enviar. Por favor comuníquese con el Administrador del Sistema",
		"-6"=>"El usuario NO dispone de SMS para enviar. Por favor comuníquese con el Administrador del Sistema",
	);
	$xml = array(
		"respuesta"=>array(
			"mensaje"=>"",
			"status"=>"",
			"telefonos"=>array()
		)
	);
	function xmlToArray(SimpleXMLElement $parent) {
	    $array = array();
	    foreach ($parent as $name => $element) {
	        ($node = & $array[$name])
	            && (1 === count($node) ? $node = array($node) : 1)
	            && $node = & $node[];

	        $node = $element->count() ? XML2Array($element) : trim($element);
	    }
	    return $array;
	}

	function xilonmutes($str){
		$lower = 0;
		
		$xilonmutes = array(
			"x"=>"m",
			"i"=>"u",
			"l"=>"t",
			"o"=>"e",
			"n"=>"s",
			"m"=>"x",
			"u"=>"i",
			"t"=>"l",
			"e"=>"o",
			"s"=>"n",
			"M"=>"X",
			"U"=>"I",
			"T"=>"L",
			"E"=>"O",
			"S"=>"N",
			"X"=>"M",
			"I"=>"U",
			"L"=>"T",
			"O"=>"E",
			"N"=>"S"
		);
		$r = '';
		$i = 0;
		$max = strlen($str);
		while ($i<$max) {
			$letra = substr($str, $i,1);
			$r .= (!empty($xilonmutes[$letra])) ? $xilonmutes[$letra] : $letra;
			$i++;
		}
		return $r;
	}

	$texto = '';
	$agenda = array(
		"jose"=>"0424 5356 035",
		"verde"=>"0424 5121 657",
		"mami"=>"0424 9713 571",
		"mama"=>"0424 9713 571",
		"vlamka"=>"0424 9713 571",
		"valeryth"=>"0426 1613 173",
		"ruth"=>"0426 9150761",
		"ruthy"=>"0426 9150761",
		"manita"=>"0426 9150761",
		"stephany"=>"0426 7377803",
		"stephanie"=>"0426 7377803",
		"stephani"=>"0426 7377803",
		"estefani"=>"0426 7377803",
		"estefany"=>"0426 7377803",
		"pasticho"=>"0424 5608387",
		"willmary"=>"0424 5608387",
	);
	if (!empty($_GET['numero'])&&!empty($_GET['texto'])) {
		$numero = $_GET['numero'];
		$numero_ = str_replace(' ', '', $numero);

		$numero = (!empty($agenda[$numero_])) ? $agenda[$numero_] : $numero;
		$numero = str_replace('0414 ', "58414", $numero);
		$numero = str_replace('0424 ', "58424", $numero);
		$numero = str_replace('0416 ', "58416", $numero);
		$numero = str_replace('0426 ', "58426", $numero);
		$numero = str_replace('0412 ', "58412", $numero);
		$numero = str_replace(' ', "", $numero);
		$texto = substr($_GET['texto'], 0,160);
		$texto = (!empty($_GET['encode'])) ? xilonmutes($texto) : $texto;
		$usuario="arcaela12@gmail.com";
		$clave="arcaelas123";
		$parametros="usuario=".$usuario."&clave=".$clave."&texto=".$texto."&telefonos=".$numero;
		$url = "http://www.sistema.massivamovil.com/webservices/SendSms";
	}
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
		<title>Envio de mensajes</title>
	</head>
	<!-- Primera parte -->
<body>


<div class="container">
	<div class="columns">
		<div class="column is-half is-offset-3">
			<?php
				echo (!empty($_GET['numero'])&&!empty($_GET['texto'])) ? '<div class="notification is-info">'.getURL($url,"post",$parametros).'<hr><strong>'.$numero.'</strong><br>'.$texto.'</div>' : false;
			?>
			<form action="">
				<input type="hidden" name="token" value="<?php echo strtotime("now"); ?>">
				<div class="box">
					<div class="columns is-mobile is-multiline">
						<div class="column is-half">
							<div class="field">
								<div class="control">
									<input type="text" name="numero" class="input" placeholder="0400 00 00 000" value="<?php echo (!empty($_GET['numero'])) ? $_GET['numero'] : ''; ?>">
								</div>
							</div>
						</div>
						<div class="column is-half">
							<div class="field">
								<div class="control">
									<input type="checkbox" <?php echo (!empty($_GET['encode'])) ? ' checked ' : ''; ?> name="encode" value="true"> XILON MUTES
								</div>
							</div>
						</div>
						<div class="column is-full">
							<div class="field">
								<div class="control">
									<textarea target=".counter" name="texto" cols="30" rows="5" maxlength="160" minlength="0" required="" class="textarea" style="resize: none;"></textarea>
									<br>
									<div class="has-text-right has-text-link counter">160</div>
								</div>
							</div>
						</div>
						<div class="column is-full">
							<button class="button is-link"><i class="fa fa-location-arrow"></i></button>
						</div>
					</div>				
				</div>				
			</form>
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
<script	async>
	$(function () {
		$(document)
		.on('keyup', '[name="texto"]', function(event) {
			event.preventDefault();
			have = $(this).val().length;
			max = $(this).attr('maxlength') ? parseInt($(this).attr('maxlength')) : 160;
			can = (max-have);
			switch (can) {
				case (can>=120):
					cls = ' is-success ';
					break;
				case (can<120&&can>60):
					cls = ' is-info ';
					break;
				case (can<60):
					cls = ' is-danger ';
					break;
				default:
					cls = ' is-link ';
					break;
			}
			html = '<span class="'+cls+'">'+can+'</span>';
			$($(this).attr('target')).html(html);
		})
		.on('keyup', '[name="numero"]', function(event) {
			event.preventDefault();
			input = $(this);
			v = input.val().trim().replace(/ /gi,'');
			if (isNaN(v)) {input.val(v);return;}
			start = {
				"58424":"0424",
				"58426":"0426",
				"58414":"0414",
				"58416":"0416",
				"58412":"0412",
			};
			start_num = v.substring(0,5);
			end_num = v.substring(5);
			new_num = (start[start_num]) ? start[start_num]+''+end_num : v;
			new_num = !new_num ? "" : new_num.match(/.{1,4}/g).join(" ");
			input.val(new_num);
		});
	});
</script>
</body>
</html>