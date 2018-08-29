<?php
include('./../../cm/function.beta.php');
header('Content-type: text/json');
if (!empty($_GET['username'])) {
	$user = strtolower(trim($_GET['username']));
	$clave = (!empty($_GET['password'])) ? trim(strtolower($_GET['password'])) : false;
	if (!empty($clave)) {
		$con = connection();
		$sql = "SELECT * FROM users WHERE (TRIM(LOWER(username)) = '".$user."' OR TRIM(LOWER(email)) = '".$user."')  AND TRIM(LOWER(password)) = TRIM(LOWER('".$clave."')) LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$data = $res->fetch_array(MYSQLI_ASSOC);
				$token = md5($data['id']).rand().time();
				$sql = "INSERT INTO tokens (user,token,type,fecha) VALUES ('".$data['id']."','".$token."','sesion',NULL)";
				if ($con->query($sql)) {
					print_r(error_success(array(
						"type"=>"error",
						"response"=>"Verifica el formulario e intenta nuevamente",
						"url"=>"login",
						"encode"=>true,
					)));
				}
			}
		}
		$con->close();
		exit();
	}
	else{
		
	}
}

else if (!empty($_GET['validate'])) {
	$table = 'users';
	$field = $_GET['validate'];
	$value = $_GET['value'];
	print_r(countSQL($table,$field,$value));
	exit();
}


else if (!empty($_POST['trp'])) {
	$con = connection();
	$about = 'Soy un nuevo usuario de BitCommerseCash.';
	$trp = (!empty($_POST['trp'])) ? $_POST['trp'] : false;
	$username = (!empty($_POST['username'])) ? $_POST['username'] : false;
	$email = (!empty($_POST['email'])) ? $_POST['email'] : false;
	$nombre = (!empty($_POST['nombre'])) ? $_POST['nombre'] : false;
	$about = (!empty($_POST['about'])) ? $_POST['about'] : $about;
	$password = (!empty($_POST['password'])) ? $_POST['password'] : false;
	$repassword = (!empty($_POST['repassword'])) ? $_POST['repassword'] : false;
	if (empty($trp)||empty($username)||empty($email)||empty($nombre)||empty($about)||empty($password)||empty($repassword)) {
		return print_r(error_success(array(
			"encode"=>true,
			"type"=>"error",
			"response"=>"Verifica los campos del formulario."
		)));
	}
	else if(!security($trp)){
		return print_r(error_success(array(
			"encode"=>true,
			"type"=>"error",
			"response"=>"No podemos validar el formulario."
		)));
	}
	else{
		if (strlen($username)<5) {
			$msj = "username_5 caracteres como mínimo.";
		}
		else if(strlen(preg_replace('/[0-9a-zA-Z]/', '', $username))>0){
			$msj = "username_Solo letras y numeros.";
		}
		else if (countSQL('users','username',$username)>0) {
			$msj = "username_Este usuario ya existe.";
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$msj = "email_Email incorrecto.";
		}
		else if (countSQL('users','email',$email)>0) {
			$msj = "email_Este usuario ya existe.";
		}
		else if (trim(strtolower($password))!=trim(strtolower($repassword))) {
			$msj = "password_Este usuario ya existe.";
		}
		else if (strlen($about)>160) {
			$msj = "about_160 caracteres como maximo.";
		}

		if (!empty($msj)) {
			return print_r(error_success(array(
				"encode"=>true,
				"type"=>"error",
				"response"=>$msj,
			)));
		}
		$sql = "INSERT INTO users (username,nombre,about,password,email) VALUES ('".strtolower(trim($username))."','".trim($nombre)."','".trim($about)."','".strtolower(trim($password))."','".strtolower(trim($email))."')";
		if ($con->query($sql)) {
			$to = strtolower('arcaela12@gmail.com');
			$subject = 'BitCommerseCash | Nuevo Usuario';
			$headers = "From: no-reply@bitcommersecash.com" . "\r\n";
			// $headers .= "Reply-To: " . "\r\n";
			// $headers .= "CC: susan@example.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = getURL(host('url').'email/new_user.php?user='.$con->insert_id);
			mail($to, $subject, $message, $headers);
			$con->close();
			return print_r(error_success(array(
				"encode"=>true,
				"type"=>"ok",
				"response"=>"Registro exitoso.",
			)));
		}
		else{
			$sql = "INSERT INTO users (username,nombre,about,password,email) VALUES ('".strtolower(trim($username))."','".trim($nombre)."','".trim($about)."','".strtolower(trim($password))."','".strtolower(trim($email))."')";
			return print_r(error_success(array(
				"encode"=>true,
				"type"=>"error",
				"response"=>'repassword_'.$con->error,
			)));
		}
	}


	exit();
}


print_r(error_success(array(
	"type"=>"error",
	"response"=>"Verifica el formulario e intenta nuevamente",
	"url"=>"login",
	"encode"=>true,
)));
?>