<?php
include('./../cm/functions.php');

if (!empty($_GET['username'])) {
	header('Content-Type: text/json');
	$user = strtolower($_GET['username']);
	$sql = "SELECT * FROM users WHERE LOWER(username) = LOWER('".$user."') OR LOWER(email) = LOWER('".$user."') LIMIT 1";
	if ($res=$con->query($sql)) {
		if ($res->num_rows>0) {
			$data = $res->fetch_array();
			if ($data['status']=='inactive') {
				echo '[{"status":"inactive","pic":"'.str_replace('http:','https:',$data['imagen']).'"}]';
			}
			else{
				echo '[{"status":"ok","pic":"'.str_replace('http:','https:',$data['imagen']).'"}]';
			}
		}
		else{
			echo '[]';
		}
	}
	else{
		echo '[{"status":"'.$con->error.'"}]';
	}
	exit();
}


else if(!empty($_GET['clave'])&&!empty($_GET['user-check'])){
	header('Content-Type: text/json');
	$user = strtolower($_GET['user-check']);
	$clave = strtolower($_GET['clave']);
	$sql = "SELECT * FROM users WHERE LOWER(username) = LOWER('".$user."') AND LOWER(password) = LOWER('".$clave."') OR LOWER(email) = LOWER('".$user."') AND LOWER(password) = LOWER('".$clave."') LIMIT 1";
	if ($res=$con->query($sql)) {
		if ($res->num_rows>0) {
			$data = $res->fetch_array(MYSQLI_ASSOC);
			$token = md5($data['id']).rand().time();
			$sql = "INSERT INTO tokens (user,token,type,fecha) VALUES ('".$data['id']."','".$token."','sesion',fecha)";
			if (notification($data['id'],'Inicio de Sesion','Has iniciado sesion bajo el token [TOKEN]'.$token.'[/TOKEN]')) {}
			if ($con->query($sql)) {
				setcookie('init_log','1',time()+3600,'/');
				setcookie('user_login',$token,time()+3600,'/');
				$_SESSION['user_login'] = $token;
				echo '[{"status":"ok"}]';				
			}
		}
		else{
			echo '[]';
		}
	}
	else{
		echo '[{"status":"'.$con->error.'"}]';
	}
	exit();
}


?>