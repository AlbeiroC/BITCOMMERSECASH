<?php
include( './function.beta.php');


if (!empty($_GET['download'])) {
	$id = $_GET['download'];
	$file = urldecode($id);
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	ob_clean();
	flush();
	readfile($file);
	exit;
}

else if (!empty($_GET['find'])) {
	header('Content-type: text/json');
	$query = trim(strtolower($_GET['find']));
	$response = array(
		"status"=>"error",
		"data"=>array(),
		"timestamp"=>strtotime("now"),
	);
	$con = connection();
	$limit = (!empty($_GET['only'])) ? 1 : 10;
	$query = (empty($_GET['only'])) ? "TRIM(LOWER(users.nombre)) LIKE '".$query."%' OR users.cedula LIKE '".$query."%' OR cuentas_bitsend.codigo_de_cuenta LIKE '".$query."%'" : " TRIM(LOWER(users.nombre)) = '".$query."' OR users.cedula = '".$query."' OR cuentas_bitsend.codigo_de_cuenta = '".$query."' ";
	$sql = "SELECT users.id FROM users,cuentas_bitsend WHERE ".$query." GROUP BY users.id LIMIT ".$limit;
	if ($res=$con->query($sql)) {
		$response['status'] = 'success';
		while ($r=$res->fetch_array(MYSQLI_ASSOC)) {
			$r = is_session($r['id']);
			if (!empty($r)) {
				$response['data'][] = $r;
			}
		}
	}
	else{
		$response['code'] = $con->error;
	}
	$response['tasa'] = getTasa();
	$con->close();
	echo json_encode($response, JSON_PRETTY_PRINT);
	exit();
}

else if(!empty($_POST)){
	header('Content-type: text/json');
	$con = connection();
	$response = array(
		"status"=>"error",
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	$cedula = (!empty($_POST['cedula'])) ? trim($_POST['cedula']) : false;
	$nombre = (!empty($_POST['nombre'])) ? trim($_POST['nombre']) : false;
	$tipo_de_cuenta = (!empty($_POST['tipo_de_cuenta'])) ? substr(trim($_POST['tipo_de_cuenta']), 0, 1) : false;
	$cod_cuenta = (!empty($_POST['cod_cuenta'])) ? trim($_POST['cod_cuenta']) : false;
	if (empty($cedula)||empty($nombre)||empty($tipo_de_cuenta)||empty($cod_cuenta)) {echo json_encode($response, JSON_PRETTY_PRINT);exit();}
	$referido = (!empty($_POST['referido'])&&is_numeric($_POST['referido'])) ? intval($_POST['referido']) : 1907;
	$is_client = countSQL('users','cedula',$cedula);
	$is_account = countSQL('cuentas_bitsend','codigo_de_cuenta',$cod_cuenta);
	if (!$is_client) {
		$sql = "INSERT INTO users (id,referido,cedula,nombre,comision) VALUES ('".$cedula."','".$referido."','".$cedula."','".$nombre."','2')";
		if ($con->query($sql)) {
			$is_vip = 0;
			$comision = 2;
			$id_cliente = $con->insert_id;
		}
		else{
			$_SESSION['notification'] = array(
				"texto"=>"Ups! tenemos problemas en el servidor",
				"icon"=>"danger",
			);
			if (empty($_POST['ajax'])) {header('Location: /bts'); }
			echo json_encode($response, JSON_PRETTY_PRINT);exit();
		}
	}
	else {
		if ($res = $con->query("SELECT * FROM users WHERE cedula = '".$cedula."' ORDER BY id ASC LIMIT 1")) {
			$data = $res->fetch_array(MYSQLI_ASSOC);
			$is_vip = $data['vip'];
			$comision = $data['comision'];
			$id_cliente = $data['id'];
		}
		else{
			$_SESSION['notification'] = array(
				"texto"=>"Ups! tenemos problemas en el servidor",
				"icon"=>"danger",
			);
			if (empty($_POST['ajax'])) {header('Location: /bts'); }
			echo json_encode($response, JSON_PRETTY_PRINT);exit();			
		}
	}
	if (!$is_account) {
		$sql = "INSERT INTO cuentas_bitsend (cliente,tipo_de_cuenta,codigo_de_cuenta) VALUES ('".$id_cliente."','".$tipo_de_cuenta."','".$cod_cuenta."')";
		if ($con->query($sql)) {
			$id_cuenta = $con->insert_id;
		}
		else{
			$_SESSION['notification'] = array(
				"texto"=>"Ups! tenemos problemas en el servidor",
				"icon"=>"danger",
			);
			if (empty($_POST['ajax'])) {header('Location: /bts'); }
			echo json_encode($response, JSON_PRETTY_PRINT);exit();
		}
	}
	else if (!$id_cuenta = $con->query("SELECT * FROM cuentas_bitsend WHERE codigo_de_cuenta = '".$cod_cuenta."' ORDER BY id ASC LIMIT 1")->fetch_array(MYSQLI_ASSOC)['id']) {
		$_SESSION['notification'] = array(
			"texto"=>"Ups! tenemos problemas en el servidor",
			"icon"=>"danger",
		);
		if (empty($_POST['ajax'])) {header('Location: /bts'); }
		echo json_encode($response, JSON_PRETTY_PRINT);exit();
	}
	$foto = '';
	if (!empty($_FILES['soporte'])) {$foto = uploadImagen($_FILES['soporte'],host('root').'/upload/soportes/'); }
	$tasa = getTasa();
	$tasa = floatval(number_format(((($is_vip) ? $tasa['tasa_vip'] : $tasa['tasa_popular'])/10000), 4, '.', ''));
	$cop = (!empty($_POST['cop'])) ? intval(str_replace(',', '.', str_replace('.', '', trim($_POST['cop'])))) : false;
	if (empty($cop)) {if (empty($_POST['ajax'])) {header('Location: /bts'); } echo json_encode($response, JSON_PRETTY_PRINT);exit(); }
	$vef = intval(($cop/$tasa));

	$sql = "INSERT INTO trades_bitsend (cuenta, comision, pesos, bolivares, soporte_de_pago, estado) VALUES ('".$id_cuenta."','".$comision."','".$cop."','".$vef."', '".$foto."','waiting')";
	if ($con->query($sql)) {
		$response['status'] = 'success';
		$response['data'] = array(
			"cliente"=>array(
				"id"=>$id_cliente,
				"nombre"=>$nombre,
				"cedula"=>$cedula,
			),
			"cuenta"=>array(
				"id"=>$id_cliente,
				"tipo_de_cuenta"=>$tipo_de_cuenta,
				"cuenta"=>$cod_cuenta,
			),
			"trade"=>array(
				"id"=>$con->insert_id,
				"cop"=>$cop,
				"vef"=>$vef,
				"imagen"=>$foto,
				"estatus"=>"waiting",
			)
		);
	}
	$ticket = $con->insert_id;
	$con->close();
	$_SESSION['notification'] = array(
		"texto"=>"El registro fue creado exitosamente con el la REFERENCIA <a href=".'"bts_trades?more='.$ticket.'&max='.$ticket.'"'.">#".$ticket."</a>",
		"icon"=>"success",
	);
	if (empty($_POST['ajax'])) {header('Location: /bts'); }
	echo json_encode($response, JSON_PRETTY_PRINT);
	exit();
}
?>