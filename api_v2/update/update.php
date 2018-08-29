<?php
include('./../../cm/function.beta.php');


if (!empty($_POST['key'])&&$user = is_session()) {
	$carpeta = createDir("./temp/user_".$user['data']['user']['id']."/");
	$file = "update.config.".$user['data']['user']['id'].".json";
	$finish_update = false;
	$arg = array(
		"key"=>$_POST['key'],
		"user"=>$user['data']['user']['id'],
	);
	if (file_exists($carpeta.$file)) {
		$c = json_decode(file_get_contents($carpeta.$file), true);
		if (!empty($c['key'])) {
			if ($c['key']==$arg['key']) {
				$arg = $c;
				if (!empty($_POST['cheked_updated'])&&($_POST['cheked_updated']==$arg['key'])) {
					$finish_update = true;
				}
			}
			else{
				$carpeta = (removeDir($carpeta)) ? createDir($carpeta) : false;
			}
		}
		else{
			$carpeta = (removeDir($carpeta)) ? createDir($carpeta) : false;
		}
	}

	// print_r(json_encode($arg)); exit();
	if (is_file($carpeta.$file)) {unlink($carpeta.$file); }
	$arg = array_merge($arg,$_POST);
	if (!empty($_FILES['ImageFileInput'])) {
		if ($nombre=uploadImagen($_FILES['ImageFileInput'],$carpeta,rand())) {
			$arg['imagen'] = $nombre;
		}
	}
	if (!empty($_POST['removeImage'])) {
		$arg['imagen'] = false;
	}
	$token = md5($arg['key']).rand().base64_encode($arg['key']);

	$user_campos = array(
		"webmail"=>"user_webmail",
		"username"=>"user_username",
		"imagen"=>"user_imagen",
		"nombre"=>"user_nombre",
		"about"=>"user_about",
		"password"=>"user_password",
		"email"=>"user_email",
		"imagen"=>"user_imagen",
		"pais"=>"pais_code",
		"divisa"=>"pais_moneda",
		"facebook"=>"user_facebook",
	);
	$update_tables = array(
		"pais"=>"pais_code",
		"divisa"=>"pais_moneda",
	);


	$t = $promo = array();
	foreach ($arg as $key => $value) {
		$int = (!empty($user_campos[$key])) ? explode('_', $user_campos[$key]) : false;
		if (!empty($user_campos[$key])&&strtolower(trim($value))!=strtolower(trim($user['data'][$int[0]][$int[1]]))) {
			$promo[$key] = $value;
			switch ($key) {
				case 'nombre':
					$nombre = eraseStr(strtolower(trim($arg[$key])));
					if (!empty(strlen($nombre)>4)) {
						$promo[$key] = $nombre;
					}
					else{
						$error = array(
							"type"=>"error",
							"target"=>$key,
							"response"=>"El nombre necesita al menos 4 caracteres."
						);
					}
					break;
				case 'imagen':
					$promo[$key] = $arg[$key];
					break;
				case 'email':
					$email = trim(strtolower(eraseStr($arg[$key])));
					if (!empty(strstr($email, "@"))&&!existReg($email,'email','users')&&!existReg($email,'email','empresa_email')) {
						$promo[$key] = $email;
					}
					else{
						$error = array(
							"type"=>"error",
							"target"=>$key,
							"response"=>"La direccion de email esta incorrecta o ya está en nuestro sistema."
						);
					}
					break;
				case 'imagen':
					if (is_file($arg[$key])) {
						$promo[$key] = $arg[$key];
					}
					break;
				case 'about':
					$promo[$key] = (strlen(trim($arg[$key]))>0) ? $arg[$key] : 'Hey, estoy en Bitcommersecash.com';
					break;
				case 'username':
					$username = eraseStr(trim(strtolower($arg[$key])));
					if (!existReg($username,'username','users')&&!existReg($username,'username','empresa_users')) {
						$promo[$key] = $username;
					}
					else{
						$error = array(
							"type"=>"error",
							"target"=>$key,
							"response"=>"Usuario asociado a otra cuenta."
						);
					}
					unset($username);
					break;
				case 'password':
				case 'repassword':
					if (!empty($arg['repassword'])&&trim(strtolower($arg[$key]))==trim(strtolower($arg['repassword']))&&(strlen(trim(strtolower($arg[$key])))>5)) {
						$promo[$key] = trim(strtolower($arg[$key]));
					}
					else{
						$error = array(
							"type"=>"error",
							"target"=>$key,
							"response"=>"Las claves no coinciden o están vacías."
						);
					}
					break;
				case 'facebook':
				case 'instagram':
				case 'twitter':
					$facebook = trim(strtolower(str_replace(' ', '', eraseStr($arg[$key]))));
					if (strlen($facebook)>=4) {
						$promo[$key] = $facebook;
					}
					break;
				case 'divisa':
				case 'pais':
					$reg = trim(strtolower($arg[$key]));
					$promo[$key] = $reg;
					break;
			}
		}
	}
	$arg = $promo;
	$arg['key'] = $_POST['key'];
	$arg['user'] = $user['data']['user']['id'];

	if (empty($error)) {
		$empresa_tables = user_tables();
		$querys = array();
		foreach ($empresa_tables as $key) {
			$querys['deletes'][] = "UPDATE empresa_".$key." SET status = 'waiting' WHERE user = '".$user['data']['user']['id']."' AND LOWER(TRIM(status)) = LOWER(TRIM('active'))";
			// $querys['deletes'][] = "DELETE FROM empresa_".$key." WHERE user = '".$user['data']['user']['id']."' AND LOWER(TRIM(status)) = LOWER(TRIM('waiting'))";
			if (!empty($arg[$key])) {
				if (!empty($finish_update)&&$key=='imagen') {
					$nombre = md5($user['data']['user']['id']).md5($user['data']['user']['username']).rand().'.jpg';
					$dir = createDir('./../../upload/');
					$ruta = $dir.$nombre;
					$to_show = host('url')."upload/".$nombre;
					$arg[$key] = (rename($arg[$key], $ruta)) ? $to_show : $ruta;
				}
				$querys['insert'][] = "INSERT INTO empresa_".$key." (token,user,".$key.",status) VALUES ('".$token."','".$user['data']['user']['id']."','".$arg[$key]."','active')";
			}
		}
		foreach ($arg as $key => $value) {
			if (!empty($update_tables[$key])&&!empty($value)) {
				$querys['update'][] = "UPDATE users SET ".$key." = '".$value."' WHERE id = '".$user['data']['user']['id']."'";
			}
		}
	}


	header('Content-type: text/json');
	$arg = json_encode($arg ,JSON_PRETTY_PRINT);
	if (empty($arg['type'])||empty($arg['type']=='error')) {
		$fn = fopen($carpeta.$file, "a");
		if (!empty(fputs($fn,$arg))) {
			fclose($fn);
			if (!empty($error)) {
				print_r(json_encode($error));
			}
			else{
				if (!empty($finish_update)) {
					$results = array();
					$con = connection();
					foreach ($querys as $key => $value) {
						if (is_array($value)) {
							foreach ($value as $index => $query) {
								if ($con->query($query)) {
									$results['success'][] = $query;
								}
								else{
									$results['error'][] = array(
										"query"=>$query,
										"result"=>$con->error
									);
								}
							}
						}
					}
					if (empty($results['error'])) {removeDir($carpeta); }
					unset($_SESSION['profiles']);
					$results = array(
						"type"=>"success",
						"response"=>"Los datos se han actualizado."
					);
					print_r(json_encode($results,JSON_PRETTY_PRINT));
				}
				else{
					print_r(json_encode(array(),JSON_PRETTY_PRINT));
				}
			}
			if (!empty($con)) {
				$con ->close();
			}
			exit();
		}
		else{
			print_r(json_encode(array(
				"type"=>"error",
				"response"=>500
			), JSON_PRETTY_PRINT));
		}
	}
}