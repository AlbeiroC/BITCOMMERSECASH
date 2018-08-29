<?php
include("./cm/functions.php");
$con = connection();
header('Content-type: text/json');
$api_key = 'bf8c-df53-1945-4b24';
$url = 'https://block.io/api/v2/get_new_address/?api_key='.$api_key;
$max = 20;
$i = 0;
while ($i<$max) {
	$json = json_decode(getURL($url), true);
	$wallet = $json['data']['address'];
	$sql = "INSERT INTO wallets (user,direccion,balance) VALUES ('false','".$wallet."',0)";
	if ($con->query($sql)) {
		echo $wallet . "\n";
	}
	else{
		echo "Error: ".$con->error . "\n";
	}
	$i++;
}
?>