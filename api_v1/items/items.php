<?php
header('Access-Control-Allow-Origin: *');
include('./../../cm/functions.php');


// Cargamos la lista de productos en relacion a la categoria indicada
if (isset($_GET['term'])||isset($_GET['query'])||isset($_POST['term'])||isset($_POST['query'])) {
	header('Content-type: text/json');
	$data = (!empty($_GET['term'])||!empty($_GET['query'])) ? $_GET : $_GET;
	$data = (!empty($_POST['term'])||!empty($_POST['query'])) ? $_POST : $data;
	print_r(listarItems($data));	
	exit();
}
// Fin de Cargamos la lista de productos en relacion a la categoria indicada


// Planteamos la eliminacion de un producto
else if (!empty($_GET['deleteItem'])) {
	header('Content-type: text/json');
	$tk = (!empty($_GET['token'])) ? $_GET['token'] :  false;
	print_r(deleteItem($_GET['deleteItem'],$tk));
	exit();
}
// Fin de Planteamos la eliminacion de un producto


// Obtener una lista de los comentarios recibidos y sin revisar
else if (isset($_GET['comments'])) {
	print_r(listComments($_GET));
	exit();
}
// Fin de Obtener una lista de los comentarios recibidos y sin revisar


// Obtener la informacion detallada de un producto
else if (!empty($_GET['item'])) {
	header('Content-type: text/json');
	print_r(itemInfo($_GET['item']));
	exit();
}
// Fin de Obtener la informacion detallada de un producto



// Agregar producto a la lista de favoritos
else if (!empty($_GET['item_fav'])) {
	print_r(favItem($_GET['item_fav'],false,(!empty($_GET['ajax']))));
	exit();
}
// Fin de Agregar producto a la lista de favoritos

// Comentar una publicacion
else if (!empty($_POST['send'])&&!empty($_POST['post'])) {
	header('Content-type: text/json');
	$response = send($_POST['post'],$_POST['send']);
	if (!empty($_POST['redirect'])) {
		$redirect = urldecode($_POST['redirect']);
		$response = json_decode($response, true);
		$_SESSION['notification'] = array(
			"icon"=>str_replace('error', "dander", $response['type']),
			"texto"=>$response['response'],
		);
		header("Location: ".$redirect);
		exit();
	}
	print_r($response);
	exit();
}
// Comentar una publicacion


// Responder comentarios recibidos en pubicaciones mias
else if(!empty($_POST['id_comment'])&&!empty($_POST['response_comment'])){
	header('Content-type: text/json');
	print_r(responseComment($_POST['id_comment'],$_POST['response_comment']));
	exit();
}
// Fin de Responder comentarios recibidos en pubicaciones mias




$erro = true;
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
?>