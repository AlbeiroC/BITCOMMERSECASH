<?php
include('./cm/functions.php');

if (!empty($_GET['term'])) {
	header('Content-type: text/json');
	echo find($_GET['term']);
	exit();
}

else if (!empty($_GET['more'])) {
	header('Content-type: text/json');
	print_r(listarItems($_GET));
	exit();
}

else if (!empty($_GET['item'])) {
	header('Content-type: text/json');
	if (!empty($_GET['json'])&&(strtolower($_GET['json'])=='false')) {
		print_r(itemInfo($_GET['item'],false));
		exit();
	}
	echo itemInfo($_GET['item']);
	exit();
}


else if (!empty($_POST['comprobate'])&&!empty($_POST['campo'])&&!empty($_POST['tabla'])) {
	print_r(existReg(htmlspecialchars($_POST['comprobate'],ENT_QUOTES),htmlspecialchars($_POST['campo'],ENT_QUOTES),htmlspecialchars($_POST['tabla'],ENT_QUOTES)));
	exit();
}


else if(!empty($_POST['registro'])){


	$_SESSION['tmp_register'] = $_POST;
	$error = false;
	$registro = array(
		"imagen"=>false,
		"username"=>false,
		"nombre"=>false,
		"about"=>false,
		"password"=>false,
		"email"=>false,
		"pais"=>false,
		"divisa"=>false
	);
	$tablas = preTables();

	// Aqui estamos trabajando solo la imagen de logotipo
	if (!empty($_FILES['ImageFileInput'])) {
		if ($imagen = uploadImagen($_FILES['ImageFileInput'],'./upload/')) {
			$registro['imagen'] = ''.http().$_SERVER['HTTP_HOST'].'/'.str_replace('./', "", str_replace('//', '/', $imagen));
		}
	}
	else if(!empty($_POST['ImageBase64'])){
		$imagen = explode(';', $_POST['ImageBase64']);
		$mime = explode(':', $imagen[0]);
		$mime = end($mime);
		$imagen = explode(',', $imagen[1]);
		$imagen = end($imagen);
		if ($imagen=uploadImagen($imagen,false,true)) {
			$registro['imagen'] = ''.http().$_SERVER['HTTP_HOST'].'/'.str_replace('./', "", str_replace('//', '/', $imagen));
		}
	}
	// Fin de Aqui estamos trabajando solo la imagen de logotipo


	// Ahora trabajamos el Nombre para Mostrar de la compañía
	if (!empty(trim(ucwords($_POST['namecompany'])))&&(strlen(trim(ucwords($_POST['namecompany'])))>=3)) {
		if (!existReg($_POST['namecompany'],"nombre","users")) {
			$registro['nombre'] = trim(ucwords($_POST['namecompany']));
		}
		else if (!empty($_POST['update'])) {
			if ($tmp_user = is_session()) {
				if (strtolower($tmp_user['nombre'])==strtolower($_POST['namecompany'])) {
					$registro['nombre'] = trim(ucwords($_POST['namecompany']));
				}
			}
		}
		else{
			$error = "namecompany";
			if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
		}
	}
	else{
		$error = "namecompany";
		if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
		exit();
	}
	// Fin de Ahora trabajamos el Nombre para Mostrar de la compañía
	




	// Ahora trabajamos la descripcion de la compañía
	if (!empty($_POST['descriptioncompany'])) {
		$registro['about'] = utf8_encode(htmlspecialchars(substr($_POST['descriptioncompany'], 0, 160), ENT_QUOTES));
	}
	else{
		$error = "descriptioncompany";
		if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
		exit();
	}
	// Fin de Ahora trabajamos la descripcion de la compañía


	
	// Ahora trabajamos el nombre de usuario
	if (!empty($_POST['username'])) {
		if (!existReg($_POST['username'],"username","users")) {
			$registro['username'] = strtolower(trim($_POST['username']));
		}
		else if (!empty($_POST['update'])) {
			if ($tmp_user = is_session()) {
				if (strtolower($tmp_user['username'])==strtolower($_POST['username'])) {
					$registro['username'] = trim(strtolower($_POST['username']));
				}
			}
		}
		else{
			$error = "username";
			if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
			exit();
		}
	}
	else{
		$error = "username";
		if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
		exit();
	}
	// Fin de Ahora trabajamos el nombre de usuario
	

	// Verificamos la direccion de email
	if (!empty($_POST['email'])) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)&&!existReg($_POST['email'],"email","users")) {
	  		$registro['email'] = strtolower($_POST['email']);
		}
		else if (!empty($_POST['update'])) {
			if ($tmp_user = is_session()) {
				if (strtolower($tmp_user['email'])==strtolower($_POST['email'])) {
					$registro['email'] = trim(strtolower($_POST['email']));
				}
			}
		}
		else{
			$error = "email";
			if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
			exit();
		}
	}
	else{
		$error = "email";
		if (empty($_POST['ajax'])) {header('Location: '.http().$_SERVER['HTTP_HOST'].'/register?error='.$error); }
		exit();
	}
	// Fin de Verificamos la direccion de email


	// Validamos y comprobamos las contraseñas
	if (!empty($_POST['password'])&&!empty($_POST['repassword'])) {
		if (strtolower($_POST['password'])==strtolower($_POST['repassword'])) {
			$registro['password'] = strtolower($_POST['password']);
		}
		else{
			$error = "password";
		}
	}
	else{
		$error = "password";
	}
	if (!empty($error)) {echo json_encode(array("status"=>"error")); if (empty($_POST['ajax'])) {header('Location: '.str_replace('?', '?error=exist_error&', $_SERVER['HTTP_REFERER'])); } exit(); }
	// Fin de Validamos y comprobamos las contraseñas


	// Pais & Moneda
	if (!empty($_POST['code2Countrie'])) {
		$registro['pais'] = strtolower(trim($_POST['code2Countrie']));
	}
	if (!empty($_POST['currencie_value'])) {
		$registro['divisa'] = strtolower(trim($_POST['currencie_value']));
	}
	else{
		$registro['divisa'] = strtolower(trim('usd'));
	}
	// Fin de Pais & Moneda



	$registro['fecha'] = 'NULL';
	$fields = array();
	$values = array();
	foreach ($registro as $key => $value) {
		if (!empty($value)) {
			array_push($fields, $key);
			array_push($values, $value);
		}
	}

	if (!$error) {
		header('Content-Type: text/json');
		$fields = implode(',', $fields);
		$values = "'".implode("','",$values)."'";
		$sql = "INSERT INTO users ($fields) VALUES ($values)";
		if ($con->query($sql)) {
			$to = strtolower($registro['email']);
			$subject = 'BitCommerseCash | Nuevo Usuario';
			$headers = "From: no-reply@bitcommersecash.com" . "\r\n";
			// $headers .= "Reply-To: " . "\r\n";
			// $headers .= "CC: susan@example.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = getURL(''.http().$_SERVER['HTTP_HOST'].'/email/new_user.php?user='.$con->insert_id);
			if (mail($to, $subject, $message, $headers)) {
				print_r(error_success(array(
					"user_id"=>$con->insert_id,
					"type"=>"success",
					"response"=>"Registro realizado correctamente",
					"page"=>"profile"
				)));
				$_SESSION['tmp_register'] = false;
				if (empty($_POST['ajax'])) {
					print_r(error_success(array(
						"type"=>"success",
						"response"=>"Registro realizado correctamente",
						"page"=>"profile"
					)));
					exit();
				}
			};
		}

		else {
			if (!empty($_POST['ajax'])) {
				print_r(error_success(array(
					"type"=>"error",
					"response"=>$sql,
					"url"=>"register"
				),'json'));
			}
			else {
				print_r(error_success(array(
					"type"=>"error",
					"response"=>urlencode($sql),
					"url"=>"register"
				)));
			}
		}
	}
	
	else {
		if (!empty($_POST['ajax'])) {
			print_r(error_success(array(
				"type"=>"error",
				"response"=>"Existe un problema en el registro."
			),'json'));
		}
		else {
			print_r(error_success(array(
				"type"=>"error",
				"response"=>"Existe un problema en el registro."
			)));
		}
	}
	exit();
}



header('Location: /');
?>