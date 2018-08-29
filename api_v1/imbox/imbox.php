<?php
include('./../../cm/functions.php');
header('Content-type: text/json');

if (!empty($_GET['ads'])) {
	$ads = array();
	$sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 1";
	if ($res=$con->query($sql)) {
		$ads = $res->fetch_array(MYSQLI_ASSOC);
	}
	print_r(json_encode($ads));
	exit();
}



else if (!empty($_GET['from'])) {
	$defaults = array(
		"from"=>false,
		"before"=>9999999999999999999999999999999,
		"after"=>0
	);
	$opt = array_merge($defaults,$_GET);

	if (!empty($opt['from'])&&$user=is_session()) {
		$from = $opt['from'];
		$sql = "UPDATE imbox SET status = 'true' WHERE user = '".$from."' AND para = '".$user['user_id']."'";
		if ($res=$con->query($sql)) {}
		$sql = "SELECT imbox.id AS id_imbox, imbox.user AS send_id, users.username AS send_username, users.nombre AS send_nombre, users.imagen AS send_imagen, imbox.mensaje AS mensaje, imbox.referencia AS referencia, imbox.status AS status, imbox.readed AS readed, imbox.fecha AS fecha FROM imbox,users WHERE imbox.para = '".$user['user_id']."'AND imbox.user = '".$from."'AND users.id = imbox.user AND UNIX_TIMESTAMP(imbox.fecha) < ".$opt['before']." AND  UNIX_TIMESTAMP(imbox.fecha) > ".$opt['after']." OR imbox.para = '".$from."' AND imbox.user = '".$user['user_id']."' AND users.id = imbox.user AND UNIX_TIMESTAMP(imbox.fecha) < ".$opt['before']." AND  UNIX_TIMESTAMP(imbox.fecha) > ".$opt['after']." ORDER BY imbox.fecha DESC,imbox.id DESC LIMIT 10";
		if ($res=$con->query($sql)) {
			$imbox = array();
			while ($i=$res->fetch_array(MYSQLI_ASSOC)) {
				$i['my'] = 'false';
				if ($i['send_id']==$user['user_id']) {
					$i['my'] = 'true';
				}
				$i['ago'] = setDate($i['fecha']);
				$i['markTime'] = strtotime(setDate($i['fecha'],'Y-m-d'));
				$i['hora'] = setDate($i['fecha'],'H:i:s a');
				$i['fecha'] = setDate($i['fecha'],'d M Y');
				array_push($imbox, $i);
			}
			print_r(json_encode($imbox));
		}
		else{
			print_r($con->error);
		}
		exit();
	}
}



else if (!empty($_POST['to'])&&$user=is_session()) {
	$_POST['id_imbox'] = 9999999999999999999999999999999999999;
	if (!empty($_POST['id_imbox'])) {
		if ($recibe = userInfo($_POST['to'])) {
			if (!empty($_POST['response'])) {
				$to = $recibe['id'];
				$id_mensaje = $_POST['id_imbox'];
				$mensaje = htmlspecialchars($_POST['response'], ENT_QUOTES);
				$referencia = 'mensaje_para_'.$to;
				if (!empty($_POST['referencia'])) {
					$referencia = $_POST['referencia'];
				}
				$sql = "INSERT INTO imbox (user,para,mensaje,referencia,fecha) VALUES ('".$user['id']."','".$recibe['id']."','".$mensaje."','".$referencia."',NULL)";
				if ($con->query($sql)) {
					$id_imbox = $con->insert_id;
					$time = 
					notification($recibe['id'],'Mensaje Recibido','Has recibido un mensaje de @'.$user['username'].' diciendo: '.$mensaje);
					$sql = "UPDATE imbox SET status = 'true' WHERE para = '".$user['id']."' AND status = 'false' AND id = '".$id_mensaje."'";
					if ($con->query($sql)) {}
					if (!empty($_POST['ajax'])) {
						print_r(error_success(array(
							"url"=>"imbox",
							"type"=>"ok",
							"response"=>"Tu mensaje se ha enviado correctamente a @".$recibe['username']
						),'json'));
						exit();
					}
					else{
						print_r(error_success(array(
							"url"=>"imbox",
							"type"=>"ok",
							"response"=>"Tu mensaje se ha enviado correctamente a @".$recibe['username']
						)));
						exit();
					}
				}
				else{
					if (!empty($_POST['ajax'])) {
						print_r(error_success(array(
							"url"=>"imbox",
							"type"=>"error",
							"response"=>"Tuvimos inconvenientes al enviar el mensaje."
						),'json'));
						exit();
					}
					else{
						print_r(error_success(array(
							"url"=>"imbox",
							"type"=>"error",
							"response"=>"Tuvimos inconvenientes al enviar el mensaje."
						)));
						exit();
					}
				}
			}
		}
	}
}







if (!empty($_POST['ajax'])) {
	print_r(error_success(array(
		"url"=>"imbox",
		"type"=>"error",
		"response"=>"No podemos procesar un mensaje sin detalles."
	),'json'));
	exit();
}
else{
	print_r(error_success(array(
		"url"=>"imbox",
		"type"=>"error",
		"response"=>"No podemos procesar un mensaje sin detalles."
	)));
	exit();
}
?>