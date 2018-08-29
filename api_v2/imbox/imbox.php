<?php
include('./../../cm/function.beta.php');
header('Content-type: text/json');

// http://bitcommersecash.local/api_v2/imbox/imbox?ticket=$id_ticket
if (!empty($_GET['ticket'])) {
	print_r(ticket($_GET['ticket'],true));
	exit();
}


// http://bitcommersecash.local/api_v2/imbox/imbox?imbox=$id_imbox&encode=$json_encode
else if (!empty($_GET['imbox'])&&empty($_GET['send'])) {
	$_GET['id'] = $_GET['imbox'];
	$_GET['encode'] = true;
	print_r(imbox($_GET));
	exit();
}


// POST - http://bitcommersecash.local/api_v2/imbox/imbox?imbox=$id_ticket&send=$mensaje
else if (!empty($_GET['imbox'])&&!empty(trim($_GET['send']))) {
	if (!empty($_GET['private'])&&!empty($_GET['public'])&&!empty($_GET['key_generated'])) {
		$private = base64_decode($_GET['private']);
		$public = base64_decode($_GET['public']);
		$key_generated = base64_decode($_GET['key_generated']);
		$validate = (($public/2.5)==$private&&(($public-$private)==$key_generated)) ? true : false;
		if (!empty($validate)) {
			$ticket = (!empty(ticket($_GET['imbox'])['data'][0])) ? ticket($_GET['imbox'])['data'][0] : array();
			$me = is_session();
			$me = (!empty($me['data']['user']['id'])) ? $me['data']['user']['id'] : false;
			$post = (!empty($ticket['id'])) ? $ticket['id'] : false;
			$seller = (!empty($ticket['seller'])) ? $ticket['seller']['id'] : false;
			$buyer = (!empty($ticket['buyer'])) ? $ticket['buyer']['id'] : false;
			$texto = htmlentities(substr($_GET['send'], 0, 160), ENT_QUOTES);
			if (!empty($me)&&!empty($post)&&!empty($seller)&&!empty($buyer)) {
				$data = array(
					"id"=>$post,
					"to"=>($me==$seller) ? $buyer : $seller,
					"texto"=>$texto,
					"type"=>"imbox",
					"encode"=>true,
				);
				print_r(send($data));
			}
		}
	}
	exit();
}



print_r(error_success(array(
	"encode"=>true,
	"type"=>"error",
	"response"=>"No podemos procesar un mensaje sin detalles."
)));
?>