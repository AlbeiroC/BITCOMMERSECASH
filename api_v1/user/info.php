<?php
include('./../../cm/functions.php');
header('Content-Type: text/json');
if (!empty($_GET['token'])) {
	if ($token=userInfo($_GET['token'],true,true)) {
		print_r($token);
		exit();
	}
}
else if (!empty($_GET['ui'])) {
	if ($token=userInfo($_GET['ui'],false,true)) {
		print_r($token);
		exit();
	}
}

print_r(error_success(array(
	"type"=>"error",
	"url"=>"login",
	"encode"=>true,
	"btc"=>BitcoinPrice(),
)));
?>