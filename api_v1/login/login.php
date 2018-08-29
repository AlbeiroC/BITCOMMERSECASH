<?php
include('./../../cm/functions.php');

if (!empty(is_session())) {
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
			"response"=>ucwords($con->error),
			"url"=>"profile"
		)));
	}
}




if (!empty($_POST['username'])) {
	$user = strtolower($_POST['username']);
	if (!empty($_POST['password'])) {
		$clave = $_POST['password'];
		$sql = "SELECT * FROM users WHERE LOWER(username) = LOWER('".$user."') AND LOWER(password) = LOWER('".$clave."') OR LOWER(email) = LOWER('".$user."') AND LOWER(password) = LOWER('".$clave."') LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$data = $res->fetch_array(MYSQLI_ASSOC);
				$token = md5($data['id']).rand().time();
				$sql = "INSERT INTO tokens (user,token,type,fecha) VALUES ('".$data['id']."','".$token."','sesion',NULL)";
				if ($con->query($sql)) {}
				if (notification($data['id'],'Inicio de Sesion','Has iniciado sesion bajo el token [TOKEN]'.$token.'[/TOKEN]')) {}
				setcookie('init_log','1',time()+3600,'/');
				setcookie('user_login',$token,time()+3600,'/');
				$_SESSION['user_login'] = $token;
				if (!empty($_POST['ajax'])) {
					print_r(error_success(array(
						"type"=>"ok",
						"response"=>"Bienvenido a BitCommerseCash",
						"url"=>"profile"
					),'json'));
				}
				else {
					print_r(error_success(array(
						"type"=>"ok",
						"response"=>ucwords("Bienvenido a BitCommerseCash"),
						"url"=>"profile"
					)));
				}

			}
			else if (!empty($_POST['ajax'])) {
				print_r(error_success(array(
					"type"=>"error",
					"response"=>"Los datos ingresados no son correctos",
					"url"=>"login"
				),'json'));
			}
			else {
				print_r(error_success(array(
					"type"=>"error",
					"response"=>ucwords("Los datos ingresados no son correctos"),
					"url"=>"login"
				)));
			}
		}
		else if (!empty($_POST['ajax'])) {
			print_r(error_success(array(
				"type"=>"error",
				"response"=>"Tuvimos un problema interno.",
				"url"=>"login"
			),'json'));
		}
		else {
			print_r(error_success(array(
				"type"=>"error",
				"response"=>ucwords("Tuvimos un problema interno."),
				"url"=>"login"
			)));
		}
	}
}








if (!empty($_POST['ajax'])) {
	print_r(error_success(array(
		"type"=>"error",
		"response"=>"Verifica el formulario e intenta nuevamente",
		"url"=>"login"
	),'json'));
}
else {
	print_r(error_success(array(
		"type"=>"error",
		"response"=>ucwords("Verifica el formulario e intenta nuevamente"),
		"url"=>"login"
	)));
}
?>