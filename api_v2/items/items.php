<?php
header('Access-Control-Allow-Origin: *');
include('./../../cm/function.beta.php');


// Cargamos la lista de productos en relacion a la categoria indicada
if (isset($_GET['query'])||isset($_POST['query'])) {
	header('Content-type: text/json');
	$params = (!empty($_POST['query'])) ? $_POST : $_GET;
	$params['encode'] = true;
	print_r(getItems($params));
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
	header('Content-type: text/json');
	$_GET['id'] = $_GET['comments'];
	$_GET['encode'] = true;
	print_r(comentarios($_GET));
	exit();
}
// Fin de Obtener una lista de los comentarios recibidos y sin revisar


// Obtener la informacion detallada de un producto
else if (!empty($_GET['item'])) {
	header('Content-type: text/json');
	print_r(itemInfo($_GET['item'],true));
	exit();
}
// Fin de Obtener la informacion detallada de un producto

// Agregar producto a la lista de favoritos
else if (!empty($_GET['item_fav'])) {
	header('Content-type: text/json');
	echo itemFav(array(
		"id"=>$_GET['item_fav'],
		"encode"=>true,
	));
	exit();
}
// Fin de Agregar producto a la lista de favoritos

// Comentar una publicacion
else if (!empty($_POST['send'])&&!empty($_POST['post'])) {
	header('Content-type: text/json');
	print_r(send(array(
		"id"=>intval($_POST['post']),
		"texto"=>htmlentities(substr($_POST['send'], 0, 160), ENT_QUOTES),
		"type"=>"comentario",
		"encode"=>true,
	)));
	exit();
}
// Comentar una publicacion


error_success(array(
	"url"=>"profile",
	"type"=>"error",
	"response"=>"Se requiere que inicies sesion para actualizar tus datos",
	"encode"=>(!empty($_GET['ajax'])||!empty($_POST['ajax'])),
));
?>