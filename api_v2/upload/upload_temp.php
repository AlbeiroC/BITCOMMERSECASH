<?php
include('./../../cm/function.beta.php');
header('Content-type: text/json');

$con = connection();

if (!empty($_POST['key'])&&$user=is_session()) {
	if (empty($user['data']['user']['id'])) {
		print_r(error_success(array(
			"type"=>"error",
			"response"=>"Oops! Tuvimos un problema",
			"encode"=>true,
		)));
		exit();
	}

	// Creamos un array con los datos ya guardados
	$arg = false;	
	$file_array = './'.$user['data']['user']['id'].'.json';
	$image_folder = './temp/'.$user['data']['user']['id'].'/';
	if (is_file($file_array)) {
		$fn = fopen($file_array, "r");
		$c = '';
		while ($linea=fgets($fn)) {
			$c .= $linea;
		}
		fclose($fn);
		$arg = isJson($c) ? json_decode($c,true) : false;
		if (is_array($arg)) {
			if ($arg['key']!=$_POST['key']) {
				$arg = false;
				unlink($file_array);
			}
		}
		if((!is_array($arg)&&is_dir($image_folder))||!is_file($file_array)){
			removeDir($image_folder);
		}
	}

	if(!is_file($file_array)||!is_array($arg)){
		if (is_dir($image_folder)) {removeDir($image_folder); }
		if (is_file($file_array)) {unlink($file_array); }
		$fn = fopen($file_array, "a");
		if (fputs($fn, json_encode(array(), JSON_PRETTY_PRINT))) {
			$arg = array();
		}
		fclose($fn);
	}
	// Fin de Creamos un array con los datos ya guardados
	$image_folder = createDir($image_folder);
	$params = array(
		"key"=>$_POST['key'],
		"user"=>$user['data']['user']['id'],
		"producto"=>"",
		"descripcion"=>"",
		"imagenes"=>array(),
		"folder"=>$image_folder,
	);
	$params = array_merge($params,$arg);

	// Realizamos la carga de imagenes
	if (!empty($_POST['img_key'])&&empty($_POST['update'])) {
		$max = $user['data']['user']['grants']['max_item']['image'];
		if (count($params['imagenes'])<$max&&!empty($_POST['picture'])&&!empty($_POST['upload'])) {
			$params['imagenes'][$_POST['img_key']] = uploadImagen($_POST['picture'],$params['folder']);
			$upload = (!empty($params['imagenes'][$_POST['img_key']]));
		}
		else if(!empty($_POST['delete'])&&!empty($params['imagenes'][$_POST['img_key']])){
			$p = $params['imagenes'][$_POST['img_key']];
			if (is_file($p)) {
				unlink($p);
				unset($params['imagenes'][$_POST['img_key']]);
			}
			$delete = true;
		}
	}
	$img_path = $params['imagenes'];
	// Fin de Realizamos la carga de imagenes

	// Borramos los campos que no queremos almacenar
	$params = array_merge($params,$_POST);
	$erase = array(
		'picture',
		'upload',
		'delete',
		'img_key',
	);
	foreach ($params as $key => $value) {
		if (in_array($key, $erase)||empty($value)) {
			unset($params[$key]);
		}
	}
	$params['imagenes'] = $img_path;
	// Fin de Borramos los campos que no queremos almacenar

	// Aca interrumpimos los procesos y subimos el producto a la base de datos
	if (!empty($_POST['finish'])) {
		$need = array(
		    // "btc_price",	
		    "descripcion",
		    "folder",
		    "imagenes",
		    "key",
		    "payment",
		    "producto",
		    "stock",
		    "shipping",
		    "user",
		    "usd_price",
		);
		foreach ($need as $key) {
			if (empty($error)&&empty($params[$key])) {
				$error = ($key=='imagenes'&&!empty($params['updated'])) ? false : $key;
			}
		}

		if (empty($error)) {
			$img_upload = array();
			foreach ($params['imagenes'] as $key => $value) {
				if (is_file($value)) {
					$img_upload[$key] = str_replace(host('root'), host('url'), uploadImagen(host('url')."api_v2/upload/".$value,host('root')."/Servers/bitcommersecash/upload/"));
				}
			}
			$params['imagenes'] = $img_upload;
			$query = array();
			$query['key_'] = intval($params['key']);
			$query['user'] = intval($user['data']['user']['id']);
			$query['nombre'] = substr(ucfirst(trim($params['producto'])), 0,150);
			$query['descripcion'] = substr(ucfirst(trim($params['descripcion'])), 0,500);
			$query['stock'] = (is_numeric($params['stock'])&&$params['stock']>0) ? intval($params['stock']) : 1;
			$query['currency'] = 'usd';
			$query['precio_usd'] = intval(str_replace(',', '', $params['usd_price']));
			
			$query['precio_btc'] = "automatic";
			// $query['precio_btc'] = (!empty($params['automatic_price'])) ? "automatic" : floatval(number_format(($query['precio_usd']/floatval(str_replace(',', '', $user['btc']['price']))), 8));
			
			$query['destination'] = strtolower(implode(',', $params['shipping']));
			$query['payment'] = (count($params['payment'])>0) ? implode(',', $params['payment']) : 'btc,bank,paypal';

			if (empty($_POST['updated'])) {
				$query['imagenes'] = (count($params['imagenes'])>0) ? implode('[EXPLODE_IMAGES]', $params['imagenes']) : '';
				$sql = 'INSERT INTO items_to_sell ';
				$fields = $values = "";
				foreach ($query as $key => $value) {
					$fields .= (empty($fields)) ? '(' . $key : ', ' . $key;
					$values .= (empty($values)) ? '("' . $value . '"' : ', "' . $value . '"';
				}
				$fields .= ')';
				$values .= ')';
				$sql .= $fields.' VALUES '.$values;
			}
			else{
				$sql = "SELECT id_producto FROM orden_de_compras WHERE id_producto = '".$_POST['updated']."' AND status = 'pending' LIMIT 1";
				if ($res=$con->query($sql)) {
					if ($res->num_rows>0) {
						$error = "Primero deber cerrar las ventas abiertas.";
					}
					else{
						$sql = "UPDATE items_to_sell SET ";
						$f = '';
						foreach ($query as $key => $value) {
							$f .= (empty($f)) ? $key." = '".$value."'" : ", ".$key." = '".$value."'";
						}
						$sql .= $f." WHERE items_to_sell.id = '".$_POST['updated']."' AND items_to_sell.user = '".$user['data']['user']['id']."' AND id NOT IN (SELECT id_producto FROM orden_de_compras WHERE status = 'pending')";
						$res = $con->query($sql);
						$error = $con->error;
					}
				}
			}

			if (empty($error)) {
				if ($con->query($sql)) {
					$error = false;
				}
				else{
					$error = true;
				}
			}
			$con->close();
			print_r(error_success(array(
				"type"=>(empty($error)) ? 'success' : 'error',
				"error"=>(empty($error)) ? false : $error,
				"encode"=>true,
			)));
		}
		else{
			print_r(json_encode(array(
				"type"=>"error",
				"error"=>(empty($error)) ? false : $error,
			)));
		}
		exit();
	}
	// Fin de Aca interrumpimos los procesos y subimos el producto a la base de datos


	$params = json_encode($params, JSON_PRETTY_PRINT);
	if (is_file($file_array)) {unlink($file_array); }
	$fn = fopen($file_array, "a");
	if (fputs($fn,$params)) {
		$params = json_decode($params, true);
		$params['user_upload'] = $user;
		if (!empty($delete)) {
			$params['delete'] = true;
		}
		if (!empty($upload)) {
			$params['upload'] = true;
		}
		$params = json_encode($params, JSON_PRETTY_PRINT);
		print_r($params);
	};
	fclose($fn);
	exit();
}



if ($user=is_session()) {
	$image_folder = $user['data']['user']['id'].".json";
	if (is_file($image_folder)) {
		print_r(file_get_contents($image_folder));
		exit();
	}
}

print_r(error_success(array(
	"type"=>"error",
	"encode"=>true,
	"response"=>"No received data"
)));
?>