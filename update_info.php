<?php
include('./cm/functions.php');
header('Content-type: text/json');

if ($user=is_session()&&!empty($_POST['key'])) {}
else{$error = true; }



if (!empty($error)) {
	if (!empty($_POST['ajax'])) {
		print_r(error_success(array(
			"url"=>"profile",
			"type"=>"error",
			"response"=>"Se requiere que inicies sesion para actualizar tus datos"
		),'json'));
		exit();
	}
	else{
		print_r(error_success(array(
			"url"=>"profile",
			"type"=>"error",
			"response"=>"Se requiere que inicies sesion para actualizar tus datos"
		)));
		exit();
	}
}



$update = array(
	"imagen"=>false,
	"username"=>false,
	"nombre"=>false,
	"about"=>false,
	"password"=>false,
	"email"=>false,
	"pais"=>false,
	"divisa"=>false,
	"facebook"=>false,
	"twitter"=>false,
	"instagram"=>false,
);
$tablas = preTables();
$arg = array_merge($user,array_merge($update,$_POST));
foreach ($arg as $key => $value) {
	if (empty($value)||!isset($update[$key])||(strtolower($value)==strtolower($user[$key]))) {
		unset($arg[$key]);
	}
}
$update = $arg;


// Aqui estamos trabajando solo la imagen personal
if (!empty($_FILES['ImageFileInput'])) {
	if ($imagen = uploadImagen($_FILES['ImageFileInput'],'./upload/')) {
		$update['imagen'] = ''.http().$_SERVER['HTTP_HOST'].'/'.str_replace('./', "", str_replace('//', '/', $imagen));
	}
}
else if(!empty($_POST['ImageBase64'])){
	if ($imagen=uploadImagen($_POST['ImageBase64'],false,true)) {
		$update['imagen'] = ''.http().$_SERVER['HTTP_HOST'].$imagen;
	}
}
// Fin de Aqui estamos trabajando solo la imagen personal


// Ahora trabajamos el Nombre para Mostrar de la compañía
if (!empty(trim(ucwords($_POST['namecompany'])))&&(strlen(trim(ucwords($_POST['namecompany'])))>=3)) {
	if (!existReg($_POST['namecompany'],"nombre","users")) {
		$update['nombre'] = trim(ucwords($_POST['namecompany']));
	}
	else if(strtolower($_POST['namecompany'])==strtolower($user['nombre'])){
		$update['nombre'] = false;
	}
	else{
		$error = true;
	}
}
if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
// Fin de Ahora trabajamos el Nombre para Mostrar de la compañía


// Ahora trabajamos la descripcion de la compañía
if (!empty($_POST['descriptioncompany'])) {
	$update['about'] = utf8_encode(htmlspecialchars(substr($_POST['descriptioncompany'], 0, 160), ENT_QUOTES));
	if(strtolower($_POST['descriptioncompany'])==strtolower($user['about'])){
		$update['about'] = false;
	}
}
if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
// Fin de Ahora trabajamos la descripcion de la compañía

// Ahora trabajamos el nombre de usuario
if (!empty($_POST['username'])) {
	if (!existReg($_POST['username'],"username","users")) {
		$update['username'] = strtolower(trim($_POST['username']));
	}
	else if(strtolower(trim($_POST['username']))==strtolower(trim($user['username']))){
		$update['username'] = false;
	}
	else{
		$error = true;
	}
}
if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
// Fin de Ahora trabajamos el nombre de usuario



// Verificamos la direccion de email
if (!empty($_POST['email'])) {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)&&!existReg($_POST['email'],"email","users")) {
  		$update['email'] = strtolower($_POST['email']);
	}
	else if(strtolower(trim($_POST['email']))==strtolower(trim($user['email']))){
  		$update['email'] = false;
	}
	else{
		$error = true;
	}
}
if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
// Fin de Verificamos la direccion de email



// Validamos y comprobamos las contraseñas
if (!empty($_POST['password'])&&!empty($_POST['repassword'])) {
	if (strtolower($_POST['password'])==strtolower($_POST['repassword'])) {
		$update['password'] = strtolower($_POST['password']);
	}
	else{
		$error = "password";
	}
}
if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
// Fin de Validamos y comprobamos las contraseñas


$t = array();
foreach ($update as $key => $value) {
	if (!empty($value)) {
		$t[$key] = $value;
	}
}
$update = $t;
$token = bin2hex(random_bytes(rand(11,100)));
$sql = array(
	"insert"=>array(),
	"delete"=>array(),
);

foreach ($update as $key => $value) {
	if (in_array($key, $tablas)) {
		array_push($sql['delete'], "DELETE FROM empresa_".$key." WHERE user = '".$user['id']."' AND LOWER(status) = LOWER('waiting')");
		array_push($sql['insert'], "INSERT INTO empresa_".$key." (token,user,".$key.",status,fecha) VALUES ('".$token."','".$user['id']."','".$value."','waiting',NULL)");
	}
}






$file = (!is_file("./test.txt")) ? "./test.txt" : (unlink("./test.txt")) ? "./test.txt" : false;
if ($file) {
	$fn = fopen($file, "a");
	fputs($fn,json_encode($update));
	fclose($fn);
}



exit();



$error = false;
foreach ($sql['delete'] as $key => $value) {
	if (!$con->query($value)) {
		$error = true;
	}
}
foreach ($sql['insert'] as $key => $value) {
	if (!$con->query($value)) {
		$error = true;
	}
}


if (!empty($error)) {
	foreach ($tablas as $key => $value) {
		if ($con->query("DELETE FROM empresa_".$key." WHERE user = '".$user['id']."' AND token = '".$token."'")) {}
		if ($con->query("DELETE FROM token WHERE token = '".$token."' AND user = '".$user['id']."'")) {}
	}	
	if (!empty($_POST['ajax'])) {
		print_r(error_success(array(
			"type"=>"error",
			"response"=>$con->error,
			"url"=>"profile"
		),'json'));
	}
	else {
		print_r(error_success(array(
			"type"=>"error",
			"response"=>urlencode($con->error),
			"url"=>"profile"
		)));
	}
}

if ($con->query("DELETE FROM tokens WHERE token IN (SELECT token FROM empresa_about WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive') OR token IN (SELECT token FROM empresa_email WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive') OR token IN (SELECT token FROM empresa_imagen WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive') OR token IN (SELECT token FROM empresa_nombre WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive') OR token IN (SELECT token FROM empresa_password WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive') OR token IN (SELECT token FROM empresa_username WHERE LOWER(status) = 'active' OR LOWER(status) = 'inactive')")) {}





$sql = "INSERT INTO tokens (user,token,type,fecha) VALUES ('".$user['id']."','".$token."','update',NULL)";
if ($con->query($sql)) {
	$to = strtolower($user['email']);
	$subject = 'BitCommerseCash | Datos Actualizados';
	$headers = "From: no-reply@bitcommersecash.com" . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$info = "Has solicitado cambiar la informacion de tu cuenta.";
	$message = getURL(''.http().$_SERVER['HTTP_HOST'].'/email/check_updates.php?FILTER_VALIDATE='.$token.'&user='.$user['id'].'&mensaje='.urlencode($info));
	if (mail($to, $subject, $message, $headers)) {
		notification($user['id'],'Solicitud de Cambio de Datos','Has realizado una solicitud de cambios en la informacion personal de tu cuenta.');
		print_r(error_success(array(
			"type"=>"ok",
			"response"=>"Revisa tu correo ".$user['email']." y confirma los cambios.",
			"url"=>"profile"
		),'json'));
		if (empty($_POST['ajax'])) {
			print_r(error_success(array(
				"type"=>"ok",
				"response"=>"Revisa tu correo ".$user['email']." y confirma los cambios.",
				"url"=>"profile"
			)));
			exit();
		}
	};
}


else{
	$error = true;
}

if (!empty($error)) {
	foreach ($tablas as $key => $value) {
		if ($con->query("DELETE FROM empresa_".$key." WHERE user = '".$user['id']."' AND token = '".$token."'")) {}
		if ($con->query("DELETE FROM token WHERE token = '".$token."' AND user = '".$user['id']."'")) {}
	}	
	if (!empty($_POST['ajax'])) {
		print_r(error_success(array(
			"type"=>"error",
			"response"=>$con->error,
			"url"=>"profile"
		),'json'));
	}
	else {
		print_r(error_success(array(
			"type"=>"error",
			"response"=>urlencode($con->error),
			"url"=>"profile"
		)));
	}
}
?>